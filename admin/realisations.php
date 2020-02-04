<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");


/**
 * Récupération de la liste des réalisation :
 */
$query = $db->prepare("SELECT id, title, mainImageName FROM realisations ORDER BY id");
$query->execute();
$realisations = $query->fetchAll();




// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Réalisations";
$template = 'realisations.phtml';
include("layout.phtml");