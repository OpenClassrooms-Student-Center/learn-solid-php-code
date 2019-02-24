<?php

namespace App\Classes\Music;

class Form
{
    protected $music;
    protected $erreurs;

    public function __construct($music)
    {
        $this->errors = [
               'title' => '',
               'file' => '',
        ];

        $this->music = $music;
    }

    public function makeForm($actionUrl, $invite)
    {
        $title = $this->music->getTitle();
        $id = $this->music->getId();
        $file = $this->music->getFile();

        $text = <<<EOT
<form class="form-horizontal" action="{$actionUrl}" method="post" enctype="multipart/form-data">
    <div class="controls">
        <label for="file">Fichier:</label>
        <input type="file" id="file" onchange="filesInputHandler(this.files,'title')"  name="file" value="{$file}" />
        <span class="help-inline">{$this->errors['file']}</span>
    </div>
    <div class="controls">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" value="{$title}" />
        <span class="help-inline">{$this->errors['title']}</span>
    </div>
    <div class="submit form-actions">
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="file" value="{$file}" />
        <button class="btn btn-primary" type="submit" name="go">{$invite}</button>
    </div>
</form>
EOT;

        return $text;
    }

    public function verify($mime)
    {
        $flag = true;
        if (empty($this->music->getTitle())) {
            $this->errors['title'] = '<em class="label label-warning">Il faut entrer le titre.</em>';
            $flag = false;
        }
        if (preg_match('$audio/mp3$', $mime) === 0) {
            $this->errors['file'] = '<em class="label label-warning">Fichier mp3 requis, ' . $mime . ' trouvé.</em>';
            $flag = false;
        }

        return $flag;
    }
}
