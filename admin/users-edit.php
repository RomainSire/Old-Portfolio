<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");


/**
 * Mise à jour du nom et du mot de passe d'un utilisateur
 */
// SI on a bien la variable nommé 'id', et qu'elle est bien de type nombre entier ; et si on a bien un nom et un mot de passe :
if (isset($_POST["id"]) && ctype_digit($_POST["id"]) && isset($_POST["login"]) && isset($_POST["password"]) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  // Crypter le MDP :
  $hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ["cost" => 12]);
  // Mettre à jour le contact dans la base de donnée
  $query = $db->prepare("UPDATE users SET login = :login, password = :hash WHERE id = :id");
  $query->bindParam(':login', $_POST["login"]);
  $query->bindParam(':hash', $hash);
  $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
  $query->execute();
  // Ajouter un message Flash
  $flashMessage->add("L'utilisateur a été mis à jour");
}

// Redirection vers la page des utilisateurs
header("Location: $baseUrl/admin/users.php");
exit();