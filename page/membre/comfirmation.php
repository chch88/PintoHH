<?php
require '../../config.php';
require 'fonction.php';


$user_id = $_GET['id'];
$token = $_GET['token'];


// On va chercher l'ID dans la base de donner et on vérifie que égal au token qui
 // a été généré pour celui-ci.

$requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = ?');
$requete->execute([$user_id]);
$user = $requete->fetch();

//debug($user);
//die();

if ($user AND $user['confirmation_token'] == $token){
    session_start();
    $bdd->prepare('UPDATE utilisateurs SET confirmation_token = NULL, confirmation_mail = NOW() WHERE id_utilisateur = ?')->execute([$user_id]);

    $_SESSION['information'] = $user;
    header('Location: my_account.php');

} else{
    //require 'inscription.php';
    $_SESSION['flash']['warning'] = "Ce token n'est plus valide";
    header('Location: connexion.php');
}
