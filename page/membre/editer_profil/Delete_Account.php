<?php

require "../../header.php";
require '../fonction.php';
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
test_connection();
require_once '../../../config.php';



if (!empty($_POST) AND !empty($_POST['password1'])) {
    $user_id = $_SESSION['information']['id_utilisateur'];
    $requete = $bdd->prepare('SELECT password FROM utilisateurs WHERE id_utilisateur = ?');
    $requete->execute(array($user_id));
    $user = $requete->fetch();


if (password_verify($_POST['password1'], $user['password']))  {
        echo "<a class=\"modal-trigger waves-effect waves-light btn\" href=\"#modal1\" style='margin: 50px 500px;'>Supprimer Votre Compte</a>";

    } else {
       $error = "Votre Mot de Passe n'est pas correct";
    }
}

/* Modal Pour la Supression du Compte */

    if (!empty($_POST['oui'])){
        $user_id = $_SESSION['information']['id_utilisateur'];
        $supp = $bdd->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = ?');
        $supp->execute(array($user_id));
        session_destroy();
        header('Location: ../../../index.php');
        exit();
    }
    if (!empty($_POST['non'])) {
        header('Location: Delete_Account.php');
        exit();
    }
?>

<head>
    <style>
        #modal1 {
            width: 650px;
            height: 280px;
        }

    </style>
</head>



<!-- Modal Structure -->
<div class="col s6">
    <div id="modal1" class="modal modal-fixed-footer">

        <div class="modal-content grey-font">
            <form action="Delete_Account.php" method="post">
                <h4> <?= $_SESSION['information']['nom'] ?> </h4>
                <p>Etes vous sur de vouloir supprimer votre compte cette action est irréversible et aucun retour en
                    arrière ne sera possible !</p>

                <button class="waves-effect waves-light btn" type="submit" name="oui" value="oui">Oui</button>
                <button class="waves-effect waves-light btn" type="submit" name="non" value="non">Non</button>
            </form>
        </div>


        <div class="modal-footer">
            <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat"><i
                    class="large material-icons prefix">close</i></a>
        </div>
    </div>
</div>

<?php
?>
<div class="row">
    <p style="color: red; margin-left: 15px; font-size: 20px;"><?php echo $error ?></p>

    <div class="col s6 offset-s3">
        <h3> Supprimer Votre Compte</h3>
        <form action="" method="post">
            <!-- Mot de Passe -->
            <div class="input-field ">
                <i class="material-icons prefix">delete</i>
                <input id="password1" name="password1" type="password" class="validate" required>
                <label for="password1"> Sécurité: Saisissez votre mot de Passe: </label>
            </div>

            <div class="center">
                <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
            </div>
        </form>
    </div>