<?php
session_start();
$page="admin";
require '../../config.php';
require '../header_admin.php';
define('ROLE',$_SESSION['ROLE']);

if(ROLE==1){
	require 'menu_admin.php';

	$Bars = "SELECT * FROM bars";
	

	if(isset($_POST)&&!empty($_POST['supprimer'])){
		

	$id_bar = (isset($_POST['id_bar'])&& !empty($_POST['id_bar'])) ? (int) $_POST['id_bar'] : "";
					
			

	$deleteBar = "DELETE FROM `bars` WHERE `id_bar` = $id_bar";
	
	if($bdd->query($deleteBar)){
		echo "<h1>Bar supprimé</h1>";
	}else{
		echo "<h1>Erreur lors de la suppression du bar !</h1>";
	}
	
	} 
?>

<h1 class="center green">Les bars</h1>
<table class="responsive-table  highlight black" style='max-width:80%;margin:auto;'>
<tr class="centered blue">
<th>id_bar</th>
<th>photos_id_photo</th>
<th>styles_bars_id_style_bar</th>
<th>villes_id_ville</th>
<th>nom_bar</th>
<th>longitude</th>
<th>latitude</th>
<th>numero</th>
<th>rue</th>
<th>description</th>
<th>telephone</th>
<th>mot_patron</th>
<th>site_web</th>
</tr>
<?php
	$id=array();
	$counter=0;
     foreach ($bdd->query($Bars) as $row) {
		 $counter++;
		 $id['id'] = $row['id_bar'];
		 ?>	
		<tr>
		<td><?=$row['id_bar']?></td>
		<td><?=$row['photos_id_photo']?></td>
		<td><?=$row['styles_bars_id_style_bar']?></td>
		<td><?=$row['villes_id_ville']?></td>
		<td><?=$row['nom_bar']?></td>
		<td><?=$row['longitude']?></td>
		<td><?=$row['latitude']?></td>
		<td><?=$row['numero']?></td>
		<td><?=$row['rue']?></td>
		<td><?=$row['description']?></td>
		<td><?=$row['telephone']?></td>
		<td><?=$row['mot_patron']?></td>
		<td><?=$row['site_web']?></td>
		</tr>
	<?php } ?>
	</table>
<p class="center"><?=$counter?> bar</p>


<h2 class="center green">Supprimer un bar</h2>

<div class="row">
<form class="col s6 offset-s3 "action="supprimer_bar.php"method="post">
<div class="col s12 file-field input-field">
<input id="id_bar"type="text"name="id_bar"class="validate">
<label for="id_bar">identifiant du bar</label>
</div>
<div class="center">
<input class="black" type="submit" name="supprimer" value="supprimer">
</div>
</form>


</div>




<?php
}
else{
	echo "<h1>Accès interdit :</h1>";
}
?>