<?php
session_start();
require_once "inc/BD.php";
require_once "php/TournoiDAO.php";
require_once "php/Authentification.php";

use TournoiDAO\TournoiDAO as TournoiDAO;
use Authentification\Authentification as Authentification;
use inc\BD;

require_once 'php/TournoiDAO.php';
$message = '';
$messageSupp = '';

$tournoiDAO = new TournoiDAO();
$authentification = new Authentification();



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tid'])) {
    $tid = $_POST['tid'];

    $authentification = new Authentification();
    //

    if (isset($_POST['participer'])) {

        $message = $authentification->rejoindreTournoi($tid);

        if (isset($_SESSION['courriel'])) {
            $mail = $_SESSION['courriel'];
            $authentification->envoyerEmailGenerale($mail,'Confirmation d\'inscription au tournoi',"Votre inscription au tournoi a été effectuée avec succès.");
            
            if ($message === true) {
                header("Refresh: 2; URL=detailTournois.php?tid=$tid");
                exit;
            }
        }
    }


    if ($authentification->estAdmin()) {
        if (isset($_POST['confirmer_suppression'])) {
            $tid = $_POST['tid'];

            $result = $tournoiDAO->setTournoiInactive($tid);

            if ($result === true) {
                $authentification->envoyerEmailSupprimerTournoi();
                $_SESSION['message'] = "Tournoi supprimé avec succès.";
            } elseif ($result === "participantsExist") {
                $_SESSION['message'] = "Le tournoi a des participants et ne peut pas être supprimé.";
            } else {
                $_SESSION['message'] = "Seuls les tournois avec le statut 'Terminé' peuvent être supprimés.";
            }
            header("Location: listeTournois3.php");
            exit;
        }

        if (isset($_POST['annuler_suppression'])) {
            header("Location: listeTournois3.php");
            exit;
        }
    }
}


    $tournois = $tournoiDAO->afficherTousTournois();
    $estAdmin = $authentification->estAdmin();

    $estConnecte = isset($_SESSION['uid']);
    $uid = $estConnecte ? $_SESSION['uid'] : null;


    $rechercheMyCookie = isset($_COOKIE['filtre_rechercheMy']) ? $_COOKIE['filtre_rechercheMy'] : "";

    if (isset($_COOKIE['filtre_statut']) && !isset($_COOKIE['filtre_sport'])) {
        $tournois = $tournoiDAO->afficherTournoisFiltres($_COOKIE['filtre_statut'], null, $uid);
    }

    if (isset($_COOKIE['filtre_sport']) && !isset($_COOKIE['filtre_statut'])) {
        $tournois = $tournoiDAO->afficherTournoisFiltres(null, $_COOKIE['filtre_sport'], $uid);
    }

    if (isset($_COOKIE['filtre_sport']) && isset($_COOKIE['filtre_statut'])) {
        $tournois = $tournoiDAO->afficherTournoisFiltres($_COOKIE['filtre_statut'], $_COOKIE['filtre_sport'], $uid);
    }




    if (isset($_POST['recherche'])) {

        $statut = isset($_POST['statut']) ? $_POST['statut'] : "";
        $sport = isset($_POST['sport']) ? $_POST['sport'] : "";

        setcookie('filtre_statut', $statut, time() + 3600);
        setcookie('filtre_sport', $sport, time() + 3600);

        $tournois = $tournoiDAO->afficherTournoisFiltres($statut, $sport, $uid);
    }

    if (isset($_POST['rechercheMy'])) {

        $estConnecte = isset($_SESSION['uid']);
        $uid = $estConnecte ? $_SESSION['uid'] : null;
        $tournois = $tournoiDAO->afficherTournoisInscrit($uid);
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>liste des tournois</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "inc/navbar.inc.php";
    ?>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<p class="success-message">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    ?>
    <main>
        <?php if (isset($message) && $message !== '') { ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php } ?>

        <?php

        if ($authentification->estAdmin() && isset($_POST['supprimer'])) {
            $tid = $_POST['tid'];
            $nomTournoi = $tournoiDAO->getNomTournoi($tid);

            echo '<section class="container-validation">
            <h2>Voulez-vous vraiment supprimer le tournoi ' . htmlspecialchars($nomTournoi) . ' ?</h2>
                    <form method="post" class="formulaire">
                        <input type="hidden" name="tid" value="' . $tid . '" />
                        <button type="submit" class="bouton" name="confirmer_suppression" style="width:200px;">Oui</button>
                        <button type="submit" class="bouton" name="annuler_suppression" style="width:200px;">Non</button>
                    </form>
                    </section>';
            exit;
        }
        ?>

        <section>
            <article id="TournoiAccueilTournoi">
                <!--
				<p>
					<a href="listeTournoiOrganisateur.php">Voir le point de vue de l'organisateur</a>
				</p>
				-->
                <form method="post">
                    <h2>Filtres</h2>
                    <section>
                        <h2>Statut :</h2>
                        <select class="typeDesport" name="statut" id="statut">
                            <option value="">Choisissez le statut</option>
                            <option value="Ouvert" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'Ouvert') ? 'selected' : ''; ?>>Ouvert</option>
                            <option value="Fermer" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'Fermer') ? 'selected' : ''; ?>>Fermé</option>
                            <option value="Cloturé" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'Cloturé') ? 'selected' : ''; ?>>Cloturé</option>
                            <option value="Généré" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'Généré') ? 'selected' : ''; ?>>Généré</option>
                            <option value="En cours" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                            <option value="Terminé" <?php echo (isset($_COOKIE['filtre_statut']) && $_COOKIE['filtre_statut'] == 'Terminé') ? 'selected' : ''; ?>>Terminé</option>
                        </select>
                    </section>
                    <section>
                        <h2>Sport :</h2>
                        <select class="typeDesport" name="sport" id="sport">
                            <option value="">Choisissez le sport</option>
                            <option value="Belotte" <?php echo (isset($_COOKIE['filtre_sport']) && $_COOKIE['filtre_sport'] == 'Belotte') ? 'selected' : ''; ?>>Belotte</option>
                            <option value="Echec" <?php echo (isset($_COOKIE['filtre_sport']) && $_COOKIE['filtre_sport'] == 'Echec') ? 'selected' : ''; ?>>Jeu d'échecs</option>
                            <option value="Tennis" <?php echo (isset($_COOKIE['filtre_sport']) && $_COOKIE['filtre_sport'] == 'Tennis') ? 'selected' : ''; ?>>Tennis</option>
                            <option value="Ping-Pong" <?php echo (isset($_COOKIE['filtre_sport']) && $_COOKIE['filtre_sport'] == 'Ping-Pong') ? 'selected' : ''; ?>>Ping Pong</option>
                            <option value="Fifa" <?php echo (isset($_COOKIE['filtre_sport']) && $_COOKIE['filtre_sport'] == 'Fifa') ? 'selected' : ''; ?>>FIFA</option>
                        </select>
                    </section>

                    <button type="submit" name="recherche">Rechercher</button>
                    <?php if (!$authentification->estAdmin()) { ?>
                        <button type="submit" name="rechercheMy">Mes tournois</button>
                    <?php } ?>
                </form>
            </article>
        </section>
        <p id="aSuppModif">
            <?php if ($authentification->estAdmin()) { ?>
                <a href="ajouterTournoi.php">Ajouter Tournoi</a>
            <?php } ?>
        </p>
        <section class="ListeTournoiAccueil">
            <?php
            // Afficher les tournois filtrés
            foreach ($tournois as $row) {
                $tid = $row['tid'];
                $nombreParticipants = $tournoiDAO->getNombreParticipants($tid);
            ?>
                <article class="articleListeTournoi">
                    <header>
                        <h3><?php echo $row["nom"]; ?></h3>
                    </header>
                    <ul class="ulListeTournoi">
                        <li>Sport : <?php echo $row["sport_nom"]; ?></li>
                        <li>Nombre de joueurs inscrits : <?php echo $nombreParticipants; ?></li>
                        <li>Places disponibles : <?php echo $row["placesDisponibles"]; ?></li>
                        <li>Statut : <?php echo $row["statut_nom"]; ?></li>
                        <li>Date du tournoi : <?php echo $row["dateTournois"]; ?></li>
                        <li>Date de fin des inscriptions : <?php echo $row["dateFininscription"]; ?></li>
                        <li><a class="hoverConnexionInscription" href="detailTournois.php?tid=<?php echo $row["tid"] ?>">En savoir plus</a></li>
                        <form method="POST">
                            <input type="hidden" name="tid" value="<?php echo $row["tid"]; ?>">
                            <?php
                            if ($authentification->estAdmin()) {
                            ?>
                                <button type="submit" name="supprimer">Supprimer</button>
                            <?php
                            } else {
                            ?>
                                <button type="submit" name="participer">Participer</button>
                            <?php
                            }
                            ?>
                        </form>

                    </ul>
                </article>
            <?php
            }
            ?>
        </section>
    </main>

    <?php include "inc/footer.inc.php"; ?>
</body>

</html>