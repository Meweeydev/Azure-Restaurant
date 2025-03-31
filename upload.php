<?php
$target_dir = "uploads/";

if(isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est bien une image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            header("Location: https://azure-restaurant.alwaysdata.net/espacemembre.php?success=uploaded");
            exit;
        } else {
            header("Location: https://azure-restaurant.alwaysdata.net/espacemembre.php?error=upload_failed");
            exit;
        }
    } else {
        header("Location: https://azure-restaurant.alwaysdata.net/espacemembre.php?error=not_image");
        exit;
    }
}

// Suppression d'une image
if(isset($_POST["delete"])) {
    $file_to_delete = $_POST["delete_file"];
    if(file_exists($file_to_delete)) {
        unlink($file_to_delete);
        header("Location: https://azure-restaurant.alwaysdata.net/espacemembre.php?success=deleted");
        exit;
    } else {
        header("Location: https://azure-restaurant.alwaysdata.net/espacemembre.php?error=delete_failed");
        exit;
    }
}
?>
