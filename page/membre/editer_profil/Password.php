<?php
session_start();
require "../../header.php";
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
require '../fonction.php';
test_connection();

// Mofifier un mot de passe.
if (!empty($_POST) AND !empty($_POST['ancien_password']) AND !empty($_POST['password']) AND !empty($_POST['password2'])) {

    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password == $password2) {
        require_once '../../../config.php';
        $user_id = $_SESSION['information']['id_utilisateur'];
        $requete = $bdd->prepare('SELECT password FROM utilisateurs WHERE id_utilisateur = ?');
        $requete->execute(array($user_id));
        $user = $requete->fetch();

        if (password_verify($_POST['ancien_password'], $user['password'])) {

            $password_nouveau = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $requete = $bdd->prepare('UPDATE utilisateurs SET password = ? WHERE  id_utilisateur = ?');
            $requete->execute(array($password_nouveau, $user_id));
            $error = "Votre mot de passe à bien été Modifié";

        } else {
            $error = "Votre Ancien Mot de Passe n'est pas correct";
        }

    } else {
        $error = "Vos deux mots de Passe ne coreesponde pas";
    }

}


?>
<div class="row">
    <p style="color: red; margin-left: 15px; font-size: 20px;"><?php echo $error ?></p>

    <div class="col s6 offset-s3">
        <h3> Changer Votre Mot de Passe</h3>
        <form action="" method="post">
            <!-- Mot de Passe -->
            <div class="input-field ">
                <i class="material-icons prefix">vpn_key</i>
                <input id="ancien_password" name="ancien_password" type="password" class="validate" required>
                <label for="ancien_password"> Ancien Mot de passe </label>
            </div>

            <div class="input-field ">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password" name="password" type="password" class="validate" required>
                <label for="password"> Nouveau Mot de passe </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password" name="password2" type="password" class="validate" required>
                <label for="password">Confirmation du nouveau Mot de Passe </label>
            </div>

            <div class="center">
                <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            </div>
        </form>
    </div>