<?php
session_start();
$page="admin";
require '../../config.php';
require '../header.php';
define('ROLE',$_SESSION['ROLE']);

	if(ROLE==1){
	
	require 'menu_admin.php';

	$Bars = "SELECT * FROM `bars`";
	$stylesBars = "SELECT * FROM `styles_bars`";
	
	if(isset($_POST)&&!empty($_POST['addBar'])){
		
	

	$photos_id_photo = (isset($_POST['photos_id_photo'])&& !empty($_POST['photos_id_photo'])) ? (int) $_POST['photos_id_photo'] : "";
	$styles_bars_id_style_bar = (isset($_POST['styles_bars_id_style_bar'])&& !empty($_POST['styles_bars_id_style_bar'])) ? (int) $_POST['styles_bars_id_style_bar'] : "";
	$villes_id_ville = (isset($_POST['villes_id_ville'])&& !empty($_POST['villes_id_ville'])) ? (int) $_POST['villes_id_ville'] : "";
		
	//temporaire
	$photos_id_photo=1;	
	$villes_id_ville = 1;
	
	$nom_bar = (isset($_POST['nom_bar'])&& !empty($_POST['nom_bar'])) ? (string) $_POST['nom_bar'] : "";
	$longitude = (isset($_POST['longitude'])&& !empty($_POST['longitude'])) ? (int) $_POST['longitude'] : "";
	$latitude = (isset($_POST['latitude'])&& !empty($_POST['latitude'])) ? (int) $_POST['latitude'] : "";
	$numero = (isset($_POST['numero'])&& !empty($_POST['numero'])) ? (string) $_POST['numero'] : "";
	$rue = (isset($_POST['rue'])&& !empty($_POST['rue'])) ? (string) $_POST['rue'] : "";
	$description = (isset($_POST['description'])&& !empty($_POST['description'])) ? (string) $_POST['description'] : "";
	$telephone = (isset($_POST['telephone'])&& !empty($_POST['telephone'])) ? (string) $_POST['telephone'] : "";
	$mot_patron = (isset($_POST['mot_patron'])&& !empty($_POST['mot_patron'])) ? (string) $_POST['mot_patron'] : "";
	$site_web = (isset($_POST['site_web'])&& !empty($_POST['site_web'])) ? (string) $_POST['site_web'] : "";
		
	$addBar = "INSERT INTO bars (
	`photos_id_photo`,
	`styles_bars_id_style_bar`,
	`villes_id_ville`,
	`nom_bar`,
	`longitude`,
	`latitude`,
	`numero`,
	`rue`,
	`description`,
	`telephone`,
	`mot_patron`,
	`site_web`
	
	) VALUES (
	
	$photos_id_photo,
	$styles_bars_id_style_bar,
	$villes_id_ville,
	'$nom_bar',
	$longitude,
	$latitude,
	'$numero',
	'$rue',
	'$description',
	'$telephone',
	'$mot_patron',
	'$site_web'
	)";
	
	if($bdd->query($addBar)){
		echo "<h1>Bar ajouté !</h1>";
		$_POST=null;
		// echo $bdd->lastInsertId(); 

	}else{
		echo "<h1>Erreur lors de l'ajout du bar !</h1>";
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



<h1 class="center green">Ajouter un bar</h1>

<form action="" method="post" class="">
<div class="row">
<div class="col s8 offset-s2">

<div class="col s12 file-field input-field" >
      <div class="btn">
        <span>Parcourir</span>
        <input type="file" multiple name="photos_id_photo">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload one or more files">
      </div>
</div>

<div class="col s6">
    <select name="styles_bars_id_style_bar">
      <option value="" disabled selected>Style de bar</option>
	  
	  <!-- RECUPERER LES STYLES DE BARS -->
<?php
	if($bdd->query($stylesBars)){ 
	foreach($bdd->query($stylesBars) as $row){ ?>
      <option value="<?=$row['id_style_bar']?>"><?=$row['nom_style_bar']?></option>
<?php 
}
}
?>	  
    </select>
</div>

<div class="col s6 input-field">
<input class="validate"name="villes_id_ville"type="text"id="ville">
<label for="ville">Ville</label>

</div>

<div class="col s6 input-field">
<input class="validate"name="nom_bar"type="text"id="nom">
<label for="nom">Nom du bar</label>

</div>

<div class="col s6 input-field">
<label for="longitude">Longitude</label>
<input class="validate"name="longitude"type="text"id="longitude">
</div>

<div class="col s6 input-field">
<label for="latitude">Latitude</label>
<input class="validate"name="latitude"type="text"id="latitude">
</div>

<div class="col s6 input-field">
<label for="numero">Numéro</label>
<input class="validate"name="numero"type="text"id="numero">
</div>

<div class="col s6 input-field">
<label for="rue">Rue</label>
<input class="validate"name="rue"type="number"id="rue">
</div>

<div class="col s6 input-field">
<label for="description">Description</label>
<input class="validate"name="description"type="text"id="description">
</div>


<div class="col s6 input-field">
<label for="mot_patron">Mot du patron</label>
<input class="validate"name="mot_patron"type="text"id="mot_patron">
</div>


<div class="col s6 input-field">
<label for="site_web">Site web</label>
<input class="validate"name="site_web"type="text"id="site_web">
</div>

</div>
</div>

<div class="center">
	<input class="blue " type="submit" name="addBar" value="ajouter">
</div>
 </form>


<?php
}
else{
	echo "<h1>Accès interdit :</h1>";
}
