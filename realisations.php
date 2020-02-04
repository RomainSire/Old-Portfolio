<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");

/**
 * Récupération de la liste des réalisation :
 */
$query = $db->prepare("SELECT id, title, mainImageName FROM realisations ORDER BY id DESC");
$query->execute();
$realisations = $query->fetchAll();


// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "Réalisations";  // titre de la page
$template = 'realisations.phtml'; // vue appelée (rangée dans le dossier "vues")
include("layout.phtml"); // layout appelé