<?php
// Démarre la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION["user"])) { // Si l'utilisateur n'est pas connecté
  Header("Location: $baseUrl/login.php"); // On le renvoie sur la page de connexion
  exit();
} elseif (isset($_SESSION["user"])) {
  // On cherche dans la base de données le mot de passe qui correspond à l'ID de session['user']
  $query = $db->prepare("SELECT password FROM users WHERE id = :id");
  $query->bindParam(':id', $_SESSION["user"]["id"]);
  $query->execute();
  $user = $query->fetch();

  // Si l'utilisateur est en session, mais que le mot de passe n'est plus bon, on renvoie sur la page de connexion
  if ($_SESSION["user"]["password"] != $user['password']) {
    Header("Location: $baseUrl/login.php"); // On le renvoie sur la page de connexion
    exit();
  } // sinon on fait rien et l'utilisateur accède à la page
}