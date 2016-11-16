<?php
session_start();
$page="admin";
require '../../config.php';
require '../header.php';

$_SESSION['ROLE']=0;



if(isset($_POST['logIn'])&&!empty($_POST['logIn'])){
	$conn = mysqli_connect('localhost','root','root','pinto');
	$email = (isset($_POST['email'])&& !empty($_POST['email'])) ? (string) $_POST['email'] : "";
	$password = (isset($_POST['password'])&& !empty($_POST['password'])) ? (string) $_POST['password'] : "";

	
	$Logs = "SELECT `roles_id_role`,`email`,`password` FROM utilisateurs wHERE email = '$email' AND password = '$password'";

	$rep = mysqli_query($conn,$Logs);
	if(mysqli_num_rows($rep)>0){
		$data = mysqli_fetch_assoc($rep);
		$_SESSION['ROLE']= (int) $data['roles_id_role'];
		


	}else{
		echo mysqli_error($conn);

	}
	}
define('ROLE',$_SESSION['ROLE']);
echo ROLE;

if(ROLE==1){
	require 'menu_admin.php';

}else{?>
	
	<div class="row">
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
	<div class="input-field center">
		<button class="waves-effect waves-light btn" type="submit" name="logIn" value="se connecter">Se connecter</button>
	</div>
</div>
	
</form>
</div>
<?php } ?>





