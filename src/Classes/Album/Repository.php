<?php

namespace App\Classes\Album;

use App\Classes\Tools\Database;
use App\Classes\Music\Music;
use PDO;

class Repository
{
    public static function read($id)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('SELECT * FROM albums WHERE id=:id');

        $data = array('id' => $id);
        $sth->execute($data);
        $line = $sth->fetch(PDO::FETCH_ASSOC);

        return Album::initialize($line);
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

    public static function new(Album $album)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('insert into albums set id=:id,title=:title, author=:author, file=:file, created_at=:created_at');

        $sth->execute([
            'id' => $album->getId(),
            'title' => $album->getTitle(),
            'author' => $album->getAuthor(),
            'created_at' => $album->getCreatedAt(),
            'file' => $album->getFile(),
        ]);
    }

    public static function update(Album $album)
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->prepare('update albums set title=:title, author=:author, file=:file where id =:id');

        $sth->execute([
            'id' => $album->getId(),
            'title' => $album->getTitle(),
            'author' => $album->getAuthor(),
            'file' => $album->getFile(),
        ]);
    }

    public static function delete(Album $album)
    {
        $db = Database::getInstance()->getConnexion();
        $sth = $db->prepare('delete from albums where id=:id');

        $sth->execute(['id' => $album->getId()]);
    }

    public static function getListAlbums($limit)
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->query("SELECT * FROM albums LIMIT $limit");

        $rawAlbums = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = [];
        foreach ($rawAlbums as $rawAlbum) {
            $albums[] = Album::initialize($rawAlbum);
        }

        return $albums;
    }

    public static function getAllAlbums()
    {
        $db = Database::getInstance()->getConnexion();

        $sth = $db->query('SELECT * FROM albums');

        $rawAlbums = $sth->fetchAll(PDO::FETCH_ASSOC);
        $albums = [];
        foreach ($rawAlbums as $rawAlbum) {
            $albums[] = Album::initialize($rawAlbum);
        }

        return $albums;
    }
}
