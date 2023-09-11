<?php
session_start();
session_destroy();
unset($_COOKIE['nom']);
unset($_COOKIE['prenom']);
setcookie('nom', '', time() - 3600);
setcookie('prenom', '', time() - 3600);
header("Location: ../index.php");
exit();

?>