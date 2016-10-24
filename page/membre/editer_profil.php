
<?php
session_start();
require "../header.php";
require 'fonction.php';
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
test_connection();

// Mofifier un mot de passe.
if (!empty($_POST)) {
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password2']) {
        $error = "Les mots de passe ne corresponde pas";

    } else {

        require_once '../../config.php';
        $user_id = $_SESSION['information']['id_utilisateur'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $donner = $bdd->prepare('UPDATE utilisateurs SET password = ?  WHERE id_utilisateur = ?  ');
        $donner->execute(array($password,  $user_id));
        $error= "Votre Mot de Passe à été Modifié ";
        header('Location: ../../index.php');


        //$_SESSION['flash']['sucess'] = 'Votre mot de passe à bien été mis à jours !';
    }

}


?>
<div class="container">
    <h3> Changer Votre Mot de Passe</h3>
    <form action="" method="post">
        <!-- Mot de Passe -->
        <div class="input-field col s4 offset-s1">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" name="password" type="password" class="validate" required>
            <label for="password"> Nouveau Mot de passe </label>
        </div>

        <div class="input-field col s4 offset-s1">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" name="password2" type="password" class="validate" required>
            <label for="password">Confirmation du nouveau Mot de Passe </label>
        </div>

        <div class="center">
            <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            <p style="float: left; color: red;"><?php  echo $error ?></p>
        </div>
    </form>