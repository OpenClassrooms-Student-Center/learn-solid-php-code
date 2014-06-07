<?php

/**
 * Global configuration of application
 */

define('SERVEUR_URL', 'http://www.weplaymusic.fr');
define('BASE_URL', SERVEUR_URL . '/');
define('BASE_FILE', __DIR__.'/../');

define('LIB_FILE', BASE_FILE . 'modeles/');

define('PUBLIC_URL', BASE_URL . "public/");
define('ADMIN_URL', BASE_URL . "admin/");

/**
 * files repository 
 */
define('ENTREPOT_URL', BASE_URL . 'entrepot/');
define('ENTREPOT_FILE', BASE_FILE . 'entrepot/');

/**
 * external libraries
 */
define('HELPER_URL', BASE_URL . 'helpers/');
define('HELPER_FILE', BASE_FILE . 'helpers/');

/**
 * Database configuration
 */
define('DB_CONFIG', "config/config_db.php");


require_once(BASE_FILE . 'config/autoload.php');
require_once(BASE_FILE . DB_CONFIG);
?>
