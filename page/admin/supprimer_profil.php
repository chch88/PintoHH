<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header_admin.php';
require 'menu_admin.php';

if (ROLE == 1) {
    $usersAll = "SELECT * FROM utilisateurs";

    if (isset($_POST['delUser'])) {


        $id_user = (isset($_POST['id_user']) && !empty($_POST['id_user'])) ? (int)$_POST['id_user'] : "";

        $deleteUser = "DELETE FROM utilisateurs WHERE id_utilisateur = $id_user";

        if ($bdd->query($deleteUser)) {
            echo "<div class='panel'>Utilsateur supprimé</div>";

        } else {
            echo "<div class='panel'>Erreur lors de la suppression</div>";
        }

    }
    ?>
    <h1 class="center green">Profil</h1>
    <table class="responsive-table  highlight black" style='max-width:80%;margin:auto;'>
        <tr class="centered blue">
            <th>id_utilisateur</th>
            <th>roles_id_role</th>
            <th>nom</th>
            <th>email</th>
            <th>password_2</th>
        </tr>

        <?php
        $counter = 0;
        foreach ($bdd->query($usersAll) as $row) {
            $counter++;
            ?>
            <tr class="">
                <td><?= $row['id_utilisateur'] ?></td>
                <td><?= $row['roles_id_role'] ?></td>
                <td><?= $row['nom'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['password'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <p class="center"><?= $counter ?> utilisateur</p>


    <h1 class="center green">Supprimer un utilisateur</h1>


    <div class="row">
        <form class="col s8 offset-s2" method="post" action="">

            <div class="input-field col s12">
                <input name="id_user" id="id_user" type="text" class="validate">
                <label for="id_user">id utilisateur</label>
            </div>


    </div>

    <div class="center">
        <input class="blue " type="submit" name="delUser" value="supprimer">
    </div>

    </form>
    </div>
    <?php

} else {
    echo "<h1>Accès interdit</h1>";
}
?>