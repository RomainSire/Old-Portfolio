<?php
/**
 * Classe CSRF : protege contre la faille CSFR avec un système de token
 */

 class CSRF 
 {
    /**
     * Constructeur
     */
    public function __construct() {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        // Si on n'a pas de token CSRF, on en crée un
        if (!isset($_SESSION["csrfToken"])) {
            $_SESSION["csrfToken"] = bin2hex(random_bytes(32));
        }

    }
 }
 