<?php include("../config.php"); ?>

<?php include("header.php"); ?>

<?php
// variables contenues dans GET
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
// Les prochaines lignes sont utilisées pour la prochaine happy hour
if ($time_array['minutes'] > 50) {
    $mp1 = 0 . $minutes - 60;
} else {
    $mp1 = $minutes - 60;
}

if ($time_array['seconds'] < 10) {
    $seconds = 0 . $time_array['seconds'];
} else {
    $seconds = $time_array['seconds'];
}

print_r($weekday);

// Fonctions pour les COUNT et les where_biere
// Pour une fonction, on déclare toutes les variables utilisées, ici $query,$restriction,$weekday,$newtime,$time
function testRestrictions($query, $restriction, $weekday, $newtime, $time)
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

function where_biere($where_biere, $restriction, $weekday, $newtime, $time)
{
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
    return $where_biere;
}

?>

    <div class="container2">

        <h2 class="center-align">Rechercher une bière</h2>

        <div class="row">

            <form method="get" action="">
                <div class="input-field col l2 m6 s6">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom_biere" id="nom" value="<?= $nom_biere ?>">
                </div>

                <div class="input-field col l2 m6 s6">
                    <select name="distance_biere" id="Distance">
                        <option value="">Pas de palier</option>
                        <option value="0.5">500M</option>
                        <option value="1">1 Km</option>
                        <option value="5">5 Km</option>
                    </select>
                    <label for="Distance">Palier de distance</label>
                </div>

                <div class="input-field col l2 m6 s6">
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
                <div class="input-field col l2 m6 s6">
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

                <div class="input-field col l2 m6 s6">
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

                <div class="input-field col l2 m6 s6">
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

                <input name="tri" class="with-gap" type="radio" id="fav"/>
                <label for="fav">Trier par nombre de fois favorite</label>
                <input name="tri" class="with-gap" type="radio" id="prix"/>
                <label for="prix">Trier par prix mini</label>

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
            <div id="liste" class="col l10 m12 s12 offset-l1">
                <ul class="collapsible popout" data-collapsible="accordion">

                    <?php

                    $query = 'SELECT *, MIN(prix_happy_bar)
                    FROM bieres AS bieres
                    LEFT JOIN bar_biere AS bar_biere ON bieres.id_biere = bar_biere.bieres_id_biere
                    LEFT JOIN bars AS bars ON bars.id_bar = bar_biere.bars_id_bar
                    LEFT JOIN villes AS villes ON villes.id_ville = bars.villes_id_ville
                    LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                    LEFT JOIN type_biere AS type_biere ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
                    LEFT JOIN styles_bars AS styles_bars ON styles_bars.id_style_bar = bars.styles_bars_id_style_bar
                    LEFT JOIN pays AS pays ON bieres.pays_id_pays = pays.id_pays
                    LEFT JOIN photos AS photos ON bieres.photos_id_photo = photos.id_photo
                    WHERE nom_biere
                    LIKE  "%' . $nom_biere . '%"
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
                    $query = testRestrictions($query, $restriction, $weekday, $newtime, $time);

                    $reponse = $bdd->query($query);
                    while ($donnees = $reponse->fetch()) {
                        ?>

                        <script>
                            $(function () { // grande fonction
                                function degrebar(callback) { /* ici voici une fonction callback
                                 callbak n'a pas de parenthèse dans degrebar, ça veut dire que c'est une fonction appelée dans degrebar() en tant que paramètre
                                 */
                                    // recupere l'adresse postale
                                    var numero = <?= $donnees['numero'] ?>;
                                    var rue = "<?= utf8_encode($donnees['rue']) ?>";
                                    var ville = "<?= utf8_encode($donnees['ville']) ?>";

                                    var adresse = numero + " " + rue + " " + ville; // définition de l'adresse pour que geocoder renvoie la latitude et la longitude d'un bar //

                                    // clé api
                                    var apiKey = 'AIzaSyBCAOGM2PURw7HTiLBxlN6dBixLnCoWBcM';
                                    // utilise Geocoder
                                    $.getJSON(
                                        'https://maps.googleapis.com/maps/api/geocode/json?address='
                                        + adresse + '&key=' + apiKey,
                                        function (data) { //calcul de lat/lng

                                            var coords = data.results[0].geometry.location; // les données se retrouvent dans cet objet
                                            //extraction des données
                                            var lat_bar = coords.lat;
                                            var lng_bar = coords.lng;

                                            callback(lat_bar, lng_bar); // on défini la fonction callback avec les données récupérées
                                        });
                                }

                                // calcul distance par rapport à notre position
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(showPosition); // cette ligne récupère les coordonnées de l'utilisateur de la fonction showposition (qui est un paramètre)
                                }
                                function showPosition(position) {

                                    var userLat = position.coords.latitude; // la position de l'utilisateur
                                    var userLng = position.coords.longitude;

                                    degrebar(function (lat_bar, lng_bar) { // on appelle la fonction degre bar avec comme fonction callback ayant pour paramètres lat_bar et lng_bar

                                        // trigo avec usercoords & adress coords (théorème de pythagore AB² = AC² + BC²)

                                        // calcul distance avec le point C (lat A - lat B ; lng A - lng B)
                                        var Clat = userLat - lat_bar;
                                        var Clng = userLng - lng_bar;
                                        if (Clat < 0) {
                                            Clat = Math.abs(Clat); // on enlève le signe " - " si c'est négatif
                                        }
                                        if (Clng < 0) {
                                            Clng = Math.abs(Clng);
                                        }

                                        var Clat2 = Math.pow(Clat, 2); // on met AC et BC au carré
                                        var Clng2 = Math.pow(Clng, 2);

                                        var AB2 = Clat2 + Clng2; //on a AB²

                                        var distanceDeg = Math.sqrt(AB2); //on prend la racine pour avoir la distance en degré

                                        var km = distanceDeg * 111.11; //comme un degré +-= 111,11km, on multiplie par ce numéro pour avoir la distance en km.
                                        console.log(km);
                                    });

                                }
                            });
                        </script>

                        <li>
                            <div class="collapsible-header bar-font"> <!-- NIVEAU 1 -->
                                <div class="row row2">
                                    <div class="col l2 m2 s12 offset-m5">
                                        <img src="<?= $donnees['fichier']; ?>" class="col l12 m12 s6 offset-s3">
                                    </div>
                                    <div class="col l3 m2 s2 offset-l7 offset-m3">
                                        <input type="checkbox" id="favoris<?php echo $donnees['id_biere']; ?>"/>
                                        <label for="favoris<?php echo $donnees['id_biere']; ?>"></label>
                                        <?php
                                        $count_fav = 'SELECT COUNT(id_utilisateur)
                                                FROM bieres
                                                LEFT JOIN biere_favori ON biere_favori.bieres_id_biere = bieres.id_biere
                                                LEFT JOIN utilisateurs ON utilisateurs.id_utilisateur = biere_favori.utilisateurs_id_utilisateur
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                ';

                                        $nombre_fav = $bdd->query($count_fav);
                                        $nb_fav = $nombre_fav->fetch(PDO::FETCH_ASSOC);
                                        echo $nb_fav['COUNT(id_utilisateur)'];
                                        ?>X favorite!
                                    </div>

                                    <div class="left-align col l10 m12 s12">
                                        <h5 class="col l10 m12 s12 center"> <?= $donnees['nom_biere']; ?> </h5>

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
                                                <i id="beer_kind" class="material-icons">euro_symbol</i>
                                                <?=
                                                $donnees['prix_happy_bar'];
                                                ?>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col l4">
                                                <?php
                                                // bars with or without happy
                                                // count of all bars with the beer
                                                $query = 'SELECT COUNT(DISTINCT nom_bar)
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN bieres AS bieres ON bieres.id_biere = bar_biere.bieres_id_biere
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                ';

                                                $query = testRestrictions($query, $restriction, $weekday, $newtime, $time);

                                                $nombre_bars_pour_biere = $bdd->query($query);
                                                ?>
                                                <i class="material-icons">local_bar</i>
                                                Où trouver cette bière?
                                                (<?php $nb_bars = $nombre_bars_pour_biere->fetch(PDO::FETCH_ASSOC);
                                                echo $nb_bars['COUNT(DISTINCT nom_bar)'];
                                                //End of count
                                                ?> bars ont cette bière)
                                            </div>
                                            <!-- end bars with or without happy -->

                                            <!-- start bars with happy -->
                                            <div class="col l4">
                                                <?php
                                                // starting the happy count
                                                $query = 'SELECT COUNT(DISTINCT nom_bar)
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN bieres AS bieres ON bieres.id_biere = bar_biere.bieres_id_biere
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bieres.id_biere = ' . $donnees['id_biere'] . '
                                                AND bar_biere.prix_happy_bar IS NOT NULL
                                                AND horaires.is_happy_hour = 1
                                                ';

                                                $query = testRestrictions($query, $restriction, $weekday, $newtime, $time);

                                                $nombre_bars_pour_biere_happy = $bdd->query($query);
                                                ?>
                                                <i class="material-icons">local_bar</i>
                                                Et en happy hour?
                                                (<?php $nb_bars_happy = $nombre_bars_pour_biere_happy->fetch(PDO::FETCH_ASSOC);
                                                echo $nb_bars_happy['COUNT(DISTINCT nom_bar)'];
                                                // End of count
                                                ?> bars ont cette bière)
                                            </div>

                                            <div class="col l4">
                                                <?php
                                                // début horaires happy pour cette bière

                                                ?>
                                            </div>

                                            <div class="col l4 m6 s12">

                                                <?php

                                                $time_began = $donnees['heure_debut'];
                                                $time_end = $donnees['heure_fin'];
                                                $time_week = $donnees['numero_jour'];

                                                $time_to = explode(":", $time_began);

                                                $time_open_hour = ($time_to[0] - $hp1);
                                                $time_open_min = ($time_to[1] - $mp1);


                                                $query = $bdd->query('
                                                SELECT * FROM bieres 
                                                LEFT JOIN bar_biere
                                                ON bar_biere.bieres_id_biere=bieres.id_biere
                                                LEFT JOIN bars 
                                                ON bars.id_bar=bar_biere.bars_id_bar
                                                LEFT JOIN horaires 
                                                ON horaires.bars_id_bar = bars.id_bar
                                                WHERE bar_biere.bieres_id_biere = ' . $donnees['id_biere'] . '
                                                AND horaires.heure_debut > "' . $time . '"
                                                AND horaires.heure_fin > "' . $time . '"
                                                AND horaires.is_happy_hour = 1
                                                ');


                                                $donnees_hh = $query->fetch();


                                                if ($time_began > $time AND $time_week == $weekday) {
                                                    echo "<i class=\"material-icons hh-red\">alarm</i>Prochaine Happy Hour dans " . $time_open_hour . ' h. ' . $time_open_min . ' min.';
                                                } elseif ($time_began <= $time AND $time_end >= $time AND $time_week == $weekday) {
                                                    echo "<i class=\"material-icons hh-green\">alarm</i> Happy Hour en ce moment";
                                                } else {
                                                    echo "<i class=\"material-icons hh-red\">alarm</i>Pas ou plus d'Happy Hour aujourd'hui";
                                                }


                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- Fin de la row -->

                            </div> <!-- FIN NIVEAU 1 -->

                            <!--------------------------------------------- NIVEAU 2 --------------------------------------------->
                            <div class="collapsible-body white-font">

                                <div class="row row2">

                                    <div class="col l12 m12 s12">

                                        <?php
                                        // variabale $where_biere is left at the top of the row because it changes multiple times.
                                        $where_biere_happy = 'SELECT *
                                                FROM bars AS bars
                                                LEFT JOIN bar_biere AS bar_biere ON bar_biere.bars_id_bar = bars.id_bar
                                                LEFT JOIN horaires AS horaires ON horaires.bars_id_bar = bars.id_bar
                                                LEFT JOIN villes AS villes ON villes.id_ville = bars.villes_id_ville
                                                WHERE bar_biere.bieres_id_biere = ' . $donnees['id_biere'] . '
                                                AND bar_biere.prix_happy_bar IS NOT NULL
                                                AND horaires.is_happy_hour = 1 GROUP BY nom_bar
                                                ';

                                        $where_biere_happy = where_biere($where_biere_happy, $restriction, $weekday, $newtime, $time);

                                        $wbh = $bdd->query($where_biere_happy);
                                        while ($bars_happy = $wbh->fetch()) {
                                            ?>
                                            <ul class="col l4 m4 s6">
                                                <li class="col l12 center">
                                                    <?=
                                                    utf8_encode($bars_happy['nom_bar']);
                                                    ?>
                                                </li>
                                                <li class="col l12 left-align">
                                                    <i class="material-icons">phone</i>
                                                    <?=
                                                    $bars_happy['telephone'];
                                                    ?>
                                                </li>
                                                <li class="col l12 left-align">
                                                    <i class="material-icons">gps_fixed</i>
                                                    <?=
                                                    utf8_encode($bars_happy['numero'] . " " . $bars_happy['rue'] . " " . $bars_happy['ville']);
                                                    ?>
                                                </li>

                                                <div class="center">
                                                    <a class="waves-effect waves-light btn modal-trigger" href="#bar<?= $bars_happy['id_bar']; ?>">
                                                        Voir la fiche complète du bar
                                                    </a>
                                                </div>

                                                <!-- MODAL - FICHE COMPLETE DU BAR -->
                                                <div id="bar<?php echo $bars_happy['id_bar'] ?>" class="modal">
                                                    <div class="modal-content grey-font">
                                                        <h4 class="bar-font center-align"><?php echo utf8_encode($bars_happy['nom_bar']) ?></h4>
                                                        <p>
                                                            <?=
                                                            utf8_encode($bars_happy['description_bar']);
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="#!"
                                                           class=" modal-action modal-close waves-effect waves-green btn-flat"><i
                                                                class="large material-icons prefix">close</i></a>
                                                    </div>

                                                </div>  <!-- FIN DU MODAL -->
                                            </ul>

                                            <!-- BOUTON POUR LE MODAL -->
                                            <?php
                                        }
                                        ?>

                                        <br>

                                    </div>

                                </div> <!-- FIN 1ere row -->


                                <!-- BOUTON POUR LE MODAL -->
                                <div class="center col l12">
                                    <a class="waves-effect waves-light btn modal-trigger"
                                       href="#biere<?php echo $donnees['id_biere']; ?>">Voir la fiche complète de cette bière
                                    </a>
                                </div>

                                <br>

                                <!-- MODAL - FICHE COMPLETE DE LA BIERE -->
                                <div id="biere<?= $donnees['id_biere']; ?>" class="modal">
                                    <div class="modal-content grey-font">
                                        <h4 class="bar-font center-align"><?= $donnees['nom_biere']; ?></h4>
                                        <p><?= $donnees['description_biere']; ?></p>
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