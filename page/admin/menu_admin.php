<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="editer_profil.php">Editer le profil</a></li>
    <li class="divider"></li>
    <li><a href="supprimer_profil.php">Supprimer le profil</a></li>
</ul>
<!-- Dropdown Structure -->
<ul id="dropdown2" class="dropdown-content">
    <li><a href="ajouter_bar.php">Ajouter un bar</a></li>
    <li class="divider"></li>
    <li><a href="modifier_bar.php">Modifier un bar</a></li>
</ul>
<!-- Dropdown Structure -->
<ul id="dropdown3" class="dropdown-content">
    <li><a href="ajouter_biere.php">Ajouter une bière</a></li>
    <li class="divider"></li>
    <li><a href="modifier_biere.php">Modifier une bière</a></li>
</ul>


<nav style="margin-top:auto; width: 333px;">
    <div class="nav-wrapper green ">
        <ul class="right ">
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Profil<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown2">Bars<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown3">Bières<i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>
    </div>
</nav>

<?php

$nom_bar = isset($_GET['nom_bar']) ? $_GET['nom_bar'] : '';
$nom_biere = isset($_GET['nom_biere']) ? $_GET['nom_biere'] : '';
?>

<!--
<p class="center-align" ><a href="index.php" alt="index" title="index">Accueil</a></p>
<p class="center-align" ><a href="../admin/index.php" alt="LogOut" title="LogOut">deconnection</a></p>


<div class="row">
<p><a class="col s4 center-align"href="enregistrer_profil.php" alt="enregistrer profil" title="enregistrer profil">enregistrer le profil</a></p>
<p><a class="col s4 center-align"href="editer_profil.php" alt="editer profil" title="editer profil">editer le profil</a></p>
<p><a class="col s4 center-align"href="supprimer_profil.php" alt="supprimer profil" title="supprimer profil">Supprimer le profil</a></p>
<p><a class="col s4 center-align"href="ajouter_bar.php" alt="ajouter bar" title="ajouter bar">ajouter bar</a></p>
<p><a class="col s4 center-align"href="modifier_bar.php" alt="modifier bar" title="modifier bar">modifier bar</a></p>
<p><a class="col s4 center-align"href="supprimer_bar.php" alt="supprimer bar" title="supprimer bar">supprimer bar</a></p>
<p><a class="col s4 center-align"href="ajouter_biere.php" alt="ajouter biere" title="ajouter biere">ajouter biere</a></p>
<p><a class="col s4 center-align"href="modifier_biere.php" alt="modifier biere" title="modifier biere">modifier biere</a></p>
<p><a class="col s4 center-align"href="supprimer_biere.php" alt="supprimer biere" title="supprimer biere">supprimer biere</a></p>
</div> -->
