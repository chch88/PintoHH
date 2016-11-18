<?php
//echo  dirname(__FILE__); = Trouver le chemin absolu.
require "../../page/header.php";
$errorlogin= "";


if(!empty($_POST) AND !empty($_POST['identifiant']) AND !empty($_POST['password'])){
    require "../../config.php";
    require "fonction.php";
    
        // On vérifie à la fin de la requette si l'utilisateur à bien comfirmer son mail
        $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE identifiant = :identifiant OR  email = :identifiant AND confirmation_mail IS NOT NULL');
        $requete->execute(['identifiant' => $_POST['identifiant']]);
        $user = $requete->fetch();

        

// On test si les mot de passe corresponde avec une fonction à cause du cryptage

if (password_verify($_POST['password'], $user['password'])) {
    session_start();
    $_SESSION['information'] = $user;
    header('Location: my_account.php');

    exit();
}
else {
    $errorlogin = "Votre Mots de Passe ou Identifiant/Adresse mail est incorrect !";
}

}


?>

    <div class="container">
    <p style="color:red; margin-left: 15px; font-size: 20px;"><?php echo $errorlogin; ?></p>
        <br>

        <h3 class="center-align">CONNECTION</h3>

        <form action="connexion.php" method="post">
            <div class="row">
                <div class="input-field col s4 offset-s4">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="icon_prefix" type="text" class="validate" name="identifiant" required>
                    <label for="icon_prefix" class="">Identifiant ou Email</label>
                </div>
            </div> <!-- fin row -->

            <div class="row">
                <div class="input-field col s4 offset-s4">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" class="validate" name="password" required>
                    <label for="password">Mot de passe</label></br>
                    <a href="forget.php" style="float: right;">J'ai oublié mon mot de Passe</a>
                </div>

            </div><!-- fin row -->

            <br>
            <div class="center">
                <input type="checkbox" class="filled-in" id="checbox" checked="checked" name="souvenir" />
                <label for="checbox"> Se Souvenir de Moi </label></br></br>
                <button class="waves-effect waves-light btn" type="submit" name="action">Envoyer</button>
            </div>
        </form>

        <br>
        <br>


    </div> <!-- fin container -->