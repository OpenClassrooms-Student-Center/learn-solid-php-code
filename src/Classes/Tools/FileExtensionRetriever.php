<?php

namespace App\Classes\Tools;

class FileExtensionRetriever
{
    /**
     * Returns the file extension
     *
     * @param $filename
     * @return mixed
     */
    public static function getExtension($filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }
}