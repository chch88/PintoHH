<?php
//echo  dirname(__FILE__); = Trouver le chemin absolu.
require "C:\wamp64\www\PintoHH\page\header.php";
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
    header('Location: ../../index.php');
    $_SESSION['flash']['success'] = "Vous etes maintenant connecté";
    exit();
}
else {
    $errorlogin = "Votre Mots de Passe ou Identifiant/Adresse mail est incorrect";
}

}


?>

    <div class="container">

        <br>

        <h3 class="center-align">CONNECTION</h3>

        <form action="connexion.php" method="post">
            <div class="row">
                <div class="input-field col s4 offset-s4">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="icon_prefix" type="text" class="validate" name="identifiant">
                    <label for="icon_prefix" class="">Identifiant</label>
                </div>
            </div> <!-- fin row -->

            <div class="row">
                <div class="input-field col s4 offset-s4">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Mot de passe</label>
                </div>
            </div><!-- fin row -->

            <br>
            <br>

            <div class="center">
                <button class="waves-effect waves-light btn" type="submit" name="action">Envoyer</button>
            </div>
            <p style="color:red;"><?php echo $errorlogin; ?></p>

        </form>

        <br>
        <br>


    </div> <!-- fin container -->

<?php include("../footer.php"); ?>