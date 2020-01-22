<?php
/**
 * @var ExportForm $export
 */

use App\Form\ExportForm; ?>

<?php

$optionsGraphes = ['DEFAULT' => 'Aucun', 'EM5' => 'Graphique des effectifs par type', 'EM7' => 'Graphique des effectifs de doctorants par équipe',
	'EM9' => 'Graphique des effectifs par équipe', 'EM15' => 'Graphique doctorants par genre et nationalité',
	'EP1' => 'Graphique le nombre Publications de YY a YY',
	'EPA1' => 'Graphique Top 10 du nombre de projets associés à chaque mission par Année',
	'EMM1' => 'Graphique pourcentage du motif de mission par année',
	'ETEN1' => 'graphique tendance de recherche en 2010-2019 par domaine recherche'
	
];

$optionsListes = ['DEFAULT' => 'Aucun', 'EM1' => 'Liste des thèses pour un encadrant', 'EM2' => 'Liste des membres de chaques équipes',
	'EM3' => 'Liste des projets auxquels un encadrant participe', 'EM4' => 'Liste des doctorants',
	'EM6' => 'Liste des effectifs par type', 'EM8' => 'Liste des effectifs de doctorants par équipe',
	'EM10' => 'Liste des effectifs par équipe', 'ET1' => 'Liste des encadrant avec % d’encadrement par encadrant', 'ET2' => 'Liste des thèses par équipe',
	'ET3' => 'Liste des soutenances', 'ET4' => 'Liste des soutenances d’Habilitation à Diriger les Recherches',
	'ET5' => 'Liste de soutenance par années', 'ET6' => 'Liste des thèses par type',
	'ET7' => 'Liste des thèses en cours', 'EPr1' => 'Liste des projets par type',
	'EPr2' => 'Liste des projets par équipe', 'EPr3' => 'Liste des projets par membre',
	'EPr4' => 'Liste des budgets par projet',
	'EMi1' => 'Liste toutes missions par année',

];

$optionsRapportAnnuel = ['DEFAULT' => '2019'];

$optionsEncadrants = array();
foreach ($encadrants as $encadrant) {
	$optionsEncadrants += [$encadrant->id => $encadrant->nom . ' ' . $encadrant->prenom];
}

$optionsEquipes = array();
foreach ($equipes as $equipe) {
	$optionsEquipes += [$equipe->id => $equipe->nom_equipe];
}

$optionsMembres = array();
foreach ($membres as $membre) {
	$optionsMembres += [$membre->id => $membre->nom . ' ' . $membre->prenom];
}
?>

<script type="text/javascript">
	//JS function used to hide or show different inputs based on what export is selected in the form.
	function toggleOptions() {
		//The export selected needs an "Encadrant" input
		if (document.getElementById('typeListe').value === 'EM1' || document.getElementById('typeListe').value === 'EM3') {
			document.getElementById('hiddenYear').style.display = 'none';
			document.getElementById('hiddenEncadrant').style.display = '';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}
		//The export selected needs an "Equipe" input
		else if (document.getElementById('typeListe').value === 'ET2') {
			document.getElementById('hiddenYear').style.display = 'none';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = '';
			document.getElementById('hiddenMembres').style.display = 'none';
		}
		//The export selected needs an "Year" input
		else if (document.getElementById('typeListe').value === 'EMi1' ||document.getElementById('typeGraphe').value === 'EPA1') {
			document.getElementById('hiddenYear').style.display = '';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}
		//The export selected needs an "Year" input
		else if (document.getElementById('typeGraphe').value === 'EMM1' ) {
			document.getElementById('hiddenYear').style.display = '';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}


		else if (document.getElementById('typeGraphe').value === 'EP1') {
			document.getElementById('hiddenYear').style.display = '';
			//document.getElementById('hiddenYear').style.display = '';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}


		//The export selected needs an "Year" input
		else if (document.getElementById('typeListe').value === 'ET5') {
			document.getElementById('hiddenYear').style.display = '';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}
		//The export selected nedds an "Membre" input
		else if (document.getElementById('typeListe').value === 'EPr3') {
			document.getElementById('hiddenYear').style.display = 'none';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = '';
		}
		//no other inputs needed
		else {
			document.getElementById('hiddenYear').style.display = 'none';
			document.getElementById('hiddenEncadrant').style.display = 'none';
			document.getElementById('hiddenEquipe').style.display = 'none';
			document.getElementById('hiddenMembres').style.display = 'none';
		}
	}
</script>

<h3><?= h("Menu d'export de graphiques et de listes") ?> </h3>
<div>
	<?php
	echo $this->Form->create($export, ['url' => ['action' => 'results']]);
	echo $this->Form->control('exportGraphe', ['label' => 'Export Graphique']);
	echo $this->Form->control('exportListe');
	echo $this->Form->control('exportRapportAnnuel');
	echo $this->Form->select('typeGraphe', $optionsGraphes, array('id' => 'typeGraphe', 'onchange' => "toggleOptions()"));
	echo $this->Form->select('typeListe', $optionsListes, array('id' => 'typeListe', 'onchange' => "toggleOptions()"));
	echo $this->Form->select('typeRapportAnnuel', $optionsRapportAnnuel, array('id' => 'typeRapportAnnuel', 'onchange' => "toggleOptions()"));

	?>
	<div id="hiddenEncadrant" style="display:none;">
		<?php
		echo $this->Form->select('encadrant', $optionsEncadrants);
		?>
	</div>
	<div id="hiddenEquipe" style="display:none;">
		<?php
		echo $this->Form->select('equipe', $optionsEquipes);
		?>
	</div>
	<div id="hiddenMembres" style="display:none;">
		<?php
		echo $this->Form->select('membre', $optionsMembres);
		?>
	</div>
	<div id="hiddenYear" style="display:none;">
		<?php
		echo $this->Form->year('annee', ['minYear' => 2000, 'maxYear' => date('Y')]);
		?>
	</div>
	<?php
	echo $this->Form->button('Valider');
	echo $this->Form->end();
	?>
</div>