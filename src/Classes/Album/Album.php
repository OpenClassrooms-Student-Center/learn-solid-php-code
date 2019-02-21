<?php

namespace App\Classes\Album;

class Album
{
    private $id;
    private $title;
    private $author;
    private $file;
    private $createdAt;

    protected function __construct($map)
    {
        $this->id = $map['id'];
        $this->title = $map['title'];
        $this->author = $map['author'];
        $this->file = $map['file'];
        $this->createdAt = $map['created_at'];
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
        if (isset($data['author'])) {
            $map['author'] = $data['author'];
        } else {
            $map['author'] = '';
        }
        if (isset($data['file'])) {
            $map['file'] = $data['file'];
        } else {
            $map['file'] = '';
        }
        if (isset($data['created_at'])) {
            $map['created_at'] = $data['created_at'];
        } else {
            $map['created_at'] = date('Y-m-d H:i:s');
        }

        return new self($map);
    }

    public function update($updateData)
    {
        if (isset($updateData['title'])) {
            $this->title = $updateData['title'];
        }
        if (isset($updateData['author'])) {
            $this->author = $updateData['author'];
        }
        if (isset($updateData['file'])) {
            $this->file = $updateData['file'];
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Retourne la auteur
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Retourne le fichier
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Retourne la date de création
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Modifie la auteur de l'album
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Modifie le fichier
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Modifie la date
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
