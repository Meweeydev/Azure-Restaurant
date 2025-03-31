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
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#accueil">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#reservation">Réservation</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#galerie">Galerie</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#apropos">À Propos</a></li>
                <li class="nav-item"><a class="nav-link" href="https://azure-restaurant.alwaysdata.net/#contact">Contact</a></li>
                <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </ul>
        </div>
    </div>
</nav>


<section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card shadow p-4 mb-5">
            <h2 class="text-center text-primary">Bienvenue, <?php echo htmlspecialchars($_SESSION['name']); ?> !</h2>
                    <p class="text-center text-muted">Votre email : <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    
                    <h4 class="mt-4"><i class="fas fa-upload"></i> Uploader une image</h4>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form d-flex flex-column gap-3">
                        <input type="file" name="file" id="file" class="form-control  mb-3" required>
                        <button type="submit" name="submit" class="btn "><i class="fas fa-cloud-upload-alt"></i> Uploader</button>
                    </form>
                    
                    <h4 class="mt-4"><i class="fas fa-images"></i> Images Uploadées</h4>
                    <div class="row image-list">
                        <?php
                        $files = glob("uploads/*.*");
                        foreach ($files as $file) {
                            echo '<div class="col-4 col-md-3 text-center">
                                    <img src="'.$file.'" width="100" class="border p-1 img-fluid">
                                    <form action="upload.php" method="post" class="mt-2">
                                        <input type="hidden" name="delete_file" value="'.$file.'">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                    </form>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center my-4">
    <h2 class="text-primary">Rédaction du nouveau menu</h2>
    <hr class="border-dark w-25 mx-auto">
    <p class="lead">Savourez la Méditerranée, une bouchée à la fois.</p> 
</div>

<section class="container my-5" id="EditMenu">
    <div class="row gy-4">

        <!-- Menu actuel -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header text-center bg-white border-0">
                    <h2 class="text-primary">Menu actuel</h2>
                    <img src="assets/img/etoile.png" alt="Image sous le titre" class="img-fluid mt-2" style="max-height: 50px;">
                </div>
                <div class="card-body">

                    <!-- Entrées -->
                    <div class="mb-4">
                        <h4>Entrées</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($entrees as $entree): ?>
                                <?php if ($entree['name'] != 0): ?>
                                    <li class="mb-2">
                                        <strong><?= htmlspecialchars($entree['name']) ?></strong><br>
                                        <small><?= htmlspecialchars($entree['description']) ?></small>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Plats -->
                    <div class="mb-4">
                        <h4>Plats</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($plats as $plat): ?>
                                <?php if ($plat['name'] != 0): ?>
                                    <li class="mb-2">
                                        <strong><?= htmlspecialchars($plat['name']) ?></strong><br>
                                        <small><?= htmlspecialchars($plat['description']) ?></small>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Desserts -->
                    <div>
                        <h4>Desserts</h4>
                        <ul class="list-unstyled">
                            <?php foreach ($desserts as $dessert): ?>
                                <?php if ($dessert['name'] != 0): ?>
                                    <li class="mb-2">
                                        <strong><?= htmlspecialchars($dessert['name']) ?></strong><br>
                                        <small><?= htmlspecialchars($dessert['description']) ?></small>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Nouveau menu -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header text-center bg-white border-0">
                    <h2 class="text-primary">Nouveau menu</h2>
                </div>
                <div class="card-body">
                    <form action="menu.php" method="post">

                        <!-- Entrées -->
                        <div class="mb-4">
                            <h4>Entrées</h4>
                            <p class="small">Ajouter ou supprimer une ligne</p>
                            <div class="mb-2">
                                <button type="button" id="addrowentree" class="btn btn-outline-success btn-sm">+</button>
                                <button type="button" id="removerowentree" class="btn btn-outline-danger btn-sm">-</button>
                            </div>
                            <ul id="listentree" class="list-unstyled">
                                <li class="mb-2">
                                    <input type="text" id="nomentree1" name="nomentree1" class="form-control mb-1" placeholder="Nom de l'entrée">
                                    <input type="text" id="descentree1" name="descentree1" class="form-control" placeholder="Description de l'entrée">
                                </li>
                            </ul>
                        </div>

                        <!-- Plats -->
                        <div class="mb-4">
                            <h4>Plats</h4>
                            <p class="small">Ajouter ou supprimer une ligne</p>
                            <div class="mb-2">
                                <button type="button" id="addrowplat" class="btn btn-outline-success btn-sm">+</button>
                                <button type="button" id="removerowplat" class="btn btn-outline-danger btn-sm">-</button>
                            </div>
                            <ul id="listplat" class="list-unstyled">
                                <li class="mb-2">
                                    <input type="text" id="nomplat1" name="nomplat1" class="form-control mb-1" placeholder="Nom du plat">
                                    <input type="text" id="descplat1" name="descplat1" class="form-control" placeholder="Description du plat">
                                </li>
                            </ul>
                        </div>

                        <!-- Desserts -->
                        <div class="mb-4">
                            <h4>Desserts</h4>
                            <p class="small">Ajouter ou supprimer une ligne</p>
                            <div class="mb-2">
                                <button type="button" id="addrowdessert" class="btn btn-outline-success btn-sm">+</button>
                                <button type="button" id="removerowdessert" class="btn btn-outline-danger btn-sm">-</button>
                            </div>
                            <ul id="listdessert" class="list-unstyled">
                                <li class="mb-2">
                                    <input type="text" id="nomdessert1" name="nomdessert1" class="form-control mb-1" placeholder="Nom du dessert">
                                    <input type="text" id="descdessert1" name="descdessert1" class="form-control" placeholder="Description du dessert">
                                </li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Sauvegarder le menu">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>


<div class="container">
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


<script>
    
document.getElementById('addrowentree').onclick = function () {
    const nbentree = document.getElementById('listentree');
    if (nbentree.children.length < 3) {
        const newRow = document.createElement('ul');
        newRow.classList.add('menu-list');

        newRow.innerHTML = `
            <li class="mb-2">
                    <input type="text" id="nomentree${nbentree.children.length + 1}" name="nomentree${nbentree.children.length + 1}" class="form-control mb-1" placeholder="Nom de l'entrée">
                    <input type="text" id="descentree${nbentree.children.length + 1}" name="descentree${nbentree.children.length + 1}" class="form-control" placeholder="Description de l'entrée">
            </li>
        `;
        nbentree.appendChild(newRow);
    } else {
        alert("Impossible d'ajouter plus de ligne !");
    }
};

document.getElementById('removerowentree').onclick = function() {
    const nbentree = document.getElementById('listentree');
    if (nbentree.children.length > 0) {
        nbentree.removeChild(nbentree.lastElementChild);
    } else {
        alert('Vous ne pouvez pas supprimée de ligne !')
    }
};

document.getElementById('addrowplat').onclick = function () {
    const nbplat = document.getElementById('listplat');
    if (nbplat.children.length < 3) {
        const newRow = document.createElement('ul');
        newRow.classList.add('menu-list');

        newRow.innerHTML = `
            <li class="mb-2">
                <input type="text" id="nomplat${nbplat.children.length + 1}" name="nomplat${nbplat.children.length + 1}" class="form-control mb-1" placeholder="Nom du plat">
                <input type="text" id="descplat${nbplat.children.length + 1}" name="descplat${nbplat.children.length + 1}" class="form-control" placeholder="Description du plat">
            </li>
        `;
        nbplat.appendChild(newRow);
    } else {
        alert("Impossible d'ajouter plus de ligne !");
    }
};



document.getElementById('removerowplat').onclick = function() {
    const nbplat = document.getElementById('listplat');
    if (nbplat.children.length > 0) {
        nbplat.removeChild(nbplat.lastElementChild);
    } else {
        alert('Vous ne pouvez pas supprimée de ligne !')
    }
};

document.getElementById('addrowdessert').onclick = function () {
    const nbdessert = document.getElementById('listdessert');
    if (nbdessert.children.length < 3) {
        const newRow = document.createElement('ul');
        newRow.classList.add('menu-list');

       
        newRow.innerHTML = `
            <li class="mb-2">
                <input type="text" id="nomdessert${nbdessert.children.length + 1}" name="nomdessert${nbdessert.children.length + 1}" class="form-control mb-1" placeholder="Nom du dessert">
                <input type="text" id="descdessert${nbdessert.children.length + 1}" name="descdessert${nbdessert.children.length + 1}" class="form-control" placeholder="Description du dessert">
            </li>
        `;
        nbdessert.appendChild(newRow);
    } else {
        alert("Impossible d'ajouter plus de ligne !");
    }
};


document.getElementById('removerowdessert').onclick = function() {
    const nbdessert = document.getElementById('listdessert');
    if (nbdessert.children.length > 0) {
        nbdessert.removeChild(nbdessert.lastElementChild);
    } else {
        alert('Vous ne pouvez pas supprimée de ligne !')
    }
};

</script>
</body>
</html>
