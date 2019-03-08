<?php

namespace App\Controllers;

use App\Models\AlbumRepository;
use App\Models\Album;

class AdminController
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

        $response = $this->render('albums/manage', [
            'title' => "Module d'administration des Albums",
            'tableContent' => $content,
        ]);

        return $this->returnResponse($response);
    }

    public function addAlbum()
    {
        $album = Album::initialize();
        $response = $this->render('albums/add', [
            'title' => 'Ajouter un album',
            'albumId' => $album->getId(),
            'submitUrl' => 'index.php?a=enregistrernouveau',
        ]);

        return $this->returnResponse($response);
    }

    public function submitAddAlbum(array $postRequest)
    {
    }

    public function updateAlbum(array $getRequest)
    {
        if (!isset($getRequest['id'])) {
            $response = $this->render('albums/update_not_found', [
                'title' => "l'Album n'a pas été trouvé",
                'albumId' => '',
            ]);
        }

        $id = $getRequest['id'];
        $album = AlbumRepository::read($id);

        $title = 'Modifier un album';
        if (isset($getRequest['id'])) {
            $album = AlbumRepository::read($id);
            $form = new AlbumForm($album);
            $c = '<div class="row-fluid show-grid"><div class="span4">' . $form->makeForm(ADMIN_URL . "index.php?a=enregistrermodif&amp;id=$id", 'Modifier') . '</div>';

            $playlist = new MusicCollection(AlbumRepository::getPlayList($id));
            $c .= '<div class="span8">' . $playlist->viewHtml() . '</div></div>';
        } else {
            $c = "<h3 class='alert'>Echec lors de la modification de l'album</h3>";
        }
    }

    public function deleteAlbum()
    {
    }

    public function render($template, $parameters)
    {
        $templatePath = VIEWS . $template . '.html.php';

        ob_start();
        require $templatePath;

        return ob_get_clean();
    }

    public function returnResponse($content)
    {
        header('HTTP/1.1 200 OK', true, 200);
        header('Content-Type: text/html');

        echo $content;
    }
}
