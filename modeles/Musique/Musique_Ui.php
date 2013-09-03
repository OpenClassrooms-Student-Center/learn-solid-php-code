<?php

use modeles/Musique/Musique;
/**
 * Description of Musique_Ui
 *
 * @author mickael.andrieu
 */
class Musique_Ui {
    
    public function __construct($musique){
        $this->musique = $musique;
    }
    public static function factory(Musique $musique) {
                $extension=pathinfo($musique->getFichier(),PATHINFO_EXTENSION);
		switch($extension) {
		case "mp3" :
			return new Musique_Mp3_Ui($musique);
			break;
                case "ogg" :
                       //return new Musique_Ui_Ogg($musique);
                       break;
		default : 
			throw new Exception("Le fichier pas de type reconnu : {$extension}");
		}
  }
}

?>
