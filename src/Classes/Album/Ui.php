<?php

namespace App\Classes\Album;

class Ui
{
    protected $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function makeHtml()
    {
        $publicUrl = PUBLIC_URL;
        $author = $this->album->getAuthor();
        $id = $this->album->getId();
        $title = $this->album->getTitle();
        $fileSource = DATA_URL . 'tb_' . $this->album->getFile();
        $html = <<<EOT
<div class="album">
    <h3>{$title}</h3>
    <p>par {$author}</p>
    <a href="{$publicUrl}index.php?a=ecouter&amp;id={$id}"><img src="{$fileSource}" alt="{$title}" /></a>
</div>
EOT;

        return $html;
    }

    public function makeRowView()
    {
        $id = $this->album->getId();
        $title = $this->album->getTitle();
        $author = $this->album->getAuthor();
        $publicUrl = PUBLIC_URL;

        $html = <<<EOT
       <tr>
            <td>{$title}</td>
            <td>{$author}</td>
            <td><a class="btn" href="{$publicUrl}index.php?a=ecouter&amp;id={$id}">Ecouter <i class="icon-headphones icon-white"></i></a></td>
       </tr>
EOT;

        return $html;
    }

    public function makeTableView()
    {
        $title = $this->album->getTitle();
        $author = $this->album->getAuthor();
        $fileSource = DATA_URL . 'tb_' . $this->album->getFile();

        $html = <<<EOT
     
   <table class='table table-striped'>
       <thead>
       <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Image</th>
       </tr>
       </thead>
       <tbody>
       <tr>
            <td>{$title}</td>
            <td>{$author}</td>
            <td><img src="{$fileSource}" alt="{$title}" /></td>
       </tr>
       </tbody>
   </table>
EOT;

        return $html;
    }

    public function makeHtmlAdmin()
    {
        $adminUrl = ADMIN_URL;
        $id = $this->album->getId();
        $title = $this->album->getTitle();
        $author = $this->album->getAuthor();
        $fileSource = DATA_URL . 'tb_' . $this->album->getFile();

        $htmlCode = <<<EOT
      <tr>
        <td>{$title}</td>
        <td>{$author}</td>
        <td><img src="{$fileSource}" alt="{$title}" /></td>
        <td>
            <ul class="nav nav-tabs nav-stacked">
                <li><a href="{$adminUrl}index.php?a=modifier&amp;id={$id}">Modifier</a></li>
                <li><a href="{$adminUrl}index.php?a=uploader&amp;id={$id}">Uploader Pistes</a></li>
                <li><a href="#deleteModal" data-toggle="modal">Supprimer</a></li>   
            </ul>
        </td>
      </tr>
EOT;

        return $htmlCode;
    }

    public function displayModal()
    {
        $adminUrl = ADMIN_URL;
        $id = $this->album->getId();
        $html = <<<EOT
      <div id="deleteModal" class="modal hide fade in" >
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h3>Confirmation de Suppression</h3>
                </div>
                <div class="modal-body">
                    <p> Attention: Opération irréversible </p>
                </div>

                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal" href="#">Annuler</a>
                    <a class="btn btn-primary" href="{$adminUrl}index.php?a=supprimer&amp;id={$id}">Confirmer</a>
                </div>
            </div>
EOT;

        return $html;
    }

    public function displayAlbumInfos()
    {
        $author = $this->album->getAuthor();
        $title = $this->album->getTitle();
        $fileSource = DATA_URL . $this->album->getFile();
        $html = <<<EOT
<section id="album-display-infos" class="span4">
    <h3>{$title}</h3>
    <p>Par : <em>{$author}</em></p>
    <img src="{$fileSource}" alt="{$title}" />
</section>
EOT;

        return $html;
    }
}
