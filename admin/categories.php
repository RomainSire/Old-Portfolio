<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");


/**
 * Ajout d'une nouvelle catégorie
 */
if (isset($_POST['name'])  && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  // Insérer dans la table users, le nouvel utilisateur
  $query = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
  $query->bindParam(':name', $_POST['name']);
  $query->execute();
  // Ajouter un message flash
  $flashMessage->add("La catégorie a été ajoutée");

  // Redirection vers la page des utilisateurs
  header("Location: $baseUrl/admin/categories.php");
  exit();
}

/**
 * Récupération de la liste des catégories :
 */
$query = $db->prepare("SELECT id, name FROM categories ORDER BY id");
$query->execute();
$categories = $query->fetchAll();




// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Catégories";
$template = 'categories.phtml';
include("layout.phtml");