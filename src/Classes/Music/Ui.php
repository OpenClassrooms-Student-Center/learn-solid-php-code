<?php

namespace App\Classes\Music;

use Exception;

class Ui
{
    protected $music;

    public function __construct($music)
    {
        $this->music = $music;
    }

    public static function factory(Music $music)
    {
        $extension = pathinfo($music->getFile(), PATHINFO_EXTENSION);
        switch ($extension) {
            case 'mp3':
                return new Mp3Ui($music);
                break;
            case 'ogg':
                break;
            default:
                throw new Exception("Le fichier pas de type reconnu : {$extension}");
        }
    }
}
