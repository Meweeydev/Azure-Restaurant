<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'upload_failed') {
        echo '<div class="alert alert-danger text-center">❌ Échec de l\'upload. Veuillez réessayer.</div>';
    } elseif ($_GET['error'] == 'not_image') {
        echo '<div class="alert alert-warning text-center">⚠️ Le fichier sélectionné n\'est pas une image valide.</div>';
    }
} elseif (isset($_GET['success']) && $_GET['success'] == 'uploaded') {
    echo '<div class="alert alert-success text-center">✅ Image uploadée avec succès !</div>';
} elseif (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    echo '<div class="alert alert-info text-center">🗑️ Image supprimée avec succès.</div>';
}

require 'db_connect.php';

///// INSCRIPTION : 

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation des champs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse e-mail est invalide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'e-mail existe déjà
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Un compte avec cet e-mail existe déjà.";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur dans la base de données
            $stmt = $conn->prepare("INSERT INTO user (name, email, password, signin_date) VALUES (:name, :email, :password, NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Inscription réussie, vous pouvez vous connecter.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Une erreur s'est produite lors de l'inscription.";
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Azure</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
    background: linear-gradient(to right, #f8f9fa, #e3f2fd);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
}

.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.card-header {
    background-color: transparent;
    border-bottom: none;
}

h2, h4 {
    font-weight: 600;
}

.upload-form button {
    background: linear-gradient(to right, #00c6ff, #0072ff);
    color: white;
    font-weight: bold;
    border-radius: 30px;
    padding: 10px 20px;
    transition: all 0.3s ease-in-out;
}

.upload-form button:hover {
    background: linear-gradient(to right, #ff4e50, #f9d423);
    color: #fff;
}

.image-list img {
    border-radius: 0.75rem;
    transition: 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.image-list img:hover {
    transform: scale(1.05);
}

.delete-btn {
    border-radius: 20px;
    font-size: 0.85rem;
    padding: 6px 12px;
}

hr.border-dark {
    opacity: 0.3;
    border-width: 2px;
}

ul.list-unstyled li {
    padding: 0.5rem;
    border-left: 3px solid #007bff;
    background-color: #f8f9fa;
    margin-bottom: 0.5rem;
    border-radius: 0.5rem;
}

input.form-control {
    border-radius: 0.5rem;
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand text-primary" href="https://azure-restaurant.alwaysdata.net/">Azure Restaurant</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#accueil">Retour Site</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/espacemembre.php">Retour Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/register.php">Inscription</a></li>
                <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </ul>
        </div>
    </div>
</nav>


<div class="container" id="inscription">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Inscription</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="espacemembre.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmez le mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional for interactive elements) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
