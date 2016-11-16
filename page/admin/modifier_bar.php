
<?php
session_start();
$page="admin";
require '../../config.php';
require '../header.php';
define('ROLE',$_SESSION['ROLE']);

if(ROLE==1){
	require 'menu_admin.php';

	$Bars = "SELECT * FROM bars";
	$stylesBars = "SELECT * FROM `styles_bars`";	
	$villes = "SELECT * FROM `villes`";

	if(isset($_POST)&&!empty($_POST['modifierBar'])){
		

	$photos_id_photo = (isset($_POST['photos_id_photo'])&& !empty($_POST['photos_id_photo'])) ? (int) $_POST['photos_id_photo'] : "";
	$styles_bars_id_style_bar = (isset($_POST['styles_bars_id_style_bar'])&& !empty($_POST['styles_bars_id_style_bar'])) ? (int) $_POST['styles_bars_id_style_bar'] : "";
	$villes_id_ville = (isset($_POST['villes_id_ville'])&& !empty($_POST['villes_id_ville'])) ? (int) $_POST['villes_id_ville'] : "";

	//temporaire
	$photos_id_photo=1;
	$villes_id_ville = 1;

	$id_bar = (isset($_POST['id_bar'])&& !empty($_POST['id_bar'])) ? (int) $_POST['id_bar'] : "";
	$nom_bar = (isset($_POST['nom_bar'])&& !empty($_POST['nom_bar'])) ? (string) $_POST['nom_bar'] : "";
	$longitude = (isset($_POST['longitude'])&& !empty($_POST['longitude'])) ? (int) $_POST['longitude'] : "";
	$latitude = (isset($_POST['latitude'])&& !empty($_POST['latitude'])) ? (int) $_POST['latitude'] : "";
	$numero = (isset($_POST['numero'])&& !empty($_POST['numero'])) ? (string) $_POST['numero'] : "";
	$rue = (isset($_POST['rue'])&& !empty($_POST['rue'])) ? (string) $_POST['rue'] : "";
	$description_bar = (isset($_POST['description_bar'])&& !empty($_POST['description_bar'])) ? (string) $_POST['description_bar'] : "";
	$telephone = (isset($_POST['telephone'])&& !empty($_POST['telephone'])) ? (string) $_POST['telephone'] : "";
	$mot_patron = (isset($_POST['mot_patron'])&& !empty($_POST['mot_patron'])) ? (string) $_POST['mot_patron'] : "";
	$site_web = (isset($_POST['site_web'])&& !empty($_POST['site_web'])) ? (string) $_POST['site_web'] : "";
		
	$modifBar = "UPDATE `bars` SET 
	`photos_id_photo` = $photos_id_photo,
	`styles_bars_id_style_bar` = $styles_bars_id_style_bar,
	`villes_id_ville` = $villes_id_ville,
	`nom_bar` = '$nom_bar',
	`longitude` = $longitude,
	`latitude` =$latitude ,
	`numero` = '$numero',
	`rue` = '$rue',
	`description_bar` = '$description_bar',
	`telephone` = '$telephone',
	`mot_patron` = '$mot_patron',
	`site_web` = '$site_web'
	 WHERE id_bar = $id_bar";

	
	if($bdd->query($modifBar)){
		echo "<h1>Bar modifié !</h1>";
		$_POST=null;
		// echo $bdd->lastInsertId(); 

	}else{
		echo "<h1>Erreur lors de la modification du bar !</h1>";
	}	
	}
	
	
	
?>

<h1 class="center green">Les bars</h1>
<table class="responsive-table  highlight green" style='max-width:80%;margin:auto;'>
<tr class="grey-font white">
<th>Id</th>
<th>Photo</th>
<th>Style de bar</th>
<th>Villes</th>
<th>Nom du bar</th>
<th>Numero</th>
<th>Rue</th>
<th>Description</th>
<th>Téléphone</th>
<th>Mot du patron</th>
<th>Site web</th>
</tr>
<?php
	$id=array();
	$counter=0;
	
     foreach ($bdd->query($Bars) as $row) {
		 $counter++;
		 $id['id'] = $row['id_bar'];  ?>	
	
		<tr>
		<td><?=$row['id_bar']?></td>
		<td><?=$row['photos_id_photo']?></td>
		<td><?=$row['styles_bars_id_style_bar']?></td>
		<td><?=$row['villes_id_ville']?></td>
		<td><?=$row['nom_bar']?></td>
		<td><?=$row['numero']?></td>
		<td><?=$row['rue']?></td>
		<td><?=utf8_encode($row['description_bar'])?></td>
		<td><?=$row['telephone']?></td>
		<td><?=utf8_encode($row['mot_patron'])?></td>
		<td><?=$row['site_web']?></td>
		</tr>
	<?php } ?>
	</table>

	<br>
<p class="center"><?=$counter?> bar</p>

<h1 class="center green">Modifier un bar</h1>


<div class="row">
<form action="" method="post" class="col s8 offset-s2">

<div class="col s6 input-field">
<input type="text"name="id_bar" class="validate" id="id_bar">
<label for="id_bar" class="">identifiant du bar</label>
</div>


 <div class="col s12 file-field input-field">
      <div class="btn">
        <span>Parcourir</span>
        <input name="photos_id_photo"type="file" multiple>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload one or more files">
      </div>
</div>
	


 <div class="input-field col s6">
    <select name="styles_bars_id_style_bar">
      <option value="" disabled selected>Choisissez un style de bar</option>
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
    <label>Style du bar</label>
  </div>

 <div class="input-field col s6">
    <select name="ville">
      <option value="" disabled selected>Choisissez une ville</option>
	  <!-- RECUPERER LES VILLES EXISTANTES -->
<?php
	if($bdd->query($villes)){ 
	foreach($bdd->query($villes) as $row){ ?>
      <option value="<?=$row['id_ville']?>"><?=$row['ville']?></option>
<?php 
}
}
?>
    </select>
    <label>Choisissez une ville</label>
  </div>

      <div class="input-field col s6">
          <input name="nom_bar"id="nom_bar" type="text" class="validate">
          <label for="nom_bar">Nom du bar</label>
        </div>
	  
      <div class="input-field col s6">
          <input name="numero"id="numero" type="text" class="validate">
          <label for="numero">numéro</label>
        </div>

	        <div class="input-field col s6">
          <input name="rue"id="rue" type="text" class="validate">
          <label for="rue">Rue</label>
        </div>

	        <div class="input-field col s6">
          <input  name="description_bar"id="description_bar" type="text" class="validate">
          <label for="description_bar">Description</label>
        </div>
	        <div class="input-field col s6">
          <input name="phone" id="phone" type="text" class="validate">
          <label for="phone">Téléphonne</label>
        </div>
	  	        <div class="input-field col s6">
          <input  name="mot_patron"id="mot_patron" type="text" class="validate">
          <label for="mot_patron">Mot du patron</label>
        </div>
		        
	<div class="input-field col s6">
          <input name="site_web" id="site_web" type="text" class="validate">
          <label for="site_web">site_web</label>
        </div>

</div>
<div class="center">
<input type="submit" name="modifierBar" value="modifier" class="black">
</div>


</form>

<?php
}
else{
	echo "<h1>Accès interdit :</h1>";
}
