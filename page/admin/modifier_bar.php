<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header_admin.php';
require 'menu_admin.php';
?>

<br>
<br>

<div class="row">
    <?php
    if (ROLE == 1) {
        $bieres = 'SELECT * FROM bars 
                LEFT JOIN styles_bars 
                ON styles_bars.id_style_bar=bars.styles_bars_id_style_bar  
                LEFT JOIN horaires 
                ON horaires.bars_id_bar = bars.id_bar
                LEFT JOIN bar_favori 
                ON bars.id_bar = bar_favori.bars_id_bar
                LEFT JOIN bar_biere
                ON bars.id_bar = bar_biere.bars_id_bar
                WHERE nom_bar LIKE "%' . $nom_bar . '%"
                GROUP BY bars.nom_bar
	';

        $reponse = $bdd->query($bieres);
        while ($donnees = $reponse->fetch()) {
            ?>

            <div class="col l3">
                <div id="<?= $donnees['id_bar']; ?>" style="cursor: pointer;" onclick="window.location='editer_biere.php?id_bar=<?=$donnees['id_bar']?>';" class="col l12 card-panel center">
                    <ul class="col l10 offset-l1">
                        <li>
                            <h5><?= utf8_encode($donnees['nom_bar']); ?></h5>
                        </li>
                        <li>
							<?php echo $donnees['numero'] . " " . utf8_encode($donnees['rue']) . ", EPINAL" ?>
                        </li>
                    </ul>
                    <div class="col l1">
                        <a href="supprimer_bar.php?id_bar=<?=$donnees['id_bar'];?>" style="color: white;">
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
