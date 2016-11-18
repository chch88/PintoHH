<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';


if (ROLE == 1) {

    $BieresAll = "SELECT * FROM `bieres` 
	JOIN `type_biere`
	ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
	JOIN `pays` ON bieres.pays_id_pays = pays.id_pays
	JOIN `photos` ON bieres.photos_id_photo = photos.id_photo ";
    $pays = "SELECT * FROM `pays`";
    $type_biere = "SELECT * FROM `type_biere`";

    if (isset($_POST) && !empty($_POST['ajouter'])) {

        $type_biere_id_type_biere = (isset($_POST['type_biere_id_type_biere']) && !empty($_POST['type_biere_id_type_biere'])) ? (int)$_POST['type_biere_id_type_biere'] : "";
        $pays_id_pays = (isset($_POST['pays_id_pays']) && !empty($_POST['pays_id_pays'])) ? (int)$_POST['pays_id_pays'] : "";
        $photos_id_photo = (isset($_POST['photos_id_photo']) && !empty($_POST['photos_id_photo'])) ? (int)$_POST['photos_id_photo'] : "";
        //temporaire
        $photos_id_photo = (int)1;
        $nom_biere = (isset($_POST['nom_biere']) && !empty($_POST['nom_biere'])) ? (string)$_POST['nom_biere'] : "";
        $degree_biere = (isset($_POST['degree_biere']) && !empty($_POST['degree_biere'])) ? (int)$_POST['degree_biere'] : "";
        $description = (isset($_POST['description']) && !empty($_POST['description'])) ? (string)$_POST['description'] : "";


        $addBeer = "INSERT INTO `bieres`(
	`type_biere_id_type_biere`,
	`pays_id_pays`,
	`photos_id_photo`,
	`nom_biere`,
	`degree_biere`,
	`description_biere`
	) VALUES (
	$type_biere_id_type_biere,
	$pays_id_pays,
	$photos_id_photo,
	'" . utf8_decode($nom_biere) . "',
	'" . utf8_decode($description) . "'
	)";


        if ($bdd->query($addBeer)) {
            echo "<h1>Nouvelle bière ajoutée !</h1>";
        } else {
            echo "<h1>Erreur lors de l'ajout de la bière !</h1>";
        }


    }
    ?>

    <h1 class="center green">Les bières</h1>
    <table class="responsive-table  highlight black" style='max-width:80%;margin:auto;'>
        <tr class="centered blue">
            <th>id_biere</th>
            <th>type</th>
            <th>pays</th>
            <th>photo</th>
            <th>nom</th>
            <th>degrès</th>
            <th>description</th>
        </tr>
        <?php
        $id = array();
        $counter = 0;
        foreach ($bdd->query($BieresAll) as $row) {
            $counter++;
            ?>
            <tr>
                <td><?= $row['id_biere'] ?></td>
                <td><?= utf8_encode($row['nom_type_biere']) ?></td>
                <td><?= utf8_encode($row['nom_pays']) ?></td>
                <td><?= $row['fichier'] ?> </td>
                <td><?= utf8_encode($row['nom_biere']) ?></td>
                <td><?= $row['degree_biere'] ?></td>
                <td><?= utf8_encode($row['description_biere']) ?></td>
            </tr>
        <?php } ?>

    </table>
    <p class="center"><?= $counter ?> bières</p>
    <h2 class="center green">Ajouter une bière</h2>

    <div class="row">
        <form class="col s8 offset-s2" action="" method="post" class="col-s8 offset-s2">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Parcourir</span>
                    <input name="photos_id_photo" type="file" multiple>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload one or more files">
                </div>
            </div>

            <div class="input-field col s6">
                <select name="type_biere_id_type_biere">
                    <option value="" disabled selected>Type de bière</option>
                    <?php
                    if ($bdd->query($type_biere)) {
                        foreach ($bdd->query($type_biere) as $row) { ?>
                            <option value="<?= $row['id_type_biere'] ?>"><?= $row['nom_type_biere'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <label>Type de bière</label>
            </div>


            <div class="input-field col s6">
                <select name="pays_id_pays">
                    <option value="" disabled selected>Pays</option>
                    <?php
                    if ($bdd->query($pays)) {
                        foreach ($bdd->query($pays) as $row) { ?>
                            <option value="<?= $row['id_pays'] ?>"><?= $row['nom_pays'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <label>Pays</label>
            </div>

            <div class="input-field col s6">
                <input name="nom_biere" id="nom_biere" type="text" class="validate">
                <label for="nom_biere">nom</label>
            </div>
            <div class="input-field col s6">
                <input name="degree_biere" id="degres" type="text" class="validate">
                <label for="degres">degrès</label>
            </div>
            <div class="input-field col s12">
                <input name="description" id="description" type="text" class="validate">
                <label for="description">Description</label>
            </div>


            <div class="row">
                <div class="center">
                    <input class="black" type="submit" name="ajouter" value="ajouter">
                </div>
            </div>
        </form>
    </div>
    </div>


<?php } else {
    echo "<h1>Accès interdit :</h1>";
}
