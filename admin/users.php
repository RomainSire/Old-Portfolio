<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");


/**
 * Ajout d'un nouvel utilisateur
 */
if (isset($_POST['name']) && isset($_POST['password']) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  // Crypter le MDP :
  $hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ["cost" => 12]);
  // Insérer dans la table users, le nouvel utilisateur
  $query = $db->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
  $query->bindParam(':login', $_POST['name']);
  $query->bindParam(':password', $hash);
  $query->execute();
  // Ajouter un message flash
  $flashMessage->add("L'utilisateur a été ajouté");

  // Redirection vers la page des utilisateurs
  header("Location: $baseUrl/admin/users.php");
  exit();
}

/**
 * Récupération de la liste des utilisateurs :
 */
$query = $db->prepare("SELECT id, login FROM users ORDER BY id");
$query->execute();
$users = $query->fetchAll();




// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Utilisateurs";
$template = 'users.phtml';
include("layout.phtml");