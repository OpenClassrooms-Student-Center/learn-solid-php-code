<?php

namespace App\Classes\Tools;

use Exception;

class Uploader
{
    private $name;
    private $type;
    public $directory = '';
    private $temporaryName;
    public $validTypes = array();
    private $error = '';

    public function __construct($file)
    {
        $fileData = $_FILES[$file];
        $this->temporaryName = $fileData['tmp_name'];
        $this->name = $fileData['name'];
        $this->type = $fileData['type'];
    }

    public function setValidTypes($validTypes)
    {
        $this->validTypes = $validTypes;
    }

    public function uploadFile($directory = './')
    {
        if (!is_uploaded_file($this->temporaryName)) {
            $this->error = 'Vous avez rien uploadé';

            return false;
        } elseif (!in_array($this->type, $this->validTypes)) {
            $this->error = 'Le fichier ' . $this->name . ' n\'est pas d\'un type valide';

            return false;
        } elseif (!move_uploaded_file($this->temporaryName, $directory . $this->name)) {
            $this->error = 'Problème lors de la copie du fichier ' . $this->name;

            return false;
        } else {
            return true;
        }
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getExtension()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    /*
     *  parametres: orig => image d'origine
     *              dest => image de destination
     *              et les dimensions
     */
    public function resize($origin, $destination, $width, $maxHeight)
    {
        $type = $this->getExtension();
        $pngFamily = array('PNG', 'png');
        $jpegFamily = array('jpeg', 'jpg', 'JPG');
        if (in_array($type, $jpegFamily)) {
            $type = 'jpeg';
        } elseif (in_array($type, $pngFamily)) {
            $type = 'png';
        }
        $function = 'imagecreatefrom' . $type;

        if (!is_callable($function)) {
            return false;
        }

        $image = $function($origin);

        $imageWidth = \imagesx($image);
        if ($imageWidth < $width) {
            if (!copy($origin, $destination)) {
                throw new Exception("Impossible de copier le fichier {$origin} vers {$destination}");
            }
        } else {
            $imageHeight = \imagesy($image);
            $height = (int) (($width * $imageHeight) / $imageWidth);
            if ($height > $maxHeight) {
                $height = $maxHeight;
                $width = (int) (($height * $imageWidth) / $imageHeight);
            }
            $newImage = \imagecreatetruecolor($width, $height);

            if ($newImage !== false) {
                \imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);

                $function = 'image' . $type;

                if (!is_callable($function)) {
                    return false;
                }

                $function($newImage, $destination);

                \imagedestroy($newImage);
                \imagedestroy($image);
            }
        }
    }
}
