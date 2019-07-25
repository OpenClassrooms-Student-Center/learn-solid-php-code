<?php

namespace App\Controllers;

use App\Classes\Tools\FilesManager;
use App\Models\MusicRepository;
use App\Models\Music;
use App\Classes\Music\Form as MusicForm;
use App\Classes\Tools\View;
use App\Classes\Tools\Strings;
use App\Classes\Tools\Uploader;
/**
 * Albums management
 */
class MusicController
{
    /**
     * Affiche le formulaire d'upload d'une musique
     *
     * @param array $getRequest
     * @return string
     */
    public function displayUploadForm(array $getRequest)
    {
        if (isset($getRequest['id'])) {
            $albumId = $getRequest['id'];

            return View::render('musics/upload', [
                'title' => "Upload d'un titre",
                'albumId' => $albumId,
                'submitUrl' => "index.php?a=ajouter_musique&amp;album_id=$albumId",
            ]);
        }
    }

    /**
     * Action de validation du formulaire d'upload de musique
     * @param $postRequest
     * @param $fileRequest
     * @return string
     */
    public function uploadMusic($postRequest, $fileRequest)
    {
        if (isset($postRequest['album_id'])) {
            if ($fileRequest['file']['error'] !== 0) {
                throw new Exception("Problème d'upload, contactez un administrateur...");
                /* en cas de fichier corrompu ou trop gros */
            }

            $data = $postRequest;
            $fileData = $fileRequest;

            $data['album_id'] = $postRequest['album_id'];
            $data['file'] = $data['album_id'] . $fileData['file']['name'];
            Strings::htmlEncodeArray($data);

            $music = Music::initialize($data);
            $form = new MusicForm($music);
            if ($form->verify($fileData['file']['type'])) {
                $uploader = new Uploader('file');
                $uploader->validTypes = ['audio/mp3, audio/mpeg'];
                $uploader->setName($data['file']);
                $uploader->uploadFile(DATA_FILE);

               MusicRepository::new($music);
               $musicId = $music->getId();
               $albumId = $data['album_id'];

                return View::render('musics/upload_success', [
                    'title' => "Piste enregistrée",
                    'music_title' => $music->getTitle(),
                    'update_music' => "index.php?a=modifier_musique&amp;id=$musicId",
                    'delete_music' => "index.php?a=supprimer_musique&amp;id=$musicId",
                    'submitUrl' => "index.php?a=ajouter_musique&amp;album_id=$albumId",
                ]);
            }

            return View::render('musics/upload', [
                'title' => "Echec d'enregistrement",
                'albumId' => $albumId,
                'submitUrl' => "index.php?a=ajouter_musique&amp;album_id=$albumId",
            ]);
        }
    }

    /**
     * Affiche le formulaire d'édition d'une musique
     *
     * @param $getRequest
     * @return string
     */
    public function displayUpdateForm($getRequest)
    {
        if (isset($getRequest['id'])) {
            $id = $getRequest['id'];
            $music = MusicRepository::read($id);

            return View::render('musics/update', [
                'title' => "Modifier une Musique",
                'music' => $music,
                'submitUrl' => "index.php?a=modifier_musique_modif&amp;id=$id",
            ]);
        }
    }

    /**
     * Valide la mise à jour d'une musique
     * @param $postRequest
     * @param $fileRequest
     * @return string
     */
    public function updateMusic($postRequest, $fileRequest)
    {
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
            $form = new MusicForm($music);
            if ($form->verify($fileData['type'])) {
                MusicRepository::update($music);
                return View::render('musics/update_success', [
                    'title' => 'Modifications enregistrées',
                    'music_title' => $music->getTitle(),
                    'music_file' => $music->getFile(),
                ]);
            }

            return View::render('musics/update', [
                'title' => "Echec de modification",
                'music' => $music,
                'submitUrl' => "index.php?a=modifier_musique_modif&amp;id=$id",
            ]);
        }
    }

    /**
     * Supprime une musique
     * @param $getRequest
     * @return string
     */
    public function deleteMusic($getRequest)
    {
        $id = $getRequest['id'];
        $music = MusicRepository::read($id);
        MusicRepository::delete($music);
        FilesManager::deleteFile($music->getFile(), DATA_FILE);

        return View::render('musics/delete', [
            'title' => 'Musique supprimée',
        ]);
    }
}