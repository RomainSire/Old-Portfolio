<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");



/**
 * Récupération des messages :
 */
$query = $db->prepare("SELECT id, name, email, content, date FROM messages ORDER BY date DESC");
$query->execute();
$messages = $query->fetchAll();

// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Messages de contact";
$template = 'messages.phtml';
include("layout.phtml");