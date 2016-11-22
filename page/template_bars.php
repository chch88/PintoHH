<div class="row"> <!-- LISTE OU MAP -->
    <div class="col l3 offset-l9">
        <div class="switch">
            <label>
                Liste
                <input type="checkbox" id="mycheckbox">
                <span class="lever"></span>
                Map
            </label>
        </div>
    </div>
</div>

 <!-- ETOILE FAVORIS <input type="checkbox"><i id="click_advance" class="material-icons mee" onclick="myFunction()">star_border</i> -->

    <script>
        function myFunction() {
            document.getElementById("click_advance").innerHTML = "star";
        }

    </script>

<!-- AFFICHAGE DES BARS SELECTIONNES -->
<div class="row">
    <div id="liste" class="col l10 offset-l1">
        <ul class="collapsible popout" data-collapsible="accordion">

            <?php
            $sqlQuery = 'SELECT * FROM bars 
                LEFT JOIN photos
                ON photos.id_photo=bars.photos_id_photo
                LEFT JOIN styles_bars 
                ON styles_bars.id_style_bar=bars.styles_bars_id_style_bar  
                LEFT JOIN horaires 
                ON horaires.bars_id_bar = bars.id_bar
                WHERE nom_bar LIKE "%' . $nom_bar . '%"  
                ';

            $newtime = $hp1 . ":" . $minutes . ":" . $seconds;
            $time = $hour . ":" . $minutes . ":" . $seconds;

            if ($style_bar !== null) {
                $sqlQuery = $sqlQuery . ' AND bars.styles_bars_id_style_bar = ' . '"' . $style_bar . '"';
            }
            if ($restriction == 1) {
                $sqlQuery = $sqlQuery . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                $sqlQuery = $sqlQuery . 'AND horaires.heure_debut != "00:00:00"';
                $sqlQuery = $sqlQuery . 'AND horaires.heure_fin != "00:00:00"';
                $sqlQuery = $sqlQuery . 'AND horaires.is_happy_hour = 1';
            }
            if ($restriction == 2) {
                //AND horaires.is_happy_hour = 1
                $sqlQuery = $sqlQuery . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                $sqlQuery = $sqlQuery . ' AND horaires.heure_debut <= ' . '"' . $newtime . '"';
                $sqlQuery = $sqlQuery . ' AND horaires.heure_fin >= ' . '"' . $newtime . '"';
                $sqlQuery = $sqlQuery . 'AND horaires.is_happy_hour = 1';
            }
            if ($restriction == 3) {
                $sqlQuery = $sqlQuery . ' AND horaires.numero_jour = ' . '"' . $weekday . '"';
                $sqlQuery = $sqlQuery . ' AND horaires.heure_debut <= ' . '"' . $time . '"';
                $sqlQuery = $sqlQuery . ' AND horaires.heure_fin >= ' . '"' . $time . '"';
                $sqlQuery = $sqlQuery . 'AND horaires.is_happy_hour = 1';
            }


            $sqlQuery = $sqlQuery . ' GROUP BY bars.id_bar ';


            $reponse = $bdd->query($sqlQuery);
            while ($donnees = $reponse->fetch()) {
                ?>

                <!--------------------------------------------- NIVEAU 1 --------------------------------------------->


                <li>
                    <div class="collapsible-header bar-font"> <!-- NIVEAU 1 -->
                        <div class="row row2">
                            <div class="col l4 m12 s12">
                                <h5> <?php echo $donnees['nom_bar']; ?> </h5>
                            </div>

                            <div class="col l4 m6 s12">

                                <?php

                                $nom_bar = $donnees['nom_bar'];

                                $sql = $bdd->query('
                                SELECT * FROM bars 
                                LEFT JOIN styles_bars 
                                ON styles_bars.id_style_bar=bars.styles_bars_id_style_bar  
                                LEFT JOIN horaires 
                                ON horaires.bars_id_bar = bars.id_bar
                                WHERE nom_bar LIKE "%' . $nom_bar . '%"
                                AND horaires.numero_jour = "' . $weekday . '"
                                AND horaires.is_happy_hour = 1
                                GROUP BY bars.id_bar
                                ');

                                while ($donnees_hh = $sql->fetch()) {

                                    $time_hour_hh = $donnees_hh['is_happy_hour'];
                                    $time_week = $donnees_hh['numero_jour'];
                                    $time_began = $donnees_hh['heure_debut'];
                                    $time_end = $donnees_hh['heure_fin'];

                                    $time_to = explode(":", $time_began);
                                    $time_to_end = explode(":", $time_end);

                                    $time_open_hour = ($time_to[0] - $hp1);
                                    $time_open_min = ($time_to[1] - $mp1);


                                    if ($minutes > $time_to[1] AND $minutes >= 00 AND $minutes <= 30) {
                                        $time_open_hour = ($time_to[0] - $hp1);
                                        $time_open_min = ($time_to[1] - $mp1);
                                    } elseif ($minutes > $time_to[1] AND $minutes >= 30 AND $minutes <= 60) {
                                        $time_open_hour = ($time_to[0] - $hp1);
                                        $time_open_min = ($time_to[1] - $mp1);
                                    } elseif ($minutes < $time_to[1] AND $minutes >= 30 AND $minutes <= 60) {
                                        $time_open_hour = ($time_to[0] - $hp1) + 1;
                                        $time_open_min = ($time_to[1] - $mp1) - 60;
                                    } else {
                                        $time_open_hour = ($time_to[0] - $hp1) + 1;
                                        $time_open_min = ($time_to[1] - $mp1) - 60;
                                    }

                                    if ($time_began > $time) {
                                        echo "<i class=\"material-icons hh-green\">bookmark</i> Happy Hour dans " . $time_open_hour . ' h. ' . $time_open_min . ' min.' . '<br>';
                                        echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                    }
                                    elseif ($time_began <= $time AND $time_end >= $time) {
                                        echo "<i class=\"material-icons hh-red\">bookmark</i> Happy Hour en ce moment" . '<br>';
                                        echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                    }
                                    elseif ($time_began == "00:00:00" AND $time_end == "00:00:00") {
                                        echo "<i class=\"material-icons hh-green\">bookmark</i>Pas d'Happy Hour aujourd'hui" . '<br>';
                                        echo "<i class=\"material-icons\">alarm</i> Pas d'Happy Hour aujourd'hui";
                                    }
                                    else {
                                        echo "<i class=\"material-icons hh-green\">bookmark</i>Plus d'Happy Hour aujourd'hui" . '<br>';
                                        echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                    }
                                }
                                ?>


                            </div>

                            <div class="col l3 m5 s10"  style="opacity: 0.5">
                                <i class="material-icons prefix">location_on</i>
                                Situé à 1,2 km
                            </div>

                            <div class="col l1 m1 s2"  style="opacity: 0.5">
                                <input type="checkbox" id="favoris<?php echo $donnees['id_bar']; ?>"/>
                                <label for="favoris<?php echo $donnees['id_bar']; ?>"></label>
                            </div>

                        </div> <!-- Fin de la row -->

                        <?php
                        $sql = $bdd->query(' 
                        SELECT * FROM bar_biere
                        LEFT JOIN bars 
                        ON bar_biere.bars_id_bar=bars.id_bar
                        WHERE bar_biere.bars_id_bar=' . $donnees['id_bar'] . '
                        ORDER BY bar_biere.prix_happy_bar ASC
                        LIMIT 1
                         ');

                        while ($donnees_bieres = $sql->fetch()) { ?>

                            <div class="row row2">
                                <div class="col l4 offset-l4">
                                    <i class="material-icons">euro_symbol</i>
                                    Pinte à partir de <?php echo $donnees_bieres['prix_happy_bar']; ?>€
                                </div>
                            </div> <!-- Fin de la row -->

                        <?php } ?>

                    </div> <!-- FIN NIVEAU 1 -->

                    <!--------------------------------------------- NIVEAU 2 --------------------------------------------->
                    <div class="collapsible-body white-font">

                        <div class="row row2">

                            <div class="col l4 m7 s12">

                                <p>
                                    <i class="material-icons">gps_fixed</i>
                                    <?php echo $donnees['numero'] . " " . utf8_encode($donnees['rue']) . ", EPINAL" ?>
                                    <br>
                                    <i class="material-icons prefix">phone</i><?php echo "  " . $donnees['telephone']; ?>
                                    <br>
                                    <i class="material-icons">blur_on</i>
                                    Type de bar : <?php echo utf8_encode($donnees['nom_style_bar']); ?>
                                </p>

                            </div>


                            <div class="col l4"> <!-- TABLEAU BIERES -->
                                <br>
                                <table class="striped centered background-green">
                                    <thead>
                                    <tr>
                                        <th data-field="id">Bière</th>
                                        <th data-field="name">Prix de la pinte</th>
                                        <th data-field="price">Prix de la pinte en Happy Hour</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php
                                    $sql = $bdd->query('SELECT * FROM bar_biere
                                            LEFT JOIN bars 
                                            ON bar_biere.bars_id_bar=bars.id_bar
                                            LEFT JOIN bieres
                                            ON bieres.id_biere=bar_biere.bieres_id_biere
                                            WHERE bar_biere.bars_id_bar=' . $donnees['id_bar'] . '
                                            ');

                                    while ($donnees_biere = $sql->fetch()) { ?>
                                        <tr>
                                            <td><?php echo utf8_encode($donnees_biere['nom_biere']); ?></td>
                                            <td><?php echo utf8_encode($donnees_biere['prix_normal_bar']); ?> €</td>
                                            <td><?php echo utf8_encode($donnees_biere['prix_happy_bar']); ?> €</td>
                                        </tr>

                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <br>
                            </div>  <!-- FIN TABLEAU BIERES -->

                            <div class="col l4 m6 s12">
                                <?php
                                //afficher une photo
                                echo "<img src='" . $donnees['fichier'] . "' width='100%'>";
                                ?>
                                <br>
                            </div><!-- fin partie droite -->

                            <!-- BOUTON POUR LE MODAL -->
                            <div class="col l12 m12 s12 center">
                                <a class="waves-effect waves-light btn btn1 modal-trigger"
                                   href="#<?php echo $donnees['id_bar']; ?>">Voir la fiche complète du bar</a>
                            </div>

                            <br>


                        </div> <!-- FIN 1ere row -->


                        <!--------------------------------------------- NIVEAU 3 --------------------------------------------->

                        <!-- MODAL - FICHE COMPLETE DU BAR - NIVEAU 3-->
                        <div id="<?php echo $donnees['id_bar']; ?>" class="modal">
                            <div class="modal-content grey-font">

                                <div class="row"> <!-- row header-->
                                    <div class="col l4 m12 s12">
                                        <h5> <?php echo utf8_encode($donnees['nom_bar']); ?> </h5>
                                    </div>

                                    <div class="col l4 m6 s12">
                                            <?php
                                            if ($time_began > $time) {
                                                echo "<i class=\"material-icons hh-green\">bookmark</i> Happy Hour dans " . $time_open_hour . ' h. ' . $time_open_min . ' min.' . '<br>';
                                                echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                            }
                                            elseif ($time_began <= $time AND $time_end >= $time) {
                                                echo "<i class=\"material-icons hh-red\">bookmark</i> Happy Hour en ce moment" . '<br>';
                                                echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                            }
                                            elseif ($time_began == "00:00:00" AND $time_end == "00:00:00") {
                                                echo "<i class=\"material-icons hh-green\">bookmark</i>Pas d'Happy Hour aujourd'hui" . '<br>';
                                                echo "<i class=\"material-icons\">alarm</i> Pas d'Happy Hour aujourd'hui" . '<br>';
                                            }
                                            else {
                                                echo "<i class=\"material-icons hh-green\">bookmark</i>Plus d'Happy Hour aujourd'hui" . '<br>';
                                                echo "<i class=\"material-icons\">alarm</i> Happy Hour de " . $time_to[0] . " h. " . $time_to[1] . " à " . $time_to_end[0] . " h. " . $time_to_end[1] . "<br>";
                                            }
                                            ?>
                                        <div style="opacity: 0.5">
                                        <i class="material-icons prefix">location_on</i>
                                        Situé à 1,2 km
                                        </div>

                                        <?php
                                        $sql = $bdd->query(' 
                                        SELECT * FROM bar_biere
                                        LEFT JOIN bars 
                                        ON bar_biere.bars_id_bar=bars.id_bar
                                        WHERE bar_biere.bars_id_bar=' . $donnees['id_bar'] . '
                                        ORDER BY bar_biere.prix_happy_bar ASC
                                        LIMIT 1
                                         ');

                                        while ($donnees_bieres = $sql->fetch()) { ?>
                                        <i class="material-icons">euro_symbol</i>
                                        Pinte à partir de <?php echo $donnees_bieres['prix_happy_bar']; ?>€
                                    </div>


                                    <?php } ?>


                                    <div class="col l4 m6 s12">
                                        <i class="material-icons">gps_fixed</i>
                                        <?php echo $donnees['numero'] . " " . utf8_encode($donnees['rue']) . ", EPINAL" ?>
                                        <br>
                                        <i class="material-icons prefix">phone</i><?php echo "  " . $donnees['telephone']; ?>
                                        <br>
                                        <i class="material-icons">blur_on</i>
                                        Type de bar : <?php echo utf8_encode($donnees['nom_style_bar']); ?>
                                    </div>

                                </div> <!-- Fin de la row header-->


                                <div class="row"> <!-- Row description-->
                                    <p><?php echo utf8_encode($donnees['description_bar']); ?></p>
                                </div> <!-- Fin row description-->

                                <div class="row"> <!-- Row carousel-->
                                    <div class="carousel">

                                        <?php
                                        $sql = $bdd->query('SELECT * FROM bars
                                LEFT JOIN galerie_bar
                                ON bars.id_bar=galerie_bar.bars_id_bar
                                LEFT JOIN photos
                                ON photos.id_photo=galerie_bar.photos_id_photo
                                WHERE galerie_bar.bars_id_bar = ' . $donnees['id_bar'] . '
                                ');

                                        while ($donnees_photo = $sql->fetch()) { ?>

                                            <a class="carousel-item"><img
                                                    src="<?php echo($donnees_photo['fichier']) ?>"></a>

                                            <?php
                                        } ?>

                                    </div>
                                </div> <!-- Fin row carousel-->
                                <br>

                                <div class="row"> <!-- Row mot proprio -->

                                    <div class="col l12">
                                        Mot du patron : <?php echo utf8_encode($donnees['mot_patron']); ?>
                                    </div>


                                </div> <!-- Fin row mot proprio -->


                                <div class="col l4 m8 s8 white-font"> <!-- TABLEAU DES HORAIRES NORMALES -->
                                    <table class="striped centered background-green">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Ouverture</th>
                                            <th data-field="name">Normal</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        $sql = $bdd->query('
                                        SELECT * FROM bars  
                                        LEFT JOIN horaires 
                                        ON horaires.bars_id_bar = bars.id_bar
                                        WHERE nom_bar LIKE "%' . $nom_bar . '%"  
                                         AND horaires.is_happy_hour = 0
                                        GROUP BY horaires.numero_jour, bars.id_bar
                                        ');


                                        while ($donnees_biere = $sql->fetch()) { ?>
                                            <tr>
                                                <td class="colonne1"><?php echo($donnees_biere['numero_jour']); ?></td>
                                                <td><?php

                                                    if ($donnees_biere['heure_debut'] == "00:00:00") {
                                                        echo "Fermé";
                                                    }

                                                    elseif ($donnees_biere['is_happy_hour'] == 0) {
                                                        echo $donnees_biere['heure_debut'] . " à " . $donnees_biere['heure_fin'];
                                                    }

                                                    else {
                                                        echo " ";
                                                    }

                                                    ?> </td>

                                            </tr>

                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    </div> <!-- FIN TABLEAU HEURES NORMALES-->

                                    <div class="col l3 m4 s4 white-font"> <!-- TABLEAU DES HORAIRES HAPPY HOUR -->
                                        <table class="striped centered background-green">
                                            <thead>
                                            <tr>

                                                <th data-field="name">Happy Hour</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            $sql = $bdd->query('
                                        SELECT * FROM bars  
                                        LEFT JOIN horaires 
                                        ON horaires.bars_id_bar = bars.id_bar
                                        WHERE nom_bar LIKE "%' . $nom_bar . '%"  
                                         AND horaires.is_happy_hour = 1
                                        GROUP BY horaires.numero_jour, bars.id_bar
                                        ');


                                            while ($donnees_biere = $sql->fetch()) { ?>
                                                <tr>
                                                    <td><?php

                                                        if ($donnees_biere['heure_debut'] == "00:00:00") {
                                                            echo ".";
                                                        }

                                                        elseif ($donnees_biere['is_happy_hour'] == 1) {
                                                            echo $donnees_biere['heure_debut'] . " à " . $donnees_biere['heure_fin'];
                                                        }

                                                        else {
                                                            echo "";
                                                        }

                                                        ?> </td>

                                                </tr>

                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        </div> <!-- FIN TABLEAU HEURES HAPPY HOUR-->

                                    <br>
                                    <br>



                                <div class="col l4 m12 s12 white-font"> <!-- TABLEAU BIERES -->

                                    <table class="striped centered background-green">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Bière</th>
                                            <th data-field="name">Prix de la pinte</th>
                                            <th data-field="price">Prix de la pinte en Happy Hour</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <?php
                                        $sql = $bdd->query('SELECT * FROM bar_biere
                                            LEFT JOIN bars 
                                            ON bar_biere.bars_id_bar=bars.id_bar
                                            LEFT JOIN bieres
                                            ON bieres.id_biere=bar_biere.bieres_id_biere
                                            WHERE bar_biere.bars_id_bar=' . $donnees['id_bar'] . '
                                            ');

                                        while ($donnees_biere = $sql->fetch()) { ?>
                                            <tr>
                                                <td><?php echo utf8_encode($donnees_biere['nom_biere']); ?></td>
                                                <td><?php echo utf8_encode($donnees_biere['prix_normal_bar']); ?> €</td>
                                                <td><?php echo utf8_encode($donnees_biere['prix_happy_bar']); ?> €</td>
                                            </tr>

                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>

                                </div>  <!-- FIN TABLEAU BIERES -->


                                <div class="row"><!-- Row map -->

                                </div> <!-- Fin row map -->

                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i
                                            class="large material-icons prefix">close</i></a>
                                </div>
                            </div>


                        </div>  <!-- FIN DU MODAL NIVEAU 3-->


                    </div> <!-- FIN DU COLLAPSE NIVEAU 2-->

                </li>

                <br>

            <?php } ?>

        </ul>

    </div>
</div> <!-- fin row -->

<div id="map" class="col l12" style="height:300px;"></div>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmZb6Wbwa9Y29h1tRoKf9h6gqaesVNEcU&callback=initMap"
    async defer></script>