<?php include("../config.php"); ?>

<?php include("header.php"); ?>

<?php
// variables contenues dans $_GET
$nom_biere = isset($_GET['nom_biere']) ? $_GET['nom_biere'] : '';
$type_biere = isset($_GET['type_biere']) && $_GET['type_biere'] !== '' ? $_GET['type_biere'] : null;
$provenance_biere = isset($_GET['provenance_biere']) && $_GET['provenance_biere'] !== '' ? $_GET['provenance_biere'] : null;
$degree_biere = isset($_GET['degre_biere']) && $_GET['degre_biere'] !== '' ? $_GET['degre_biere'] : null;
$restriction = isset($_GET['restriction']) && $_GET['restriction'] !== '' ? $_GET['restriction'] : null;


// Les informations de la date
$time_array = getdate();
print_r($time_array);


$weekday = $time_array['wday'];
$hour = $time_array['hours'];
$hp1 = $time_array['hours'] + 1;
$minutes = $time_array['minutes'];
if ($time_array['seconds'] < 10) {
    $seconds = 0 . $time_array['seconds'];
} else {
    $seconds = $time_array['seconds'];
}
$time = $hour . ":" . $minutes . ":" . $seconds;
$newtime = $hp1 . ":" . $minutes . ":" . $seconds;

