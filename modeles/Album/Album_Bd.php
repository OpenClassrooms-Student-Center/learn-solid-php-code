<?php

class Album_Bd {

  /* Fonctions membres de la classe */



/* Initialisation d'un album à partir d'un code album : on va chercher les données dans la BD pour afficher un album ou pour le modifier */ 
  public static function lire($id) {  
    /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("SELECT * FROM tp_upload WHERE id=:id");
    /* recuperer les donnes */
    $data=array('id' => $id);
    /* executer la requete */
    $sth->execute($data);
    /* recuperer le resultat */
    $ligne = $sth->fetch(PDO::FETCH_ASSOC);

    /*retourner un objet Album */
    return Album::initialize($ligne);

}

/* Récupération de toutes les pistes de l'album, on retourne un tableau  */
static public function getPlayList($id) {
     /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("SELECT * FROM songs WHERE id_album=:id_album");
    /* recuperer les donnes */
    $data=array('id_album' => $id);
    /* executer la requete */
    $sth->execute($data);
    /* recuperer le resultat */
    $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
    $musiques = array();
    foreach ($lignes as $ligne) {
        $musiques[] = Musique::initialize($ligne);
    }
    /*retourner un objet Album */
    return $musiques;
}



/* Méthode enregistrer() : enregistre les données dans la Bd */
  static public function enregistrerNouveau(Album $album) { 
    /* Enregistrer le fichier */
    
     /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("insert into tp_upload set id=:id,titre=:titre, auteur=:auteur, fichier=:fichier, dateIns=:dateIns");

    /* recuperer les donnes */
    $data=array(
		'id' => $album->getId(),
		'titre' => $album->getTitre(),
		'auteur' => $album->getAuteur(),
		'dateIns' => $album->getDateIns(),
		'fichier' => $album->getFichier()
		);

    /* executer la requete */
    $sth->execute($data);    
  }


  /* Méthode enregistrer() : enregistre les données dans la BdD */
 static public function enregistrerModif(Album $album) { 
   /* Enregistrer le fichier */
   
   /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("update tp_upload set titre=:titre, auteur=:auteur, fichier=:fichier where id =:id ");

    /* recuperer les donnes */
    $data=array(
		'id' => $album->getId(),
		'titre' => $album->getTitre(),
		'auteur' => $album->getAuteur(),
		'fichier' => $album->getFichier()
);

    /* executer la requete */
    $sth->execute($data);
  }


  /* Méthode supprimer : faire la requête DELETE en BD 
   * même principe que précédement pour les exceptions
  */
 static public function supprimer(Album $album) {
     /* supprimer le fichier */
   
     /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth=$db->prepare("delete from tp_upload where id=:id");

    /* recuperer les donnes */
    $data=array('id' => $album->getId());

    /* executer la requete */
    $sth->execute($data);
  }
  
  /* retourne la liste des albums */
  
  static public function getListAlbums($limit){
         /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth= $db->query("SELECT * FROM tp_upload LIMIT $limit");
    /* recuperer le resultat */
    $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
    $albums = array();
    foreach ($lignes as $ligne) {
        $albums[] = Album::initialize($ligne);
    }
    /*retourner un objet Album */
    return $albums;
  }
  
  static public function getAllAlbums(){
        /* creer la connection BD */
    $db = Outils_Bd::getInstance()->getConnexion();
    /* preparer le requete */
    $sth= $db->query("SELECT * FROM tp_upload");
    /* recuperer le resultat */
    $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
    $albums = array();
    foreach ($lignes as $ligne) {
        $albums[] = Album::initialize($ligne);
    }
    /*retourner un objet Album */
    return $albums;
  }
  
  

} // fin class Album_Bd
?>
