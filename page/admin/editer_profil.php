<?php
$page="admin";
define('ROLE',1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';


if(ROLE ==1){ 

if(isset($_POST['edit_user'])&&!empty($_POST['edit_user'])){

	$id_user = (isset($_POST['id_user'])&& !empty($_POST['id_user'])) ? (int) $_POST['id_user'] : "";
	$email = (isset($_POST['email'])&& !empty($_POST['email'])) ? (string) $_POST['email'] : "";
	$password = (isset($_POST['password'])&& !empty($_POST['password'])) ? (string) $_POST['password'] : "";
	$role = (isset($_POST['role'])&& !empty($_POST['role'])) ?   (int) $_POST['role'] : "";
	
	$editUser = "UPDATE utilisateurs SET 
	`roles_id_role` = $role,
	`email` = '$email',
	`password_2` = '$password'
	 WHERE `id_utilisateur` = $id_user";
	
	if($bdd->query($editUser)){
		echo "<div class='panel'>Utilsateur modifié</div>";
		$_POST=array();

	}else{
		echo "<div class='panel'>Erreur lors de la modification</div>";
	}
}

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
	$id=array();
	$counter=0;
     foreach ($bdd->query($usersAll) as $row) {
		 $counter++;
		 $id['id'] = $row['id_utilisateur'];
		 ?>	
		<tr>
		<td><?=$row['id_utilisateur']?></td>
		<td><?=$row['roles_id_role']?></td>
		<td><?=$row['email']?></td>
		<td><?=$row['password_2']?></td>
		</tr>
	<?php } ?>
	</table>
<p class="center"><?=$counter?> utilisateur</p>


	<h1 class="center green">Editer un utilisateur</h1>
	
	
	<div class="row">
    <form class="col s8 offset-s2"method="post"action="">
	
	<div class="input-field col s6">
          <input name="id_user" id="id_user" type="text" class="validate">
          <label for="id_user">id utilisateur</label>
	</div>
	
		  
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


        <div class="input-field col s6">
          <input name="email" id="email" type="email" class="validate">
          <label for="email" data-error="wrong" data-success="right">Email</label>
      </div>
	  
	  
</div>
	  
	<div class="center">
	<input class="blue " type="submit" name="edit_user" value="editer">
	</div>
		
	</form>
	</div>
	
	
	
	
	
	
	
<?php }else{
	echo "<h1>Accès interdit </h1>";
}
?>
