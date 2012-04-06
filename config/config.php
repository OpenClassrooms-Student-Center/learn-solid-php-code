<?php

/**
 *
 *  URL de base de l'application
 *
 *  @note : attention au / final
 */

define('SERVEUR_URL', '');

define('BASE_URL', SERVEUR_URL . '');
define('BASE_FILE', '');

define('LIB_FILE', BASE_FILE . 'modeles/');

define('PUBLIC_URL', BASE_URL . "public/");
define('ADMIN_URL', BASE_URL . "admin/");


/**
 * entrepot 
 */
define('ENTREPOT_URL', BASE_URL . 'entrepot/');
define('ENTREPOT_FILE', BASE_FILE . 'entrepot/');

/**
 * librairies externes
 */
define('HELPER_URL', BASE_URL . 'helpers/');
define('HELPER_FILE', BASE_FILE . 'helpers/');



/**
 *
 *  Base de données
 *
 */

define('DB_CONFIG', "config/config_db.php");


/**
 *
 *  Appel des autres fichiers de configuration
 *  et de l'Autoload
 *
 */


require_once(BASE_FILE . 'config/autoload.php');
require_once(BASE_FILE . DB_CONFIG);







?>
