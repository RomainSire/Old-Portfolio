<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");





// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "Compétences";  // titre de la page
$template = 'skills.phtml'; // vue appelée (rangée dans le dossier "vues")
include("layout.phtml"); // layout appelé