<?php
/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  <http://www.gnu.org/licenses/>
 *
 */


/**
 * Autoload.class.php
 * \brief Sélection dynamique des classes nécessaires à l'application
 * @author Jean-Marc Lecarpentier, Hervé Le Crosnier
 *         Valérie Cauchard, Mickaël Andrieu
 * @since Janvier 2008
 */

/**
 * Pour permettre à l'autoload de fonctionner, il
 * convient de nommer les classes en fonction
 * des bibliothèques de programmes les contenant.
 *
 * Classes propres à l'appli :NomClasse
 *
 * Conventions de nommage : comme pour le
 *  Zend Framework : première lettre capitale,
 *  jamais deux capitales à la suite
 *  http://framework.zend.com/manual/fr/coding-standard.naming-conventions.html
 *
 *********************************************/

function my_autoloader($className)
{
    if (preg_match('#_#', $className)) {
        $tclass=preg_split('#_#', $className);
        $obj=$tclass[0];
    } else {
        $obj=$className;
        $tclass=array($obj);
    }

    $file=LIB_FILE . $obj . "/{$tclass[0]}";

    if (($size = count($tclass)) > 1) {
        for ($i=1;$i<$size; $i++) {
            $file .= "_{$tclass[$i]}";
        }
    }
    $file .= ".php";
  
    if (is_file($file)) {
        require_once($file);
    } else {
        throw new Exception("Erreur Autoload : le fichier {$file} n'existe pas");
    }
} // fin de l'autoload

spl_autoload_register('my_autoloader');
