<?php include("../config.php"); ?>

<?php include("header.php"); ?>


<div class="container2">

    <h3 class="center-align">Rechercher un Bar</h3>
    <br>
    <br>

    <!-- BARRE DE RECHERCHE DES BARS -->
    <div class="row">

        <form method="post" action="#">

          <div class="input-field col l2 s6 offset-l1">
            <label for="nom_bar">Nom</label>
            <input type="text" name="nom_bar" id="nom_bar" class="autocomplete"/>
          </div>


            <div class="input-field col l2 s6">
                <select name="distance" id="distance">
                    <option value="" disabled selected>Choisissez votre option</option>
                    <option>500M</option>
                    <option>1 Km</option>
                    <option>5 Km</option>
                    <option>Pas de Palier</option>
                </select>
                <label for="distance">Palier de Distance</label>
            </div>

            <div class="input-field col l2 s6">
            <select name="style" id="style">
                <option>Lounge</option>
                <option>Bar</option>
                <option value="" disabled selected>Choisissez votre option</option>
                <option>Pub</option>
                <option>Brasserie</option>
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
                <a class="waves-effect waves-light btn" type="submit" name="action">Rechercher</a>
            </div>

        </form> <!-- fin du formulaire -->

    </div> <!-- fin row -->

            <div class="row">
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
                $reponse = $bdd->query
                ('SELECT * FROM bars
                INNER JOIN styles_bars
                ON styles_bars.id_style_bar=bars.styles_bars_id_style_bar
                ');
                while ($donnees = $reponse->fetch()) {
                    ?>

                    <li>
                        <div class="collapsible-header bar-font"><?php echo $donnees['nom_bar']; ?></div>
                        <div class="collapsible-body white-font">


                            <div class="row">
                                <div class="col l5">
                                    <p><?php echo $donnees['numero'] . " " . $donnees['rue'] . ", EPINAL" ?></p>
                                </div>

                                <div class="col l3 offset-l4">
                                    <p>
                                        <i class="material-icons prefix">phone</i><?php echo "  " . $donnees['telephone']; ?>
                                    </p>
                                </div>
                            </div><!-- fin row -->

                            <div class="row">
                                <div>
                                    <p>Type de bar : <?php echo $donnees['nom_style_bar']; ?></p>
                                </div>
                            </div><!-- fin row -->


                            <!-- BOUTON POUR LE MODAL -->
                            <div class="center">
                                <a class="waves-effect waves-light btn modal-trigger"
                                   href="#<?php echo $donnees['id_bar']; ?>">Voir la fiche complète du bar</a>
                            </div>

                            <br>

                            <!-- MODAL - FICHE COMPLETE DU BAR -->
                            <div id="<?php echo $donnees['id_bar']; ?>" class="modal">
                                <div class="modal-content grey-font">
                                    <h4 class="bar-font"><?php echo $donnees['nom_bar']; ?></h4>
                                        <p><?php echo utf8_encode($donnees['description']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i
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
    </div> <!-- fin row -->

</div> <!-- fin container -->

<?php include("footer.php"); ?>
