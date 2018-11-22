<?php

/**
 * Singleton
 */
class Outils_Bd
{
    private static $instance = false;

    protected $connexion;

    private function __construct()
    {
        $this->connexion = new PDO(PDO_DSN, USER, PASSWD);
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === false) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnexion()
    {
        return $this->connexion;
    }
}
