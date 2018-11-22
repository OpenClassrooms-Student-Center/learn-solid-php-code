<?php

namespace App\Classes\Album;

class Album_Form
{
    protected $album;
    protected $erreurs;

    public function __construct($album)
    {
        $this->erreurs = array(
            'titre' => "",
            'auteur' => "",
            'fichier' => ""
        );

        $this->album = $album;
    }


    public function makeForm($actionUrl, $invite)
    {
        $titre = $this->album->getTitre();
        $auteur = $this->album->getAuteur();
        $id = $this->album->getId();
        $album = $this->album->getFichier();
        if ($this->album->getFichier() != "") {
            $fichierSrc = DATA_URL . 'tb_'. $this->album->getFichier();
            $imagePresente = " <img src=\"{$fichierSrc}\" alt=\"{$titre}\" style=\"margin: 10px 10px; margin-left: 35px; \" />";
        } else {
            $imagePresente = "";
        }
        /* génération du formulaire :
         * - on affiche les données de l'objet dans les différents champs
         * - on affiche aussi les erreurs du formulaire
         */

        /* Il faut ajouter la balise responsable du choix de fichier et le type de codage utilisé */
        $form = <<<EOT
<form action="{$actionUrl}" method="post" enctype="multipart/form-data">
<div class="controls">
    <label for="fichier">Fichier:</label>
    <input type="file" id="fichier" onchange="filesInputHandler(this.files,'titre')" name="fichier" value="{$album}" />
    <span class="help-inline warning">{$this->erreurs["fichier"]}</span>
</div>
<div class="controls">
    <label for="titre">Titre :</label><span>
    <input type="text" id="titre"  name="titre" value="{$titre}" />
    <span class="help-inline">{$this->erreurs["titre"]}</span>
</div>
<div class="controls">
     <label for="auteur">Auteur :</label><span>
     <input type="text" id="auteur" name="auteur" value="{$auteur}" />
     <span class="help-inline warning">{$this->erreurs["auteur"]}</span>
</div>
<div class="controls">
    {$imagePresente}
</div>
<div class="submit form-actions">
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="fichier" value="{$album}" />
    <button class="btn btn-primary" type="submit" name="go">{$invite}</button>
</div>
</form>
EOT;
        return $form;
    }

    public function verifier($mime)
    {
        $mimes_allowed = array('image/png','image/jpeg');
        $flag = true;
        if ($this->album->getTitre() == "") {
            $this->erreurs["titre"] = '<em class="label label-warning">Il faut entrer le titre.</em>';
            $flag = false;
        }
        if ($this->album->getAuteur() == "" && !preg_match('#\w#', $this->album->getAuteur())) {
            $this->erreurs["auteur"] = '<em class="label label-warning">Il faut entrer la auteur.</em>';
            $flag = false;
        }
        if (! in_array($mime, $mimes_allowed)) {
            $this->erreurs["fichier"] = '<em class="label label-warning">Il faut entrer un fichier valide(png,PNG,jpg,jpeg,JPG).</em>';
            $flag = false;
        }
        return $flag;
    }
}
