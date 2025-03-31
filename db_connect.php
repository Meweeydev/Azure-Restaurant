<?php
$servername = "mysql-azure-restaurant.alwaysdata.net";
$username = "374595";
$password = "5uFW456Pjsf7du";
$dbname = "azure-restaurant_restau";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration pour lever des exceptions en cas d'erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupération des éléments du menu
function getMenuItems($conn, $category) {
    $stmt = $conn->prepare("SELECT name, description FROM menu_items WHERE category = :category");
    $stmt->bindParam(':category', $category);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$entrees = getMenuItems($conn, 'Entrées');
$plats = getMenuItems($conn, 'Plats');
$desserts = getMenuItems($conn, 'Desserts');

?>
