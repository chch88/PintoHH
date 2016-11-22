
<?php
require "../../header.php";
require '../fonction.php';
$error = "";
// On vérifie que l'utilisateur est bien connecté !!
test_connection();
require_once '../../../config.php';



// Mofifier le Nom d'Utilisateur.
if (!empty($_POST) AND !empty($_POST['nom'])) {
        $user_id = $_SESSION['information']['id_utilisateur'];
        $nom = $_POST['nom'];
        $donner = $bdd->prepare('UPDATE utilisateurs SET nom = ?  WHERE id_utilisateur = ?  ');
        $donner->execute(array($nom,  $user_id));
        $error= "Votre Nom été Modifié ";
    

} else {
    $user_id = $_SESSION['information']['id_utilisateur'];
    $donner = $bdd->prepare('SELECT nom FROM utilisateurs WHERE id_utilisateur = ? ');
    $donner->execute(array($user_id));
    $recupere = $donner->fetch();
    $nom = $recupere['nom'];
}


?>
<div class="row">
    <p style="color: red; margin-left: 15px; font-size: 20px;"><?php  echo $error ?></p>

    <div class="col s6 offset-s3">
    <h3> Modifier Votre Nom </h3>
    <form action="Nom.php" method="post">
        <!-- Mot de Passe -->
        <div class="input-field ">
            <i class="material-icons prefix">perm_identity</i>
            <input disabled="disabled">
            <label ><?php echo $nom ?>  </label>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">perm_identity</i>
            <input id="nom" name="nom" type="text" class="validate" required>
            <label for="nom"> Mettre à jour votre Nom</label>
        </div>

        <div class="center">
            <input class="waves-effect waves-light btn" type="submit" name="action"/><br>
        </div>
    </form>
    </div>