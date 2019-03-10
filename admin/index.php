<?php

require_once '../config/config.php';
require_once '../config/config_db.php';
require_once '../vendor/autoload.php';

use App\Classes\Music\Repository as MusicRepository;
use App\Classes\Album\Repository as AlbumRepository;
use App\Classes\Music\Form as MusicForm;
use App\Classes\Album\Form as AlbumForm;
use App\Controllers\AlbumController;
use App\Classes\Album\Ui as AlbumUi;
use App\Classes\Music\Ui as MusicUi;
use App\Classes\Tools\FilesManager;
use App\Classes\Tools\Uploader;
use App\Classes\Tools\Strings;
use App\Classes\Music\Music;

// initialisation des variables
$title = '';
$c = '';
$header = file_get_contents('../ui/fragments/header.frg.html');
$footer = file_get_contents('../ui/fragments/footer.frg.html');
$skeleton = '../ui/pages/galerie.html.php';
$controller = new AlbumController();

try {
    $getRequest = $_GET;
    $postRequest = $_POST;
    $fileRequest = $_FILES;

    $action = isset($getRequest['a']) ? $getRequest['a'] : '';

    /*
     * Will execute an action according to the User request
     */
    switch ($action) {
        case 'ajouter':
            return $controller->addAlbum();
            break;

        case 'modifier':
            return $controller->updateAlbum($getRequest);
            break;

        case 'enregistrernouveau':
            return $controller->submitAddAlbum($postRequest, $fileRequest);
            break;

        case 'enregistrermodif':
            $title = 'Modifications enregistrées';
            $data = $postRequest;
            $fileData = is_array($fileRequest['file']) ? $fileRequest['file'] : [];

            if (isset($getRequest['id'])) {
                $id = $getRequest['id'];

                if (!empty($fileData['name'])) {
                    // dont delete the file if it exists already
                    if ($id . $fileData['name'] == $data['file']) {
                        $case = 1; // On uploade mais on efface pas
                    } else {
                        $case = 2; //On uploade et on efface
                        $data['file'] = $data['id'] . $fileData['name'];
                    }
                } else {
                    $case = 0;
                    $fileData['type'] = 'image/jpeg';
                }

                Strings::htmlEncodeArray($data);

                $album = AlbumRepository::read($id);

                if ($case > 0) {
                    $uploader = new Uploader('file');
                    $uploader->validTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/JPG');
                    $uploader->setName($data['file']);
                    $uploader->uploadFile(DATA_FILE);
                    $uploader->resize(DATA_FILE . '/' . $data['file'], DATA_FILE . '/' . 'tb_' . $data['file'], 150, 150);

                    if ($case > 1) {
                        FilesManager::deleteFile($album->getFile(), DATA_FILE);
                        FilesManager::deleteFile('tb_' . $album->getFile(), DATA_FILE);
                    }
                }

                $album->update($data);
                AlbumRepository::update($album);
                $form = new AlbumForm($album);
                if ($form->verify($fileData['type'])) {
                    AlbumRepository::update($album);
                    $albumUi = new AlbumUi($album);
                    $c = $albumUi->makeHtml();
                } else {
                    $title = 'Echec de modification';
                    $c = $form->makeForm(ADMIN_URL . "index.php?a=enregistrermodif&amp;id=$id", 'modifier');
                }
            }
            break;

        case 'supprimer':
            return $controller->deleteAlbum($getRequest);
            break;

        /* Gestion des pistes */

        case 'uploader':
            $title = "Upload d'un titre";
            if (isset($getRequest['id'])) {
                $albumId = $getRequest['id'];

                $music = Music::initialize();
                $form = new MusicForm($music);
                $c = $form->makeForm(ADMIN_URL . "index.php?a=ajouter_musique&amp;album_id=$albumId", 'Ajouter une piste');
            }
            break;

        case 'ajouter_musique':
            if (isset($getRequest['album_id'])) {
                if ($fileRequest['file']['error'] !== 0) {
                    throw new Exception("Problème d'upload, contactez un administrateur...");
                    /* en cas de fichier corrompu ou trop gros */
                }

                $data = $postRequest;
                $fileData = $fileRequest;

                $data['album_id'] = $getRequest['album_id'];
                $data['file'] = $data['album_id'] . $fileData['file']['name'];
                Strings::htmlEncodeArray($data);

                $music = Music::initialize($data);
                $form = new MusicForm($music);
                if ($form->verify($fileData['file']['type'])) {
                    $title = 'Piste enregistrée';

                    $uploader = new Uploader('file');
                    $uploader->validTypes = ['audio/mp3, audio/mpeg'];
                    $uploader->setName($data['file']);
                    $uploader->uploadFile(DATA_FILE);

                    MusicRepository::new($music);
                    $musicUi = MusicUi::factory($music);
                    $c = $musicUi->makeAdminHtml();
                } else {
                    $c = "<h3 class='alert'>Echec d'enregistrement</h3>";
                    $albumId = $data['album_id'];
                    $c .= $form->makeForm(ADMIN_URL . "index.php?a=ajouter_musique&amp;album_id=$albumId", 'ajouter une piste');
                }
            }
            break;

        case 'modifier_musique':
            $title = 'Modifier une Musique';
            if (isset($getRequest['id'])) {
                $id = $getRequest['id'];
                $music = MusicRepository::read($id);
                $form = new MusicForm($music);
                $c = $form->makeForm(ADMIN_URL . "index.php?a=modifier_musique_modif&amp;id=$id", 'Modifier');
            } else {
                $c = "<h3 class='alert'>Echec lors de la modification de la Musique</h3>";
            }
            break;

        case 'modifier_musique_modif':
            $title = 'Modifications enregistrées';
            $data = $postRequest;
            $fileData = is_array($fileRequest['file']) ? $fileRequest['file'] : array();
            if (isset($data['id'])) {
                $id = $data['id'];

                if (!empty($fileData['name'])) {
                    /* attention à ne pas effacer si le nom du nouveau fichier est identique à son prédecesseur */
                    if ($id . $fileData['name'] == $data['file']) {
                        $case = 1; // On uploade mais on efface pas
                    } else {
                        $case = 2; //On uploade et on efface
                        $data['file'] = $data['id'] . $fileData['name'];
                    }
                } else {
                    $case = 0;
                    $fileData['type'] = 'audio/mpeg';
                }
                Strings::htmlEncodeArray($data);

                $music = MusicRepository::read($id);
                /* mettre à jour avec les données du formulaire, impose de redownloader l'image? */
                if ($case > 0) {
                    //Si nouveau, alors upload/redimensionnement de la nouvelle image
                    $uploader = new Uploader('file');
                    $uploader->validTypes = array('audio/ogg', 'audio/mpeg');
                    $uploader->setName($data['file']);
                    $uploader->uploadFile(DATA_FILE);
                    if ($case > 1) {
                        FilesManager::deleteFile($music->getFile(), DATA_FILE);
                    }
                }

                $music->update($data);
                MusicRepository::update($music);
                $form = new MusicForm($music);
                if ($form->verify($fileData['type'])) {
                    MusicRepository::update($music);
                    $musicUi = MusicUi::factory($music);
                    $c = $musicUi->makeHtml();
                } else {
                    $titre = 'Echec de modification';
                    $c = $form->makeForm(ADMIN_URL . "index.php?a=modifier_musique_modif&amp;id=$id", 'modifier');
                }
            }
            break;

        case 'supprimer_musique':
            $title = 'Musique supprimée';
            $id = $getRequest['id'];
            $music = MusicRepository::read($id);
            MusicRepository::delete($music);
            FilesManager::deleteFile($music->getFile(), DATA_FILE);
            break;

        // Page d'administration : affiche tous les Albums de la BD
        default:
            return $controller->manageAlbums();
    }
} catch (Exception $e) {
    $c = $e->getMessage();
    $c .= "<pre>{$e->getTraceAsString()}</pre>";
}

ob_start();
    require_once $skeleton;
    $html = ob_get_contents();
ob_end_clean();
echo $html;
