<?php

namespace App\Classes\Album;

use App\Classes\Tools\Database;
use PDO;

class Repository
{
    public static function lire($id)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('SELECT * FROM albums WHERE id=:id');

        $data = array('id' => $id);
        $sth->execute($data);
        $ligne = $sth->fetch(PDO::FETCH_ASSOC);

        return Album::initialize($ligne);
    }

    public static function getPlayList($id)
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->prepare('SELECT * FROM songs WHERE id_album=:id_album');

        $data = array('id_album' => $id);

        $sth->execute($data);

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $musiques = array();
        foreach ($lignes as $ligne) {
            $musiques[] = Music::initialize($ligne);
        }

        return $musiques;
    }

    public static function enregistrerNouveau(Album $album)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('insert into albums set id=:id,titre=:titre, auteur=:auteur, fichier=:fichier, dateIns=:dateIns');

        $data = array(
        'id' => $album->getId(),
        'titre' => $album->getTitre(),
        'auteur' => $album->getAuteur(),
        'dateIns' => $album->getDateIns(),
        'fichier' => $album->getFichier(),
        );

        $sth->execute($data);
    }

    public static function enregistrerModif(Album $album)
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->prepare('update albums set titre=:titre, auteur=:auteur, fichier=:fichier where id =:id ');

        $data = array(
            'id' => $album->getId(),
            'titre' => $album->getTitre(),
            'auteur' => $album->getAuteur(),
            'fichier' => $album->getFichier(),
        );

        $sth->execute($data);
    }

    public static function supprimer(Album $album)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('delete from albums where id=:id');

        $data = array('id' => $album->getId());

        $sth->execute($data);
    }

    public static function getListAlbums($limit)
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->query("SELECT * FROM albums LIMIT $limit");

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = array();
        foreach ($lignes as $ligne) {
            $albums[] = Album::initialize($ligne);
        }

        return $albums;
    }

    public static function getAllAlbums()
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->query('SELECT * FROM albums');

        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = array();
        foreach ($lignes as $ligne) {
            $albums[] = Album::initialize($ligne);
        }

        return $albums;
    }
}
