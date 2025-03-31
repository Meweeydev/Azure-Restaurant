<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure - Restaurant</title>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <link rel="icon" href="assets/img/azure_icon.png" type="image/icon type">
    <?php
    require 'db_connect.php';
    ?>

</head>
<body>
    
    <section class="header" id="accueil">
        <div class="picturefiltre">
            <div class="navbar">
                <nav>
                    <a href="#accueil">Accueil</a>
                    <a href="#menu">Menu</a>
                    <a href="#reservation">Réservation</a>
                    <a href="#galerie">Galerie</a>
                    <a href="#apropos">A Propos</a>
                    <a href="#contact">Contact</a>
                </nav>
                <img class="logo" src="assets/img/azure_logo.png" alt="Logo Azure">
            <h1>Bienvenue chez <br>AZURE</h1>
            <p class="numerotele">Numéro de téléphone : 06.10.20.30.40</p>
            </div>
        </div>
    </section>
    <button onclick="topFunction()" id="boutontop" title="Retourner en haut de la page"><img class="fleche" src="assets/img/Arrow_top.png" alt=""></button>


    <section class="Menu" id="menu">
        <div class="titleMenu">
            <h2 class="Titrebleumarin">Notre Menu</h2>
            <div class="traitnoirMenu"></div>
            <p class="bhead">Savourez la Méditerranée, une bouchée à la fois.</p> <br> <br>
            <div class="wrapper">
                <div class="menu-container">
                    <div class="menu-header">
                        <h2>Menu du jour</h2>
                        <img src="assets/img/etoile.png" alt="Image sous le titre" class="header-image">
                    </div>
                    <div class="menu-category">
                        <h3>Entrées</h3>
                        <ul class="menu-list">
                            <?php foreach ($entrees as $entree) : ?>
                                <li class="menu-item">
                                    <strong><?= htmlspecialchars($entree['name']) ?></strong>
                                    <p><?= htmlspecialchars($entree['description']) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="menu-category">
                        <h3>Plats</h3>
                        <ul class="menu-list">
                            <?php foreach ($plats as $plat) : ?>
                                <li class="menu-item">
                                    <strong><?= htmlspecialchars($plat['name']) ?></strong>
                                    <p><?= htmlspecialchars($plat['description']) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="menu-category">
                        <h3>Desserts</h3>
                        <ul class="menu-list">
                            <?php foreach ($desserts as $dessert) : ?>
                                <li class="menu-item">
                                    <strong><?= htmlspecialchars($dessert['name']) ?></strong>
                                    <p><?= htmlspecialchars($dessert['description']) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="reservation" id="reservation">
    <div class="picturefiltrereservation">
        <div class="titlereserv">
            <h2 class="Titreblanc">Réservation</h2>
            <div class="traitBlancreservation"></div>
            <p class="bhead">Réservez chez Azure pour une expérience culinaire raffinée.</p>
        </div>
        <div class="formulairereservation">
            <form action="reservation_handler.php" method="POST" class="formulaireres">
                <div class="form-group">
                    <label class="formstexte" for="nom">Nom</label>
                    <input class="forminput" type="text" name="nom" id="nom" placeholder="Nom" required>
                </div>

                <div class="form-group">
                    <label class="formstexte" for="prenom">Prénom</label>
                    <input class="forminput" type="text" name="prenom" id="prenom" placeholder="Prénom" required>
                </div>

                <div class="form-group">
                    <label class="formstexte" for="email">Email</label>
                    <input class="forminput" type="email" name="email" id="email" placeholder="user.name@exemple.fr" required>
                </div>

                <div class="form-group">
                    <label class="formstexte" for="phonenumber">Numéro téléphone</label>
                    <input class="forminput" type="tel" name="phonenumber" id="phonenumber" placeholder="06.03.30.60.50" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" required>
                </div>

                <div class="form-group">
                    <label class="formstexte" for="nbconvive">Nombre de convives</label>
                    <input class="forminput" type="number" name="nbconvive" id="nbconvive" placeholder="1-5" required>
                </div>

                <div class="form-group">
                    <label class="formstexte" for="datereser">Date de réservation</label>
                    <input class="forminput" type="datetime-local" name="datereser" id="datereser" required>
                </div>

                <button class="formbutton" id="envoyer" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</section>

<div id="confirmationPopup" class="popup">
    <div class="popup-content">
        <span id="closePopup" class="close">&times;</span>
        <img class="logo" src="assets/img/azure_logo.png" alt="Logo Azure">

        <p>Nous sommes ravis de vous accueillir dans notre restaurant. Une copie de votre réservation vous a été envoyé par mail.</p>
        <button class="formbutton" id="closePopupButton">Fermer</button>
    </div>
