<?php

namespace App\Controllers;

use App\Models\AlbumRepository;

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
            'content' => $content,
        ]);

        return $this->returnResponse($response);
    }

    public function updateAlbum()
    {
    }

    public function addAlbum()
    {
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
