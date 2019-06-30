<?php

namespace App\Classes\Album;

class Form
{
    protected $album;
    protected $errors;

    public function __construct($album)
    {
        $this->errors = array(
            'title' => '',
            'author' => '',
            'file' => '',
        );

        $this->album = $album;
    }

    public function makeForm($actionUrl, $invite)
    {
        $title = $this->album->getTitle();
        $author = $this->album->getAuthor();
        $id = $this->album->getId();
        $file = $this->album->getFile();
        if (!empty($this->album->getFile())) {
            $fileSource = DATA_URL . 'tb_' . $this->album->getFile();
            $picture = " <img src=\"{$fileSource}\" alt=\"{$title}\" style=\"margin: 10px 10px; margin-left: 35px; \" />";
        } else {
            $picture = '';
        }
        /* génération du formulaire :
         * - on affiche les données de l'objet dans les différents champs
         * - on affiche aussi les erreurs du formulaire
         */

        /* Il faut ajouter la balise responsable du choix de fichier et le type de codage utilisé */
        $form = <<<EOT
<form action="{$actionUrl}" method="post" enctype="multipart/form-data">
<div class="controls">
    <label for="file">Fichier:</label>
    <input type="file" id="file" onchange="filesInputHandler(this.files,'title')" name="file" value="{$file}">
    <span class="help-inline warning">{$this->errors['file']}</span>
</div>
<div class="controls">
    <label for="title">Titre :</label><span>
    <input type="text" id="title" name="title" value="{$title}" />
    <span class="help-inline">{$this->errors['title']}</span>
</div>
<div class="controls">
     <label for="author">Auteur :</label><span>
     <input type="text" id="author" name="author" value="{$author}" />
     <span class="help-inline warning">{$this->errors['author']}</span>
</div>
<div class="controls">
    {$picture}
</div>
<div class="submit form-actions">
    <button class="btn btn-primary" type="submit" name="go">{$invite}</button>
</div>
</form>
EOT;

        return $form;
    }

    public function verify($mime)
    {
        $allowedMimes = array('image/png', 'image/jpeg');
        $flag = true;
        if ($this->album->getTitle() == '') {
            $this->errors['title'] = '<em class="label label-warning">Il faut entrer le titre.</em>';
            $flag = false;
        }
        if ($this->album->getAuthor() == '' && !preg_match('#\w#', $this->album->getAuthor())) {
            $this->errors['author'] = '<em class="label label-warning">Il faut entrer la auteur.</em>';
            $flag = false;
        }
        if (!in_array($mime, $allowedMimes)) {
            $this->errors['file'] = '<em class="label label-warning">Il faut entrer un fichier valide(png,PNG,jpg,jpeg,JPG).</em>';
            $flag = false;
        }

        return $flag;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
