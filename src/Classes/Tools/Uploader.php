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
}
