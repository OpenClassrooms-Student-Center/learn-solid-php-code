<?php

namespace App\Controllers;

use App\Classes\Tools\View;

class PublicController
{
    public function home()
    {

        return View::render('home', [
            'title' => 'Les derniers Albums enregistrés',
            'selectedAlbums' => [],
            'allAlbums' => [],
        ]);
    }

    public function help()
    {
        return View::render('help', [
            'title' => 'Comment ça fonctionne ?',
        ]);
    }
}
