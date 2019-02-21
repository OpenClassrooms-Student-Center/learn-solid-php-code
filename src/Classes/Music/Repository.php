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

    public static function new(Music $music)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('insert into songs set id=:id,titre=:titre,fichier=:fichier,id_album=:id_album');

        $sth->execute([
            'id' => $music->getId(),
            'title' => $music->getTitle(),
            'file' => $music->getFile(),
            'album_id' => $music->getAlbumId(),
        ]);
    }

    public static function update(Music $music)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('update songs set titre=:titre where id=:id');

        $sth->execute([
            'id' => $music->getId(),
            'title' => $music->getTitle(),
        ]);
    }

    public static function delete(Music $music)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('delete from songs where id=:id');

        $sth->execute(['id' => $music->getId()]);
    }
}
