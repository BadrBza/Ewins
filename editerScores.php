<?php
require_once "inc/bd.php";


?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Editer Score</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<main>
  <?php
  include "inc/navbar.inc.php";
  ?>

  <form>
    <section class="sectionScore">
      <h2>Participant fictif 1: *</h2>
      <input class="EntrerPoint" name="score" required type="number" value="0">
      <h2>Participant fictif 2: *</h2>
      <input class="EntrerPoint" name="score" required type="number" value="0">
      <button id="buttonScore" type="submit" name="Se connecter">Confirmer</button>
    </section>
  </form>
  <?php
  include "inc/footer.inc.php";
  ?>

</main>

</html>