<?php
$page = "admin";
define('ROLE', 1);
require '../../config.php';
require '../header.php';
require 'menu_admin.php';
?>

<?php
if (ROLE == 1) {
	?>

	<?php
	//Tu recuperes l'id du contact
	$id = $_GET["id_biere"];
	//Requete SQL pour supprimer le contact dans la base

	$delete = $bdd->prepare("DELETE bar_biere, bieres, biere_favori
	FROM  bar_biere
	LEFT JOIN bieres ON bieres.id_biere = bar_biere.bieres_id_biere
	LEFT JOIN biere_favori ON biere_favori.bieres_id_biere = bieres.id_biere
	WHERE bieres.id_biere = $id
	");

	//Et la tu rediriges vers ta page contacts.php pour rafraichir la liste

	if ($delete->execute()) {
		echo "les données ont bien été supprimées";
	};
	?>

	<?php
}
?>
