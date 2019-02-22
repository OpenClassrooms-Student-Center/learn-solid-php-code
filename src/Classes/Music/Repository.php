<?php

namespace App\Classes\Music;

use App\Classes\Tools\Database;
use PDO;

class Repository
{
    public static function read($id)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('SELECT * FROM songs WHERE id=:id');
        $data = array('id' => $id);
        $sth->execute($data);
        $musicResult = $sth->fetch(PDO::FETCH_ASSOC);

        return Music::initialize($musicResult);
    }

    public static function new(Music $music)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('insert into songs set id=:id,title=:title,file=:file,id_album=:album_id');

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
