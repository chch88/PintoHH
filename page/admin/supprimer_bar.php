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

	$delete = $bdd->prepare("DELETE bar_favori, bar_biere, galerie_bar, photos, horaires
	FROM  bars
	LEFT JOIN bar_favori ON bar_favori.bars_id_bar = bars.id_bar
	LEFT JOIN bar_biere ON bars.id_bar = bar_biere.bars_id_bar
	LEFT JOIN galerie_bar ON bars.id_bar = galerie_bar.bars_id_bar
	LEFT JOIN photos ON galerie_bar.photos_id_photo = photos.id_photo
	LEFT JOIN horaires ON  bars.id_bar = horaires.bars_id_bar
	WHERE bars.id_bar = '$id'
	");

	$delete->execute();

	$delete2 = $bdd->prepare("DELETE bars
	FROM  bars
	WHERE bars.id_bar = '$id'
	");

	//Et la tu rediriges vers ta page contacts.php pour rafraichir la liste

	if ($delete2->execute()) {
		echo "les données ont bien été supprimées";
	};
	?>

	<?php
}
?>


