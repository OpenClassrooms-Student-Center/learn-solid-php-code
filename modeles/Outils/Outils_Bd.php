<?php

/**
 * @file BD.class.php Classes génériques permettant l'interfaçage avec
 * une base de données.
 *
 * @author Jean-Marc Lecarpentier
 * @since Octobre 2007
 */

/**
 * Classe fournissant l'accès à la base de données.
 * @note Un singleton est utilisé pour la connexion
 * PDO fait abstraction du SGBD utilisé (modulo config du serveur adaptée)
 * et est orienté objet (il faut PHP >5.1 pour l'avoir en standard).
 * Avantage : il y a déjà des PDOException pour gérer les pbs
 *
 * @author Jean-Marc Lecarpentier
 */


class Outils_Bd {
  /* pour être sûr qu'il n'y a qu'une et une seule instance */
  private static $instance = false;

  /* le lien de connexion BD */
  protected $connexion;

  /* constructeur privé */
  private function __construct() {
      $this->connexion = new PDO(PDO_DSN, USER, PASSWD);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /* clonage impossible */
  private function __clone() {}



  /**
   * Accéder à l'UNIQUE instance de la classe
   */
  static public function getInstance() {
    if (self::$instance === false) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Accesseur à la connexion
   */
  public function getConnexion() {
    return $this->connexion;
  }
}
