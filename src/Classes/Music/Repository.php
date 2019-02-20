<?php

namespace App\Classes\Music;

use App\Classes\Tools\Database;
use PDO;

class Repository
{
    public static function lire($id)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('SELECT * FROM songs WHERE id=:id');
        $data = array('id' => $id);
        $sth->execute($data);
        $ligne = $sth->fetch(PDO::FETCH_ASSOC);

        return Music::initialize($ligne);
    }

    public static function enregistrerNouveau(Musique $musique)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('insert into songs set id=:id,titre=:titre,fichier=:fichier,id_album=:id_album');

        $data = array(
            'id' => $musique->getId(),
            'titre' => $musique->getTitre(),
                    'fichier' => $musique->getFichier(),
            'id_album' => $musique->getIdAlbum(),
        );

        $sth->execute($data);
    }

    public static function enregistrerModif(Musique $musique)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('update songs set titre=:titre where id=:id');

        $data = array(
            'id' => $musique->getId(),
            'titre' => $musique->getTitre(),
        );

        $sth->execute($data);
    }

    public static function supprimer(Musique $musique)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('delete from songs where id=:id');

        $data = array('id' => $musique->getId());

        $sth->execute($data);
    }
}
