<?php

require_once '../config/config.php';
require_once '../config/config_db.php';
require_once '../vendor/autoload.php';

use App\Classes\Music\Repository as MusicRepository;
use App\Classes\Album\Repository as AlbumRepository;
use App\Classes\Music\Form as MusicForm;
use App\Classes\Album\Form as AlbumForm;
use App\Controllers\MusicController;
use App\Controllers\AlbumController;
use App\Classes\Album\Ui as AlbumUi;
use App\Classes\Music\Ui as MusicUi;
use App\Classes\Tools\FilesManager;
use App\Classes\Tools\Uploader;
use App\Classes\Tools\Strings;
use App\Classes\Tools\View;
use App\Classes\Music\Music;

// initialisation des variables
$title = '';
$c = '';
$header = file_get_contents('../ui/fragments/header.frg.html');
$footer = file_get_contents('../ui/fragments/footer.frg.html');
$skeleton = '../ui/pages/galerie.html.php';
$controller = new AlbumController();
$musicController = new MusicController();

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
            return View::sendHttpResponse($controller->addAlbum());
            break;

        case 'modifier':
            return View::sendHttpResponse($controller->updateAlbum($getRequest));
            break;

        case 'enregistrernouveau':
            return View::sendHttpResponse($controller
                ->submitAddAlbum($postRequest, $fileRequest)
            );
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
            return View::sendHttpResponse($controller->deleteAlbum($getRequest));
            break;

        /* Gestion des pistes */

        case 'uploader':
            return View::sendHttpResponse($musicController->displayUploadForm($getRequest));
            break;

        case 'ajouter_musique':
            return View::sendHttpResponse($musicController->uploadMusic($postRequest, $fileRequest));
            break;

        case 'modifier_musique':
            return View::sendHttpResponse($musicController->displayUpdateForm($getRequest));
            break;

        case 'modifier_musique_modif':
            return View::sendHttpResponse($musicController->updateMusic($postRequest, $fileRequest));
            break;

        case 'supprimer_musique':
            return View::sendHttpResponse($musicController->deleteMusic($getRequest));
            break;

        // Page d'administration : affiche tous les Albums de la BD
        default:
            return View::sendHttpResponse($controller->manageAlbums());
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
