<?php

require_once "inc/BD.php";
require_once "php/TournoiDAO.php";

use TournoiDAO\TournoiDAO as TournoiDAO;
use inc\BD;

$message = "";
$messageType = "";


$tournoiDAO = new TournoiDAO();

if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    $tournoi = $tournoiDAO->getTournoiById($tid);

    if ($tournoi) {

        $nomTournoi = $tournoi['nom'];
        $typeDesport = $tournoi['sid'];
        $placeDisponible = $tournoi['placesDisponibles'];
        $statutDutournoi = $tournoi['id_statut'];
        $dateDebutTournoi = $tournoi['dateTournois'];
        $finDinscription = $tournoi['dateFininscription'];

        if (isset($_POST['envoyerEditerTournoi'])) {

            $nomTournoi = $_POST['nomTournoi'];
            $typeDesport = $_POST['typeDesport'];
            $placeDisponible = $_POST['placeDisponible'];
            $statutDutournoi = $_POST['statutDutournoi'];
            $dateDebutTournoi = $_POST['dateDebutTournoi'];
            $finDinscription = $_POST['finDinscription'];

            if (empty($nomTournoi) || empty($typeDesport) || empty($placeDisponible)  || empty($dateDebutTournoi) || empty($finDinscription)) {
                $message = "Veuillez remplir tous les champs obligatoires.";
                $messageType = "error";
            } else {
                $result = $tournoiDAO->modifierTournoi($tid, $nomTournoi, $typeDesport, $placeDisponible, $statutDutournoi, $dateDebutTournoi, $finDinscription);

                if ($result) {
                    $message = "Le tournoi a été modifié avec succès.";
                    $messageType = "success";
                } else {
                    $message = "Une erreur est survenue lors de la modification du tournoi.";
                    $messageType = "error";
                }
            }
        }
    } else {
        $message = "Le tournoi n'a pas été trouvé.";
        $messageType = "error";
    }
} else {
    $message = "L'ID du tournoi n'est pas spécifié.";
    $messageType = "error";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un tournoi</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "inc/navbar.inc.php";
    ?>
    <form action="#" method="post" id="formInscription" enctype="multipart/form-data">
        <h1 id="h1Connexion">Modifier un tournoi</h1>
        <?php

        if (isset($message) && !empty($message)) {
            if ($messageType === "success") {
                echo '<div class="success-message">' . $message . '</div>';
            } elseif ($messageType === "error") {
                echo '<div class="error-message">' . $message . '</div>';
            }
        }

        ?>
        <label for="nom">Nom du tournoi</label>
        <input id="nom" name="nomTournoi" type="text" placeholder="Nom" value="<?php echo isset($nomTournoi) ? $nomTournoi : ''; ?>">

        <label for="sport">Sport</label>
        <select class="typeDesport" name="typeDesport" id="sport">
            <option value="">Choisissez le sport</option>
            <option value="Belotte" <?php echo isset($typeDesport) && $typeDesport === 'Belotte' ? 'selected' : ''; ?>>Belotte</option>
            <option value="Echec" <?php echo isset($typeDesport) && $typeDesport === 'Echec' ? 'selected' : ''; ?>>Jeu d'échecs</option>
            <option value="Tennis" <?php echo isset($typeDesport) && $typeDesport === 'Tennis' ? 'selected' : ''; ?>>Tennis</option>
            <option value="Ping-Pong" <?php echo isset($typeDesport) && $typeDesport === 'Ping-Pong' ? 'selected' : ''; ?>>Ping Pong</option>
            <option value="Fifa" <?php echo isset($typeDesport) && $typeDesport === 'Fifa' ? 'selected' : ''; ?>>FIFA</option>
        </select>
        <label for="placeDispo">Places disponibles</label>
        <input type="number" name="placeDisponible" id="placeDispo" value="<?php echo isset($placeDisponible) ? $placeDisponible : ''; ?>" placeholder="Minimum 2 places">

        <label for="statut">Statut</label>
        <select class="typeDesport" name="statutDutournoi" id="statut">
            <option value="">Choisissez le statut</option>
            <option value="Ouvert" <?php echo isset($statutDutournoi) && $statutDutournoi === 'Ouvert' ? 'selected' : ''; ?>>Ouvert</option>
            <option value="Fermer" <?php echo isset($statutDutournoi) && $statutDutournoi === 'Fermer' ? 'selected' : ''; ?>>Fermé</option>
            <option value="Cloturé" <?php echo isset($statutDutournoi) && $statutDutournoi === 'Cloturé' ? 'selected' : ''; ?>>Cloturé</option>
            <option value="Généré" <?php echo isset($statutDutournoi) && $statutDutournoi === 'Généré' ? 'selected' : ''; ?>>Généré</option>
            <option value="En cours" <?php echo isset($statutDutournoi) && $statutDutournoi === 'En cours' ? 'selected' : ''; ?>>En cours</option>
            <option value="Terminé" <?php echo isset($statutDutournoi) && $statutDutournoi === 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
        </select>
        <label for="dateDebut">Date du tournoi</label>
        <input id="dateDebut" name="dateDebutTournoi" type="date" placeholder="Date du tournoi" value="<?php echo isset($dateDebutTournoi) ? $dateDebutTournoi : ''; ?>">

        <label for="dateFin">Date de fin d'inscription</label>
        <input id="dateFin" name="finDinscription" type="date" placeholder="Date de fin d'inscription" value="<?php echo isset($finDinscription) ? $finDinscription : ''; ?>">

        <button type="submit" name="envoyerEditerTournoi">Confirmer</button>
    </form>
    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>