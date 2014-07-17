<?php

/**
 * Description of Outils_Upload
 *
 * @author mickael.andrieu
 */
class Outils_Upload {
    
	private $Nom            ='';
	private $Type           ='';
	public $Repertoire     ='';
	private $Temp           ='';
	public $typesValides   = array();
	private $Erreur         ='';


	public  function __construct($Fichier)
	{
			$this->Temp = $_FILES[$Fichier]['tmp_name'];
			$this->Nom = $_FILES[$Fichier]['name'];
			$this->Type =$_FILES[$Fichier]['type'];

	}

	public  function setTypesValides($typesValides)
	{
			$this->typesValides = $typesValides;
	}	
	
	public  function UploadFichier($Repertoire='./')
	{
            if(!is_uploaded_file($this->Temp))
            {
              $this->Erreur='Vous avez rien uploadé';
		return false;
		
            }

            else if(!in_array($this->Type,$this->TypesValides))
            {
              $this->Erreur= 'Le fichier '.$this->Nom.' n\'est pas d\'un type valide';
		return false;
            }

            elseif(!move_uploaded_file($this->Temp, $Repertoire.$this->Nom))
            {
              $this->Erreur='Problème lors de la copie du fichier '.$this->Nom;
		return false;
            }
            else return true;
	}
	
	public  function UploadErreur()
	{
			return $this->Erreur='Aucune erreur';
	}

	public  function setNom($Nom)
	{
		$this->Nom=$Nom;
	}		
		
	public  function getType()
	{
			return($this->Type);
	}	
		
	public  function getNom()
	{
		return($this->Nom);
	}
        
        public function getExtension()
        {
            return pathinfo($this->Nom,PATHINFO_EXTENSION);
        }
        
        /*
         *  parametres: orig => image d'origine
         *              dest => image de destination
         *              et les dimensions
         */
        public function redimensionner($orig, $dest, $newLargeur, $maxHauteur) {
    
            $type = $this->getExtension();
            $png_family = array('PNG','png');
            $jpeg_family = array('jpeg','jpg','JPG');
            if(in_array($type,$jpeg_family)){$type='jpeg';}
            elseif(in_array($type,$png_family)){$type='png';}
            $fonction = "imagecreatefrom" . $type;

            $image = $fonction($orig); 

            $largeurImage = imagesx($image);
            if ($largeurImage < $newLargeur) {
              if (!copy($orig, $dest)) {
                throw new Exception("Impossible de copier le fichier {$orig} vers {$dest}");
              }
            } else {
              $hauteurImage = imagesy($image);   
              $newHauteur = (int)(($newLargeur*$hauteurImage) / $largeurImage );       
              if ($newHauteur > $maxHauteur) {
                $newHauteur = $maxHauteur;
                $newLargeur = (int) (($newHauteur * $largeurImage) / $hauteurImage);
              }
              $newImage  = imagecreatetruecolor($newLargeur, $newHauteur);
              imagecopyresampled ($newImage, $image, 0, 0, 0, 0, $newLargeur, $newHauteur, $largeurImage, $hauteurImage);     

              $fonction= "image" . $type;
              $fonction($newImage,$dest);

              imagedestroy($newImage);
              imagedestroy($image);
            }
          }
		
}

?>
