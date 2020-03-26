<?php $title = 'Login'; ?>
<title><?php echo $title; ?></title>
<h2>Connexion par mot de passe</h2>
<div class="login form">
	<fieldset>
		<?php
		echo $this->Form->create('Membre');
		echo $this->Form->control('email');
		echo $this->Form->control('passwd', ['label' => "Mot de passe"]);
		echo $this->Form->button('Connexion');
		echo $this->Form->end();
		?>
	</fieldset>
</div>

<hr>
<?php

$phpCAS = $this->Session->read('phpCAS');

if ($compteExistant || !isset($phpCAS['membre'])) {
	echo '<h2>'.$this->Html->link('Connexion par ENT/CAS',array('controller' => 'membres', 'action' => 'caslogin')).'</h2>';
} else {
	echo '<h2>Connexion par ENT/CAS</h2>';
}

if (isset($phpCAS['membre'])) {
	if ($compteExistant) {
		?>
		<p>Vous êtes actuellement identifié grâce au service CAS en tant que « <span class="italic"><?php echo $phpCAS['membre']?></span> », pour vous connecter simplement <span class="bold"><?php echo $this->Html->link('cliquez ici',array('controller' => 'membres', 'action' => 'caslogin')) ?></span>.</p>
		<?php
	} else {
		?>
		<p>Vous êtes actuellement identifié grâce au service CAS en tant que « <span class="italic"><?php echo $phpCAS['membre']?></span> ». Cependant, cet identifiant n'est associé à aucun compte. Si vous possédez déjà un compte, vous pouvez utiliser la "connexion par mot de passe", puis associer votre identifiant ENT dans votre profil.
		</p>
		<?php
	}
} else {
	?>
	<p>Si vous possédez un identifiant ENT/CAS, vous pouvez vous connecter avec celui-ci en <span class="bold"><?php echo $this->Html->link('cliquant ici',array('controller' => 'membres', 'action' => 'caslogin')) ?></span>.<br>
	Pour pouvoir vous connecter : votre identifiant doit avoir été associé avec votre compte de gestion des ordre de missions (Un message vous avertira, le cas échant).
	</p>
	<?php
}
?>

