<?php
echo $this->Session->flash('email');
echo $this->Session->flash(); 
?>

<h2>Ordre de Missions à valider</h2>

<div class="note"> En cliquant sur valider, la mission sera transmise au secrétariat du LI.</div>

<table id="listMissionValidation" class="display cell-border">
	<thead>
		<tr>
			<th>N°</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Motif</th>
			<th>Lieu</th>
			<th class="tableDate">Départ</th>
			<th class="tableDate">Arrivée</th>
			<th>Etat</th>
			<th class="nosort">Editer</th>
			<th class="nosort">Visualiser</th>
			<th class="nosort">Valider</th>
		</tr>
	</thead>
<?php

$i=0;
foreach($missions as $mission) {
	//line creation
	$line = array(
		$this->Html->link($mission['Mission']['id'], array('controller' => 'missions', 'action' => 'edit', $mission['Mission']['id'])),
		$mission['User']['name'],
		$mission['User']['first_name'],
		$mission['Motif']['nom_motif'],
		$mission['Lieu']['nom_lieu'],
		date("d/m/Y", strtotime($mission['Mission']['date_d'])),
		date("d/m/Y", strtotime($mission['Mission']['date_r']))
		);

	switch($mission['Mission']['etat']) {
		case "en_cours":
			array_push($line, 'En cours');
			break;
		case "soumis":
			array_push($line, 'Soumis');
			break;
		case "valide":
			array_push($line, 'Validé');
			break;
	}

	array_push($line, $this->Html->link('Editer', array('controller' => 'missions', 'action' => 'edit', $mission['Mission']['id'])) ); 
	array_push($line, $this->Html->link('Visualiser', array('controller' => 'missions', 'action' => 'generation', $mission['Mission']['id'] ), array('target' => '_blank')) );
	array_push($line, $this->Html->link(
		'Valider',
		array('controller' => 'missions', 'action' => 'valid', $mission['Mission']['id']),
		array('class' => 'open-popup',
			'data-mfp-src' => '#popupValidation'.$mission['Mission']['id']
			)
		)
	); 
	echo $this->Html->tableCells($line);
}

?>
</table>

<?php foreach ($missions as $mission) {
	?>
	<div id="popupValidation<?php echo $mission['Mission']['id'] ?>" class="popup mfp-hide">
		<p>Êtes vous sûr de vouloir valider cette mission ?</p>
		<?php
		echo $this->Form->create('Mission',array('controller' => 'missions', 'action'=> 'valid/'.$mission['Mission']['id']));
		echo $this->Form->input('id', array('type' => 'hidden', 'value' => $mission['Mission']['id']));
		echo $this->Form->end('Oui');
		?>
		<button class="button-non">Non</button>
	</div>
	<?php
	}
	?>

<!--?php  echo $this->Html->link('nouvelle mission',array('controller' => 'missions', 'action' => 'edit')); ?-->

