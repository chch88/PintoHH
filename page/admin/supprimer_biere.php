<?php
$page="admin";
define('ROLE',1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';


if(ROLE ==1){ 

	$BieresAll = "SELECT * FROM `bieres` 
	JOIN `type_biere`
	ON bieres.type_biere_id_type_biere = type_biere.id_type_biere
	JOIN `pays` ON bieres.pays_id_pays = pays.id_pays
	JOIN `photos` ON bieres.photos_id_photo = photos.id_photo ";	
	
	if(isset($_POST)&&!empty($_POST['supprimer'])){
		
	$id_biere = (isset($_POST['id_biere'])&& !empty($_POST['id_biere'])) ? (int) $_POST['id_biere'] : "";

	$DeleteBeer = "DELETE FROM `bieres` WHERE `id_biere` = $id_biere";
	
	if($bdd->query($DeleteBeer)){
		echo "<h1>Bière supprimée</h1>";
	}else{
		echo "<h1>Erreur lors de la suppression de la bière !</h1>";
	}

	}
?>
<h1 class="center green">Les bières</h1>
<table class="responsive-table  highlight black" style='max-width:80%;margin:auto;'>
<tr class="centered blue">
	<th>id_biere</th>
	<th>type</th>
	<th>pays</th>
	<th>photo</th>
	<th>nom</th>
	<th>degrès</th>
	<th>prix</th>
	<th>prix happy</th>
	<th>description</th>
</tr>
<?php
	$id=array();
	$counter=0;
     foreach ($bdd->query($BieresAll) as $row) {
		 $counter++;
		 ?>	
		<tr>
		<td><?=$row['id_biere']?></td>
		<td><?=$row['nom_type_biere']?></td>
		<td><?=$row['nom_pays']?></td>
		<td><?=$row['fichier']?></td>
		<td><?=$row['nom_biere']?></td>
		<td><?=$row['degree_biere']?></td>
		<td><?=$row['prix_normal']?></td>
		<td><?=$row['prix_happy']?></td>
		<td><?=$row['description_biere']?></td>

		</tr>
	<?php } ?>

</table>
	<p class="center"><?=$counter?> bières</p>

<h2 class="center green">Suppimer une bière</h2>

<div class="row">
<form class="col s8 offset-s2"method="post"action="supprimer_biere.php">

<div class="col s12 input-field">
<label for="id_biere">identifiant bière</label>
<input class="validate"name="id_biere"type="text"id="id_biere">
</div>
<div class="center">
<input type="submit"class="black"name="supprimer"value="supprimer">
</div>
</form>
</div>





<?php 
}
else{
	echo "<h1>Accès interdit :</h1>";
}
