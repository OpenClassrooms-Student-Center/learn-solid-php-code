<?php

/**
 * Global configuration of application
 */

function get($configKey, $default)
{
    if (getenv($configKey) !== false) {
        return getenv($configKey);
    }

    return $default;
}

define('SERVEUR_URL', '');
define('BASE_URL', SERVEUR_URL . '/');
define('BASE_FILE', __DIR__.'/../');
define('VIEWS', __DIR__.'/../views/');

define('PUBLIC_URL', BASE_URL . 'public/');
define('ADMIN_URL', BASE_URL . 'admin/');

/**
 * files repository
 */
define('DATA_URL', BASE_URL . 'data/');
define('DATA_FILE', BASE_FILE . 'data/');

/**
 * Database configuration
 */
define('DB_CONFIG', "config/config_db.php");
