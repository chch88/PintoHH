<?php
require "../../page/header.php";
require "../../config.php";
require 'fonction.php';

if (isset($_GET['id']) AND isset($_GET['token'])) {

    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = ? AND reinitialiser_token = ?');
    $requete->execute([$_GET['id'], $_GET['token']]);
    $user = $requete->fetch();

    if ($user == true) {
        if (!empty($_POST)) {
            if (!empty($_POST['password']) AND $_POST['password'] == $_POST['password_confirm']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $bdd->prepare('UPDATE utilisateurs SET password = ?')->execute([$password]);
                session_start();
                $_SESSION['flash']['succes'] = "Votre mot de passe à bien été mofifié ";
                $_SESSION['information'] = $user;
                header('Location: my_account.php');
                exit();

            }
        }
    } else {
        require "flash.php";
        $Session = new Session();
        $Session->setflash("Ce token n'est plus valide");
        header('Location: connexion.php');
        exit();
    }

} else {
    header('Location: connexion.php');
    exit();
}


?>
<div class="row">
    <div class="col s6 offset-s3">
        <h3> Réinitialiser votre Mot de Passe</h3>
        <form action="" method="post">
            <!-- Mot de Passe -->
            <div class="input-field ">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password" name="password" type="password" class="validate" required>
                <label for="password"> Réinitialiser le Mot de passe </label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password_confirm" name="password_confirm" type="password" class="validate" required>
                <label for="password_confirm">Confirmation du nouveau Mot de Passe </label>
            </div>

            <div class="center">
                <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            </div>
        </form>
    </div>