<?php


class Album_Ui {

 /* Données membres de la classe */
  protected $album;
  
 /* Fonctions membres de la classe */


  /* Constructeur   */

  public function __construct(Album $album) {
    $this->album = $album;

  }




  /* Méthode afficher : afficher l'album avec les liens modifier/supprimer */
  public function makeHtml() {
    $publicurl = PUBLIC_URL;
    $id = $this->album->getId();
    $titre = $this->album->getTitre();
    $fichierSrc = ENTREPOT_URL . 'tb_'. $this->album->getFichier();
    $html = <<<EOT
<div class="album">
    <a href="{$publicurl}index.php?a=ecouter&amp;id={$id}"><img src="{$fichierSrc}" alt="{$titre}" /></a>
</div>
EOT;

    return $html;
  }
  
  public function makeRowView(){
     $id = $this->album->getId();
     $titre = $this->album->getTitre();
     $auteur = $this->album->getAuteur();
     $publicurl = PUBLIC_URL;
     
     $html = <<<EOT
       <tr>
            <td>{$titre}</td>
            <td>{$auteur}</td>
            <td><a class="btn" href="{$publicurl}index.php?a=ecouter&amp;id={$id}">Ecouter <i class="icon-headphones icon-white"></i></a></td>
       </tr>
EOT;
     return $html;
  }
  
  public function makeTableView() {
     $titre = $this->album->getTitre();
     $auteur = $this->album->getAuteur();
     $fichierSrc = ENTREPOT_URL .'tb_'. $this->album->getFichier();
     
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
            <td>{$titre}</td>
            <td>{$auteur}</td>
            <td><img src="{$fichierSrc}" alt="{$titre}" /></td>
       </tr>
       </tbody>
   </table>
EOT;
     return $html;
  }
  
  public function makeHtmlAdmin(){
    $adminurl = ADMIN_URL;
    $id = $this->album->getId();
    $titre = $this->album->getTitre();
    $auteur = $this->album->getAuteur();
    $fichierSrc = ENTREPOT_URL .'tb_'. $this->album->getFichier();
    
    $htmlCode = <<<EOT
      <tr>
        <td>{$titre}</td>
        <td>{$auteur}</td>
        <td><img src="{$fichierSrc}" alt="{$titre}" /></td>
        <td>
            <ul class="nav nav-tabs nav-stacked">
                <li><a href="{$adminurl}index.php?a=modifier&amp;id={$id}">Modifier</a></li>
                <li><a href="{$adminurl}index.php?a=uploader&amp;id={$id}">Uploader Pistes</a></li>
                <li><a href="#deleteModal" data-toggle="modal">Supprimer</a></li>   
            </ul>
        </td>
      </tr>
EOT;

    return $htmlCode;
  }
  
  public function displayModal(){
      $adminurl = ADMIN_URL;
      $id = $this->album->getId();
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
                    <a class="btn btn-primary" href="{$adminurl}index.php?a=supprimer&amp;id={$id}">Confirmer</a>
                </div>
            </div>
EOT;
  return $html;
  }
  public function displayAlbumInfos(){
      
    $auteur = $this->album->getAuteur();
    $titre = $this->album->getTitre();
    $fichierSrc = ENTREPOT_URL . $this->album->getFichier();
    $html = <<<EOT
<section id="album-display-infos" class="span4">
    <h3>{$titre}</h3>
    <p>Par : <em>{$auteur}</em></p>
    <img src="{$fichierSrc}" alt="{$titre}" />
</section>
EOT;

    return $html; 
  }

} // fin class Album_Ui
