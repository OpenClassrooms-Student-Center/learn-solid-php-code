<?php 
require_once("../config/config.php");
try {
  $getRequest = $_GET;
  $postRequest = $_POST;
  $fileRequest = $_FILES;
  
  $action = isset($getRequest['a']) ? $getRequest['a'] : "";

  // initialisation des variables
  $titre="";
  $c="";
  $header = file_get_contents("../ui/fragments/header.frg.html");
  $footer = file_get_contents("../ui/fragments/footer.frg.html");
  $squelette = "../ui/pages/galerie.html.php";


  /* contrôleur : 
   * indique que faire en fonction de l'action demandée 
   * par l'utilisateur
   */
  switch($action) {
  
      /*
       * 
       *   GESTION DES ALBUMS
       * 
       */
       
    /* ajouter un nouvel album */
  case "ajouter" : 
    $titre = "Ajouter un album";   
    /* créer une Album vide */
    $Album = Album::initialize(); 
    /* afficher le formulaire */
    $form = new Album_Form($Album);
    $c = $form->makeForm(ADMIN_URL."index.php?a=enregistrernouveau", "ajouter");
    $c .= <<<EOT
        <script type="text/javascript">
            $('.nav li:eq(0)').attr('class','active');
        </script>
EOT;
    break;
  
    /* modifier un album */
  case "modifier" : 
    $titre = "Modifier un album";
    if (isset($getRequest['id'])) {
      $id = $getRequest['id'];
      $Album = Album_Bd::lire($id);
      $form = new Album_Form($Album);
      $c = '<div class="row-fluid show-grid">
                <div class="span4">'.$form->makeForm(ADMIN_URL."index.php?a=enregistrermodif&amp;id=$id",'Modifier').'</div>';
      
      /* rajouter la liste des pistes */
      $playlist = new Musique_List(Album_Bd::getPlayList($id));
      $c .= '<div class="span8">'.$playlist->viewHtml().'</div>
          </div>';
      } else {
        $c = "<h3 class='alert'>Echec lors de la modification de l'album</h3>";
    }

    break;
   
  case "enregistrernouveau":
    $titre = "Création d'album";
    /* créer une Album à partir des infos du formulaire */  
    
    $data = is_array($postRequest) ? $postRequest : array();
    $file_data = is_array($fileRequest) ? $fileRequest : array();
    $data['fichier'] = $data['id'] . $file_data['fichier']['name'];
    Outils_Chaines::htmlEncodeArray($data);
    $Album = Album::initialize($data);
    $form = new Album_Form($Album);
    
    if($form->verifier($file_data['fichier']['type']))
    {
        $titre = "Album enregistré";
        
        /* enregistrer l'image dans l'entrepot */
        $ObjFichier = new Outils_Upload('fichier');
        $ObjFichier->typesValides = array('image/png','image/jpg','image/jpeg','image/JPG');
        $ObjFichier->setNom($data['fichier']);
        $ObjFichier->UploadFichier(ENTREPOT_FILE);
        $ObjFichier->redimensionner(ENTREPOT_FILE.'/'.$data['fichier'], ENTREPOT_FILE.'/'.'tb_'.$data['fichier'], 150, 150);
        Album_Bd::enregistrerNouveau($Album);
        
        $Album_Ui = new Album_Ui($Album);
        $c = $Album_Ui->makeTableView();
    }
    else
    {   
        $c = "<h3 class='alert'>Echec d'enregistrement</h3>";
        $c .= $form->makeForm(ADMIN_URL.'index.php?a=enregistrernouveau', 'ajouter');
        
     }

    break;

  case "enregistrermodif":
    $titre = "Modifications enregistrées";
    /* créer un Album à partir des infos du formulaire et des infos de la BD */
    $data = is_array($postRequest) ? $postRequest : array();
    $file_data = is_array($fileRequest['fichier']) ? $fileRequest['fichier'] : array();
    if (isset($data['id'])) {
        $id = $data['id'];
        
        if(!empty($file_data['name']) ){
            /* attention à ne pas effacer si le nom du nouveau fichier
                         est identique à son prédecesseur */
            if( $id . $file_data['name'] == $data['fichier'])
            {
                $case = 1; // On uploade mais on efface pas
            }
            else{
                $case = 2; //On uploade et on efface
                $data['fichier'] = $data['id'] . $file_data['name'];
            }
        }else{$case = 0; $file_data['type']= 'image/jpeg';} //On ne fait rien, juste déclarer un type valide
        Outils_Chaines::htmlEncodeArray($data);
    
         
         /* créer une Album à partir des infos de la BD */
         $Album = Album_Bd::lire($id);
         /* mettre à jour avec les données du formulaire, impose de redownloader l'image? */
         if($case >0)
         {
             //Si nouveau, alors upload/redimensionnement de la nouvelle image
             $ObjFichier = new Outils_Upload('fichier');
             $ObjFichier->typesValides = array('image/png','image/jpg','image/jpeg','image/JPG');
             $ObjFichier->setNom($data['fichier']);
             $ObjFichier->UploadFichier(ENTREPOT_FILE);
             $ObjFichier->redimensionner(ENTREPOT_FILE.'/'.$data['fichier'], ENTREPOT_FILE.'/'.'tb_'.$data['fichier'], 150, 150);
             if($case > 1)
             {
             // Suppression de l'image d'origine
                 Outils_Files_Manager::deleteFile($Album->getFichier(), ENTREPOT_FILE);
                 Outils_Files_Manager::deleteFile('tb_'.$Album->getFichier(), ENTREPOT_FILE);
             }
         }
         
         $Album->update($data);
         Album_Bd::enregistrerModif($Album);
         $form = new Album_Form($Album);
        if($form->verifier($file_data['type']))
        {
         /* enregistrer puis afficher le bookmark */
         Album_Bd::enregistrerModif($Album);
         $Album_display = new Album_Ui($Album);
         $c = $Album_display->makeHtml();
        }
        else
        {
            $titre = "Echec de modification";
            $c = $form->makeForm(ADMIN_URL."index.php?a=enregistrermodif&amp;id=$id", 'modifier');
        }
    }//fin if
    break;

  case "supprimer":
    $titre = "Album supprimé";
      $id = $getRequest['id'];
    /* créer une Album à partir des infos de la BD */
         $Album = Album_Bd::lire($id); 
    /* supprimer l'Album */
         Album_Bd::supprimer($Album);
    /* supprimer l'image et sa miniature */ 
         Outils_Files_Manager::deleteFile($Album->getFichier(), ENTREPOT_FILE);
         Outils_Files_Manager::deleteFile('tb_'.$Album->getFichier(), ENTREPOT_FILE);
    /* supprimer les pistes audio correspondantes */
         $ListOfMusics = Album_Bd::getPlayList($id);
         foreach($ListOfMusics as $Music)
         {
             Outils_Files_Manager::deleteFile($Music->getFichier(),ENTREPOT_FILE);
         } 
    break;

    /*
     * 
     *  GESTION DES PISTES
     * 
     * 
     */


/* Formulaire d'upload */
  case "uploader" :
      $titre = "Upload d'un titre";
      if(isset($getRequest['id'])){
           $id_album = $getRequest['id'];
          
           /* créer un album à partir des infos de la BD */
           $Musique = Musique::initialize();
           $form = new Musique_Form($Musique);
           $c = $form->makeForm(ADMIN_URL."index.php?a=ajouter_musique&amp;id_album=$id_album", "ajouter une piste");
      }
    break;
    
  /* Geston de l'upload */  
  case "ajouter_musique" :
      if(isset($getRequest['id_album'])){
			
            /* créer un Album à partir des infos du formulaire */   
            if (! $fileRequest['fichier']['error'] == 0) {  
                throw new Exception("Problème d'upload, contactez un administrateur...");
            /* en cas de fichier corrompu ou trop gros */
            }
            $data = is_array($postRequest) ? $postRequest : array();
            $file_data = is_array($fileRequest) ? $fileRequest : array();
            
            $data['id_album'] = $getRequest['id_album']; 
            $data['fichier'] = $data['id_album'] . $file_data['fichier']['name'];
            Outils_Chaines::htmlEncodeArray($data);
            
            $Musique = Musique::initialize($data);
            $form = new Musique_Form($Musique);
            if($form->verifier($file_data['fichier']['type']))
            {
				
                $titre = "Piste enregistrée";

                /* enregistrer l'image dans l'entrepot */ 
                $ObjFichier = new Outils_Upload('fichier');
                $ObjFichier->typesValides = array('audio/mp3');
                $ObjFichier->setNom($data['fichier']);
                $ObjFichier->UploadFichier(ENTREPOT_FILE);
                
                /* enregistrement en Bd */
                Musique_Bd::enregistrerNouveau($Musique);
                $Musique_Ui = Musique_Ui::factory($Musique);
                $c = $Musique_Ui->makeAdminHtml();
            }
            else
            {   
                $c = "<h3 class='alert'>Echec d'enregistrement</h3>";
                $id_album = $data['id_album'];
                $c .= $form->makeForm(ADMIN_URL."index.php?a=ajouter_musique&amp;id_album=$id_album", "ajouter une piste");
             }
      }
    break;
    
    case "modifier_musique":
       $titre = "Modifier une Musique";
    if (isset($getRequest['id'])) {
      $id = $getRequest['id'];
      $Musique = Musique_Bd::lire($id);
      $form = new Musique_Form($Musique);
      $c = $form->makeForm(ADMIN_URL."index.php?a=modifier_musique_modif&amp;id=$id",'Modifier');
      } else {
        $c = "<h3 class='alert'>Echec lors de la modification de la Musique</h3>";
    } 
    break;

    case "modifier_musique_modif":
        $titre = "Modifications enregistrées";
    /* créer un Album à partir des infos du formulaire et des infos de la BD */
    $data = is_array($postRequest) ? $postRequest : array();
    $file_data = is_array($fileRequest['fichier']) ? $fileRequest['fichier'] : array();
    if (isset($data['id'])) {
        $id = $data['id'];
        
        if(!empty($file_data['name']) ){
            /* attention à ne pas effacer si le nom du nouveau fichier
                         est identique à son prédecesseur */
            if( $id . $file_data['name'] == $data['fichier'])
            {
                $case = 1; // On uploade mais on efface pas
            }
            else{
                $case = 2; //On uploade et on efface
                $data['fichier'] = $data['id'] . $file_data['name'];
            }
        }else{$case = 0; $file_data['type']= 'audio/mpeg';} //On ne fait rien, juste déclarer un type valide
        Outils_Chaines::htmlEncodeArray($data);
    
         
         /* créer une Musique à partir des infos de la BD */
         $Musique = Musique_Bd::lire($id);
         /* mettre à jour avec les données du formulaire, impose de redownloader l'image? */
         if($case >0)
         {
             //Si nouveau, alors upload/redimensionnement de la nouvelle image
             $ObjFichier = new Outils_Upload('fichier');
             $ObjFichier->TypesValides = array('audio/ogg','audio/mpeg');
             $ObjFichier->setNom($data['fichier']);
             $ObjFichier->UploadFichier(ENTREPOT_FILE);
             if($case > 1)
             {
             // Suppression de la musique d'origine
                 Outils_Files_Manager::deleteFile($Musique->getFichier(), ENTREPOT_FILE);
             }
         }
         
         $Musique->update($data);
         Musique_Bd::enregistrerModif($Musique);
         $form = new Musique_Form($Musique);
        if($form->verifier($file_data['type']))
        {
         /* enregistrer puis afficher la musique */
         Musique_Bd::enregistrerModif($Musique);
         $Musique_display = Musique_Ui::factory($Musique);
         $c = $Musique_display->makeHtml();
        }
        else
        {
            $titre = "Echec de modification";
            $c = $form->makeForm(ADMIN_URL."index.php?a=modifier_musique_modif&amp;id=$id", 'modifier');
        }
    }//fin if
    break;

    case "supprimer_musique":
        $titre = "Musique supprimée";
        $id = $getRequest['id'];
    /* créer une Musique à partir des infos de la BD */
         $Music = Musique_Bd::lire($id); 
    /* supprimer la Musique en BD */
         Musique_Bd::supprimer($Music);
    /* supprimer le fichier correspondant */ 
         Outils_Files_Manager::deleteFile($Music->getFichier(), ENTREPOT_FILE);
    break;
   
 

    // Page d'administration : affiche tous les Albums de la BD
  default : 
    $titre = "Module d'administration des Albums";
    
    /* construire de la requête */
    $req = "select * from tp_upload order by dateIns DESC";
    $db = Outils_Bd::getInstance()->getConnexion();

    $res = $db->query($req);
    $tableau = $res->fetchAll(PDO::FETCH_ASSOC);
    /* Traiter les résultats de la requête 
           Pour chaque ligne de résultat */
    $c = '<table class="table table-striped">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Vignette</th>
            <th>Actions</th>
       </tr>
    </thead>';
    
    foreach ($tableau as $line) {
      /* Créer un Album à partir des infos de la BD */
      $Album = Album::initialize($line);
      /* Afficher le Album */
      $ui = new Album_Ui($Album);
      $c .= $ui->makeHtmlAdmin();
      $c .= $ui->displayModal();

    }
    $c .= '</table>';
    $c .= <<<EOT
        <script type="text/javascript">
            $('.nav li:eq(1)').attr('class','active');
        </script>
EOT;
  }

} catch (Exception $e) {
  $c = $e->getMessage();
  $c .= "<pre>{$e->getTraceAsString()}</pre>";
  }

ob_start();
  require_once($squelette);
  $html = ob_get_contents();
ob_end_clean();
echo $html;

?>
