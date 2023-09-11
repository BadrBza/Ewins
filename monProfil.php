<!DOCTYPE html>
<html>

<head>
    <title>Profil de compte</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <?php include "inc/navbar.inc.php";

        require_once "inc/BD.php";
        require_once "php/Authentification.php";

        use Authentification\Authentification as Authentification;

        $auth = new Authentification();

        $row = $auth->afficherProfilCompte();

        $uploadsDir = 'uploads/';

        ?>

        <article class="container">
            <?php if (isset($row) && $row['urlPhoto'] != null) : ?>
                <?php if (strpos($row['urlPhoto'], 'uploads/') === 0) : ?>
                    <img class="imagePP" src="<?php echo $row['urlPhoto']; ?>" alt="Photo de profil" width="50" height="50">
                <?php else : ?>
                    <img class="imagePP" src="<?php echo $uploadsDir . $row['urlPhoto']; ?>" alt="Photo de profil" width="50" height="50">
                <?php endif; ?>
            <?php else : ?>
                <img class="imagePP" src="../images/photoDeProfil.jpg" alt="Photo de profil" width="50" height="50">
            <?php endif; ?>

            <h1>Profil de compte</h1>
            <p class="name">Nom : <?php echo $row["nom"]; ?></p>
            <p class="name">Prénom : <?php echo $row["prenom"]; ?></p>
            <p class="name">Pseudo : <?php echo $row["pseudo"]; ?></p>
            <p>Email : <?php echo $row["courriel"]; ?></p>
            <p>Mot de passe : **********</p>
            <a class="button" href="editerProfil.php">Modifier</a>

        </article>

    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>

</html>