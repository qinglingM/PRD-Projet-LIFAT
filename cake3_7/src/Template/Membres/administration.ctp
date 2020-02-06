<?php echo $this->Session->flash('email'); ?>

<?php echo $this->Session->flash(); ?>

<h2>Administration utilisateurs</h2>

<div class="note">Vous pouvez accéder au profil d'un utilisateur en cliquant sur son identifiant (Vous pouvez modifier le mot de passe à partir de cette page).<br>
	Si un compte est "Actif", il sera affiché dans la liste présentée aux utilisateurs (lors du choix d'un passager).
</div>

<table id="listUsers" class="display cell-border">
	<thead>
		<tr>
			<th>N°</th>
			<th>E-Mail</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Equipe</th>
			<th>Rôle</th>
			<th>Actif</th>
		</tr>
	</thead>
	<?php

	foreach($users as $user) {
		//line creation
		$line = array(
			$this->Html->link($user['User']['id'], array('controller' => 'users', 'action' => 'viewProfil', $user['User']['id'])),
			$user['User']['email'],
			$user['User']['name'],
			$user['User']['first_name'],
			$user['Equipe']['nom_equipe']
			);
		switch ($user['User']['role']) {
			case "admin" :
			$role = "chef d'équipe"; 
			break;
			case "user" : 
			$role = "utilisateur"; 
			break;
			case "secretary" : 
			$role = "secrétaire"; 
			break;
		}
		$role = $role.' ('.$this->Html->link('modifier', array('controller' => 'users', 'action' => 'roleEdition', $user['User']['id'])).')';
		array_push($line, $role);

		if ($user['User']['actif'] == 1) {
			$estActif = 'Oui';
		} else {
			$estActif = 'Non';
		}

		$modifierActifLien = $this->Html->link('modifier', array('controller' => 'users', 'action' => 'actifEdition', $user['User']['id']));

		array_push($line, $estActif.' ('.$modifierActifLien.')');

		//print line
		echo $this->Html->tableCells($line);
	}

	?>

</table>


