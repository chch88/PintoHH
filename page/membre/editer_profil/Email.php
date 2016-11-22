<?php
session_start();
require "../../header.php";
require '../fonction.php';
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
test_connection();
require_once '../../../config.php';


// Mofifier l' Email.

if (!empty($_POST)) {
    $erreur = array();
    $email = "";


    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $erreur['email'] = "Vous n'avez pas renter d'email, ou votre email n'est pas valide";

    } else {
        $requete = $bdd->prepare('SELECT id_utilisateur FROM utilisateurs WHERE email = ?');
        $requete->execute([$_POST['email']]);
        $user = $requete->fetch();
        if ($user == true) {
            $erreur['email'] = "Cette Email est déjà utilisé";
        }
    }


// Si aucune Erreur n'est trouvé
    if (empty($erreur)) {
        $user_id = $_SESSION['information']['id_utilisateur'];
        $email = $_POST['email'];
        $donner = $bdd->prepare('UPDATE utilisateurs SET email = ?  WHERE id_utilisateur = ?  ');
        $donner->execute(array($email, $user_id));
        $error = "Votre Email a été Modifié ";
    }
    
    
} else {
    $user_id = $_SESSION['information']['id_utilisateur'];
    $donner = $bdd->prepare('SELECT email FROM utilisateurs WHERE id_utilisateur = ? ');
    $donner->execute(array($user_id));
    $recupere = $donner->fetch();
    $email = $recupere['email'];

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
        <h3> Changer Votre Email</h3>
        <form action="" method="post">
            <!-- Mot de Passe -->
            <div class="input-field ">
                <i class="material-icons prefix">email</i>
                <input disabled="disabled">
                <label><?php echo $email ?>  </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">email</i>
                <input id="email" name="email" type="email" class="validate" required>
                <label for="email"> Mettre à jour votre Email </label>
            </div>

            <div class="center">
                <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            </div>
        </form>
    </div>

