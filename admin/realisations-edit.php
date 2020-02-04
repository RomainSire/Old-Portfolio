<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");

/**
 * GET : Récupération des infos de la réalisation
 */
// SI en GET on a bien la variable nommé 'id', et qu'elle est bien de type nombre entier
if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

  // Récupération de la réalisation dans la BDD réalisation
  $query = $db->prepare("SELECT id, title, description, mainImageName, linkToWebsite FROM realisations WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $realisation = $query->fetch();

  // Récupération des liens entre catégories et réalisation
  $query = $db->prepare("SELECT categorieId FROM realisations_categories WHERE realisationId = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $IDcategories = $query->fetchAll(PDO::FETCH_COLUMN);

  // Récupération des liens entre images et réalisation
  $query = $db->prepare("SELECT imageId FROM realisations_images WHERE realisationId = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $IDimages = $query->fetchAll(PDO::FETCH_COLUMN);

  // Récupérer la liste des Catégories
  $query = $db->prepare("SELECT id, name FROM categories ORDER BY id");
  $query->execute();
  $categories = $query->fetchAll();

  // Récupérer la liste des images
  $query = $db->prepare("SELECT id, filename FROM images ORDER BY id");
  $query->execute();
  $images = $query->fetchAll();

  // debug :
  // var_dump($realisation, $IDcategories, $IDimages, $categories, $images);
}


/**
 *  POST : On update la réalisation
 */


 if (isset($_POST["id"]) && ctype_digit($_POST["id"]) && isset($_POST['title']) && isset($_POST['description']) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
   // 1/ Alimenter la table 'realisations' de la BDD
   $query = $db->prepare("UPDATE realisations SET title = :title, description = :description, mainImageName = :mainImageName, linkToWebsite = :linkToWebsite WHERE id = :id");
   $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
   $query->bindParam(':title', $_POST['title']);
   $query->bindParam(':description', $_POST['description']);
   $query->bindParam(':mainImageName', $_POST['mainImageName']);
   $query->bindParam(':linkToWebsite', $_POST['link']);
   $query->execute();
   // 2/ Alimenter la table des liens entre catégories et réalisations
   // D'abord on supprime tous les anciens liens
   $query = $db->prepare("DELETE FROM realisations_categories WHERE realisationId = :id");
   $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
   $query->execute();
   // Ensuite on ajoute les nouveaux liens
   if (isset($_POST['categories'])) {
     foreach ($_POST['categories'] as $categorieID) {
       $query = $db->prepare("INSERT INTO realisations_categories (realisationId, categorieId) VALUES (:realisationId, :categorieId)");
       $query->bindParam(':realisationId', $_POST['id']);
       $query->bindParam(':categorieId', $categorieID);
       $query->execute();
     }
   }
   // 3/ Alimenter la table des liens entre images et réalisations
   // D'abord on supprime tous les anciens liens
   $query = $db->prepare("DELETE FROM realisations_images WHERE realisationId = :id");
   $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
   $query->execute();
   // Ensuite on ajoute les nouveaux liens
   if (isset($_POST['images'])) {
     foreach ($_POST['images'] as $imageID) {
       $query = $db->prepare("INSERT INTO realisations_images (realisationId, imageId) VALUES (:realisationId, :imageId)");
       $query->bindParam(':realisationId', $_POST['id']);
       $query->bindParam(':imageId', $imageID);
       $query->execute();
     }
   }
   // 4/ Ajouter un message flash
   $flashMessage->add("La réalisation a bien été mise à jour");
   // 5/ Redirection vers la page d'affichage de toutes les réalisations
   header("Location: $baseUrl/admin/realisations.php");
   exit();
 }





// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Réalisations : edit";
$template = 'realisations-edit.phtml';
include("layout.phtml");