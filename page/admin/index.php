<?php
session_start();
$page="admin";
require '../../config.php';
require '../header.php';

$_SESSION['ROLE']=0;

if(isset($_POST['logIn'])&&!empty($_POST['logIn'])){
	
	$email = (isset($_POST['email'])&& !empty($_POST['email'])) ? (string) $_POST['email'] : "";
	$password = (isset($_POST['password'])&& !empty($_POST['password'])) ? (string) $_POST['password'] : "";

	
	$Logs = "SELECT `roles_id_role`,`email`,`password_2` FROM utilisateurs";
	   
	foreach  ($bdd->query($Logs) as $row) {
         if($row['email'] === $email && $row['password_2'] === $password){
			$_SESSION['ROLE'] = (int) $row['roles_id_role'];
		 }
	}
	
	
}
define('ROLE',$_SESSION['ROLE']);


if(ROLE==1){
	require 'menu_admin.php';

}else{?>
	
	<div class="row">
<form class="col s6 offset-s3" method="post" action="">

<div class="row">
<div class="col s12 ">
<label>email</label>
<input type="email"name="email">
</div>
<div class="col s12 ">
<label>mot de passe</label>
<input type="password"name="password">
</div>
<div class="center">
<input class="black"type="submit"name="logIn"value="se connecter">
</div>
</div>
	
</form>
</div>
<?php } ?>





