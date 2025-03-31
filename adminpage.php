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
    

    <button onclick="topFunction()" id="boutontop" title="Retourner en haut de la page"><img class="fleche" src="assets/img/Arrow_top.png" alt=""></button>
    <div class="titleMenu">
            <h2 class="Titrebleumarin">Rédaction du nouveau menu</h2>
            <div class="traitnoirMenu"></div>
            <p class="bhead">Savourez la Méditerranée, une bouchée à la fois.</p> <br> <br>
            </div>
<section class="EditMenu" id="EditMenu">


    <section class="Menu" id="menu">
      
            <div class="wrapper">
                <div class="menu-container">
                    <div class="menu-header">
                        <h2>Menu actuelle</h2>
                        <img src="assets/img/etoile.png" alt="Image sous le titre" class="header-image">
                    </div>
                    <div class="menu-category">
                        <h3>Entrées</h3>
                        <ul>
                            <?php foreach ($entrees as $entree): ?>
                                <?php if ($entree['name'] != 0): ?>
                                    <li class="menu-item">
                                        <strong><?= htmlspecialchars($entree['name']) ?></strong>
                                        <p><?= htmlspecialchars($entree['description']) ?></p>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                    <div class="menu-category">
                        <h3>Plats</h3>
                        <ul class="menu-list">
                            <?php foreach ($plats as $plat) : ?>
                                <?php if($plat['name'] != 0) : ?>
                                <li class="menu-item">
                                    <strong><?= htmlspecialchars($plat['name']) ?></strong>
                                    <p><?= htmlspecialchars($plat['description']) ?></p>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="menu-category">
                        <h3>Desserts</h3>
                        <ul class="menu-list">
                            <?php foreach ($desserts as $dessert) : ?>
                                <?php if ($dessert['name'] != 0) : ?>

                                <li class="menu-item">
                                    <strong><?= htmlspecialchars($dessert['name']) ?></strong>
                                    <p><?= htmlspecialchars($dessert['description']) ?></p>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="Menu" id="menu">
        <div class="titleMenu">

            <div class="wrapper">
                <div class="menu-container">
                    <div class="menu-header">
                        <h2>Nouveau menu</h2>
                        <img src="assets/img/etoile.png" alt="Image sous le titre" class="header-image">
                    </div>
                    <form action="menu.php" method="post">

                    <div class="menu-category">
                        <h3>Entrées</h3>
                        <p>Ajouter ou supprimer une ligne</p>
                        <input type="button" value="+" id="addrowentree" class="addremoverow">
                        <input type="button" value="-" id="removerowentree" class="addremoverow">
                        
                        <ul id="listentree">
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <input type="text" id='nomentree1' name="nomentree1" class="menuinput" placeholder="Nom de l'entrée">
                                    <input type="text" id="descentree1" name="descentree1" class="menuinput" placeholder="Description de l'entrée">
                                </li>
                            </ul>
                        </ul>

                    </div>
                    <div class="menu-category">
                        <h3>Plats</h3>
                        <p>Ajouter ou supprimer une ligne</p>
                        <input type="button" value="+" id="addrowplat" class="addremoverow">
                        <input type="button" value="-" id="removerowplat" class="addremoverow">
                        
                        <ul id="listplat">
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <input type="text" id='nomplat1' name='nomplat1' class="menuinput" placeholder="Nom du plat">
                                    <input type="text" id="descplat1" name="descplat1" class="menuinput"placeholder="Description du plat">
                                </li>
                            </ul>
                        </ul>

                    </div>
                    <div class="menu-category">
                        <h3>Desserts</h3>
                        <p>Ajouter ou supprimer une ligne</p>
                        <input type="button" value="+" id="addrowdessert" class="addremoverow">
                        <input type="button" value="-" id="removerowdessert" class="addremoverow">
                        
                        <ul id="listdessert">
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <input type="text" id='nomdessert1' name='nomdessert1' class="menuinput" placeholder="Nom du dessert">
                                    <input type="text" id="descdessert1" name="descdessert1" class="menuinput"placeholder="Description du dessert">
                                </li>
                            </ul>
                        </ul>
            </div>
            <input type="submit" class="submit formbuttonContact" value="Sauvegarder le menu">
            </form>
        </div>
    </section>
