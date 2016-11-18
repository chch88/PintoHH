<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';
?>

<div class="row">
    <?php
    if (ROLE == 1) {
        $bieres = 'SELECT *
	FROM bieres
	LEFT JOIN type_biere ON type_biere.id_type_biere = bieres.type_biere_id_type_biere
	LEFT JOIN photos ON photos.id_photo = bieres.photos_id_photo
	LEFT JOIN pays ON pays.id_pays = bieres.pays_id_pays
	';

        $reponse = $bdd->query($bieres);
        while ($donnees = $reponse->fetch()) {
            ?>

            <div class="col l3">
                <div id="<?= $donnees['id_biere']; ?>" style="cursor: pointer;" onclick="window.location='edition_biere.php?id_biere=<?=$donnees['id_biere']?>';" class="col l12 card-panel center">
                    <ul class="col l10 offset-l1">
                        <li>
                            <?= $donnees['nom_biere']; ?>
                        </li>
                        <li>
                            Type de bière: <?= $donnees['nom_type_biere']; ?>
                        </li>
                        <li>
                            Pays d'origine: <?= $donnees['nom_pays']; ?>
                        </li>
                    </ul>
                    <div class="col l1">
                        <a href="supprimer_biere.php?id_biere=<?=$donnees['id_biere'];?>" style="color: white;">
                            <i class="material-icons">delete_forever</i>
                        </a>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
        <?php
    }
    ?>
</div>
