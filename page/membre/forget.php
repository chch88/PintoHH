<?php
require "../../../PintoHH/page/header.php";
$comfirmation = "";

if (!empty($_POST) AND !empty($_POST['email'])) {

    require_once '../../../PintoHH/config.php';
    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ? AND reinitialiser_mail_token '); //
    $requete->execute([$_POST['email']]);
    $user = $requete->fetch();

    // SI l'email est bien identique à celui rentrer dans la base, et que le mail de réinitilaiser est toujours null on peut renvoyer
    // une confirmation

    if ($user == true) {
        require 'fonction.php';
        // session_start();
        $reset_token = caracteres_aleatoire(60);
        $id = $user['id_utilisateur'];

        $donner = $bdd->prepare('UPDATE utilisateurs SET reinitialiser_token = ?, reinitialiser_mail_token = NOW() WHERE id_utilisateur = ?  ');
        $donner->execute(array($reset_token, $id));

        // Envoie le Mail de Récupération
        $to = $_POST['email'];
        $subjet = 'Reinitialisation du mot de passe  de votre Compte';
        $message = "Afin de réinitialisation le mot de passe de  votre compte merci de cliquer sur ce lien (Ce Lien est unique) \n\n 
                     <a href='http://localhost//PintoHH/page/membre/reset_password.php?id=$id&token=$reset_token'> http://localhost//PintoHH/page/membre/reinitialiser_password</a>";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        mail($to, $subjet, $message, $headers);
        $comfirmation = "Un email de Validation à été envoyé sur votre Adresse Mail ";


        $comfirmation = "Un email de Réinitialisation du mot de Passe à été envoyé sur votre Adresse Mail "; ?>
        <h4 style="text-align: center; color: red;"><?php echo $comfirmation; ?></h4>
        <?php
        exit();
    }


}

?>

<h3 class="center-align">Mot de Passe Oublié </h3>


<form action="forget.php" method="post">
    <div class="row">
        <div class="input-field col s4 offset-s4">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" class="validate" required>
            <label for="email" data-error="wrong" data-success="right">Email de Récupération</label>
        </div>
    </div>

    <div class="center">
        <input class="waves-effect waves-light btn" type="submit" name="action"/>
    </div>
</form>
