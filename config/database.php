<?php
// Connexion à la base de donnée
try {
  $db = new PDO('mysql:host=XXXXX.mysql.db;dbname=XXXXX', 'XXXXX', 'XXXXX', [ // nom de la base de données et mot de passes cachés !!
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On configure la conenxion à la base de données pour que les résultats de requête soient toujours renvoyés sous forme de tableau associatifs
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // pour que les erreurs SQL soient envoyées dans la page
  ]);
} catch (Exception $e) {
  echo "Impossible de se connecter à la base de données<br>";
  echo $e->getMessage(); // afficher le message d'erreur.
  die();
}

