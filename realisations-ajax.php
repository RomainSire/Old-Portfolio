<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");



/**
 * Récupération des infos de la réalisation
 * data AJAX passé en GET
 */
// SI en GET on a bien la variable nommé 'id', et qu'elle est bien de type nombre entier
if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
  /**
   * REALISATION
   */
  // Récupération de la réalisation dans la BDD réalisation
  $query = $db->prepare("SELECT id, title, description, mainImageName, linkToWebsite FROM realisations WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $realisation = $query->fetch();
  $realisation['description'] = nl2br($realisation['description']); // Pour conserver les sauts de lignes
  /**
   * CATEGORIES
   */
  // Récupération des liens entre catégories et réalisation
  $query = $db->prepare("SELECT categorieId FROM realisations_categories WHERE realisationId = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $IDcategories = $query->fetchAll(PDO::FETCH_COLUMN);
  // Récupérer la liste des Catégories
  $query = $db->prepare("SELECT id, name FROM categories ORDER BY id");
  $query->execute();
  $categories = $query->fetchAll();
  // Création et implémentation du tableau avec le nom de toutes les catégories
  $categoriesNames = [];
  foreach ($categories as $category) {
    if (in_array($category['id'], $IDcategories)) {
      array_push($categoriesNames, $category['name']);
    }
  }
  /**
   * IMAGES
   */
  // Récupération des liens entre images et réalisation
  $query = $db->prepare("SELECT imageId FROM realisations_images WHERE realisationId = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $IDimages = $query->fetchAll(PDO::FETCH_COLUMN);
  // Récupérer la liste des images
  $query = $db->prepare("SELECT id, filename FROM images ORDER BY id");
  $query->execute();
  $images = $query->fetchAll();
  // Création et implémentation du tableau avec le nom de toutes les images
  $imagesNames = [];
  foreach ($images as $image) {
    if (in_array($image['id'], $IDimages)) {
      array_push($imagesNames, $image['filename']);
    }
  }
}


// Création du tableau qui sera renvoyé en front avec Ajax
$result = [
  'realisation' => $realisation,
  'categories' => $categoriesNames,
  'images' => $imagesNames
];

// Envoi du résultat en JSON
echo json_encode($result);
