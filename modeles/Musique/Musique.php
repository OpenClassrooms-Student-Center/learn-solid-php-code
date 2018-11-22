<?php

class Musique
{
    private $id;
    private $titre;
    private $fichier;
    private $id_album;
    
    public function __construct($map)
    {
        $this->id = $map['id'];
        $this->titre = $map['titre'];
        $this->id_album = $map['id_album'];
        $this->fichier = $map['fichier'];
    }
    
    public function initialize($data = array())
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
        if (isset($data['fichier'])) {
            $map['fichier']= $data['fichier'];
        } else {
            $map['fichier']= '';
        }
        if (isset($data['id_album'])) {
            $map['id_album'] = $data['id_album'];
        } else {
            $map['id_album'] = 0; //valeur impossible
        }
        
        return self::factory($map);
    }
    
    public static function factory($map)
    {
        $extension=pathinfo($map['fichier'], PATHINFO_EXTENSION);
        switch ($extension) {
            case "mp3":
                return new Musique_Mp3($map);
            break;
            case "ogg":
            break;
            default:
                return new Musique($map);
        }
    }

    public function update($updateData)
    {
        if (isset($updateData['titre'])) {
            $this->titre = $updateData['titre'];
        }
    }
  
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
   
    public function getFichier()
    {
        return $this->fichier;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function getIdAlbum()
    {
        return $this->id_album;
    }

    public function setIdAlbum($id_album)
    {
        $this->id_album = $id_album;
    }
}
