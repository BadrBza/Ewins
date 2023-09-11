<?php
require_once "inc/bd.php";

session_start();

if (isset($_SESSION['uid']) && isset($_GET['tid'])) {
    $uid = $_SESSION['uid'];
    $tid = $_GET['tid'];

    if (isset($_POST['rejoindreTournoi'])) {
        $sql = "SELECT * FROM participer WHERE uid = $uid AND tid = $tid";
        $result = $connexion->query($sql);

        if ($result->num_rows > 0) {
            echo "Vous avez déjà rejoint ce tournoi.";
        } else {
            $sql = "INSERT INTO participer (uid, tid, dateParticipation) VALUES ($uid, $tid, NOW())";
            $result = $connexion->query($sql);

            if ($result) {
                header("Location:DetailTournoiJoueur.php?tid=$tid");
                exit;
            } else {
                echo "Une erreur est survenue, veuillez réessayer.";
            }
        }
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
    <?php
    include "inc/navbar.inc.php";
    ?>
    <section>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
            <p>
                Voulez-vous rejoindre ce tournoi ?
            </p>
            <button type="submit" name="rejoindreTournoi" value="oui">Oui</button>
            <button type="submit" name="annulerRejoindreTournoi" value="non">Non</button>
        </form>
    </section>
    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>