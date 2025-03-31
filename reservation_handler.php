<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $phonenumber = htmlspecialchars($_POST['phonenumber']);
    $nbconvive = htmlspecialchars($_POST['nbconvive']);
    $datereser = htmlspecialchars($_POST['datereser']);

    // Configuration de l'email
    $to = "azurerestaurant69@gmail.com, $email";
    $subject = "Nouvelle réservation de $nom $prenom";
    $message = "
<html>
<head>
    <title>Nouvelle Réservation</title>
    <style>
        /* Styles généraux */
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Arial, sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 37, 94, 0.607);
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            color: #ffffff;
            text-align: center;
        }
        .logo img {
            width: 150px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            margin: 20px 0;
        }
        p {
            padding-top: 50px;
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.5;
        }
        @media only screen and (max-width: 480px) {
            .container {
                padding: 10px;
            }
            h2 {
                font-size: 20px;
            }
            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <table class='container'>
        <tr>
            <td>
                <div class='logo'>
                <img src='https://azure-restaurant.alwaysdata.net/assets/img/azure_logo.png' alt='Logo Azure' style='width: 150px; margin-bottom: 20px;'>
                </div>
                <h2>Nous sommes ravis de vous recevoir dans notre restaurant.</h2>
                <p><strong>Nom:</strong> $nom</p>
                <p><strong>Prénom:</strong> $prenom</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Numéro de téléphone:</strong> $phonenumber</p>
                <p><strong>Nombre de convives:</strong> $nbconvive</p>
                <p><strong>Date de réservation:</strong> $datereser</p>
            </td>
        </tr>
    </table>
</body>
</html>

    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $headers .= "From: noreply@azure-restaurant-reservation.com" . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        $servername = "mysql-azure-restaurant.alwaysdata.net";
        $username = "374595";
        $password = "5uFW456Pjsf7du";
        $dbname = "azure-restaurant_restau";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        try {


        $sql = "INSERT INTO reservation (user_name,phonenumber,reservation_date,number_people) VALUES (:user_name, :phone_number,:reservation_date,:number_people)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_name', $nom);
        $stmt->bindParam(':reservation_date', $datereser);
        $stmt->bindParam(':number_people', $nbconvive);
        $stmt->bindParam(':phone_number', $phonenumber);
        $stmt->execute(); 
        header("Location: index.php?statusReservation=success#reservation");
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    }
}
?>
