<?php
// Si tu n'as pas de session active tu peux la démarrer
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>PINTO HAPPY HOUR</title>

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/PintoHH/materialize/materialize.css">
    <link rel="stylesheet" type="text/css" href="/PintoHH/feuille.css">
    <link href="https://fonts.googleapis.com/css?family=Coming+Soon" rel="stylesheet">


</head>

<body>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/PintoHH/materialize/materialize.js"></script>
<script type="text/javascript" src="/PintoHH/scripts.js"></script>

<nav>
    <div class="nav-wrapper">
        <a href="/PintoHH/index.php" class="brand-logo center">PINTO HAPPY HOUR</a>
        <ul class="right hide-on-med-and-down">
          <?php if (isset($_SESSION['information'])): ?>
                <li><a class="waves-effect waves-light btn" href="/PintoHH/page/membre/editer_profil.php">Editer Profil</a> </li>
                <li><a class="waves-effect waves-light btn" href="/PintoHH/page/membre/deconnexion.php">Deconnection</a> </li>

                <?php else: ?>
                <li><a class="waves-effect waves-light btn" href="/PintoHH/page/membre/inscription.php">Inscription</a></li>
                <li><a class="waves-effect waves-light btn"  href="/PintoHH/page/membre/connexion.php">Connexion</a></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
    <?php
    if(isset($_SESSION['information']))
    {
        echo "Bonjour" . ($_SESSION['nom']);
    }
    ?>

<div class="container">
    <div class="row">

        <a href="/PintoHH/index.php">
        <div class="col l4 s4" style="background-color: #EB9532">
            <img src="/PintoHH/images/accueil.png" height="110px" class="center-block">
        </div>
        </a>

        <a href="/PintoHH/page/chercher_bar.php">
        <div class="col l4 s4" style="background-color: #F5AB35">
            <img src="/PintoHH/images/chercher-bar.png" height="110px" class="center-block">
        </div>
        </a>

        <a href="/PintoHH/page/chercher_biere.php">
        <div class="col l4 s4" style="background-color: #F27935">
            <img src="/PintoHH/images/chercher-biere.png" height="110px" class="center-block">
        </div>
        </a>

    </div>
</div>


