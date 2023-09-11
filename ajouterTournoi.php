<?php

require_once "inc/BD.php";
require_once "php/TournoiDAO.php";

use TournoiDAO\TournoiDAO as TournoiDAO;
use inc\BD;

$message = "";

$tournoiDAO = new TournoiDAO();

$nomTournoi = '';
$typeDesport = '';
$placeDisponible = '';
$statutDutournoi = '';
$dateDebutTournoi = '';
$finDinscription = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomTournoi = $_POST['nomTournoi'];
    $typeDesport = $_POST['typeDesport'];
    $placeDisponible = $_POST['placeDisponible'] ? max(2, $_POST['placeDisponible']) : 10;
    $statutDutournoi = $_POST['statutDutournoi'];
    $dateDebutTournoi = $_POST['dateDebutTournoi'];
    $finDinscription = $_POST['finDinscription'];

    $result = $tournoiDAO->ajouterTournoi($nomTournoi, $typeDesport, $placeDisponible, $statutDutournoi, $dateDebutTournoi, $finDinscription);

    if ($result === true) {
        $message = "Le tournoi a été ajouté avec succès.";
        header("Refresh:1; listeTournois3.php");
    } else {
        $message = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Projet</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "inc/navbar.inc.php"; ?>
    <article id="articleAjoutTournoi">
        <form action="#" method="post" id="formAjoutTournoi">
            <h1 id="h1AjoutTournoi">Ajouter un tournoi</h1>
            <?php
            if (isset($message) && !empty($message)) {
                echo '<div class="success-message">' . $message . '</div>';
            }
            ?>
            <label for="nom">Nom du tournoi</label>
            <input id="nom" name="nomTournoi" type="text" placeholder="Nom du tournoi" required>

            <label for="sport">Sport</label>
            <select class="typeDesport" name="typeDesport" id="sport" required>
                <option value="vide">Choisissez le sport</option>
                <option value="Belotte">Belotte</option>
                <option value="Echec">Jeu d'échecs</option>
                <option value="Tennis">Tennis</option>
                <option value="Ping-Pong">Ping Pong</option>
                <option value="Fifa">FIFA</option>
            </select>

            <label for="placeDispo">Places disponibles</label>
            <input type="number" name="placeDisponible" id="placeDispo" value=10 placeholder="Nombre de places disponibles" required>

            <label for="statut">Statut</label>
            <select class="typeDesport" name="statutDutournoi" id="statut" required>
                <option value="vide">Choisissez le statut</option>
                <option value="Ouvert">Ouvert</option>
                <option value="Fermer">Fermé</option>
                <option value="Cloturé">Cloturé</option>
                <option value="Généré">Généré</option>
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
            </select>

            <label for="dateDebut">Date du tournoi</label>
            <input id="dateDebut" name="dateDebutTournoi" type="date" required>

            <label for="dateFin">Date de fin d'inscription</label>
            <input id="dateFin" name="finDinscription" type="date" required>

            <button type="submit" name="envoyerAjoutTournoi">Ajouter le tournoi</button>
        </form>
    </article>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>