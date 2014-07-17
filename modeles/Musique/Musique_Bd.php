<?php

use modeles/Musique/Musique;
/**
 * Description of Musique_Bd
 *
 * @author mickael.andrieu
 */
class Musique_Bd {
    
    /* les fonctions bateaux et standards... */
    public static function lire($id) {  
    /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("SELECT * FROM songs WHERE id=:id");
    /* recuperer les donnes */
    $data=array('id' => $id);
    /* executer la requete */
    $sth->execute($data);
    /* recuperer le resultat */
    $ligne = $sth->fetch(PDO::FETCH_ASSOC);

    /*retourner un objet Photo */
    return Musique::initialize($ligne);

    }
  

  /* Méthode enregistrer() : enregistre les données dans la Bd */
  static public function enregistrerNouveau(Musique $musique) { 

     /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("insert into songs set id=:id,titre=:titre,fichier=:fichier,id_album=:id_album");

    /* recuperer les donnes */
    $data=array(
		'id' => $musique->getId(),
		'titre' => $musique->getTitre(),
                'fichier' => $musique->getFichier(),
		'id_album' => $musique->getIdAlbum()
		);

    /* executer la requete */
    $sth->execute($data);    
  }


  /* Méthode enregistrer() : enregistre les données dans la BdD */
 static public function enregistrerModif(Musique $musique) { 
   /* Enregistrer le fichier */
   
   /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("update songs set titre=:titre where id=:id");

    /* recuperer les donnes */
    $data=array(
		'id' => $musique->getId(),
		'titre' => $musique->getTitre()
               );

    /* executer la requete */
    $sth->execute($data);
  }


  /* Méthode supprimer : faire la requête DELETE en BD 
   * même principe que précédement pour les exceptions
  */
 static public function supprimer(Musique $musique) {
     /* supprimer le fichier */
   
     /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("delete from songs where id=:id");

    /* recuperer les donnes */
    $data=array('id' => $musique->getId());

    /* executer la requete */
    $sth->execute($data);
  }
  
}

?>
