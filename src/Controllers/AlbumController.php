<?php

namespace App\Controllers;

use App\Models\AlbumRepository;
use App\Models\Album;
use App\Classes\Album\Form as AlbumForm;
use App\Classes\Music\Collection as MusicCollection;
use App\Classes\Tools\Strings;
use App\Classes\Tools\Uploader;
use App\Classes\Tools\FilesManager;

/**
 * Albums management
 */
class AlbumController
{
    public function manageAlbums()
    {
        $albums = AlbumRepository::getAllAlbums();
        $content = '';

        foreach ($albums as $album) {
            $content = $content . $this->render('albums/admin_row', [
                'album' => $album,
            ]);

            $content .= $this->render('albums/admin_modal', [
                'album' => $album,
            ]);
        }

        return $this->render('albums/manage', [
            'title' => "Module d'administration des Albums",
            'tableContent' => $content,
        ]);
    }

    public function addAlbum()
    {
        $album = Album::initialize();

        return $this->render('albums/add', [
            'title' => 'Ajouter un album',
            'albumId' => $album->getId(),
            'submitUrl' => 'index.php?a=enregistrernouveau',
        ]);
    }

    public function submitAddAlbum(array $postRequest, array $fileRequest)
    {
        $title = 'Album enregistré';
        $formErrors = [];

        $postRequest['file'] = $postRequest['id'] . $fileRequest['file']['name'];
        Strings::htmlEncodeArray($postRequest);
        $album = Album::initialize($postRequest);
        $form = new AlbumForm($album);

        if ($form->verify($fileRequest['file']['type'])) {
            $uploader = new Uploader('file');
            $uploader->validTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/JPG'];
            $uploader->setName($postRequest['file']);
            $uploader->uploadFile(DATA_FILE);
            $uploader->resize(DATA_FILE . '/' . $postRequest['file'], DATA_FILE . '/' . 'tb_' . $postRequest['file'], 150, 150);
            AlbumRepository::new($album);
        } else {
            $title = "Echec de l'enregistrement";
            $formErrors = $form->getErrors();
        }

        return $this->render('albums/submit_add', [
            'title' => $title,
            'album' => $album,
            'formErrors' => $formErrors,
        ]);
    }

    public function updateAlbum(array $getRequest)
    {
        if (!isset($getRequest['id'])) {
            $content = $this->render('albums/update_not_found', [
                'title' => "l'Album n'a pas été trouvé",
                'albumId' => '',
            ]);

            return $this->returnResponse($content);
        }

        $id = $getRequest['id'];
        $album = AlbumRepository::read($id);
        $playList = new MusicCollection(AlbumRepository::getPlayList($id));

        return $this->render('albums/update', [
            'title' => 'Modifier un album',
            'album' => $album,
            'fileSource' => DATA_URL . 'tb_' . $album->getFile(),
            'submitUrl' => ADMIN_URL . "index.php?a=enregistrermodif&amp;id=$id",
            'playList' => $playList->viewHtml(),
        ]);
    }

    public function deleteAlbum(array $getRequest)
    {
        $id = $getRequest['id'];
        $album = AlbumRepository::read($id);
        AlbumRepository::delete($album);
        FilesManager::deleteFile($album->getFile(), DATA_FILE);
        FilesManager::deleteFile('tb_' . $album->getFile(), DATA_FILE);
        $listOfMusics = AlbumRepository::getPlayList($id);

        foreach ($listOfMusics as $music) {
            FilesManager::deleteFile($music->getFile(), DATA_FILE);
        }

        return $this->render('albums/delete', [
            'title' => 'Album supprimé',
        ]);
    }

    public function render($template, $parameters)
    {
        $templatePath = VIEWS . $template . '.html.php';

        ob_start();
        require $templatePath;

        return ob_get_clean();
    }
}
