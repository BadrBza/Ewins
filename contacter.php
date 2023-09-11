<?php
require_once "inc/BD.php";
require_once "php/Authentification.php";
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/Exception.php';

use inc\BD;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Authentification\Authentification as Authentification;

$auth = new Authentification();


$valide = '';

if (isset($_POST['envoyer'])) {
    $email = $_POST['Courriel'];
    $objet = $_POST['intitulé'];
    $message = $_POST['Message'];

    $envoiEmail = $auth->envoyerEmailContact($email, $objet, $message);

    if ($envoiEmail) {
        $valide = '<p class="success-message">Courrier envoyé</p>';
    } else {
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
            Contacter
        </p>
        <?php echo $valide; ?>
        <label for="inputContacter">Courriel</label>
        <input id="inputContacter" name="Courriel" type="email" value="<?php echo isset($_SESSION['courriel']) ? $_SESSION['courriel'] : ''; ?>" placeholder="Adresse e-mail(*)">
        <label for="inputIntitulé">Objet</label>
        <input id="inputIntitulé" name="intitulé" type="text" placeholder="Objet">
        <label for="Message">Message</label>
        <textarea id="Message" name="Message" rows="10" cols="50" placeholder="Message..."></textarea>
        <button type="submit" name="envoyer">envoyer</button>
    </form>

    <?php include "inc/footer.inc.php"; ?>
</body>

</html>