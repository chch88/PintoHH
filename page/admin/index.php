<?php
session_start();
$error = "";
$page = "admin";
require '../../config.php';
require '../header_admin.php';

$_SESSION['ROLE'] = 0;
if (!empty($_POST) AND !empty($_POST['email']) AND !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ?  AND password = ?');
    $requete->execute(array($email, $password));
    $admin = $requete->fetch();

    if (!$admin) {
        $error = "Vos Identifiant sont incorrect !";
    } else {
        $_SESSION['ROLE'] = (int)$admin['roles_id_role'];
    }
}

define('ROLE', $_SESSION['ROLE']);

if (ROLE == 1) {
    require 'menu_admin.php';
} else {
    ?>

    <div class="row" style="margin-top:150px;">
        <form class="col s6 offset-s3" method="post" action="">

            <div class="row">
                <div class="col s12 ">
                    <label>email</label>
                    <input type="email" name="email">
                </div>
                <div class="col s12 ">
                    <label>mot de passe</label>
                    <input type="password" name="password">
                </div>

                <div class="center">
                    <input class="waves-effect waves-light btn" type="submit" name="logIn" value="Se connecter"/>
                </div>

                <p></p>

            </div>
            <h4 style="text-align: center; color: red"><?php echo $error ?></h4>
        </form>
    </div>
<?php } ?>





