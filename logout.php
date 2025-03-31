<?php
session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session

header("Location: https://azure-restaurant.alwaysdata.net/login.php?success=logout"); 
exit;
?>
