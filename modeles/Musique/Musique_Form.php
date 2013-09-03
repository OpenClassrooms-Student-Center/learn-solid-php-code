<?php
/**
 * Description of Musique_Form
 *
 * @author mickael.andrieu
 */
class Musique_Form {
    
    /* Données membres de la classe */
  protected $musique;
  protected $erreurs; // tableau contenant les erreurs du formulaire 

  /* Constructeur   */

  public function __construct($musique) {
     /* initialisation du tableau des erreurs */
    $this->erreurs = array(
			   'titre' => "",
			   'fichier' => ""
			   );
    /* initialisation du musique */
    $this->musique = $musique;

  }


  public function makeForm($actionUrl,$invite) {
   
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

   /* vérification du formulaire
   * la méthode renvoie un booléen, on pourrait imaginer le faire avec 
   * une exception mais ce n'est pas mieux
   */
  public function verifier($mime) {
    $flag = true;
    if ($this->musique->getTitre() == "") {
      $this->erreurs["titre"] = '<em class="label label-warning">Il faut entrer le titre.</em>';
      $flag = false;
    }
    if (preg_match('$audio/mpeg$',$mime)== 0) {
      $this->erreurs["fichier"] = '<em class="label label-warning">Fichier mp3 requis.</em>' ;
      $flag = false;
    }
    return $flag;
  }

} // fin class Musique_Form

?>
