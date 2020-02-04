<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");



/**
 * Ajout une nouvelle image
 */
// si l'utilisateur a upload des fichiers
if (!empty($_FILES) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
  $images = $_FILES['images'];  // pour faciliter l'écriture

  // Pour le nombre de photo qui a été uploadé  (foreach n'est pas super pratique dans ce cas)
  for ($i=0; $i < count($images['name']); $i++) {
    // TEST sur le type de fichier :
    $ext = strtolower(end(explode(".", $images['name'][$i]))); // extension du fichier
    $allowedExt = ["jpg", "jpeg", "png"]; // extensions de fichier autorisées
    if (in_array($ext , $allowedExt)) {  // test
      //TEST de la taille du fichier :
      if ($images['size'][$i] < 100000000) {
        // TEST sur le code d'erreur :
        if ($images['error'][$i] === 0) {

          // Si tous les tests sur les fichiers uploadés sont passés, on exécute le code :

          // 1 - on déplace le fichier du dossier temporaire, jusqu'au dossier img/portfolio
          $oldImagePath = $images['tmp_name'][$i]; // chemin de l'image dans le dossier temporaire
          $newImageName = uniqid() . rand() . "." . $ext; // nouveau nom de l'image
          $newImagePath = $baseFolder . "/img/portfolio/". $newImageName; // chemin de destination de l'image
          move_uploaded_file($oldImagePath, $newImagePath);

          // 2 - Pas besoin de créer une miniature car toutes les images seront des screenshots donc taille modeste

          // 3 - On renseigne la base de données
          $query = $db->prepare("INSERT INTO images (filename) VALUES (:filename)");
          $query->bindParam(':filename', $newImageName);
          $query->execute();

          // 4 - Flash Message :
          $flashMessage->add("Les images ont bien été enregistrées");

        } else {
          $flashMessage->add("Une erreur s'est produite !");
        }
      } else {
        $flashMessage->add("Le fichier est trop volumineux !");
      }
    } else {
      $flashMessage->add("Le type de fichier n'est pas autorisé !");
    }

  }

  // Redirection vers la page des utilisateurs
  header("Location: $baseUrl/admin/images.php");
  exit();
}

/**
 * Récupération de la liste des images :
 */
$query = $db->prepare("SELECT id, filename FROM images ORDER BY id");
$query->execute();
$images = $query->fetchAll();



// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "ADMIN Images";
$template = 'images.phtml';
include("layout.phtml");