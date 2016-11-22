<?php
session_start();
require "../../header.php";
require '../fonction.php';
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
test_connection();
require_once '../../../config.php';



if (!empty($_POST)) {
    $erreur = array();
    $identifiant = "";


    if (empty($_POST['identifiant']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['identifiant'])) {
        $erreur['identifiant'] = "Vous n'avez pas renter d' identifiant, ou il est invalide";

    } else {
        $requete = $bdd->prepare('SELECT id_utilisateur FROM utilisateurs WHERE identifiant = ?');
        $requete->execute([$_POST['identifiant']]);
        $user = $requete->fetch();
        if ($user == true) {
            $erreur['identifiant'] = "Cette identifiant est déjà utilisé";
        }
    }


// Si aucune Erreur n'est trouvé
    if (empty($erreur)) {
        $user_id = $_SESSION['information']['id_utilisateur'];
        $identifiant = $_POST['identifiant'];
        $donner = $bdd->prepare('UPDATE utilisateurs SET identifiant= ?  WHERE id_utilisateur = ?  ');
        $donner->execute(array($identifiant, $user_id));
        $error = "Votre Identifiant a été Modifié ";
    }


} else {
    $user_id = $_SESSION['information']['id_utilisateur'];
    $donner = $bdd->prepare('SELECT identifiant FROM utilisateurs WHERE id_utilisateur = ? ');
    $donner->execute(array($user_id));
    $recupere = $donner->fetch();
    $identifiant = $recupere['identifiant'];

}

?>
<div style="margin-left: 20px;">
    <!-- Boucle qui parcours le tableaux et affiche les erreurs -->
    <?php if (!empty($erreur)): ?>
        <?php foreach ($erreur as $erreurs): ?>
            <ul><li style="color: red; margin-left: 15px; font-size: 20px;"> <?= $erreurs ?></li></ul>
        <?php endforeach; ?>
    <?php endif; ?>


<div class="row">
    <p style="color: red; margin-left: 15px; font-size: 20px;"><?php echo $error ?></p>

    <div class="col s6 offset-s3">
        <h3> Changer Votre Identifiant</h3>
        <form action="" method="post">
            <!-- Mot de Passe -->
            <div class="input-field ">
                <i class="material-icons prefix">perm_identity</i>
                <input disabled="disabled">
                <label><?php echo $identifiant ?>  </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">perm_identity</i>
                <input id="identifiant" name="identifiant" type="text" class="validate" required>
                <label for="identifiant"> Mettre à jour votre Identifiant </label>
            </div>

            <div class="center">
                <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            </div>
        </form>
    </div>