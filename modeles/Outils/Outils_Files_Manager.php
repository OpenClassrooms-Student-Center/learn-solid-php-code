<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Outils_FilesManager
 *
 * @author mickael.andrieu
 */
class Outils_Files_Manager {
    
    static public function deleteFile($filename, $path){
        unlink($path . $filename);
    }
}

?>
