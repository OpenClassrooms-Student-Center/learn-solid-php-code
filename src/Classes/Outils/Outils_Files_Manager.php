<?php

namespace App\Classes\Outils;

class Outils_Files_Manager
{
    public static function deleteFile($filename, $path)
    {
        unlink($path . $filename);
    }
}
