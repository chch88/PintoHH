<?php
session_start();
$page="admin";
require '../../config.php';
require '../header.php';
define('ROLE',$_SESSION['ROLE']);

	if(ROLE==1){
	
	require 'menu_admin.php';

	$Bars = "SELECT * FROM bars";
	$stylesBars = "SELECT * FROM styles_bars";
	$bar_biere = "SELECT * FROM bars 
				LEFT JOIN bar_biere
				ON bar_biere.bars_id_bar=bars.id_bar
				LEFT JOIN bieres
                ON bieres.id_biere=bar_biere.bieres_id_biere";

	if(isset($_POST)&&!empty($_POST['addBar'])){
		
	

	$photos_id_photo = (isset($_POST['photos_id_photo'])&& !empty($_POST['photos_id_photo'])) ? (int) $_POST['photos_id_photo'] : "";
	$styles_bars_id_style_bar = (isset($_POST['styles_bars_id_style_bar'])&& !empty($_POST['styles_bars_id_style_bar'])) ? (int) $_POST['styles_bars_id_style_bar'] : "";
	$villes_id_ville = (isset($_POST['villes_id_ville'])&& !empty($_POST['villes_id_ville'])) ? (int) $_POST['villes_id_ville'] : "";
		
	//temporaire
	$photos_id_photo=1;	
	$villes_id_ville = 1;
	
	$nom_bar = (isset($_POST['nom_bar'])&& !empty($_POST['nom_bar'])) ? (string) $_POST['nom_bar'] : "";
	$numero = (isset($_POST['numero'])&& !empty($_POST['numero'])) ? (string) $_POST['numero'] : "";
	$rue = (isset($_POST['rue'])&& !empty($_POST['rue'])) ? (string) $_POST['rue'] : "";
	$description_bar = (isset($_POST['description_bar'])&& !empty($_POST['description_bar'])) ? (string) $_POST['description_bar'] : "";
	$telephone = (isset($_POST['telephone'])&& !empty($_POST['telephone'])) ? (string) $_POST['telephone'] : "";
	$mot_patron = (isset($_POST['mot_patron'])&& !empty($_POST['mot_patron'])) ? (string) $_POST['mot_patron'] : "";
	$site_web = (isset($_POST['site_web'])&& !empty($_POST['site_web'])) ? (string) $_POST['site_web'] : "";
		
	$addBar = "INSERT INTO bars (
	`photos_id_photo`,
	`styles_bars_id_style_bar`,
	`villes_id_ville`,
	`nom_bar`,
	`numero`,
	`rue`,
	`description_bar`,
	`telephone`,
	`mot_patron`,
	`site_web`
	
	) VALUES (
	
	$photos_id_photo,
	$styles_bars_id_style_bar,
	$villes_id_ville,
	'$nom_bar',
	'$numero',
	'$rue',
	'$description_bar',
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

<h1 class="center">Ajouter un bar</h1>

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
<label for="numero">Numéro</label>
<input class="validate"name="numero"type="number"id="numero">
</div>

<div class="col s6 input-field">
<label for="rue">Rue</label>
<input class="validate"name="rue"type="text"id="rue">
</div>

<div class="col s6 input-field">
<label for="description_bar">Description</label>
<input class="validate"name="description_bar"type="text"id="description_bar">
</div>

<div class="col s6 input-field">
<label for="telephone">Telephone</label>
<input class="validate"name="telephone"type="text"id="telephone">
</div>

<div class="col s6 input-field">
<label for="mot_patron">Mot du patron</label>
<input class="validate"name="mot_patron"type="text"id="mot_patron">
</div>


<div class="col s6 input-field">
<label for="site_web">Site web</label>
<input class="validate"name="site_web"type="text"id="site_web">
</div>


<div class="col s6">
	<select name="styles_bars_id_style_bar">
		<option value="" disabled selected>Bières en Happy Hour</option>
	<?php
	if($bdd->query($bar_biere)){
		foreach($bdd->query($bar_biere) as $row){ ?>
			<option value="<?=$row['id_biere']?>"><?=$row['nom_biere']?></option>
			<?php
		}
	}
	?>
	</select>
</div>

</div>
</div>

	<div class="center">
		<input class="waves-effect waves-light btn" type="submit" name="addBar" value="ajouter"/>
	</div>

 </form>
		
<br>
		<br>

<?php
}
else{
	echo "<h1>Accès interdit :</h1>";
}
