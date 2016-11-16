<?php include("../config.php"); ?>

<?php include("header.php"); ?>

<?php
// variables contenues dans $_GET
// <?= revient à dire <? echo
// isset ? : revient à dire if / else
$nom_bar = isset($_GET['nom_bar']) ? $_GET['nom_bar'] : '';
$style_bar = isset($_GET['style_bar']) && $_GET['style_bar']!=='' ? $_GET['style_bar'] : null;
$restriction = isset($_GET['restriction']) && $_GET['restriction'] !== '' ? $_GET['restriction'] : null;

$time_array = getdate();



$weekday = $time_array['wday'];
$hour = $time_array['hours'];
$hp1 = $time_array['hours'] + 1;
$hp2 = $time_array['hours'] + 1;
$minutes = $time_array['minutes'];
$mp1 = $time_array['minutes'] - 60;
$seconds = $time_array['seconds'];




if ($time_array['hours'] < 10) {
    $hour = 0 . $time_array['hours'];
}

if ($time_array['minutes'] < 10) {
    $minutes = 0 . $time_array['minutes'];
}

if ($time_array['seconds'] < 10) {
    $seconds = 0 . $time_array['seconds'];
}


?>

<div class="container2">

    <h3 class="center-align">Rechercher un Bar</h3>
    <br>
    <br>

    <!-- BARRE DE RECHERCHE DES BARS -->
    <div class="row">

        <form method="get">

          <div class="input-field col l2 s6 offset-l1">
            <label for="nom_bar">Nom</label>
              <input type="text" name="nom_bar" id="nom_bar" class="autocomplete" value="<?= $nom_bar ?>"/>
          </div>


           <!-- <div class="input-field col l2 s6">
                <select name="distance" id="distance">
                    <option value="" disabled selected>Choisissez votre option</option>
                    <option>500M</option>
                    <option>1 Km</option>
                    <option>5 Km</option>
                    <option>Pas de Palier</option>
                </select>
                <label for="distance">Palier de Distance</label>
            </div> -->

            <div class="input-field col l3 s6">
                <select name="style_bar" id="style_bar">
                    <option value="">Choisissez votre option</option>
                    <?php
                    $reponse = $bdd->query('select * from styles_bars');
                    while ($style = $reponse->fetch()) {?>
                        <option value="<?= $style['id_style_bar'] ?>" <?= $style_bar==$style['id_style_bar'] ? 'selected' : '' ?>><?= utf8_encode($style['nom_style_bar']) ?></option>
                    <?php }
                    ?>
                </select>
                <label for="style">Style de Bar</label>
            </div>

            <div class="input-field col l3 s6">
                <select name="restriction" id="Restriction">
                    <option value="" disabled selected>Choisissez votre option</option>
                    <option value="0" <?php if (strpos($_SERVER['REQUEST_URI'], "&restriction=0") !== false) {
                        echo "selected";
                    } ?>>Pas de restriction
                    </option>
                    <option value="1" <?php if (strpos($_SERVER['REQUEST_URI'], "&restriction=1") !== false) {
                        echo "selected";
                    } ?>>Dans la journée
                    </option>
                    <option value="2" <?php if (strpos($_SERVER['REQUEST_URI'], "&restriction=2") !== false) {
                        echo "selected";
                    } ?>>Dans une heure
                    </option>
                    <option value="3" <?php if (strpos($_SERVER['REQUEST_URI'], "&restriction=3") !== false) {
                        echo "selected";
                    } ?>>En ce moment
                    </option>
                </select>
                <label for="Restriction">Happy Hour ouvert</label>
            </div>


            <!--- <div class="input-field col l2 s6">
             <label>Ouverture de l'Happy Hour</label>
             <input type="radio" name="Ouverture" id="moment"> <label for="moment">En ce moment</label>
             <input type="radio" name="Ouverture" id="heure"><label for="heure">Dans une heure</label>
             <input type="radio" name="Ouverture" id="journee"><label for="journee">Dans la journée</label>
             <input type="radio" name="Ouverture" id="Pas_de_restriction"><label for="Pas_de_restriction">Pas de
             restriction</label>
             </div>
         --->
            <div class="input-field col l1 s6">
                <button class="waves-effect waves-light btn" type="submit" name="action">Rechercher</button>
            </div>

        </form> <!-- fin du formulaire -->

    </div> <!-- fin row -->

<?php
    include('template_bars.php');
?>


</div> <!-- fin container -->

<?php include("footer.php"); ?>
