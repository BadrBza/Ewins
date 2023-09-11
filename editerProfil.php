<?php
include "inc/navbar.inc.php";

require_once "inc/BD.php";
require_once "php/Authentification.php";

use Authentification\Authentification as Authentification;
use inc\BD;

$auth = new Authentification();

$auth->verifierConnexion();

$row = $auth->getProfilInfo();

$errorMessage = '';
$successMessage = '';

if (isset($_POST['Valider'])) {

    list($errorMessage, $successMessage) = $auth->modifierProfil();
    $row = $auth->getProfilInfo();
    header("Refresh: 0.5; URL=monProfil.php");
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
    <header>
        <form action="#" method="post" enctype="multipart/form-data">
            <h2> Modifier le compte </h2>
            <?php
            if (!empty($errorMessage)) {
                echo '<p class="error-message">' . $errorMessage . '</p>';
            }
            if (!empty($successMessage)) {
                echo '<p class="success-message">' . $successMessage . '</p>';
            }
            ?>
            <label for="Photodeprofil">Photo de profil</label>
            <input id="Photodeprofil" type="file" name="Photodeprofil" accept=".pdf, .jpg, .png">
            <label for="Courriel">Courriel</label>
            <input id="Courriel" name="Courriel" type="email" required placeholder="Adresse e-mail(*)" value="<?php echo $row['courriel']; ?>">
            <label for="Pseudo">Pseudo</label>
            <input id="Pseudo" name="Pseudo" type="text" required placeholder="Pseudo(*)" value="<?php echo $row['pseudo']; ?>">
            <label for="Nom">Nom</label>
            <input id="Nom" name="Nom" type="text" placeholder="Nom" value="<?php echo $row['nom']; ?>">
            <label for="Prénom">Prénom</label>
            <input id="Prénom" name="Prénom" type="text" placeholder="Prénom" value="<?php echo $row['prenom']; ?>">
            <button type="submit" name="Valider">Valider</button>
            <a class="button" href="modifierMdp.php">Modifier mot de passe</a>
            <a class="button" href="supprimerCompte.php" name="Supprimerprofil">Supprimer Profil</a>
        </form>

    </header>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>