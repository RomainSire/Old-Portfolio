<?php
// Logout = on supprime l'utilisateur de la session
session_start();
if (isset($_SESSION["user"])) {
  unset($_SESSION["user"]);
}

header("location: index.php");