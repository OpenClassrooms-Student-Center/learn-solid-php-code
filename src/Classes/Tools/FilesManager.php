<?php

namespace App\Classes\Tools;

class FilesManager
{
    public static function deleteFile($filename, $path)
    {
        unlink($path . $filename);
    }
}
