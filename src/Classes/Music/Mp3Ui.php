<?php

namespace App\Classes\Music;

class Mp3Ui extends Ui
{
    protected $music;

    public function __construct($music)
    {
        parent::__construct($music);
    }

    public function makeHtml()
    {
        $title = $this->music->getTitle();

        $fileSource = DATA_URL . $this->music->getFile();

        $html = <<<EOT
                <a data-src="{$fileSource}" href="#">{$title}</a>
    
EOT;

        return $html;
    }

    public function makePlayer()
    {
        $title = $this->music->getTitle();
        $fileSource = DATA_URL . $this->music->getFile();

        $html = <<<EOT
           <audio src="{$fileSource}" preload="auto"></audio>
           <div class="track-details">
                {$title}
            </div>
            <div class"track-volume">
                <em>Volume:</em>
                <a href="#" id="vol-0">Off</a> -
                <a href="#" id="vol-10">10%</a> -
                <a href="#" id="vol-40">40%</a> -
                <a href="#" id="vol-70">70%</a> -
                <a href="#" id="vol-100">100%</a>
            </div>
EOT;

        return $html;
    }

    public function makeAdminHtml()
    {
        $id = $this->music->getId();
        $albumId = $this->music->getAlbumId();
        $title = $this->music->getTitle();
        $adminUrl = ADMIN_URL;

        $html = <<<EOT
           <table class='table table-striped'>
               <thead>
                   <tr>
                       <th>Titre</th><th>Actions</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>{$title}</td>
                       <td>
                            <a class="btn" href="{$adminUrl}index.php?a=modifier_musique&amp;id={$id}">Modifier <i class="icon-edit icon-white"></i></a>
                            <a class="btn" href="{$adminUrl}index.php?a=supprimer_musique&amp;id={$id}">Supprimer <i class="icon-trash icon-white"></i></a>
                        </td>
                   </tr>
               </tbody>
           </table>
           <div class="submit form-actions">
               <a class="btn btn-primary" href="{$adminUrl}index.php?a=uploader&amp;id={$albumId}">Ajouter une piste</a>
           </div>
EOT;

        return $html;
    }

    public function makeAdminRowHtml()
    {
        $id = $this->music->getId();
        $title = $this->music->getTitle();
        $adminUrl = ADMIN_URL;

        $html = <<<EOT
                   <tr>
                       <td>{$title}</td>
                       <td>
                            <a class="btn" href="{$adminUrl}index.php?a=modifier_musique&amp;id={$id}">Modifier <i class="icon-edit icon-white"></i></a>
                            <a class="btn" href="#deleteModal" data-toggle="modal">Supprimer <i class="icon-trash icon-white"></i></a>
                        </td>
                   </tr>
EOT;

        return $html;
    }

    public function displayModal()
    {
        $adminUrl = ADMIN_URL;
        $id = $this->music->getId();
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
                    <a class="btn btn-primary" href="{$adminUrl}index.php?a=supprimer_musique&amp;id={$id}">Confirmer</a>
                </div>
            </div>
EOT;

        return $html;
    }
}
