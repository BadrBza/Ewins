<?php
require_once 'php/Authentification.php';
require_once 'inc/BD.php';

use Authentification\Authentification as Authentification;
use inc\BD;

$auth = new Authentification();
$auth->verifierReactivationCompte();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réactivation du compte</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "inc/navbar.inc.php"; ?>
    <section class="container-validation">
        <h2>Votre compte a été réactivé, vous pouvez vous reconnectez</h2>
    </section>
</body>

</html>