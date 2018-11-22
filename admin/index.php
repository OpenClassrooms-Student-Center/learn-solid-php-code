<?php
require_once '../config/config.php';

use App\Classes\Album\Album;
use App\Classes\Album\Album_Bd;
use App\Classes\Album\Album_Form;
use App\Classes\Album\Album_Ui;
use App\Classes\Musique\Musique;
use App\Classes\Musique\Musique_Bd;
use App\Classes\Musique\Musique_Form;
use App\Classes\Musique\Musique_List;
use App\Classes\Musique\Musique_Ui;
use App\Classes\Outils\Outils_Bd;
use App\Classes\Outils\Outils_Chaines;
use App\Classes\Outils\Outils_Upload;
use App\Classes\Outils\Outils_Files_Manager;

try {
    $getRequest = $_GET;
    $postRequest = $_POST;
    $fileRequest = $_FILES;
  
    $action = isset($getRequest['a']) ? $getRequest['a'] : '';

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
    switch ($action) {
        case 'ajouter':
            $titre = "Ajouter un album";
            $Album = Album::initialize();
            $form = new Album_Form($Album);
            $c = $form->makeForm(ADMIN_URL."index.php?a=enregistrernouveau", "ajouter");
            $c .= <<<EOT
                <script type="text/javascript">
                    $('.nav li:eq(0)').attr('class','active');
                </script>
EOT;
        break;

        case 'modifier':
            $titre = "Modifier un album";
            if (isset($getRequest['id'])) {
                $id = $getRequest['id'];
                $Album = Album_Bd::lire($id);
                $form = new Album_Form($Album);
                $c = '<div class="row-fluid show-grid"><div class="span4">'.$form->makeForm(ADMIN_URL."index.php?a=enregistrermodif&amp;id=$id", 'Modifier').'</div>';

                $playlist = new Musique_List(Album_Bd::getPlayList($id));
                $c .= '<div class="span8">'.$playlist->viewHtml().'</div></div>';
            } else {
                $c = "<h3 class='alert'>Echec lors de la modification de l'album</h3>";
            }

        break;
   
        case 'enregistrernouveau':
            $titre = "Création d'album";
    
            $data = is_array($postRequest) ? $postRequest : array();
            $file_data = is_array($fileRequest) ? $fileRequest : array();
            $data['fichier'] = $data['id'] . $file_data['fichier']['name'];
            Outils_Chaines::htmlEncodeArray($data);
            $Album = Album::initialize($data);
            $form = new Album_Form($Album);
    
            if ($form->verifier($file_data['fichier']['type'])) {
                $titre = 'Album enregistré';

                $ObjFichier = new Outils_Upload('fichier');
                $ObjFichier->typesValides = array('image/png','image/jpg','image/jpeg','image/JPG');
                $ObjFichier->setNom($data['fichier']);
                $ObjFichier->uploadFichier(DATA_FILE);
                $ObjFichier->redimensionner(DATA_FILE.'/'.$data['fichier'], DATA_FILE.'/'.'tb_'.$data['fichier'], 150, 150);
                Album_Bd::enregistrerNouveau($Album);
        
                $Album_Ui = new Album_Ui($Album);
                $c = $Album_Ui->makeTableView();
            } else {
                $c = "<h3 class='alert'>Echec d'enregistrement</h3>";
                $c .= $form->makeForm(ADMIN_URL.'index.php?a=enregistrernouveau', 'ajouter');
            }

        break;

    case 'enregistrermodif':
        $titre = 'Modifications enregistrées';
        $data = is_array($postRequest) ? $postRequest : array();
        $file_data = is_array($fileRequest['fichier']) ? $fileRequest['fichier'] : array();
        if (isset($data['id'])) {
            $id = $data['id'];

            if (!empty($file_data['name'])) {
                /* attention à ne pas effacer si le nom du nouveau fichier
                             est identique à son prédecesseur */
                if ($id . $file_data['name'] == $data['fichier']) {
                    $case = 1; // On uploade mais on efface pas
                } else {
                    $case = 2; //On uploade et on efface
                    $data['fichier'] = $data['id'] . $file_data['name'];
                }
            } else {
                $case = 0;
                $file_data['type']= 'image/jpeg';
            }

            Outils_Chaines::htmlEncodeArray($data);

            $Album = Album_Bd::lire($id);

            if ($case > 0) {
                $ObjFichier = new Outils_Upload('fichier');
                $ObjFichier->typesValides = array('image/png','image/jpg','image/jpeg','image/JPG');
                $ObjFichier->setNom($data['fichier']);
                $ObjFichier->uploadFichier(DATA_FILE);
                $ObjFichier->redimensionner(DATA_FILE.'/'.$data['fichier'], DATA_FILE.'/'.'tb_'.$data['fichier'], 150, 150);

                if ($case > 1) {
                    Outils_Files_Manager::deleteFile($Album->getFichier(), DATA_FILE);
                    Outils_Files_Manager::deleteFile('tb_'.$Album->getFichier(), DATA_FILE);
                }
            }
         
            $Album->update($data);
            Album_Bd::enregistrerModif($Album);
            $form = new Album_Form($Album);
            if ($form->verifier($file_data['type'])) {
                Album_Bd::enregistrerModif($Album);
                $Album_display = new Album_Ui($Album);
                $c = $Album_display->makeHtml();
            } else {
                $titre = "Echec de modification";
                $c = $form->makeForm(ADMIN_URL."index.php?a=enregistrermodif&amp;id=$id", 'modifier');
            }
        }
    break;

    case 'supprimer':
        $titre = 'Album supprimé';
        $id = $getRequest['id'];
        $Album = Album_Bd::lire($id);
        Album_Bd::supprimer($Album);
        Outils_Files_Manager::deleteFile($Album->getFichier(), DATA_FILE);
        Outils_Files_Manager::deleteFile('tb_'.$Album->getFichier(), DATA_FILE);
        $ListOfMusics = Album_Bd::getPlayList($id);

        foreach ($ListOfMusics as $Music) {
            Outils_Files_Manager::deleteFile($Music->getFichier(), DATA_FILE);
        }

    break;

/* Gestion des pistes */

    case 'uploader':
        $titre = "Upload d'un titre";
        if (isset($getRequest['id'])) {
            $id_album = $getRequest['id'];

            $Musique = Musique::initialize();
            $form = new Musique_Form($Musique);
            $c = $form->makeForm(ADMIN_URL."index.php?a=ajouter_musique&amp;id_album=$id_album", "ajouter une piste");
        }
    break;

    case 'ajouter_musique':
        if (isset($getRequest['id_album'])) {
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
            if ($form->verifier($file_data['fichier']['type'])) {
                $titre = "Piste enregistrée";

                $ObjFichier = new Outils_Upload('fichier');
                $ObjFichier->typesValides = array('audio/mp3');
                $ObjFichier->setNom($data['fichier']);
                $ObjFichier->uploadFichier(DATA_FILE);

                Musique_Bd::enregistrerNouveau($Musique);
                $Musique_Ui = Musique_Ui::factory($Musique);
                $c = $Musique_Ui->makeAdminHtml();
            } else {
                $c = "<h3 class='alert'>Echec d'enregistrement</h3>";
                $id_album = $data['id_album'];
                $c .= $form->makeForm(ADMIN_URL."index.php?a=ajouter_musique&amp;id_album=$id_album", "ajouter une piste");
            }
        }
    break;

    case 'modifier_musique':
       $titre = 'Modifier une Musique';
        if (isset($getRequest['id'])) {
            $id = $getRequest['id'];
            $Musique = Musique_Bd::lire($id);
            $form = new Musique_Form($Musique);
            $c = $form->makeForm(ADMIN_URL."index.php?a=modifier_musique_modif&amp;id=$id", 'Modifier');
        } else {
            $c = "<h3 class='alert'>Echec lors de la modification de la Musique</h3>";
        }
    break;

    case 'modifier_musique_modif':
        $titre = 'Modifications enregistrées';
        $data = is_array($postRequest) ? $postRequest : array();
        $file_data = is_array($fileRequest['fichier']) ? $fileRequest['fichier'] : array();
        if (isset($data['id'])) {
            $id = $data['id'];

            if (!empty($file_data['name'])) {
                /* attention à ne pas effacer si le nom du nouveau fichier est identique à son prédecesseur */
                if ($id . $file_data['name'] == $data['fichier']) {
                    $case = 1; // On uploade mais on efface pas
                } else {
                    $case = 2; //On uploade et on efface
                    $data['fichier'] = $data['id'] . $file_data['name'];
                }
            } else {
                $case = 0;
                $file_data['type']= 'audio/mpeg';
            }
            Outils_Chaines::htmlEncodeArray($data);

            $Musique = Musique_Bd::lire($id);
            /* mettre à jour avec les données du formulaire, impose de redownloader l'image? */
            if ($case >0) {
                //Si nouveau, alors upload/redimensionnement de la nouvelle image
                $ObjFichier = new Outils_Upload('fichier');
                $ObjFichier->TypesValides = array('audio/ogg','audio/mpeg');
                $ObjFichier->setNom($data['fichier']);
                $ObjFichier->uploadFichier(DATA_FILE);
                if ($case > 1) {
                    Outils_Files_Manager::deleteFile($Musique->getFichier(), DATA_FILE);
                }
            }

            $Musique->update($data);
            Musique_Bd::enregistrerModif($Musique);
            $form = new Musique_Form($Musique);
            if ($form->verifier($file_data['type'])) {
                Musique_Bd::enregistrerModif($Musique);
                $Musique_display = Musique_Ui::factory($Musique);
                $c = $Musique_display->makeHtml();
            } else {
                $titre = "Echec de modification";
                $c = $form->makeForm(ADMIN_URL."index.php?a=modifier_musique_modif&amp;id=$id", 'modifier');
            }
        }
    break;

    case "supprimer_musique":
        $titre = "Musique supprimée";
        $id = $getRequest['id'];
        $Music = Musique_Bd::lire($id);
        Musique_Bd::supprimer($Music);
        Outils_Files_Manager::deleteFile($Music->getFichier(), DATA_FILE);
    break;

    // Page d'administration : affiche tous les Albums de la BD
    default:
        $titre = "Module d'administration des Albums";

        $req = "select * from tp_upload order by dateIns DESC";
        $db = Outils_Bd::getInstance()->getConnexion();

        $res = $db->query($req);
        $tableau = $res->fetchAll(PDO::FETCH_ASSOC);
        /* Traiter les résultats de la requête pour chaque ligne de résultat */
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
            $Album = Album::initialize($line);
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
