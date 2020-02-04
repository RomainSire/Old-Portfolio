<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");


/**
 * Mise à jour de la catégorie
 */
// SI on a bien la variable nommé 'id', et qu'elle est bien de type nombre entier ; et si on a bien un nom :
if (isset($_POST["id"]) && ctype_digit($_POST["id"]) && isset($_POST["name"]) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  // Mettre à jour le contact dans la base de donnée
  $query = $db->prepare("UPDATE categories SET name = :name WHERE id = :id");
  $query->bindParam(':name', $_POST["name"]);
  $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
  $query->execute();
  // Ajouter un message Flash
  $flashMessage->add("La catégorie a été mise à jour");
}

// Redirection vers la page des utilisateurs
header("Location: $baseUrl/admin/categories.php");
exit();