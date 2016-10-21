<?php
/* On créer une fonction pour générer un nombre aléatoire qu'on va se servir comme Token

    str_repeat — Répète une chaîne
    str_shuffle — Mélange les caractères d'une chaîne de caractères
    substr — Retourne un segment de chaîne
*/

function caracteres_aleatoire($length)
{
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

}

// On creer une fonction pour débugger les erreurs !
// var_dump — Affiche les informations d'une variable
//print_r — Affiche des informations lisibles pour une variable


function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

// On creer uen fonction pour voir si l'utilisateur est connecté 


function test_connection(){

    if (!isset($_SESSION['information'])) {
        //$_SESSION['flash']['danger'] =  " Vous n'avez pas le droit d'acceder à cette page!";
        header('Location: connexion.php');
        exit();
    }

}