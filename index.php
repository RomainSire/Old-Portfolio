<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");



// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "Accueil";
$template = 'index.phtml';
include("layout.phtml");