</div>




    <section class="galerie" id="galerie">
        <div class="titlegalerie">
        <h2 class="Titrebleumarin">Galerie</h2>
        <div class="traitnoirgalerie"></div>
        <p class="bhead">Un aperçu visuel de notre ambiance et de nos délices</p>
    </div>  <br><br>
    <div class="rectangle">
        <img src="assets/img/Gallerie.png" alt="Image dans le rectangle">
    </div>
    <br>
    </section>


    <section class="apropos" id="apropos">
        <div class="titleapropos">
        <h2 class="Titrebleumarin">A Propos</h2>
        <div class="traitnoirapropos"></div>
        <p class="bhead">Découvrez l'Essence de la Méditerranée avec Azure.</p>
        <br>
    </div>  
    <p>Bienvenue chez Azure, votre destination culinaire méditerranéenne au cœur de la ville. 
        <br><br>
        Depuis notre ouverture, nous nous consacrons à offrir à nos clients une expérience gastronomique unique, où tradition et modernité se rencontrent dans une harmonie parfaite. Notre chef, passionné par les saveurs authentiques de la Méditerranée, crée chaque plat avec une attention particulière portée aux détails, en utilisant uniquement les ingrédients les plus frais et de la plus haute qualité. Des fruits de mer succulents aux légumes grillés savoureux, chaque bouchée est une invitation à un voyage culinaire le long des côtes ensoleillées de la Méditerranée.
        <br><br>
        L'ambiance chez Azure est élégante et accueillante, conçue pour vous offrir un cadre chaleureux où vous pourrez vous détendre et savourer un repas mémorable. Que vous soyez un habitant local ou un touriste en quête d'une aventure culinaire exceptionnelle, notre équipe dévouée est là pour vous offrir un service impeccable et personnalisé.
        Nous croyons que chaque visite est une opportunité de créer des souvenirs, et nous nous efforçons de rendre chaque expérience unique et inoubliable. 
        <br><br>
        Notre engagement envers l'excellence se reflète non seulement dans notre cuisine, mais aussi dans notre volonté constante d'améliorer notre service, notre environnement et notre présence en ligne.
        Rejoignez-nous chez Azure et laissez-vous emporter par les délices de la Méditerranée, où chaque repas est une célébration de la vie, de l'amitié et du plaisir de bien manger.</p>
    </section>
    

    <section class="Contact" id="contact">
    <div class="picturefiltre">
        <div class="titlecontact">
            <h2 class="Titreblanc">Contact</h2>
            <div class="traitBlancContact"></div>
            <p class="bhead">Contactez Azure pour une expérience culinaire raffinée.</p>
        </div>  
        <div class="formulairecontact">
            <form action="contact_handler.php" method="post" class="formulaircont">
                <div class="test">
                    <div class="form-group-contact">
                        <label class="formstexte" for="nom">Nom</label>
                        <input class="forminput" type="text" name="nom" id="nom" placeholder="Nom" required>
                    </div>
                
                    <div class="form-group-contact">
                        <label class="formstexte" for="prenom">Prénom</label>
                        <input class="forminput" type="text" name="prenom" id="prenom" placeholder="Prénom" required>
                    </div>
                </div>
                <div class="test">
                    <div class="form-group-contact">
                        <label class="formstexte" for="email">Email</label>
                        <input class="forminput" type="email" name="email" id="email" placeholder="user.name@exemple.fr" required>
                    </div>

                    <div class="form-group-contact">
                        <label class="formstexte" for="phonenumber">Numéro téléphone</label>
                        <input class="forminput" type="tel" name="phonenumber" id="phonenumber" placeholder="06.03.30.60.50">
                    </div>
                </div>

                <div class="form-group-commentaire">
                    <label class="formstexte" for="commentaire">Commentaire</label>
                    <textarea class="forminputcomment" name="commentaire" id="commentaire" placeholder="..." required></textarea>
                </div>
                
                <button class="formbuttonContact" id="envoyer" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</section>

    
    <div id="confirmationPopupContact" class="popup">
    <div class="popup-content">
        <span id="closePopupContact" class="close">&times;</span>
        <img class="logo" src="assets/img/azure_logo.png" alt="Logo Azure">

        <p>Votre demande a bien été prise en compte. Nous vous répondrons dans les plus brefs délais.</p>
        <button class="formbutton" id="closePopupButtonContact">Fermer</button>
    </div>
</div>

    

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column logo">
                <a href="#accueil"><img src="/assets/img/azure_logo.png" alt="Logo" /></a>
            </div>
            <div class="footer-column menu">
                <ul>
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#reservation">Réservation</a></li>
                    <li><a href="#galerie">Galerie</a></li>
                    <li><a href="#apropos">A Propos</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column contact-info">
                <p><strong>INFO CONTACT :</strong></p> <br>
                <p>Téléphone : 06 10 20 30 40</p>
                <p>Adresse : 53 Cr Albert Thomas, 69003 Lyon</p><br>
                <p><strong>HORAIRE :</strong></p><br>
                <p>Mardi au Samedi : 11h30 à 13h30 / 19h00 à 21h30</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; Copyright by © Azure 2024.  All rights reserved. - <a href="mentions_legales.html">Mentions Légales</a></p>
        </div>
    </footer>

<script>
function showPopup() {
    var popup = document.getElementById('confirmationPopup');
    popup.classList.add('show');
}

document.getElementById('closePopup').onclick = function() {
    var popup = document.getElementById('confirmationPopup');
    popup.classList.remove('show');
}

document.getElementById('closePopupButton').onclick = function() {
    var popup = document.getElementById('confirmationPopup');
    popup.classList.remove('show');
}

function showPopupContact() {
    var popup = document.getElementById('confirmationPopupContact');
    popup.classList.add('show');
}

document.getElementById('closePopupContact').onclick = function() {
    var popup = document.getElementById('confirmationPopupContact');
    popup.classList.remove('show');
}

document.getElementById('closePopupButtonContact').onclick = function() {
    var popup = document.getElementById('confirmationPopupContact');
    popup.classList.remove('show');
}


window.onload = function() {
    <?php if (isset($_GET['statusReservation']) && $_GET['statusReservation'] == 'success') : ?>
        showPopup();
    <?php elseif (isset($_GET['statuscontact']) && $_GET['statuscontact'] == 'success') : ?>
        showPopupContact();
    <?php endif; ?>
}

</script>

<script>

let mybutton = document.getElementById("boutontop");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
</body>


</html>