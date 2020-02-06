<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> -->

<!DOCTYPE html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>
		<?= $this->fetch('title') ?>
	</title>
	<?php

use App\Model\Entity\Membre;

?>

	<?php
	echo $this->Html->charset();
	echo $this->Html->css('jquery.dataTables.css');
	echo $this->Html->css('style.css');
	echo $this->Html->css('jquery.timepicker.css');
	echo $this->Html->css('datepicker3.css');
	echo $this->Html->css('chosen.min.css');
	echo $this->Html->css('magnific-popup.css');
	echo $this->Html->script('jquery-1.11.1.min.js');
	echo $this->Html->script('jquery.timepicker.js');
	echo $this->Html->script('bootstrap-datepicker.js');
	echo $this->Html->script('bootstrap-datepicker.fr.js');
	//echo $this->Html->script('jquery.datepair.min.js');
	echo $this->Html->script('jquery.dataTables.min.js');
	echo $this->Html->script('chosen.jquery.min.js');
	echo $this->Html->script('date-eu.js');
	echo $this->Html->script('jquery.magnific-popup.min.js');

	?> 


	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->css('base.css') ?>
	<?= $this->Html->css('style-ok.css') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>

<?= $this->Flash->render() ?>
<div id="main">
	<!-- Header -->
	<?php
	// titre du site (banniere)
	echo $this->Html->div('', null, array('id' => 'header'));
	echo $this->Html->link('<h1>LIFAT Manager</h1>', ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]);
	echo '</div>';
	?>

	<!-- // Navbar
	// // echo $this->element('navbar'); -->
	<?php
		if (!empty($user)) {
			echo '<div class="text-right">';
			echo "Connecté en tant que : " . $user['prenom'] . ' ' . $user['nom'] . ' (';
			if ($user['actif'] === true) {
				echo $user['role'];
				if ($user['permanent'] === true && $user['role'] != Membre::ADMIN) {
					echo " permanent";
				}
			} else {
				echo "Compte désactivé";
			}
			echo ") ";
			echo "</div>";
		}
	?>
	<?php
	//menu
	echo $this->Html->div('',null, array('id' => 'menu')); 
	
	$connexion = $this->Html->link('Connexion',['controller' => 'membres', 'action' => 'login']);
	$inscription = $this->Html->link('Inscription',['controller' => 'membres', 'action' => 'register']);
	$menuDeconnecte = array(
		$connexion,
		$inscription
	);

		if (!empty($user)) {
			//   <!--	Si user non connecté : il ne peut faire que Connexion et Inscription	-->
			if ($user['actif'] === true){

				
				
		// Définition des liens à afficher
		$accueil = $this->Html->link('Accueil',['controller' => 'pages', 'action' => 'home']);
		$profil = $this->Html->link('Mon Profil', ['controller' => 'membres', 'action' => 'view', $user['id']]);
		$missions = $this->Html->link('Mes Missions', ['controller' => 'missions', 'action' => 'index']);
		$missionsAValider = $this->Html->link('Mission à Valider', ['controller' => 'missions', 'action' => 'needValidation']);
		$missionsValides = $this->Html->link('Missions Validées', ['controller' => 'missions', 'action' => 'alreadyvalid']);
		$administration = $this->Html->link('Administration', ['controller' => 'administration', 'action' => 'index']);
		$deconnexion = $this->Html->link('Deconnexion', ['controller' => 'membres', 'action' => 'logout']);
		$connexion = $this->Html->link('Connexion',['controller' => 'membres', 'action' => 'login']);
		$inscription = $this->Html->link('Inscription',['controller' => 'membres', 'action' => 'register']);
		// $deconnexionCas = $this->Html->link('Déconnexion du service CAS',array('controller' => 'membres', 'action' => 'logoutCas'));

		// Liens de l'administration
		$projets = $this->Html->link('Projets', ['controller' => 'projets', 'action' => 'index']);
		$equipes = $this->Html->link('Equipes', ['controller' => 'equipes', 'action' => 'index']);
		$motifs = $this->Html->link('Motifs', ['controller' => 'motifs', 'action' => 'index']);
		$theses = $this->Html->link('Theses', ['controller' => 'theses', 'action' => 'index']);
		$lieuTravails = $this->Html->link('LieuTravails', ['controller' => 'lieuTravails', 'action' => 'index']);
		$financements = $this->Html->link('Financements', ['controller' => 'financements', 'action' => 'index']);
		$export = $this->Html->link('Export', ['controller' => 'export', 'action' => 'index']);
		$fichiers = $this->Html->link('Fichiers', ['controller' => 'fichiers', 'action' => 'index']);
		// $matricules = $this->Html->link('Matricules', ['controller' => 'membres', 'action' => 'editMatricule']);
		// $loginCas = $this->Html->link('Identifiant CAS/ENT', ['controller' => 'membres', 'action' => 'editLoginCas']);
		$lieus = $this->Html->link('Lieus', ['controller' => 'lieus', 'action' => 'index']);
		$mail = $this->Html->link('Configuration Mail', ['controller' => 'administration', 'action' => 'mail']);
		// $utilisateurs = $this->Html->link('Utilisateurs', ['controller' => 'membres', 'action' => 'administration']);
		$membres = 	$this->Html->link('Membres', ['controller' => 'membres', 'action' => 'index']);

		// Mise en place des menus en fonction du rôle
	
		$menuConnecte = array(
			$accueil,
			$missions,
			$export,
			$fichiers,
			$administration => array(
				$membres,
				$equipes,
				$projets,
				$motifs,
				$theses,
				$lieuTravails,
				$financements),
			$profil,
			$deconnexion
			);

		$menuAdmin = array(
			$accueil,
			$missions,
			$missionsAValider,
			$missionsValides,
			$administration => array(
				// $utilisateurs,
				$mail,
				$membres,
				$equipes,
				$projets,
				$motifs,
				$theses,
				$lieuTravails,
				$financements,	
			),
			$export,
			$fichiers,
			$profil,
			$deconnexion
			);

		$menuSecretary = array(
			$accueil,
			$missions,
			$missionsValides,
			$administration => array(
				$projets,
				$equipes,
				$motifs,
				$lieus,
				$membres,
				// $matricules,
				// $loginCas,
				$mail,
				$motifs,
				$theses,
				$lieuTravails,
				$financements,
				),
			$export,
			$fichiers,
			$profil,
			$deconnexion
			);

		// echo $user['id'];
		if (!empty( $user['id'])) {
			if ( $user['role'] === Membre::ADMIN) {
				echo $this->Html->nestedList($menuAdmin);
			} else if ( $user['role'] == Membre::SECRETAIRE) {
				echo $this->Html->nestedList($menuSecretary);
			} else {
				echo $this->Html->nestedList($menuConnecte);
			}
		} else {
				echo $this->Html->nestedList($menuDeconnecte);
		}
		 
		} else
			 echo $this->Html->nestedList($menuDeconnecte);
	}
	
	else{
		// echo $this->Html->div('', null, array('id' => 'menu'));
		// echo $connexion = $this->Html->link('Connexion',['controller' => 'membres', 'action' => 'login']);
		// echo $inscription = $this->Html->link('Inscription',['controller' => 'membres', 'action' => 'register']);
		// // <li class="nav-item"> $this->Html->link(__('Connexion'), ['controller' => 'membres', 'action' => 'login']) </li>
		// <li class="nav-item"><?= $this->Html->link(__('Inscription'), ['controller' => 'membres', 'action' => 'register']) </li>
		 echo $this->Html->nestedList($menuDeconnecte); 
	}
			 
	?>



	<!-- Contenu -->
	<div id="content">
		<div class="container clearfix">
			<?= $this->fetch('content') ?>
		</div>
	</div>

	<!-- Pied de page -->
	<?php
	echo $this->Html->div('', null, array('id' => 'footer'));
	echo $this->Html->para('', 'Site réalisé à l\'initiative du Laboratoire d\'Informatique de l\'université François Rabelais');
	echo '</div>';
	?>
</div>
</body>
</html>