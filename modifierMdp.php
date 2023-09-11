<?php
session_start();

require_once "inc/BD.php";
require_once "php/Authentification.php";

use Authentification\Authentification as Authentification;
use inc\BD;

$Authentification = new Authentification();

if (isset($_SESSION['uid'])) {
    $idUtilisateur = $_SESSION['uid'];

    list($errorMessage, $successMessage) = $Authentification->modifierMdp();
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
    <?php
    include "inc/navbar.inc.php";
    ?>
    <header>
        <form action="#" method="post" enctype="multipart/form-data">
            <h2> Modifier le compte </h2>
            <?php
            if (!empty($errorMessage)) {
                echo '<div class="error-message">' . $errorMessage . '</div>';
            }
            if (!empty($successMessage)) {
                echo '<div class="success-message">' . $successMessage . '</div>';
            }
            ?>
            <label for="AncienMotDePasse">Ancien Mot De Passe</label>
            <input id="AncienMotDePasse" name="AncienMotDePasse" type="password" placeholder="Mot de passe">
            <label for="NouveauMotDePasse">Nouveau Mot De Passe</label>
            <input id="NouveauMotDePasse" name="newMotDePasse" type="password" placeholder="Mot de passe">
            <label for="ConfirmezNouveauMotDePasse">Confirmer nouveau mot de passe</label>
            <input id="ConfirmezNouveauMotDePasse" name="confirmezNewMotDePasse" type="password" placeholder="Confirmez votre Mot de passe">
            <button type="submit" name="Valider">Valider</button>
    </header>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>