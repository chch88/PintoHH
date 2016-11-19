<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';
?>
<!-- froala text-editor -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/froala_editor.min.css" rel="stylesheet"
      type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/froala_style.min.css" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<!-- Code Mirror (required) & froala plugins -->
<!-- Include Code Mirror style -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

<!-- Include Editor Plugins style. -->
<link rel="stylesheet" href="../../froala/css/plugins/char_counter.css">
<link rel="stylesheet" href="../../froala/css/plugins/code_view.css">
<link rel="stylesheet" href="../../froala/css/plugins/colors.css">
<link rel="stylesheet" href="../../froala/css/plugins/emoticons.css">
<link rel="stylesheet" href="../../froala/css/plugins/file.css">
<link rel="stylesheet" href="../../froala/css/plugins/fullscreen.css">
<link rel="stylesheet" href="../../froala/css/plugins/image.css">
<link rel="stylesheet" href="../../froala/css/plugins/image_manager.css">
<link rel="stylesheet" href="../../froala/css/plugins/line_breaker.css">
<link rel="stylesheet" href="../../froala/css/plugins/quick_insert.css">
<link rel="stylesheet" href="../../froala/css/plugins/table.css">
<link rel="stylesheet" href="../../froala/css/plugins/video.css">


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/froala_editor.min.js"></script>
<script src="../../froala/js/plugins/align.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/colors.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/code_view.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/code_beautifier.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/draggable.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/font_family.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/font_size.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/file.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/image.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/link.min.js" type="text/javascript"></script>
<script src="../../froala/js/plugins/lists.min.js" type="text/javascript"></script>
<!--fin des plugins -->
<!-- fin froala -->

<script src="admin.js" type="text/javascript"></script>


<div class="row">

    <?php
    if (ROLE == 1) {

    if (isset($_POST) && !empty($_POST['modifier'])) {

        $id = $_GET["id_biere"];

        $type_biere_id_type_biere = (isset($_POST['type_biere_id_type_biere']) && !empty($_POST['type_biere_id_type_biere'])) ? (int)$_POST['type_biere_id_type_biere'] : "";
        $pays_id_pays = (isset($_POST['pays_id_pays']) && !empty($_POST['pays_id_pays'])) ? (int)$_POST['pays_id_pays'] : "";
        // $photos_id_photo = (isset($_POST['photos_id_photo']) && !empty($_POST['photos_id_photo'])) ? (int)$_POST['photos_id_photo'] : "";
        //temporaire
        $photos_id_photo = (int)1;
        $nom_biere = (isset($_POST['nom_biere']) && !empty($_POST['nom_biere'])) ? (string)$_POST['nom_biere'] : "";
        $degree_biere = (isset($_POST['degree_biere']) && !empty($_POST['degree_biere'])) ? (float)$_POST['degree_biere'] : "";

        $description = (isset($_POST['description']) && !empty($_POST['description'])) ? (string)$_POST['description'] : "";


        $addBeer = $bdd->prepare("UPDATE bieres SET nom_biere = :nom,
        pays_id_pays = :pays,
        type_biere_id_type_biere = :type_biere,
        degree_biere = :degre,
        description_biere = :description 
        WHERE id_biere = $id"
        );

        $addBeer->bindParam('nom', $nom_biere, PDO::PARAM_STR);
        $addBeer->bindParam('description', utf8_decode($description), PDO::PARAM_STR);
        $addBeer->bindParam('type_biere', $type_biere_id_type_biere, PDO::PARAM_INT);
        $addBeer->bindParam('pays', $pays_id_pays, PDO::PARAM_INT);
        $addBeer->bindParam('degre', $degree_biere, PDO::PARAM_STR);

        if ($addBeer->execute()) {
            echo "La bière a bien été ajoutée à la base de données.";
        } else {
            echo "Une erreur est survenue lors de l'ajout de la bière.";
        }

    }

    $id = $_GET["id_biere"];

    $biere = "SELECT *
        FROM bieres
        LEFT JOIN type_biere ON type_biere.id_type_biere = bieres.type_biere_id_type_biere
        lEFT JOIN pays ON pays.id_pays = bieres.pays_id_pays
        WHERE bieres.id_biere = $id
        ";
    $pays = "SELECT * FROM `pays`";
    $type_biere = "SELECT * FROM `type_biere`";

    $reponse = $bdd->query($biere);
    while ($donnees = $reponse->fetch()) {
    ?>
    type
    pays
    nom_biere
    degree
    prix_normal
    prix_happy
    description_biere
    <h2 class="center green">Modifier une bière, pu'téh</h2>

    <div class="row">
        <div class="col l12 center">
            <h4><?= $donnees['nom_biere']; ?></h4>
        </div>
        <form class="col l8 offset-l2" action="" method="post" class="col-s8 offset-s2">
            <div class="row">
                <div class="input-field col l4">
                    <select name="type_biere_id_type_biere">
                        <option value="" disabled selected>Choisissez votre option</option>
                        <?php
                        if ($bdd->query($type_biere)) {
                            foreach ($bdd->query($type_biere) as $row) { ?>
                                <option
                                    value="<?= $row['id_type_biere'] ?>" <?php if ($row['id_type_biere'] == $donnees['type_biere_id_type_biere']) {
                                    echo 'selected';
                                } ?>><?= $row['nom_type_biere'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>

                    <label>Type de bière</label>
                </div>


                <div class="input-field col l4">
                    <select name="pays_id_pays">
                        <option value="" disabled selected>Choisissez votre option</option>
                        <?php
                        if ($bdd->query($pays)) {
                            foreach ($bdd->query($pays) as $row) { ?>
                                <option
                                    value="<?= $row['id_pays'] ?>" <?php if ($row['id_pays'] == $donnees['pays_id_pays']) {
                                    echo 'selected';
                                } ?>><?= $row['nom_pays'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <label>Pays</label>
                </div>

                <div class="input-field col l4">
                    <input name="nom_biere" id="nom_biere" type="text" class="validate"
                           value="<?= $donnees['nom_biere']; ?>">
                    <label for="nom_biere">Nom</label>
                </div>
                <div class="input-field col l2">
                    <input name="degree_biere" id="degree" type="text" class="validate"
                           value="<?= $donnees['degree_biere']; ?>">
                    <label for="degree">Degrée</label>
                </div>
                <!--
                NORMALEMENT PRIX NORMAL ET HAPPY
                -->
                <!-- Appel text-editor -->
                <div class="col l12">
                    <textarea id="edit-description"
                              name="description"><?= utf8_encode($donnees['description_biere']); ?></textarea>
                </div>
                <!-- fin du text-editor -->

            </div>


            <div class="row">
                <div class="center col l2 offset-l5">
                    <input class="black" type="submit" name="modifier" value="modifier">
                </div>
            </div>
        </form>
    </div>
</div>


<?php
}
?>
<?php
}
?>
</div>