print_r($weekday);

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
                        <option value="0" <?php if (strpos($_SERVER['REQUEST_URI'], "&degre_biere=0") !== false) {
                            echo "selected";
                        } ?>>Sans alcool
                        </option>
                        <option value="4" <?php if (strpos($_SERVER['REQUEST_URI'], "&degre_biere=4") !== false) {
                            echo "selected";
                        } ?>><4 %
                        </option>
                        <option value="7" <?php if (strpos($_SERVER['REQUEST_URI'], "&degre_biere=7") !== false) {
                            echo "selected";
                        } ?>><7 %
                        </option>
                        <option value="10" <?php if (strpos($_SERVER['REQUEST_URI'], "&degre_biere=10") !== false) {
                            echo "selected";
                        } ?>><10 %
                        </option>
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

                <div class="input-field col l2 s6">
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
                    <label for="Restriction">Happy Hour</label>
                </div>

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
                        <input type="checkbox" id="mycheckbox">
                        <span class="lever"></span>
                        Map
                    </label>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- résultats de la recherche en liste" -->
            <div id="liste" class="col l10 offset-l1">
                <ul class="collapsible popout" data-collapsible="accordion">

                    <?php

                    $query = 'SELECT *
                    FROM bieres AS bieres
                    LEFT JOIN bar_biere AS bar_biere ON bieres.id_biere = bar_biere.bieres_id_biere
                    LEFT JOIN bars AS bars ON bars.id_bar = bar_biere.bars_id_bar
                    LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                    LEFT JOIN type_biere AS type_biere ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
                    LEFT JOIN pays AS pays ON bieres.pays_id_pays = pays.id_pays
                    LEFT JOIN photos AS photos ON bieres.photos_id_photo = photos.id_photo
                    WHERE nom_biere
                    LIKE  "%' . $nom_biere . '%"
                    AND bieres.id_biere = bar_biere.bieres_id_biere
                    AND horaires.is_happy_hour = 1
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
                    function testResttrictiuons($query,$restriction,$weekday,$newtime,$time)
                    {
                        if ($restriction == 1) {
                            $query = $query . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                        }
                        if ($restriction == 2) {
                            $query = $query . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                            $query = $query . ' AND horaires.heure_debut <= ' . '"' . $newtime . '"';
                            $query = $query . ' AND horaires.heure_fin >= ' . '"' . $newtime . '"';
                        }
                        if ($restriction == 3) {
                            $query = $query . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                            $query = $query . ' AND horaires.heure_debut <= ' . '"' . $time . '"';
                            $query = $query . ' AND horaires.heure_fin >= ' . '"' . $time . '"';
                        }
                        $query = $query . ' GROUP BY bieres.id_biere';
                        return $query;
                    }
                    $query=testResttrictiuons($query,$restriction,$weekday,$newtime,$time);

                    $reponse = $bdd->query($query);
                    while ($donnees = $reponse->fetch()) {
                        ?>

                        <li>
                            <div class="collapsible-header bar-font"> <!-- NIVEAU 1 -->
                                <div class="row row2">
                                    <div class="col l2 m12 s12">
                                        <img src="<?= $donnees['fichier']; ?>">
                                    </div>
                                    <div class="left-align col l10 m12 s12">
                                        <h5 class="col l10 center"> <?= $donnees['nom_biere']; ?> </h5>

                                        <div class="col offset-l1 l1 m1 s2">
                                            <input type="checkbox" id="favoris<?php echo $donnees['id_biere']; ?>"/>
                                            <label for="favoris<?php echo $donnees['id_biere']; ?>"></label>
                                        </div>

                                        <div class="row">
                                            <div class="col l4 m6 s12">
                                                <label for="percent_degree">Degré</label>
                                                <i id="percent_degree" class="material-icons">%</i>
                                                <?=
                                                $donnees['degree_biere'];
                                                ?>
                                            </div>

                                            <div class="col l4 m6 s12">
                                                <label for="beer_kind">Type de bière</label>
                                                <i id="beer_kind" class="material-icons">local_drink</i>
                                                <?=
                                                $donnees['nom_type_biere'];
                                                ?>
                                            </div>

                                            <div class="col l4 m6 s12">
                                                <label for="beer_kind">Prix minimum en pinte</label>
                                                <i id="beer_kind" class="material-icons">€</i>
                                                <?

                                                ?>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col l4">
                                                <?php
                                                // variabale $where_biere is left at the top of the row because it changes multiple times.
                                                $where_biere = 'SELECT DISTINCT nom_bar
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN bieres AS bieres ON bieres.id_biere = bar_biere.bieres_id_biere
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                ';


                                                // bars with or without happy
                                                // count of all bars with the beer
                                                $nombre_bars_pour_biere = 'SELECT COUNT(DISTINCT nom_bar)
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN bieres AS bieres ON bieres.id_biere = bar_biere.bieres_id_biere
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                ';

                                                if ($restriction == 1) {
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                }
                                                if ($restriction == 2) {
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.heure_debut <= ' . '"' . $newtime . '"';
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.heure_fin >= ' . '"' . $newtime . '"';
                                                }
                                                if ($restriction == 3) {
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.heure_debut <= ' . '"' . $time . '"';
                                                    $nombre_bars_pour_biere = $nombre_bars_pour_biere . ' AND horaires.heure_fin >= ' . '"' . $time . '"';
                                                }
                                                testResttrictiuons($query,$restriction,$weekday,$newtime,$time);

                                                $nombre_bars_pour_biere = $bdd->query($nombre_bars_pour_biere);
                                                ?>
                                                <i class="material-icons">local_bar</i>
                                                Où trouver cette bière?
                                                (<?php $nb_bars = $nombre_bars_pour_biere->fetch(PDO::FETCH_ASSOC);
                                                echo $nb_bars['COUNT(DISTINCT nom_bar)'];
                                                //End of count
                                                ?> bars ont cette bière)
                                                <ul>
                                                    <?php
                                                    //first use of where biere
                                                    if ($restriction == 1) {
                                                        $where_biere = $where_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                    }
                                                    if ($restriction == 2) {
                                                        $where_biere = $where_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                        $where_biere = $where_biere . ' AND horaires.heure_debut <= ' . '"' . $newtime . '"';
                                                        $where_biere = $where_biere . ' AND horaires.heure_fin >= ' . '"' . $newtime . '"';
                                                    }
                                                    if ($restriction == 3) {
                                                        $where_biere = $where_biere . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                        $where_biere = $where_biere . ' AND horaires.heure_debut <= ' . '"' . $time . '"';
                                                        $where_biere = $where_biere . ' AND horaires.heure_fin >= ' . '"' . $time . '"';
                                                    }


                                                    $wb = $bdd->query($where_biere);
                                                    while ($bars = $wb->fetch()) {
                                                        ?>
                                                        <li>
                                                            <?=
                                                            $bars['nom_bar'];
                                                            ?>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <!-- end bars with or without happy -->

                                            <!-- start bars with happy -->
                                            <div class="col l4">
                                                <?php
                                                // starting the happy count
                                                $nombre_bars_pour_biere_happy = 'SELECT COUNT(DISTINCT nom_bar)
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN bieres AS bieres ON bieres.id_biere = bar_biere.bieres_id_biere
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                AND bar_biere.prix_happy_bar IS NOT NULL
                                                AND horaires.is_happy_hour = 1
                                                ';

                                                if ($restriction == 1) {
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                }
                                                if ($restriction == 2) {
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.heure_debut <= ' . '"' . $newtime . '"';
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.heure_fin >= ' . '"' . $newtime . '"';
                                                }
                                                if ($restriction == 3) {
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.heure_debut <= ' . '"' . $time . '"';
                                                    $nombre_bars_pour_biere_happy = $nombre_bars_pour_biere_happy . ' AND horaires.heure_fin >= ' . '"' . $time . '"';
                                                }

                                                $nombre_bars_pour_biere_happy = $bdd->query($nombre_bars_pour_biere_happy);
                                                ?>
                                                <i class="material-icons">local_bar</i>
                                                Et en happy hour?
                                                (<?php $nb_bars_happy = $nombre_bars_pour_biere_happy->fetch(PDO::FETCH_ASSOC);
                                                echo $nb_bars_happy['COUNT(DISTINCT nom_bar)'];
                                                // End of count
                                                ?> bars ont cette bière)
                                                <ul>
                                                    <?php
                                                    // name of the bars
                                                    // change on variable $where_biere to $where_biere_happy
                                                    $where_biere_happy = $where_biere . ' AND bar_biere.prix_happy_bar IS NOT NULL';

                                                    $wbh = $bdd->query($where_biere_happy);
                                                    while ($bars_happy = $wbh->fetch()) {
                                                        ?>
                                                        <li>
                                                            <?=
                                                            $bars_happy['nom_bar'];
                                                            ?>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>

                                            <div class="col l4">
                                                <?php
                                                // début horaires happy pour cette bière

                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- Fin de la row -->

                            </div> <!-- FIN NIVEAU 1 -->

                            <!--------------------------------------------- NIVEAU 2 --------------------------------------------->
                            <div class="collapsible-body white-font">

                                <div class="row row2">

                                    <div class="col l8 m7 s12">

                                        <p>
                                            <i class="material-icons">gps_fixed</i>
                                            <?php echo $donnees['numero'] . " " . $donnees['rue'] . ", EPINAL" ?>
                                            <br>
                                            <i class="material-icons prefix">phone</i><?php echo "  " . $donnees['telephone']; ?>
                                            <br>
                                            <i class="material-icons">blur_on</i>
                                            Type de bar : <?php echo $donnees['nom_style_bar']; ?>
                                        </p>


                                        <!-- BOUTON POUR LE MODAL -->
                                        <div class="center">
                                            <a class="waves-effect waves-light btn modal-trigger"
                                               href="#<?php echo $donnees['id_bar']; ?>">Voir la fiche complète du
                                                bar</a>
                                        </div>

                                        <br>

                                    </div> <!-- fin partie gauche -->

                                    <div class="col l4 m5 s12">
                                        <?php
                                        //afficher une photo
                                        echo "<img src='" . $donnees['fichier'] . "' width='100%'>";
                                        ?>
                                    </div><!-- fin partie droite -->


                                </div> <!-- FIN 1ere row -->


                                <!-- BOUTON POUR LE MODAL -->
                                <div class="center">
                                    <a class="waves-effect waves-light btn modal-trigger"
                                       href="#<?php echo $donnees['id_biere']; ?>">Voir la fiche complète de cette bière
                                    </a>
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

            <div id="map" class="col l12" style="height:300px;"></div>

            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmZb6Wbwa9Y29h1tRoKf9h6gqaesVNEcU&callback=initMap"
                async defer></script>
        </div>
    </div>
    </div>


<?php include("footer.php"); ?>