<?php
$fichier = $this->get("nomFichier");
$fichierPNG = $this->get("nomGraphe");
$tableau = $this->get("tableau");
$entetes = $this->get("entetes");
$boolGraph = $this->get("boolGraphe");
$boolTableau = $this->get("boolTableau");
?>

<?php if ($boolGraph == true) { ?>
	<a style="color:white;text-decoration:none;"
	   href=<?php echo '/Projet-LIFAT/cake3_7/img/' . $fichierPNG; ?> download>
		<button>Export Image</button>
	</a>
<?php } ?>

<?php if ($boolGraph == true) {
	echo $this->Html->image($fichierPNG);
}
?>

<?php if ($boolTableau == true) { ?>
	<form method="get" action=<?php echo '/Projet-LIFAT/cake3_7/' . $fichier; ?>>
		<button type="submit">Export CSV</button>
	</form>

	<table>
		<tr>
			<?php
			foreach ($entetes as $key => $row) {
				echo '<th>' . $row . '</th>';
			}
			?>
		</tr>
		<?php
		foreach ($tableau as $key => $row) {
			echo '<tr>';
			foreach ($tableau[$key] as $cle => $col) {
				echo '<td>' . $tableau[$key][$cle] . '</td>';
			}
			echo '</tr>';
		}
		?>
	</table>

<?php } ?>