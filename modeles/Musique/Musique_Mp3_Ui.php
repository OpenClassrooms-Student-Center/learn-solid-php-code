<?php
/**
 * Description of Musique_Ui
 *
 * @author mickael.andrieu
 */
class Musique_Mp3_Ui extends Musique_Ui{
    
    protected $musique;
    
    /* Constructeur   */
    
    public function __construct(Musique_Mp3 $musique){
        parent::__construct($musique);
    }
    
     /* Méthode afficher : afficher la musique */
  public function makeHtml() {
    $titre = $this->musique->getTitre();
    
    $fichierSrc = ENTREPOT_URL . $this->musique->getFichier();

    $html = <<<EOT
                <a data-src="{$fichierSrc}" href="#">{$titre}</a>
    
EOT;

    return $html;
  }
  
  public function makePlayer(){
      $titre = $this->musique->getTitre();
      $fichierSrc = ENTREPOT_URL . $this->musique->getFichier();
      
      $html = <<<EOT
           <audio src="{$fichierSrc}" preload="auto"></audio>
           <div class="track-details">
                {$titre}
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
  
  public function makeAdminHtml(){
      $id = $this->musique->getId();
      $id_album = $this->musique->getId_album();
      $titre = $this->musique->getTitre();
      $adminurl = ADMIN_URL;
      
      $html = <<<EOT
           <table class='table table-striped'>
               <thead>
                   <tr>
                       <th>Titre</th><th>Actions</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>{$titre}</td><td>
                                            <a class="btn" href="{$adminurl}index.php?a=modifier_musique&amp;id={$id}">Modifier <i class="icon-edit icon-white"></i></a>
                                            <a class="btn" href="{$adminurl}index.php?a=supprimer_musique&amp;id={$id}">Supprimer <i class="icon-trash icon-white"></i></a>
                                        </td>
                   </tr>
               </tbody>
           </table>
           <div class="submit form-actions">
               <a class="btn btn-primary" href="{$adminurl}index.php?a=uploader&amp;id={$id_album}">Ajouter une piste</a>
           </div>
EOT;
      return $html;
  }
  
  public function makeAdminRowHtml(){
      $id = $this->musique->getId();
      $titre = $this->musique->getTitre();
      $fichierSrc = ENTREPOT_URL . $this->musique->getFichier();
      $adminurl = ADMIN_URL;
      
      $html = <<<EOT
                   <tr>
                       <td>{$titre}</td><td>
                                            <a class="btn" href="{$adminurl}index.php?a=modifier_musique&amp;id={$id}">Modifier <i class="icon-edit icon-white"></i></a>
                                            <a class="btn" href="#deleteModal" data-toggle="modal">Supprimer <i class="icon-trash icon-white"></i></a>
                                        </td>
                   </tr>
EOT;
      return $html;
  }

public function displayModal(){
      $adminurl = ADMIN_URL;
      $id = $this->musique->getId();
      $html= <<<EOT
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
                    <a class="btn btn-primary" href="{$adminurl}index.php?a=supprimer_musique&amp;id={$id}">Confirmer</a>
                </div>
            </div>
EOT;
  return $html;
  }
}
?>
