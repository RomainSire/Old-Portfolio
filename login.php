<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");

// Si l'utilisateur a écrit qqch :
if (!empty($_POST)) {

  // On cherche dans la base de données l'utilisateur qui correspond au login donné dans le formulaire (renvoie 'false' si aucun utilisateur trouvé)
  $query = $db->prepare("SELECT id, login, password FROM users WHERE login = :login");
  $query->bindParam(':login', $_POST['login']);
  $query->execute();
  $user = $query->fetch();

  // SI on a bien trouvé un utilisateur et que le mot de passe est correct
  if ($user && password_verify($_POST['password'], $user['password'])) {
    // Démarre la session si elle n'est pas déjà démarrée
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION["user"] = $user;
    header("location: $baseUrl/admin/index.php");
  } else {
    $flashMessage->add("Nom d'utilisateur ou mot de passe incorrect");
  }
}


// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "Se connecter";  // titre de la page
$template = 'login.phtml'; // vue appelée (rangée dans le dossier "vues")
include("layout.phtml"); // layout appelé