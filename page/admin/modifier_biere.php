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
	$pays = "SELECT * FROM `pays`";
	$type_biere = "SELECT * FROM `type_biere`";

	if(isset($_POST)&&!empty($_POST['modifier'])){

	var_dump($_POST);
	
	$id_biere = (isset($_POST['id_biere'])&& !empty($_POST['id_biere'])) ? (int) $_POST['id_biere'] : "";
	$type_biere_id_type_biere = (isset($_POST['type_biere_id_type_biere'])&& !empty($_POST['type_biere_id_type_biere'])) ? (int) $_POST['type_biere_id_type_biere'] : "";
	$pays_id_pays = (isset($_POST['pays_id_pays'])&& !empty($_POST['pays_id_pays'])) ? (int) $_POST['pays_id_pays'] : "";
	$photos_id_photo = (isset($_POST['photos_id_photo'])&& !empty($_POST['photos_id_photo'])) ? (int) $_POST['photos_id_photo'] : "";
	//temporaire 
	$photos_id_photo= 1;
	$nom_biere = (isset($_POST['nom_biere'])&& !empty($_POST['nom_biere'])) ? (string) $_POST['nom_biere'] : "";
	$degree_biere = (isset($_POST['degree_biere'])&& !empty($_POST['degree_biere'])) ? (int) $_POST['degree_biere'] : "";
	$prix_normal = (isset($_POST['prix_normal'])&& !empty($_POST['prix_normal'])) ? (int) $_POST['prix_normal'] : "";
	$prix_happy = (isset($_POST['prix_happy'])&& !empty($_POST['prix_happy'])) ? (int) $_POST['prix_happy'] : "";
	$description = (isset($_POST['description'])&& !empty($_POST['description'])) ? (string) $_POST['description'] : "";
	
	$modifierBeer = "UPDATE  `bieres` SET 
	`type_biere_id_type_biere` = $type_biere_id_type_biere,
	`pays_id_pays` = $pays_id_pays,
	`photos_id_photo` = $photos_id_photo,
	`nom_biere` = '$nom_biere',
	`degree_biere` = $degree_biere,
	`prix_normal` =	$prix_normal,
	`prix_happy` = $prix_happy,
	`description` = '$description'
	WHERE `id_biere` = $id_biere ";	
	

	
	if($bdd->query($modifierBeer)){
		echo "<h1>Bière modifiée</h1>";
	}else{
		echo "<h1>Erreur lors de la modification de la bière</h1>";
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
		<td><?=$row['fichier']?> </td>
		<td><?=$row['nom_biere']?></td>
		<td><?=$row['degree_biere']?></td>
		<td><?=$row['prix_normal']?></td>
		<td><?=$row['prix_happy']?></td>
		<td><?=$row['description']?></td>

		</tr>
	<?php } ?>

</table>
	<p class="center"><?=$counter?> bières</p>
	
	
	
	
<h2 class="center green">Modifier une bière</h2>

<div class="row">
<form class="col s8 offset-s2"action=""method="post"class="col-s8 offset-s2">


		
    <div class="file-field input-field">
      <div class="btn">
        <span>Parcourir</span>
        <input name="photos_id_photo"type="file" multiple>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload one or more files">
      </div>
    </div>
	
  <div class="input-field col s12">
          <input name="id_biere" id="nom_biere" type="text" class="validate">
          <label for="id_biere">identifiant de la bière</label>
        </div>
		
  <div class="input-field col s6">
    <select name="type_biere_id_type_biere">
      <option value="" disabled selected>Type de bière</option>
<?php
	if($bdd->query($type_biere)){ 
	foreach($bdd->query($type_biere) as $row){ ?>
      <option value="<?=$row['id_type_biere']?>"><?=$row['nom_type_biere']?></option>
<?php 
}
}
?>
    </select>
	
    <label>Type de bière</label>
  </div>
  
  
    <div class="input-field col s6">
    <select name="pays_id_pays">
      <option value="" disabled selected>Pays</option>
<?php
	if($bdd->query($pays)){ 
	foreach($bdd->query($pays) as $row){ ?>
      <option value="<?=$row['id_pays']?>"><?=$row['nom_pays']?></option>
<?php 
}
}
?>	  
    </select>
    <label>Pays</label>
  </div>

	  <div class="input-field col s6">
          <input name="nom_biere" id="nom_biere" type="text" class="validate">
          <label for="nom_biere">nom</label>
        </div>
	  <div class="input-field col s6">
          <input name="degree_biere" id="degres" type="text" class="validate">
          <label for="degres">degrès</label>
        </div>
     <div class="input-field col s6">
          <input name="prix_normal"id="prix_normal" type="text" class="validate">
          <label for="prix_normal">prix</label>
        </div>
	    <div class="input-field col s6">
          <input name="prix_happy"id="prix_happy" type="text" class="validate">
          <label for="prix_happy">prix happy</label>
        </div>
	    <div class="input-field col s12">
          <input name="description" id="description" type="text" class="validate">
          <label for="description">Description</label>
        </div>


		<div class="row">
<div class="center">
<input class="black"type="submit"name="modifier"value="modifier">
</div>
</div>
</form>
</div>


<?php	}
else{
	echo "<h1>Accès interdit :</h1>";
}
?>