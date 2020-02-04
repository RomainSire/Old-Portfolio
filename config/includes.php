<?php
// on inclus le chemin d'accès de base à notre répertoire principal
require("config.php");
// on inclus le fichier dans lequel on ouvre la base de données
require("database.php");
// on inclus le fichier pour afficher les erreurs
require("errors.php");

// on inclus la classe Flash Message, et on initialise l'objet FlashMessage
require("$baseFolder/class/flashMessage.class.php");
$flashMessage = new FlashMessage;
// on inclus la classe csrf, et on initialise l'objet csfr
require("$baseFolder/class/csrf.class.php");
new csrf;
