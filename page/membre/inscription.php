<?php
require("../header.php");
require "../../config.php";
$comfirmation = "";
?>

<?php
// On sécurise les champs Input

function purge_input($data)
{
    $date = trim($data);
    $date = stripslashes($data);
    $date = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST)) {
    $erreur = array();

    // Vérification de Identifiant

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

    //Vérification de l'EMAIL

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

    //Vérification des Password

    if (empty($_POST['password']) || $_POST['password'] != $_POST['password2']) {
        $erreur['password'] = "Vos deux mot de passe ne corresponde pas !";
    }

    //Vérification du  champs nom

    if (empty($_POST['nom'])) {
        $erreur['nom'] = "Vous n'avez pas indiquer votre nom, ou il n'est pas valide (Il ne peut comporter que des Lettres) ";
    }

    //Vérification du bouton sexe
    if (empty($_POST['sexe'])) {
        $erreur['sexe'] = "Vous n'avez pas indiquer votre Sexe";
    }

    // Si aucune Erreur n'est trouvé
    if (empty($erreur)) {

        $requete = $bdd->prepare("INSERT INTO utilisateurs SET identifiant = ?, email = ?, password = ?, nom = ? , sexe = ? ,  confirmation_token= ? ");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $nom = purge_input($_POST['nom']);
        $sexe = $_POST['sexe'];


        //On appelle la fonction Token
        require 'fonction.php';
        $token = caracteres_aleatoire(60);
        $requete->execute([$_POST['identifiant'], $_POST['email'], $password, $nom, $sexe, $token]);
        $user_id = $bdd->lastInsertId(); // Sa nous renvoie le dernier ID qui a été générer

        // Envoie le Mail de Validation
        $to = $_POST['email'];
        $subjet = 'Confirmation de votre Compte';
        $message = "Afin de valider votre compte merci de cliquer sur ce lien (Ce Lien est unique) \n\n 
                     <a href='http://localhost//PintoHH/page/membre/comfirmation.php?id=$user_id&token=$token'> http://localhost//PintoHH/page/membre/comfirmation</a>";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        mail($to, $subjet, $message, $headers);
        $comfirmation = "Un email de Validation à été envoyé sur votre Adresse Mail "; ?>
        <h4 style="text-align: center; color: red;"><?php echo $comfirmation; ?></h4>
        <?php
        exit();
    }
}

        ?>

    <div class="container" style="margin-left: 20px;">
        <!-- Boucle qui parcours le tableaux et affiche les erreurs -->
            <?php if (!empty($erreur)): ?>
            <p style="color: red; font-weight: bold; font-style: italic;"> Vous n'avez pas remplie le formulaire
                correctement :</p>
            <?php foreach ($erreur as $erreurs): ?>
                <ul class="chip">
                    <li> <?= $erreurs ?></li>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3 class="center-align">INSCRIPTION</h3>

        <form action="inscription.php" method="post">
            <div class="row">

                <!-- NOM -->
                <div class="input-field col s4 offset-s1">
                    <i class="material-icons prefix">person_add</i>
                    <input  type="text" name="nom" class="validate"  required>
                    <label  class="">Nom *</label>
                </div>

                <!-- Email -->
                <div class="input-field col s4 offset-s1">
                    <i class="material-icons prefix">email</i>
                    <input type="email" name="email" class="validate"  required>
                    <label  data-error="wrong" data-success="right">Email *</label>
                </div>

            </div> <!-- fin row -->


            <div class="row">
         
                <!-- SEXE -->
                <div class="input-field col s4 offset-s1">
                    <div>
                        <i class="material-icons prefix">wc</i>
                        <label>Sexe *</label>
                        <br>
                        <p>
                            <input name="sexe" type="radio" id="test1" value="F"/>
                            <label for="test1">Femme</label>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input name="sexe" type="radio" id="test2" value="H"/>
                            <label for="test2">Homme</label>
                        </p>

                    </div>
                </div>


                <div class="row">
                    <!-- Identifiant -->
                    <div class="input-field col s4 offset-s1">
                        <i class="material-icons prefix">account_circle</i>
                        <input  type="text" name="identifiant" class="validate"  required>
                        <label>Identifiant *</label>
                    </div>

                </div> <!-- fin row -->


                <div class="row">
                    <!-- Mot de Passe -->
                    <div class="input-field col s4 offset-s1">
                        <i class="material-icons prefix">vpn_key</i>
                        <input  name="password" type="password" class="validate" id="password" required>
                        <label for="password">Mot de passe *</label>
                    </div>

                    <div class="input-field col s4 offset-s1">
                        <i class="material-icons prefix">vpn_key</i>
                        <input name="password2" type="password" class="validate" id="password" required>
                        <label for="password">Vérification de mot de passe *</label>
                    </div>

                </div> <!-- fin row -->

                <p>* Champs obligatoires</p>
                <hr>

                <br>
                <br>

                <div class="center">
                    <input class="waves-effect waves-light btn" type="submit" name="action"/>
                </div>
        </form>
        <br>
        <br>

    </> <!-- fin container -->

<?php require "../footer.php"; ?>
