<?php echo $this->Session->flash('email'); ?>

<?php echo $this->Session->flash(); ?>

<h2>Administration</h2>

<?php
		$projets = $this->Html->link('Projets', array('controller' => 'projets', 'action' => 'index'));
		$equipes = $this->Html->link('Equipes', array('controller' => 'equipes', 'action' => 'index'));
		$motifs = $this->Html->link('Motifs', array('controller' => 'motifs', 'action' => 'index'));
		$matricules = $this->Html->link('Matricules', array('controller' => 'users', 'action' => 'editMatricule'));
		$loginCas = $this->Html->link('Identifiant CAS/ENT', array('controller' => 'users', 'action' => 'editLoginCas'));
		$lieux = $this->Html->link('Lieux', array('controller' => 'lieux', 'action' => 'index'));
		$mail = $this->Html->link('Configuration mail', array('controller' => 'administration', 'action' => 'mail'));
		$utilisateurs = $this->Html->link('Utilisateurs', array('controller' => 'users', 'action' => 'administration'));

	$listAdmin = array(
		$utilisateurs.' (Rôles, Activité du compte, Visualisation du profil)',
		$mail
		);

	$listSecretary = array(
		'Missions :' => array(
		$projets,
		$equipes,
		$motifs,
		$lieux,
		),
		'Utilisateurs :' => array(
			$utilisateurs.' (Rôles, Activité du compte, Visualisation du profil, Mot de passe)',
			$matricules,
			$loginCas),
		'Paramètres serveur :' => array(
			$mail)
		);

	if ($session->read('Auth.User.role') == 'admin') {
		echo $this->Html->nestedList($listAdmin);
	} else if ( $session->read('Auth.User.role') == 'secretary') {
		echo $this->Html->nestedList($listSecretary);
	}
?>