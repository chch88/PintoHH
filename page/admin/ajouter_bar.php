<?php
session_start();
$page="admin";
require '../../config.php';
require '../header_admin.php';
define('ROLE',$_SESSION['ROLE']);

	if(ROLE==1){
	
	require 'menu_admin.php';

	$Bars = "SELECT * FROM bars";
	$stylesBars = "SELECT * FROM styles_bars";
	$bar_biere = "SELECT * FROM bar_biere
				LEFT JOIN bieres
                ON bieres.id_biere=bar_biere.bieres_id_biere
                GROUP BY bieres.nom_biere DESC";

	if(isset($_POST)&&!empty($_POST['ajout'])){
		
	

	$photos_id_photo = (isset($_POST['photos_id_photo'])&& !empty($_POST['photos_id_photo'])) ? (int) $_POST['photos_id_photo'] : "";
	$styles_bars_id_style_bar = (isset($_POST['styles_bars_id_style_bar'])&& !empty($_POST['styles_bars_id_style_bar'])) ? (int) $_POST['styles_bars_id_style_bar'] : "";
	$villes_id_ville = (isset($_POST['villes_id_ville'])&& !empty($_POST['villes_id_ville'])) ? (int) $_POST['villes_id_ville'] : "";

	$bieres_id_biere = (isset($_POST['bieres_id_biere'])&& !empty($_POST['bieres_id_biere'])) ? (int) $_POST['bieres_id_biere'] : "";
	$prix_normal_bar = (isset($_POST['prix_normal_bar'])&& !empty($_POST['prix_normal_bar'])) ? (int) $_POST['prix_normal_bar'] : "";

	$prix_happy_bar = (isset($_POST['prix_happy_bar'])&& !empty($_POST['prix_happy_bar'])) ? (int) $_POST['prix_happy_bar'] : "";


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

	$bars_id_bar = (isset($_POST['bars_id_bar'])&& !empty($_POST['bars_id_bar'])) ? (string) $_POST['bars_id_bar'] : "";

	$numero_jour1 = 1;
	$numero_jour2 = 2;
	$numero_jour3 = 3;
	$numero_jour4 = 4;
	$numero_jour5 = 5;
	$numero_jour6 = 6;
	$numero_jour7 = 7;

	$heure_debut10 = (isset($_POST['heure_debut10'])&& !empty($_POST['heure_debut10'])) ? (string) $_POST['heure_debut10'] : "";
	$heure_debut11 = (isset($_POST['heure_debut11'])&& !empty($_POST['heure_debut11'])) ? (string) $_POST['heure_debut11'] : "";
	$heure_debut20 = (isset($_POST['heure_debut20'])&& !empty($_POST['heure_debut20'])) ? (string) $_POST['heure_debut20'] : "";
	$heure_debut21 = (isset($_POST['heure_debut21'])&& !empty($_POST['heure_debut21'])) ? (string) $_POST['heure_debut21'] : "";
	$heure_debut30 = (isset($_POST['heure_debut30'])&& !empty($_POST['heure_debut30'])) ? (string) $_POST['heure_debut30'] : "";
	$heure_debut31 = (isset($_POST['heure_debut31'])&& !empty($_POST['heure_debut31'])) ? (string) $_POST['heure_debut31'] : "";
	$heure_debut40 = (isset($_POST['heure_debut40'])&& !empty($_POST['heure_debut40'])) ? (string) $_POST['heure_debut40'] : "";
	$heure_debut41 = (isset($_POST['heure_debut41'])&& !empty($_POST['heure_debut41'])) ? (string) $_POST['heure_debut41'] : "";
	$heure_debut50 = (isset($_POST['heure_debut50'])&& !empty($_POST['heure_debut50'])) ? (string) $_POST['heure_debut50'] : "";
	$heure_debut51 = (isset($_POST['heure_debut51'])&& !empty($_POST['heure_debut51'])) ? (string) $_POST['heure_debut51'] : "";
	$heure_debut60 = (isset($_POST['heure_debut60'])&& !empty($_POST['heure_debut60'])) ? (string) $_POST['heure_debut60'] : "";
	$heure_debut61 = (isset($_POST['heure_debut61'])&& !empty($_POST['heure_debut61'])) ? (string) $_POST['heure_debut61'] : "";
	$heure_debut70 = (isset($_POST['heure_debut70'])&& !empty($_POST['heure_debut70'])) ? (string) $_POST['heure_debut70'] : "";
	$heure_debut71 = (isset($_POST['heure_debut71'])&& !empty($_POST['heure_debut71'])) ? (string) $_POST['heure_debut71'] : "";

	$heure_fin10 = (isset($_POST['heure_fin10'])&& !empty($_POST['heure_fin10'])) ? (string) $_POST['heure_fin10'] : "";
	$heure_fin11 = (isset($_POST['heure_fin11'])&& !empty($_POST['heure_fin11'])) ? (string) $_POST['heure_fin11'] : "";
	$heure_fin20 = (isset($_POST['heure_fin20'])&& !empty($_POST['heure_fin20'])) ? (string) $_POST['heure_fin20'] : "";
	$heure_fin21 = (isset($_POST['heure_fin21'])&& !empty($_POST['heure_fin21'])) ? (string) $_POST['heure_fin21'] : "";
	$heure_fin30 = (isset($_POST['heure_fin30'])&& !empty($_POST['heure_fin30'])) ? (string) $_POST['heure_fin30'] : "";
	$heure_fin31 = (isset($_POST['heure_fin31'])&& !empty($_POST['heure_fin31'])) ? (string) $_POST['heure_fin31'] : "";
	$heure_fin40 = (isset($_POST['heure_fin40'])&& !empty($_POST['heure_fin40'])) ? (string) $_POST['heure_fin40'] : "";
	$heure_fin41 = (isset($_POST['heure_fin41'])&& !empty($_POST['heure_fin41'])) ? (string) $_POST['heure_fin41'] : "";
	$heure_fin50 = (isset($_POST['heure_fin50'])&& !empty($_POST['heure_fin50'])) ? (string) $_POST['heure_fin50'] : "";
	$heure_fin51 = (isset($_POST['heure_fin51'])&& !empty($_POST['heure_fin51'])) ? (string) $_POST['heure_fin51'] : "";
	$heure_fin60 = (isset($_POST['heure_fin60'])&& !empty($_POST['heure_fin60'])) ? (string) $_POST['heure_fin60'] : "";
	$heure_fin61 = (isset($_POST['heure_fin61'])&& !empty($_POST['heure_fin61'])) ? (string) $_POST['heure_fin61'] : "";
	$heure_fin70 = (isset($_POST['heure_fin70'])&& !empty($_POST['heure_fin70'])) ? (string) $_POST['heure_fin70'] : "";
	$heure_fin71 = (isset($_POST['heure_fin71'])&& !empty($_POST['heure_fin71'])) ? (string) $_POST['heure_fin71'] : "";


	//temporaire
	$bars_id_bar=1;

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
	);
	
	INSERT INTO horaires (`bars_id_bar`, `numero_jour`, `heure_debut`, `heure_fin`, `is_happy_hour`) 
	VALUES 
	('$bars_id_bar', '$numero_jour1', '$heure_debut10', '$heure_fin10', '0'),
	('$bars_id_bar', '$numero_jour1', '$heure_debut11', '$heure_fin11', '1'),
	('$bars_id_bar', '$numero_jour2', '$heure_debut20', '$heure_fin20', '0'),
	('$bars_id_bar', '$numero_jour2', '$heure_debut21', '$heure_fin21', '1'),
	('$bars_id_bar', '$numero_jour3', '$heure_debut30', '$heure_fin30', '0'),
	('$bars_id_bar', '$numero_jour3', '$heure_debut31', '$heure_fin31', '1'),
	('$bars_id_bar', '$numero_jour4', '$heure_debut40', '$heure_fin40', '0'),
	('$bars_id_bar', '$numero_jour4', '$heure_debut41', '$heure_fin41', '1'),
	('$bars_id_bar', '$numero_jour5', '$heure_debut50', '$heure_fin50', '0'),
	('$bars_id_bar', '$numero_jour5', '$heure_debut51', '$heure_fin51', '1'),
	('$bars_id_bar', '$numero_jour6', '$heure_debut60', '$heure_fin60', '0'),
	('$bars_id_bar', '$numero_jour6', '$heure_debut61', '$heure_fin61', '1'),
	('$bars_id_bar', '$numero_jour7', '$heure_debut70', '$heure_fin70', '0'),
	('$bars_id_bar', '$numero_jour7', '$heure_debut71', '$heure_fin71', '1');
	
	INSERT INTO  bar_biere (`bars_id_bar` , `bieres_id_biere` , `prix_normal_bar` , `prix_happy_bar`)
	VALUES 
	('$bars_id_bar',  '$bieres_id_biere',  '$prix_normal_bar',  '$prix_happy_bar');
	
	";

	
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
<div class="col l8 offset-l2 m12">

<div class="col s12 file-field input-field" >
      <div class="btn">
        <span>Parcourir</span>
        <input type="file" multiple name="photos_id_photo">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload one or more files">
      </div>
</div>

<div class="col s6 grey-font">
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
<input class="validate"name="numero"type="number"id="numero" min="1">
</div>

<div class="col s6 input-field">
<label for="rue">Rue</label>
<input class="validate"name="rue"type="text"id="rue">
</div>

<div class="col s6 input-field">
<label for="telephone">Telephone</label>
<input class="validate"name="telephone"type="text"id="telephone">
</div>

<div class="col s6 input-field">
<label for="site_web">Site web</label>
<input class="validate"name="site_web"type="text"id="site_web">
</div>

<div class="col s6 input-field">
<label for="description_bar">Description</label>
<textarea id="description_bar" class="materialize-textarea" name="description_bar"></textarea>
</div>

<div class="col s6 input-field">
<label for="mot_patron">Mot du patron</label>
<textarea id="mot_patron" class="materialize-textarea" name="mot_patron"></textarea>
</div>

</div>
</div> <!-- fin row -->

<div class="row"> <!-- HORAIRES NORMAL ET HAPPY -->
	<div class="col l8 offset-l2 m12">

	<div class="col l5 m12 s12 green">
	<table>
		<thead>
		<tr>
			<th data-field="id">Jour d'ouverture normal</th>
			<th data-field="name">Début</th>
			<th data-field="price">Fin</th>
		</tr>
		</thead>

		<tbody>
		<tr>
			<td>Lundi</td>
			<td>
				<label for="heure_debut10"></label>
				<input class="validate"name="heure_debut10"type="time"id="heure_debut10" step="1">
			</td>
			<td>
				<label for="heure_fin10"></label>
				<input class="validate"name="heure_fin10"type="time"id="heure_fin10" step="1">
			</td>
		</tr>

		<tr>
			<td>Mardi</td>
			<td>
					<label for="heure_debut20"></label>
					<input class="validate"name="heure_debut20"type="time"id="heure_debut20" step="1">
			</td>
			<td>
					<label for="heure_fin20"></label>
					<input class="validate"name="heure_fin20"type="time"id="heure_fin20" step="1">
			</td>
		</tr>

		<tr>
			<td>Mercredi</td>
			<td>
					<label for="heure_debut30"></label>
					<input class="validate"name="heure_debut30"type="time"id="heure_debut30" step="1">
			</td>
			<td>
					<label for="heure_fin30"></label>
					<input class="validate"name="heure_fin30"type="time"id="heure_fin30" step="1">
			</td>
		</tr>

		<tr>
			<td>Jeudi</td>
			<td>
					<label for="heure_debut40"></label>
					<input class="validate"name="heure_debut40"type="time"id="heure_debut40" step="1">
			</td>
			<td>
					<label for="heure_fin40"></label>
					<input class="validate"name="heure_fin40"type="time"id="heure_fin40" step="1">
			</td>
		</tr>

		<tr>
			<td>Vendredi</td>
			<td>
					<label for="heure_debut50"></label>
					<input class="validate"name="heure_debut50"type="time"id="heure_debut50" step="1">
			</td>
			<td>
					<label for="heure_fin50"></label>
					<input class="validate"name="heure_fin50"type="time"id="heure_fin50" step="1">
			</td>
		</tr>

		<tr>
			<td>Samedi</td>
			<td>
					<label for="heure_debut60"></label>
					<input class="validate"name="heure_debut60"type="time"id="heure_debut60" step="1">
			</td>
			<td>
					<label for="heure_fin60"></label>
					<input class="validate"name="heure_fin60"type="time"id="heure_fin60" step="1">
			</td>
		</tr>

		<tr>
			<td>Dimanche</td>
			<td>
					<label for="heure_debut70"></label>
					<input class="validate"name="heure_debut70"type="time"id="heure_debut70" step="1">
			</td>
			<td>
					<label for="heure_fin70"></label>
					<input class="validate"name="heure_fin70"type="time"id="heure_fin70" step="1">
			</td>
		</tr>


		</tbody>
	</table>
	</div>

	<div class="col l5 offset-l2 m12 s12 green">
	<table>
		<thead>
		<tr>
			<th data-field="id">Jour d'ouverture Happy Hour</th>
			<th data-field="name">Début</th>
			<th data-field="price">Fin</th>
		</tr>
		</thead>

		<tbody>
		<tr>
			<td>Lundi</td>
			<td>
				<label for="heure_debut11"></label>
				<input class="validate"name="heure_debut11"type="time"id="heure_debut11" step="1">
			</td>
			<td>
				<label for="heure_fin11"></label>
				<input class="validate"name="heure_fin11"type="time"id="heure_fin11" step="1">
			</td>
		</tr>

		<tr>
			<td>Mardi</td>
			<td>
					<label for="heure_debut21"></label>
					<input class="validate"name="heure_debut21"type="time"id="heure_debut21" step="1">
			</td>
			<td>
					<label for="heure_fin21"></label>
					<input class="validate"name="heure_fin21"type="time"id="heure_fin21" step="1">
			</td>
		</tr>

		<tr>
			<td>Mercredi</td>
			<td>
					<label for="heure_debut31"></label>
					<input class="validate"name="heure_debut31"type="time"id="heure_debut31" step="1">
			</td>
			<td>
					<label for="heure_fin31"></label>
					<input class="validate"name="heure_fin31"type="time"id="heure_fin31" step="1">
			</td>
		</tr>

		<tr>
			<td>Jeudi</td>
			<td>
					<label for="heure_debut41"></label>
					<input class="validate"name="heure_debut41"type="time"id="heure_debut41" step="1">
			</td>
			<td>
					<label for="heure_fin41"></label>
					<input class="validate"name="heure_fin41"type="time"id="heure_fin41" step="1">
			</td>
		</tr>

		<tr>
			<td>Vendredi</td>
			<td>
					<label for="heure_debut51"></label>
					<input class="validate"name="heure_debut51"type="time"id="heure_debut51" step="1">
			</td>
			<td>
					<label for="heure_fin51"></label>
					<input class="validate"name="heure_fin51"type="time"id="heure_fin51" step="1">
			</td>
		</tr>

		<tr>
			<td>Samedi</td>
			<td>
					<label for="heure_debut61"></label>
					<input class="validate"name="heure_debut61"type="time"id="heure_debut61" step="1">
			</td>
			<td>
					<label for="heure_fin61"></label>
					<input class="validate"name="heure_fin61"type="time"id="heure_fin61" step="1">
			</td>
		</tr>

		<tr>
			<td>Dimanche</td>
			<td>
					<label for="heure_debut71"></label>
					<input class="validate"name="heure_debut71"type="time"id="heure_debut71" step="1">
			</td>
			<td>
					<label for="heure_fin71"></label>
					<input class="validate"name="heure_fin71"type="time"id="heure_fin71" step="1">
			</td>
		</tr>

		</tbody>
	</table>

	</div>
	</div>

</div> <!-- FIN ROW HORAIRES NORMAL ET HAPPY -->







<div class="row"> <!-- PRIX BIERES PINTE -->
<div class="col l8 offset-l2 m12">

	<div class="col l9 m12 s12 green">
		<table>
			<thead>
			<tr>
				<th data-field="id">Bières en pinte</th>
				<th data-field="name">Prix normal</th>
				<th data-field="price">Prix en happy hour</th>
			</tr>
			</thead>

			<tbody>
			<tr>
				<td>
				<select name="bieres_id_biere ">
					<option value="" disabled selected>Bières</option>
					<?php
						if($bdd->query($bar_biere)){
							foreach($bdd->query($bar_biere) as $row){ ?>
								<option value="<?=$row['id_biere']?>"><?=$row['nom_biere']?></option>
					<?php
							}
						}
					?>
				</select>
				</td>
				<td>
					<div class="col s6 ">
						<label for="prix_normal_bar"></label>
						<input class="validate"name="prix_normal_bar"type="number"id="prix_normal_bar" step="0.01" min="0.01" max="99">
					</div>
				</td>
				<td>
					<div class="col s6 ">
						<label for="prix_happy_bar"></label>
						<input class="validate"name="prix_happy_bar"type="number"id="prix_happy_bar" step="0.01" min="0.01" max="99">
					</div>
				</td>
			</tr>

			</tbody>
		</table>
	</div>

	</div>
</div>
</div> <!-- FIN ROW PRIX BIERES PINTE -->



	<!--
<div class="col s6">
	<select name="styles_bars_id_style_bar">
		<option value="" disabled selected>Bières en Happy Hour</option>
	<?php
//	if($bdd->query($bar_biere)){
//		foreach($bdd->query($bar_biere) as $row){ ?>
//			<option value=" $row['id_biere'] ">  $row['nom_biere'] </option>
			<?php
//		}
//	}
	?>
	</select>
</div> -->




	<div class="center">
		<input class="waves-effect waves-light btn" type="submit" name="ajout" value="ajouter"/>
	</div>

 </form>
		
<br>
		<br>

<?php
}
else{
	echo "<h1>Accès interdit :</h1>";
}
