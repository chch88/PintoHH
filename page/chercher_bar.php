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

            <div class="row"> <!-- LISTE OU MAP -->
                <div class="col l3 offset-l9">
                    <div class="switch">
                        <label>
                            Liste
                            <input type="checkbox">
                            <span class="lever"></span>
                            Map
                        </label>
                    </div>
                </div>
            </div>


            <!-- AFFICHAGE DES BARS SELECTIONNES -->
            <div class="row">
            <div class="col l10 offset-l1">
            <ul class="collapsible popout" data-collapsible="accordion">

                <?php
                $sqlQuery = 'SELECT * FROM bars 
                LEFT JOIN photos
                ON bars.photos_id_photo=photos.id_photo
                LEFT JOIN styles_bars 
                ON styles_bars.id_style_bar=bars.styles_bars_id_style_bar 
                WHERE nom_bar LIKE "%'.$nom_bar.'%" 
                
                ';
                if ($style_bar!==null){
                    $sqlQuery = $sqlQuery.' AND bars.styles_bars_id_style_bar = '.$style_bar;
                }

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
                                    <i class="material-icons">alarm</i>
                                    Happy Hour en ce moment
                                </div>

                                <div class="col l3 m5 s10">
                                    <i class="material-icons prefix">location_on</i>
                                    Situé à 1,2 km
                                </div>

                                <div class="col l1 m1 s2">
                                    <input type="checkbox" id="favoris<?php echo $donnees['id_bar']; ?>" />
                                    <label for="favoris<?php echo $donnees['id_bar']; ?>"></label>
                                </div>

                            </div> <!-- Fin de la row -->

                            <div class="row row2">
                                <div class="col l4 offset-l4">
                                    <i class="material-icons">euro_symbol</i>
                                    Pinte à partir de 5€
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
                                               href="#<?php echo $donnees['id_bar']; ?>">Voir la fiche complète du bar</a>
                                        </div>

                                        <br>

                                     </div> <!-- fin partie gauche -->

                                    <div class="col l4 m5 s12">
                                            <?php
                                            //afficher une photo
                                            echo  "<img src='". $donnees['fichier'] . "' width='100%'>";
                                            ?>
                                    </div><!-- fin partie droite -->


                            </div> <!-- FIN 1ere row -->


                            <!--------------------------------------------- NIVEAU 3 --------------------------------------------->

                            <!-- MODAL - FICHE COMPLETE DU BAR - NIVEAU 3-->
                            <div id="<?php echo $donnees['id_bar']; ?>" class="modal">
                                <div class="modal-content grey-font">

                                    <div class="row">
                                        <div class="col l4 m12 s12">
                                            <h5> <?php echo $donnees['nom_bar']; ?> </h5>
                                        </div>

                                        <div class="col l4 m6 s12">
                                            <i class="material-icons">alarm</i>
                                            Happy Hour en ce moment
                                            <br>
                                            <i class="material-icons prefix">location_on</i>
                                            Situé à 1,2 km
                                            <br>
                                            <i class="material-icons">euro_symbol</i>
                                            Pinte à partir de 5€
                                        </div>

                                        <div class="col l4 m6 s12">
                                            <i class="material-icons">gps_fixed</i>
                                            <?php echo $donnees['numero'] . " " . $donnees['rue'] . ", EPINAL" ?>
                                            <br>
                                            <i class="material-icons prefix">phone</i><?php echo "  " . $donnees['telephone']; ?>
                                            <br>
                                            <i class="material-icons">blur_on</i>
                                            Type de bar : <?php echo $donnees['nom_style_bar']; ?>
                                        </div>
                                    </div> <!-- Fin de la row header-->




                                        <p><?php echo utf8_encode($donnees['description']); ?></p>


                                    <div class="carousel">
                                        <img src="<?php echo ($donnees['fichier']); ?>"></a>
                                    </div>





                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i
                                            class="large material-icons prefix">close</i></a>
                                </div>
                                </div>

                            </div>  <!-- FIN DU MODAL NIVEAU 3-->


                        </div> <!-- FIN DU COLLAPSE NIVEAU 2-->


                    </li>

<br>
                    <?php
                }

                ?>

            </ul>

              <?php
                //afficher une photo
       //        $sqlQuery = 'SELECT * FROM photos
         //      ';
//
  //           $reponse = $bdd->query($sqlQuery);
    //          while ($donnees = $reponse->fetch()) {
      //        echo  "<img src='". $donnees['fichier'] . "' height='100px'>";
        //        }

                ?>

        </div>
    </div> <!-- fin row -->

</div> <!-- fin container -->

<?php include("footer.php"); ?>
