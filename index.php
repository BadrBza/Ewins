<?php
require_once "inc/BD.php";
require_once "php/TournoiDAO.php";

use TournoiDAO\TournoiDAO as TournoiDAO;
use inc\BD;

$tournoiDAO = new TournoiDAO();
$tournois = $tournoiDAO->getDerniersTournois();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "inc/navbar.inc.php";
    ?>
    <main>
        <header>
            <p id="h1Accueil">
                Bienvenue sur E-wins
            </p>
        </header>
        <section class="ListeTournoiAccueil">
            <?php foreach ($tournois as $tournoi) : ?>
                <article class="TournoiAccueil">
                    <img src="images/<?php echo $tournoiDAO->getSportImage($tournoi["sid"]); ?>" alt="<?php echo $tournoi["sport"]; ?>" width="300" height="150">
                    <header>
                        <h3><?php echo $tournoi["nom"]; ?></h3>
                    </header>
                    <p>Sport : <?php echo $tournoi["sport"]; ?></p>
                    <p>Nombre de joueurs inscrits : <?php echo $tournoi["nbInscrits"]; ?></p>
                    <p>Places disponibles : <?php echo $tournoi["placesDisponibles"]; ?></p>
                    <p>Statut : <?php echo $tournoi["statut"]; ?></p>
                    <p>Date du tournoi : <?php echo $tournoi["dateTournois"]; ?></p>
                    <p>Date de fin des inscriptions : <?php echo $tournoi["dateFininscription"]; ?></p>
                    <p><a class="hoverConnexionInscription" href="detailTournois.php?tid=<?php echo $tournoi["tid"]; ?>">En savoir plus</a></p>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>