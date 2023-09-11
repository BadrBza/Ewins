<?php
require_once "inc/BD.php";
require_once "php/InscriptionCompte.php";
require_once "php/Authentification.php";

use InscriptionCompte\InscriptionCompte as InscriptionCompte;
use Authentification\Authentification as Authentification;
use inc\BD;

$db = new BD();
$inscription = new InscriptionCompte($db);
$auth = new Authentification();

$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscrire'])) {
    $inscription->inscrire($_POST, $_FILES);

    $courriel = $_POST["Courriel"];
    $auth->envoyerEmailGenerale($courriel,'Confirmation d\'inscription',"Votre inscription a été effectuée avec succès.");
}

if (isset($_GET['inscription_err'])) {
    $errors = [
        'missPhoto' => 'veuillez mettre une photo de profil',
        'missingValue' => 'Veuillez remplir tous les champs',
        'invalideEmail' => 'Email invalide',
        'notUniqueEmail' => 'Email déja utilisé',
        'notUniquePseudo' => 'Le pseudo est deja utilisé',
        'notEqualsMdp' => 'Veuillez répéter le mot de passe',
        'notUniqueMail' => 'Mail deja utilisé',
    ];

    $message = isset($errors[$_GET['inscription_err']]) ? $errors[$_GET['inscription_err']] : '';
    $message = '<p class="error-message">' . $message . '</p>';
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

    <article id="articleInscription">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" id="formInscription" enctype="multipart/form-data">
            <h1 id="h1Connexion">Inscription</h1>
            <?php echo $message; ?>
            <label for="Photodeprofil">Photo de profil</label>
            <input id="Photodeprofil" type="file" name="Photodeprofil" accept=".pdf, .jpg, .png">
            <label for="Courriel">Courriel</label>
            <input id="Courriel" name="Courriel" type="email" placeholder="Adresse e-mail">
            <label for="Nom">Nom</label>
            <input id="Nom" name="Nom" type="text" placeholder="Nom">
            <label for="Prénom">Prénom</label>
            <input id="Prénom" name="Prénom" type="text" placeholder="Prénom">
            <label for="Pseudo">Pseudo</label>
            <input id="Pseudo" name="Pseudo" type="text" placeholder="Pseudo">
            <label for="MotDePasse">Mot De Passe</label>
            <input id="MotDePasse" name="motDePasse" type="password" placeholder="Mot de passe">
            <label for="ConfirmezMotDePasse">Confirmer mot de passe</label>
            <input id="ConfirmezMotDePasse" name="confirmezmotDePasse" type="password" placeholder="Confirmez votre Mot de passe">
            <button type="submit" name="inscrire">S'inscrire</button>
        </form>
    </article>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>