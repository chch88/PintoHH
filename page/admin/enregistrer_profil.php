<?php
$page="admin";
define('ROLE',1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';



if (isset($_POST['add_user'])){
	
	$email = (isset($_POST['email'])&& !empty($_POST['email'])) ? (string) $_POST['email'] : "";
	$password = (isset($_POST['password'])&& !empty($_POST['password'])) ? (string) $_POST['password'] : "";
	$role = (isset($_POST['role'])&& !empty($_POST['role'])) ?   (int) $_POST['role'] : "";
	
	$addUser = "INSERT INTO `utilisateurs`(
	`roles_id_role` ,
	`email` ,
	`password_2` 
	)VALUES(
	".$role.",'".$email."','".$password."'
	)";
	
	if($bdd->query($addUser)){
		echo "<div class='panel'>Utilsateur ajouté</div>";
	}else{
		echo "<div class='panel'>Erreur lors de l'ajout</div>";
	}

	var_dump($_POST);	
}

	//SI USER = admin
	//fields  = password, role, email,  ajouter_utilisateur
	if(ROLE ===1 ){ 
	$usersAll = "SELECT * FROM utilisateurs";
?>
	
	<h1 class="center green">Utilisateurs</h1>
<table class="responsive-table  highlight black" style='max-width:80%;margin:auto;'>
<tr class="centered blue">
<th>id_utilisateur</th>
<th>roles_id_role</th>
<th>email</th>
<th>password_2</th>
</tr>
<?php
	$counter=0;
     foreach ($bdd->query($usersAll) as $row) {
		 $counter++;
		 ?>	
		<tr class="">
		<td><?=$row['id_utilisateur']?></td>
		<td><?=$row['roles_id_role']?></td>
		<td><?=$row['email']?></td>
		<td><?=$row['password_2']?></td>
		</tr>
	<?php } ?>
	</table>
	
<p class="center"><?=$counter?> utilisateur</p>


<h2 class="center green">Ajouter un utilisateur </h2>

	<div class="row">
    <form class="col s8 offset-s2"method="post"action="">
      <div class="row">
	  
	  <div class="input-field col s6">
          <input name="password" id="password" type="text" class="validate">
          <label for="password">Mot de passe</label>
        </div>
	
	<div class="input-field col s6">
    <select name="role">
      <option value="" disabled selected>Le rôle</option>
      <option value="1">Administrateur</option>
      <option value="2">Membre</option>
    </select>
    <label>Rôle de l'utilisateur</label>
  </div>
  
</div>


 <div class="row">

        <div class="input-field col s6 offset-s3">
          <input name="email" id="email" type="email" class="validate">
          <label for="email" data-error="wrong" data-success="right">Email</label>
        </div>

      </div>
   <div class="center">
			<input class="blue " type="submit" name="add_user" value="ajouter">

	      </div>
	  
	</form>
	  </div>
	<?php } ?>
	
	
	