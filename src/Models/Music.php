<?php

namespace App\Models;

use App\Models\Music\Mp3;

class Music
{
    private $id;
    private $title;
    private $file;
    private $albumId;

    public function __construct($map)
    {
        $this->id = $map['id'];
        $this->title = $map['title'];
        $this->albumId = $map['album_id'];
        $this->file = $map['file'];
    }

    public static function initialize($data = array())
    {
        if (isset($data['id'])) {
            $map['id'] = $data['id'];
        } else {
            $map['id'] = md5(microtime());
        }
        if (isset($data['title'])) {
            $map['title'] = $data['title'];
        } else {
            $map['title'] = '';
        }
        if (isset($data['file'])) {
            $map['file'] = $data['file'];
        } else {
            $map['file'] = '';
        }
        if (isset($data['album_id'])) {
            $map['album_id'] = $data['album_id'];
        } else {
            $map['album_id'] = 0; // this value is not possible
        }

        return self::factory($map);
    }

    public static function factory($map)
    {
        $extension = pathinfo($map['file'], PATHINFO_EXTENSION);
        switch ($extension) {
            case 'mp3':
                return new Mp3($map);
                break;
            case 'ogg':
                break;
            default:
                return new Music($map);
        }
    }

    public function update($updateData)
    {
        if (isset($updateData['title'])) {
            $this->title = $updateData['title'];
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

    public function getFile()
    {
        return $this->file;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAlbumId()
    {
        return $this->albumId;
    }

    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    }
}
