<?php

/**
 * Classe qui gère les messages flash qui apparaissent pour confirmer une action
 */
class FlashMessage
{
  /**
   * Constructeur
   */
  public function __construct() {
      // Démarre la session si elle n'est pas déjà démarrée
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // // Si le flashMessage n'existe pas, on crée un tableau qui contiendra tous les messages flash
      if (array_key_exists('flash-messages', $_SESSION) == false) {
        $_SESSION['flash-messages'] = array();
      }
  }

  /**
   *  Définir un message flash
   */
  public function add($message) {
      array_push($_SESSION['flash-messages'], $message);
  }

  /**
   * Récupérer et afficher un mesasge flash
   */
  public function getMessages() {
    // Récupère tous les messages dans la session
    $messages = $_SESSION['flash-messages'];
    // Vide le tableau de messages dans la session
    $_SESSION['flash-messages'] = array();
    // Retourne les messages sous forme de tableau
    return $messages;
  }

  /**
   * Vérifie si on a un messgae flash
   * retourne "true" si on a des messages flash, "false" sinon
   */
  public function hasMessages() {
    return (empty($_SESSION['flash-messages']) == false);
  }








}
