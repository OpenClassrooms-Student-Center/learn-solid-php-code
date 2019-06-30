<?php

require_once '../config/config.php';
require_once '../config/config_db.php';
require_once '../vendor/autoload.php';

use App\Classes\Album\Repository as AlbumRepository;
use App\Classes\Album\Collection as AlbumCollection;
use App\Controllers\PublicController;
use App\Classes\Tools\View;
use App\Classes\Album\Ui as AlbumUi;
use App\Classes\Music\Ui as MusicUi;

// initialisation des variables
$title = '';
$c = '';
$header = file_get_contents('../ui/fragments/header.frg.html');
$footer = file_get_contents('../ui/fragments/footer.frg.html');
$skeleton = '../ui/pages/galerie.html.php';
$controller = new PublicController();

try {
    $getRequest = $_GET;
    $action = isset($getRequest['a']) ? $getRequest['a'] : '';

    switch ($action) {
        case 'ecouter':
            $title = "Ecoute de l'album";
            if (isset($getRequest['id'])) {
                $albumId = $getRequest['id'];
                $ListOfMusics = AlbumRepository::getPlayList($albumId);
                if (count($ListOfMusics) == 0) {
                    $c = 'Album vide, Ajoutez des pistes';
                } else {
                    $i = 0;
                    foreach ($ListOfMusics as $Music) {
                        $ui = MusicUi::factory($Music);
                        if ($i < 1) {
                            $c = '<section id="album_view" class="span6">' . $ui->makePlayer();
                            $c .= '<ol>';

                            $c .= '<li class="playing">' . $ui->makeHtml() . '</li>';
                            $i = 1;
                        } else {
                            $c .= '<li>' . $ui->makeHtml() . '</li>';
                        }
                    }
                    $c .= '</ol></section>';
                }

                $album = AlbumRepository::read($albumId);
                $albumUi = new AlbumUi($album);
                $c .= $albumUi->displayAlbumInfos();
            }
            break;

        case 'aide':
            return View::sendHttpResponse($controller->help());
            break;

        default:
            $title = 'Les derniers Albums enregistrés';
            $selectionOfAlbums = AlbumRepository::getListAlbums(20);
            $selectionOfAlbums = new AlbumCollection($selectionOfAlbums);
            $c = $selectionOfAlbums->viewHtml();

            $allAlbums = AlbumRepository::getAllAlbums();
            $allAlbums = new AlbumCollection($allAlbums);
            $c .= $allAlbums->viewTable();
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
