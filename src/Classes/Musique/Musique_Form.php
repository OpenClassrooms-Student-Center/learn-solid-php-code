<?php

namespace App\Classes\Musique;

class Musique_Form
{
    protected $musique;
    protected $erreurs;

    public function __construct($musique)
    {
        $this->erreurs = array(
               'titre' => '',
               'fichier' => '',
        );

        $this->musique = $musique;
    }


    public function makeForm($actionUrl, $invite)
    {
        $titre = $this->musique->getTitre();
        $id = $this->musique->getId();
        $musique = $this->musique->getFichier();
    
        $text = <<<EOT
<form class="form-horizontal" action="{$actionUrl}" method="post" enctype="multipart/form-data">
    <div class="controls">
        <label for="fichier">Fichier:</label>
        <input type="file" id="fichier" onchange="filesInputHandler(this.files,'titre')"  name="fichier" value="{$musique}" />
        <span class="help-inline">{$this->erreurs["fichier"]}</span>
    </div>
    <div class="controls">
        <label for="titre">Titre :</label>
        <input type="text" id="titre"  name="titre" value="{$titre}" />
        <span class="help-inline">{$this->erreurs["titre"]}</span>
    </div>
    <div class="submit form-actions">
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="fichier" value="{$musique}" />
        <button class="btn btn-primary" type="submit" name="go">{$invite}</button>
    </div>
</form>
EOT;
        return $text;
    }

    public function verifier($mime)
    {
        $flag = true;
        if (empty($this->musique->getTitre())) {
            $this->erreurs["titre"] = '<em class="label label-warning">Il faut entrer le titre.</em>';
            $flag = false;
        }
        if (preg_match('$audio/mp3$', $mime) === 0) {
            $this->erreurs["fichier"] = '<em class="label label-warning">Fichier mp3 requis, ' . $mime . ' trouvé.</em>' ;
            $flag = false;
        }
        return $flag;
    }
}
