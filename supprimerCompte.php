<?php

session_start();
require_once "inc/BD.php";
require_once "php/Authentification.php";
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/Exception.php';

use Authentification\Authentification as Authentification;


$auth = new Authentification();

$message = "";

if (isset($_POST['SupprimerprofilCompte'])) {

    $motDePasse = $_POST['MotDePasse'];

    if (isset($_SESSION['courriel'])) {

        $courrielUtilisateur = $_SESSION['courriel'];
        $auth->envoyerEmailGenerale($courrielUtilisateur,'Confirmation de suppression de compte', 'Votre compte a été supprimé avec succès.');
    }

    $result = $auth->supprimerProfil($motDePasse);

    if ($result === true) {
        header("Location:index.php");
        exit();
    } else {
        $message = '<p class="error-message">' . $result . '</p>';
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
    <form action="#" method="post" id="formContacter">
        <p id="h1Connexion">
            Supprimer Compte
        </p>
        <?php echo $message; ?>
        <label for="MotDePasse">Mot De Passe</label>
        <input id="MotDePasse" name="MotDePasse" type="password" placeholder="Mot de passe">
        <button type="submit" name="SupprimerprofilCompte">Supprimer Profil</button>
        <a class="button" href="editerProfil.php">annuler</a>
    </form>

    <?php include "inc/footer.inc.php"; ?>
</body>

</html>