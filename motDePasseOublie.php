<?php

require_once "inc/BD.php";
require_once "php/Authentification.php";

use Authentification\Authentification as Authentification;
use inc\BD;

$message = '';
if (isset($_POST['envoyer'])) {
    $courriel = $_POST['Courriel'];

    $authentification = new Authentification();

    $reinitialisationReussie = $authentification->reinitialiserMotDePasseOublie($courriel);

    if ($reinitialisationReussie) {
        $message = '<div class="success-message">Un nouveau mot de passe a été envoyé à votre adresse e-mail.</div>';
    } else {
        $message = '<div class="error-message">Cette adresse e-mail n\'est pas enregistrée dans notre système.</div>';
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
    <form action="#" method="post" id="mdpOublie">
        <p id="h4">
            Mot de passe oublié
        </p>
        <?php echo $message; ?>
        <label for="Courriel">Courriel</label>
        <input id="Courriel" name="Courriel" type="email" placeholder="Adresse e-mail">
        <button type="submit" name="envoyer">Envoyer</button>
    </form>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>