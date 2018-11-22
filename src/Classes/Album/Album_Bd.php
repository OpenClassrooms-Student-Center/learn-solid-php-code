<?php

namespace App\Classes\Album;

use App\Classes\Outils\Outils_Bd;
use App\Classes\Musique\Musique;
use App\Classes\Album\Album;

use \PDO;

class Album_Bd
{
    public static function lire($id)
    {
        $db = Outils_Bd::getInstance()->getConnexion();
        $sth=$db->prepare("SELECT * FROM tp_upload WHERE id=:id");

        $data=array('id' => $id);
        $sth->execute($data);
        $ligne = $sth->fetch(PDO::FETCH_ASSOC);

        return Album::initialize($ligne);
    }

    public static function getPlayList($id)
    {
        $db = Outils_Bd::getInstance()->getConnexion();

        $sth=$db->prepare("SELECT * FROM songs WHERE id_album=:id_album");

        $data=array('id_album' => $id);

        $sth->execute($data);

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $musiques = array();
        foreach ($lignes as $ligne) {
            $musiques[] = Musique::initialize($ligne);
        }

        return $musiques;
    }

    public static function enregistrerNouveau(Album $album)
    {
        $db = Outils_Bd::getInstance()->getConnexion();
        $sth=$db->prepare("insert into tp_upload set id=:id,titre=:titre, auteur=:auteur, fichier=:fichier, dateIns=:dateIns");

        $data=array(
        'id' => $album->getId(),
        'titre' => $album->getTitre(),
        'auteur' => $album->getAuteur(),
        'dateIns' => $album->getDateIns(),
        'fichier' => $album->getFichier()
        );

        $sth->execute($data);
    }

    public static function enregistrerModif(Album $album)
    {
        $db = Outils_Bd::getInstance()->getConnexion();

        $sth=$db->prepare("update tp_upload set titre=:titre, auteur=:auteur, fichier=:fichier where id =:id ");

        $data=array(
        'id' => $album->getId(),
        'titre' => $album->getTitre(),
        'auteur' => $album->getAuteur(),
        'fichier' => $album->getFichier()
);

        $sth->execute($data);
    }

    public static function supprimer(Album $album)
    {
        $db = Outils_Bd::getInstance()->getConnexion();
        $sth=$db->prepare("delete from tp_upload where id=:id");

        $data=array('id' => $album->getId());

        $sth->execute($data);
    }
  
    public static function getListAlbums($limit)
    {
        $db = Outils_Bd::getInstance()->getConnexion();

        $sth= $db->query("SELECT * FROM tp_upload LIMIT $limit");

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = array();
        foreach ($lignes as $ligne) {
            $albums[] = Album::initialize($ligne);
        }

        return $albums;
    }
  
    public static function getAllAlbums()
    {
        $db = Outils_Bd::getInstance()->getConnexion();

        $sth= $db->query("SELECT * FROM tp_upload");

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = array();
        foreach ($lignes as $ligne) {
            $albums[] = Album::initialize($ligne);
        }

        return $albums;
    }
}
