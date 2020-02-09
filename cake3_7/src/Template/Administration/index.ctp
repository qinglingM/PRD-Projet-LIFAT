

<h2>Administration</h2>

<?php
		// $projets = $this->Html->link('Projets', array('controller' => 'projets', 'action' => 'index'));
		// $equipes = $this->Html->link('Equipes', array('controller' => 'equipes', 'action' => 'index'));
		// $motifs = $this->Html->link('Motifs', array('controller' => 'motifs', 'action' => 'index'));
		// $matricules = $this->Html->link('Matricules', array('controller' => 'users', 'action' => 'editMatricule'));
		// $loginCas = $this->Html->link('Identifiant CAS/ENT', array('controller' => 'users', 'action' => 'editLoginCas'));
		// $lieux = $this->Html->link('Lieux', array('controller' => 'lieux', 'action' => 'index'));
		// $mail = $this->Html->link('Configuration mail', array('controller' => 'administration', 'action' => 'mail'));
		// $utilisateurs = $this->Html->link('Utilisateurs', array('controller' => 'users', 'action' => 'administration'));

		$projets = $this->Html->link('Projets', ['controller' => 'projets', 'action' => 'index']);
		$equipes = $this->Html->link('Equipes', ['controller' => 'equipes', 'action' => 'index']);
		$motifs = $this->Html->link('Motifs', ['controller' => 'motifs', 'action' => 'index']);
		$theses = $this->Html->link('Theses', ['controller' => 'theses', 'action' => 'index']);
		$lieuTravails = $this->Html->link('LieuTravails', ['controller' => 'lieuTravails', 'action' => 'index']);
		$financements = $this->Html->link('Financements', ['controller' => 'financements', 'action' => 'index']);
		$export = $this->Html->link('Export', ['controller' => 'export', 'action' => 'index']);
		$fichiers = $this->Html->link('Fichiers', ['controller' => 'fichiers', 'action' => 'index']);
		$lieus = $this->Html->link('Lieus', ['controller' => 'lieus', 'action' => 'index']);
		$mail = $this->Html->link('Configuration Mail', ['controller' => 'administration', 'action' => 'mail']);
		// $utilisateurs = $this->Html->link('Utilisateurs', ['controller' => 'membres', 'action' => 'administration']);
		$membres = 	$this->Html->link('Membres', ['controller' => 'membres', 'action' => 'index']);

	$listAdmin = array(
		'| Missions ' => array(
			$projets,
			$equipes,
			$motifs,
			$lieus,
			),
		'| Laboratoire ' =>array(
			$theses,
			$lieuTravails,
			$financements,
			$membres.' (Rôles, Activité du compte, Visualisation du profil, Mot de passe)'
		),
		' | Paramètres serveur | ' => array(
				$mail)
		// $membres.' (Rôles, Activité du compte, Visualisation du profil)',
		// $mail
		);

	// $listSecretary = array(
	// 	'Missions :' => array(
	// 	$projets,
	// 	$equipes,
	// 	$motifs,
	// 	$lieus,
	// 	),
	// 	'Laboratoire : ' =>array(
	// 		$theses,
	// 		$lieuTravails,
	// 		$financements,
	// 		$membres.' (Rôles, Activité du compte, Visualisation du profil, Mot de passe)'
	// 	),
	// 	'Paramètres serveur :' => array(
	// 		$mail)
	// 	);

	if ($user['role'] == 'admin' || $user['role'] == 'chef d\'equipe' || $user['role'] == 'secretaire') {
		echo $this->Html->nestedList($listAdmin);
	}
?>