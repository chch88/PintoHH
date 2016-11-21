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


<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/froala_editor.min.js"></script>
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

<?php
if (ROLE == 1) {

    $BieresAll = "SELECT * FROM `bieres` 
	JOIN `type_biere`
	ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
	JOIN `pays` ON bieres.pays_id_pays = pays.id_pays
	JOIN `photos` ON bieres.photos_id_photo = photos.id_photo ";
    $pays = "SELECT * FROM `pays`";
    $type_biere = "SELECT * FROM `type_biere`";

    if (isset($_POST) && !empty($_POST['ajouter'])) {
        $dossier = '../../images/photosbieres/';
        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 1000000000000000000000000000000000000000000000000;
        $taille = filesize($_FILES['image']['tmp_name']);


        //Début des vérifications de sécurité...
        if($taille>$taille_maxi)
        {
            $erreur = 'Le fichier est trop gros...';
        }
        if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            //formatage du nom (suppression des accents, remplacements des espaces par "-")
            $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier)) //correct si la fonction renvoie TRUE
            {
                echo 'Upload effectué avec succès !';
                //ajout_image($fichier,);
            }
            else //sinon, cas où la fonction renvoie FALSE
            {
                echo 'Echec de l\'upload !';
            }
        }
        else
        {
            echo $erreur;
        }


        $addfile = $bdd->prepare("INSERT INTO photos(
        fichier
        ) VALUES (
        '$dossier$fichier'
        )"
        );


        $addfile->execute();

        $last_id = $bdd->lastInsertId();

        $type_biere_id_type_biere = (isset($_POST['type_biere_id_type_biere']) && !empty($_POST['type_biere_id_type_biere'])) ? (int)$_POST['type_biere_id_type_biere'] : "";
        $pays_id_pays = (isset($_POST['pays_id_pays']) && !empty($_POST['pays_id_pays'])) ? (int)$_POST['pays_id_pays'] : "";
        // $photos_id_photo = (isset($_POST['photos_id_photo']) && !empty($_POST['photos_id_photo'])) ? (int)$_POST['photos_id_photo'] : "";
        //temporaire
        $photos_id_photo = (int)1;
        $nom_biere = (isset($_POST['nom_biere']) && !empty($_POST['nom_biere'])) ? (string)$_POST['nom_biere'] : "";
        $degree_biere = (isset($_POST['degree_biere']) && !empty($_POST['degree_biere'])) ? (float)$_POST['degree_biere'] : "";

        $description = (isset($_POST['description']) && !empty($_POST['description'])) ? (string)$_POST['description'] : "";


        $addBeer = $bdd->prepare("INSERT INTO bieres(
        type_biere_id_type_biere,
        pays_id_pays,
        nom_biere,
        degree_biere,
        description_biere,
        photos_id_photo
        ) VALUES (
        :type_biere, 
        :pays,
        :nom,
        :degre,
        :description,
        :photo)"
        );

        $addBeer->bindParam('nom', utf8_decode($nom_biere), PDO::PARAM_STR);
        $addBeer->bindParam('description', utf8_decode($description), PDO::PARAM_STR);
        $addBeer->bindParam('type_biere', $type_biere_id_type_biere, PDO::PARAM_INT);
        $addBeer->bindParam('pays', $pays_id_pays, PDO::PARAM_INT);
        $addBeer->bindParam('degre', $degree_biere, PDO::PARAM_STR);
        $addBeer->bindParam('photo', $last_id, PDO::PARAM_INT);

        if ($addBeer->execute()) {
            echo "La bière a bien été ajoutée à la base de données.";
        } else {
            echo "Une erreur est survenue lors de l'ajout de la bière.";
        }

    }
    ?>

    <h2 class="center green">Ajouter une bière</h2>

    <div class="row">
        <form class="col s8 offset-s2" action="" method="post" enctype="multipart/form-data">
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
            <!-- Appel text-editor -->
            <div class="col l12">
                <textarea id="edit-description" name="description"></textarea>
                <label for="edit-description">description</label>
            </div>
            <!-- fin du text-editor -->
            <input type="file" class="col l6" name="image"/>



            <div class="row">
                <div class="center">
                    <input class="black" type="submit" name="ajouter" value="ajouter">
                </div>
            </div>
        </form>
    </div>


<?php } else {
    echo "<h1>Accès interdit :</h1>";
}
