<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");



/**
 * Ajout de la nouvelle réalisation dans la BDD
 */
if (isset($_POST['title']) && isset($_POST['description']) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  // DEBUG :
  // var_dump($_POST);
  // exit;

  // 1/ Alimenter la table 'realisations' de la BDD
  $query = $db->prepare("INSERT INTO realisations (title, description, mainImageName, linkToWebsite) VALUES (:title, :description, :mainImageName, :linkToWebsite)");
  $query->bindParam(':title', $_POST['title']);
  $query->bindParam(':description', $_POST['description']);
  $query->bindParam(':mainImageName', $_POST['mainImageName']);
  $query->bindParam(':linkToWebsite', $_POST['link']);
  $query->execute();
  // Récupération de l'ID de la nouvelle réalisation :
  $realisationID = $db->lastInsertId();
  // 2/ Alimenter la table des liens entre catégories et réalisations
  if (isset($_POST['categories'])) {
    foreach ($_POST['categories'] as $categorieID) {
      $query = $db->prepare("INSERT INTO realisations_categories (realisationId, categorieId) VALUES (:realisationId, :categorieId)");
      $query->bindParam(':realisationId', $realisationID);
      $query->bindParam(':categorieId', $categorieID);
      $query->execute();
    }
  }
  // 3/ Alimenter la table des liens entre images et réalisations
  if (isset($_POST['images'])) {
    foreach ($_POST['images'] as $imageID) {
      $query = $db->prepare("INSERT INTO realisations_images (realisationId, imageId) VALUES (:realisationId, :imageId)");
      $query->bindParam(':realisationId', $realisationID);
      $query->bindParam(':imageId', $imageID);
      $query->execute();
    }
  }
  // 4/ Ajouter un message flash
  $flashMessage->add("La réalisation a bien été ajoutée");
  // 5/ Redirection vers la page d'affichage de toutes les réalisations
  header("Location: $baseUrl/admin/realisations.php");
  exit();
}




// Récupérer la liste des Catégories
$query = $db->prepare("SELECT id, name FROM categories ORDER BY id");
$query->execute();
$categories = $query->fetchAll();

// Récupérer la liste des images
$query = $db->prepare("SELECT id, filename FROM images ORDER BY id");
$query->execute();
$images = $query->fetchAll();



// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Ajouter une réalisation";
$template = 'realisations-add.phtml';
include("layout.phtml");