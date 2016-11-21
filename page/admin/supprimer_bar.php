<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header_admin.php';
require 'menu_admin.php';
?>

<?php
if (ROLE == 1) {
	?>

	<?php
	//Tu recuperes l'id du contact
	$id = $_GET["id_bar"];
	//Requete SQL pour supprimer le contact dans la base

	$delete = $bdd->prepare("DELETE bieres, bar_biere, biere_favori
	FROM  bars
	LEFT JOIN horaires ON horaires.bars_id_bar = bars.id_bar
	LEFT JOIN biere_favori ON biere_favori.bieres_id_biere = bieres.id_biere
	LEFT JOIN bar_biere ON bieres.id_biere = bar_biere.bieres_id_biere
	WHERE bars.id_bar = $id
	");

	//Et la tu rediriges vers ta page contacts.php pour rafraichir la liste

	if ($delete->execute()) {
		echo "les données ont bien été supprimées";
	};
	?>

	<?php
}
?>
