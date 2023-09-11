<?php
require_once "inc/BD.php";
require_once "php/navbarDisplay.php";
require_once "inc/BD.php";
use inc\BD;

use navbarDisplay\navbarDisplay as navbarDisplay;

$navbar = new navbarDisplay();
$id = $navbar->getUserId();
$user = $navbar->fetchUser($id);

?>

<header>
    <nav>
        <h1 class="logo"><a href="index.php">E-Wins</a></h1>
        <ul id="ulAccueil">
            <?php
            if (!$id) {
                echo '<li><a href="inscription.php">Inscription</a></li>';
                echo '<li><a href="seConnecter.php">Connexion</a></li>';
            }
            ?>
            <li><a href="listeTournois3.php">liste des tournois</a></li>
            <li><a href="contacter.php">contacter</a></li>
            
            <?php $navbar->displayUser($user); ?>

            <?php
            if ($id) {
                echo '<li><a class="hoverDeconnexion" href="php/deconnexion.controller.php">Deconnexion</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
