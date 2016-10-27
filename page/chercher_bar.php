<?php include("../config.php"); ?>

<?php include("header.php"); ?>

<?php
// variables contenues dans $_GET
// <?= revient à dire <? echo
// isset ? : revient à dire if / else
$nom_bar = isset($_GET['nom_bar']) ? $_GET['nom_bar'] : '';
$style_bar = isset($_GET['style_bar']) && $_GET['style_bar']!=='' ? $_GET['style_bar'] : null;

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

            <div class="input-field col l2 s6">
                <select name="style_bar" id="style_bar">
                    <option value="">Choisissez votre option</option>
                    <?php
                    $reponse = $bdd->query('select * from styles_bars');
                    while ($style = $reponse->fetch()) {?>
                        <option value="<?= $style['id_style_bar'] ?>" <?= $style_bar==$style['id_style_bar'] ? 'selected' : '' ?>><?= $style['nom_style_bar'] ?></option>
                    <?php }
                    ?>
                </select>
                <label for="style">Style de Bar</label>
            </div>

            <div class="input-field col l2 s6">
                <select name="ouverture" id="ouverture">
                    <option value="" disabled selected>Choisissez votre option</option>
                    <option>En ce moment</option>
                    <option>Dans une heure</option>
                    <option>Dans la journée</option>
                    <option>Pas de restriction</option>
                </select>
                <label for="ouverture">Ouverture de l'Happy Hour</label>
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
