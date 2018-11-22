<?php

namespace App\Classes\Album;

class Album
{
    private $id;
    private $titre;
    private $auteur;
    private $fichier;
    private $dateIns;

    protected function __construct($map)
    {
        $this->id = $map['id'];
        $this->titre = $map['titre'];
        $this->auteur = $map['auteur'];
        $this->fichier = $map['fichier'];
        $this->dateIns = $map['dateIns'];
    }


    public static function initialize($data = array())
    {
        if (isset($data['id'])) {
            $map['id'] = $data['id'];
        } else {
            $map['id'] = md5(microtime());
        }
        if (isset($data['titre'])) {
            $map['titre'] = $data['titre'];
        } else {
            $map['titre'] = '';
        }
        if (isset($data['auteur'])) {
            $map['auteur'] = $data['auteur'];
        } else {
            $map['auteur']= '';
        }
        if (isset($data['fichier'])) {
            $map['fichier']= $data['fichier'];
        } else {
            $map['fichier']= '';
        }
        if (isset($data['dateIns'])) {
            $map['dateIns'] = $data['dateIns'];
        } else {
            $map['dateIns']= date("Y-m-d H:i:s");
        }

        return new self($map);
    }


    public function update($updateData)
    {
        if (isset($updateData['titre'])) {
            $this->titre = $updateData['titre'];
        }
        if (isset($updateData['auteur'])) {
            $this->auteur = $updateData['auteur'];
        }
        if (isset($updateData['fichier'])) {
            $this->fichier = $updateData['fichier'];
        }
    }



 
    /**
     * Retourne le code d'identification d'un album
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Retourne le nom du site
     */
    public function getTitre()
    {
        return $this->titre;
    }



    /**
     * Retourne la auteur
     */
    public function getAuteur()
    {
        return $this->auteur;
    }


    /**
     * Retourne le fichier
     */
    public function getFichier()
    {
        return $this->fichier;
    }


    /**
     * Retourne la date de création
     */

    public function getDateIns()
    {
        return $this->dateIns;
    }

    /**
     * Modifie le code d'identification d'un album
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Modifie le nom du site
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }



    /**
     * Modifie la auteur de l'album
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }


    /**
     * Modifie le fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }


    /**
     * Modifie la date
     */
    public function setDateIns($dateIns)
    {
        $this->dateIns = $dateIns;
    }
}
