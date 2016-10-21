<?php include("../config.php"); ?>

<?php include("header.php"); ?>

<?php
// variables contenues dans $_GET
$nom_biere = isset($_GET['nom_biere']) ? $_GET['nom_biere'] : '';
$type_biere = isset($_GET['type_biere']) && $_GET['type_biere'] !== '' ? $_GET['type_biere'] : null;
$provenance_biere = isset($_GET['provenance_biere']) && $_GET['provenance_biere'] !== '' ? $_GET['provenance_biere'] : null;
$degree_biere = isset($_GET['degre_biere']) && $_GET['degre_biere'] !== '' ? $_GET['degre_biere'] : null;

// Définit le fuseau horaire par défaut à utiliser. Disponible depuis PHP 5.1
date_default_timezone_set('UTC');
?>

    <div class="container2">

        <h2 class="center-align">Rechercher une bière</h2>

        <div class="row">

            <form method="get" action="">
                <div class="input-field col l2 s6">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom_biere" id="nom" value="<?= $nom_biere ?>">
                </div>

                <!--
                <div class="input-field col l2 s6">
                    <select name="distance_biere" id="Distance">
                        <option>500M</option>
                        <option>1 Km</option>
                        <option>5 Km</option>
                        <option>Pas de palier</option>
                    </select>
                    <label for="Distance">Palier de distance</label>
                </div>
                -->

                <div class="input-field col l2 s6">
                    <select name="degre_biere" id="Degre">
                        <option value="" disabled selected>Choisissez votre option</option>
                        <option value="0">Sans alcool</option>
                        <option value="4"><4 %</option>
                        <option value="7"><7 %</option>
                        <option value="10"><10 %</option>
                    </select>
                    <label for="Degre"> Degré d'alcool </label>
                </div>


                <!-- TYPE BIERE -->
                <div class="input-field col l2 s6">
                    <select name="type_biere" id="Type">
                        <option value="" disabled selected>Choisissez votre option</option>
                        <?php
                        $sql = $bdd->query("SELECT *
                                FROM type_biere
                                ");

                        while ($type = $sql->fetch()) { ?>
                            <option
                                value="<?= $type['id_type_biere'] ?>" <?= $type_biere == $type['id_type_biere'] ? 'selected' : '' ?>><?= $type['nom_type_biere'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="Type">Type de bière</label>
                </div>

                <div class="input-field col l2 s6">
                    <select name="provenance_biere" id="Provenance">
                        <option value="" disabled selected>Choisissez votre option</option>
                        <?php
                        $sql = $bdd->query("SELECT *
                                FROM pays
                                ");

                        while ($provenance = $sql->fetch()) { ?>
                            <option
                                value="<?= $provenance['id_pays'] ?>" <?= $provenance_biere == $provenance['id_pays'] ? 'selected' : '' ?>><?= $provenance['nom_pays'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="Provenance">Provenance</label>
                </div>


                <!-- RESTRICTIONS
                <div class="input-field col l2 s6">
                    <select name="happy_biere" id="Restriction">
                        <option>Pas de restriction</option>
                        <option>Dans la journée</option>
                        <option>Dans une heure</option>
                        <option>En ce moment</option>
                    </select>
                    <label for="Restriction">Happy Hour</label>
                </div>
                -->

                <div class="input-field col l1 s6 offset-l10 offset-s3">
                    <button class="waves-effect waves-light btn" type="submit" name="search">Rechercher
                    </button>
                </div>

            </form>
        </div>

        <div class="row">
            <div class="col l3 offset-l9">
                <div class="switch center-align">
                    <label>
                        Liste
                        <input type="checkbox">
                        <span class="lever"></span>
                        Map
                    </label>
                </div>
            </div>
        </div>

        <!-- résultats de la recherche en liste" -->
        <div class="row">
            <div class="col l10 offset-l1">
                <ul class="collapsible popout" data-collapsible="accordion">

                    <?php


                    $query = 'SELECT *
                    FROM bieres AS bieres
                    LEFT JOIN type_biere AS type_biere ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
                    LEFT JOIN pays AS pays ON bieres.pays_id_pays = pays.id_pays
                    LEFT JOIN photos AS photos ON bieres.photos_id_photo = photos.id_photo
                    WHERE nom_biere 
                    LIKE  "%'.$nom_biere.'%"
                    ';
                    if ($type_biere !== null) {
                        $query = $query . ' AND bieres.type_biere_id_type_biere = ' . $type_biere;
                    }
                    if ($provenance_biere !== null) {
                        $query = $query . ' AND bieres.pays_id_pays = ' . $provenance_biere;
                    }
                    if ($degree_biere !== null) {
                        $query = $query . ' AND bieres.degree_biere <= ' . $degree_biere;
                    }

                    $reponse = $bdd->query($query);
                    while ($donnees = $reponse->fetch()) {
                        ?>

                        <li>
                            <div
                                class="collapsible-header bar-font center-align"><?php echo $donnees['nom_biere']; ?></div>
                            <div class="collapsible-body white-font">


                                <div class="row">
                                    <div class="col l6">
                                        <p><?php echo $donnees['degree_biere'] ?></p>
                                    </div>

                                    <div class="col l6 right-align">
                                        <p>
                                            Type de bière : <?php echo "  " . $donnees['nom_type_biere']; ?>
                                        </p>
                                    </div>
                                </div><!-- fin row -->

                                <div class="row">
                                    <div>
                                        <p>Pays de provenance : <?php echo $donnees['nom_pays']; ?></p>
                                    </div>
                                </div><!-- fin row -->


                                <!-- BOUTON POUR LE MODAL -->
                                <div class="center">
                                    <a class="waves-effect waves-light btn modal-trigger"
                                       href="#<?php echo $donnees['id_biere']; ?>">Voir la fiche complète de cette
                                        bière</a>
                                </div>

                                <br>

                                <!-- MODAL - FICHE COMPLETE DU BAR -->
                                <div id="<?php echo $donnees['id_biere']; ?>" class="modal">
                                    <div class="modal-content grey-font">
                                        <h4 class="bar-font center-align"><?php echo $donnees['nom_biere']; ?></h4>
                                        <p><?php echo $donnees['description']; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!"
                                           class=" modal-action modal-close waves-effect waves-green btn-flat"><i
                                                class="large material-icons prefix">close</i></a>
                                    </div>

                                </div>  <!-- FIN DU MODAL -->


                            </div> <!-- FIN DU COLLAPSE -->


                        </li>

                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>



<?php include("footer.php"); ?>