</section>


<section class="reservations-section" id="reservation"> 
    <div class="reservation-background">
        <div class="reservation-title">
            <h2 class="title-white">Liste des Réservations</h2>
            <div class="white-line"></div>
            <p class="subheading">Réservez chez Azure pour une expérience culinaire raffinée.</p>
        </div>
        <div class="content-wrapper">
            <div class="menu-box">
                <div class="menu-header">
                    <h2>Menu actuelle</h2>
                    <img src="assets/img/etoile.png" alt="Image sous le titre" class="header-image">
                </div>
                <div class="menu-category">
                    <h3>Entrées</h3>
                    <ul>
                        <?php foreach ($listereserves as $listereserve): ?>
                            <?php if ($listereserve['user_name'] != 0): ?>
                                <li class="reservation-item">
                                    <strong><?= htmlspecialchars($listereserve['user_name']) ?></strong>
                                    <p><?= htmlspecialchars($listereserve['phonenumber']) ?></p>
                                    <p><?= htmlspecialchars($listereserve['reservation_date']) ?></p>
                                    <p><?= htmlspecialchars($listereserve['number_people']) ?></p>
                                    <p><?= htmlspecialchars($listereserve['status']) ?></p>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>





<section class="galerie" id="galerie">
<div class="titlegalerie mb-4">
    <h2 class="Titrebleumarin text-start">Galerie</h2>
    <div class="traitnoirgalerie mb-3" style="width: 100px; height: 3px; background-color: black;"></div>
    <p class="bhead text-start">Un aperçu visuel de notre ambiance et de nos délices</p>
  </div>

  <div class="container">
    <div class="row g-4">
        <?php
        $files = glob("uploads/*.{jpg,jpeg,png,webp,gif}", GLOB_BRACE);
        foreach ($files as $file) {
            echo '<div class="col-lg-4 col-md-6">
                    <img src="'.$file.'" class="w-100 shadow-1-strong rounded mt-4" alt="Image">
                  </div>';
        }
        ?>
    </div>
</div>

  <!-- End Gallery Grid -->

  <br>
</section>


   
    

   
    

    

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




function showPopupContact() {
    var popup = document.getElementById('confirmationPopupContact');
    popup.classList.add('show');
}



window.onload = function() {
    <?php if (isset($_GET['statusReservation']) && $_GET['statusReservation'] == 'success') : ?>
        showPopup();
    <?php elseif (isset($_GET['statuscontact']) && $_GET['statuscontact'] == 'success') : ?>
        showPopupContact();
    <?php endif; ?>
}


document.getElementById('addrowentree').onclick = function () {
    const nbentree = document.getElementById('listentree');
    if (nbentree.children.length < 3) {
        const newRow = document.createElement('ul');
        newRow.classList.add('menu-list');
        newRow.innerHTML = `
            <li class="menu-item">
                <input type="text" id="nomentree${nbentree.children.length + 1}" name="nomentree${nbentree.children.length + 1}" class="menuinput" placeholder="Nom de l'entrée">
                <input type="text" id="descentree${nbentree.children.length + 1}" name="descentree${nbentree.children.length + 1}" class="menuinput" placeholder="Description de l'entrée">
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
            <li class="menu-item">
                <input type="text" id="nomplat${nbplat.children.length + 1}" name="nomplat${nbplat.children.length + 1}" class="menuinput" placeholder="Nom du plat">
                <input type="text" id="descplat${nbplat.children.length + 1}" name="descplat${nbplat.children.length + 1}" class="menuinput" placeholder="Description du plat">
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
            <li class="menu-item">
                <input type="text" id="nomdessert${nbdessert.children.length + 1}" name="nomdessert${nbdessert.children.length + 1}" class="menuinput" placeholder="Nom du dessert">
                <input type="text" id="descdessert${nbdessert.children.length + 1}" name="descdessert${nbdessert.children.length + 1}" class="menuinput" placeholder="Description du dessert">
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