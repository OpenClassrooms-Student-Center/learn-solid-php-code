<?php

namespace App\Classes\Music;

class Ui
{
    public function __construct($musique)
    {
        $this->musique = $musique;
    }

    public static function factory(Music $musique)
    {
        $extension = pathinfo($musique->getFichier(), PATHINFO_EXTENSION);
        switch ($extension) {
            case 'mp3':
                return new Mp3Ui($musique);
                break;
            case 'ogg':
                break;
            default:
                throw new Exception("Le fichier pas de type reconnu : {$extension}");
        }
    }
}
