<?php

use App\Model\Entity\Membre;
use App\View\AppView;

/**
 * @var AppView $this
 * @var Membre $membre
 */

$optionsGenre = [
	'H' => 'Homme',
	'F' => 'Femme'
];
?>
<div class="membres form large-9 medium-8 columns content">
	<div class="note">
		Votre compte utilisateur devra être validé par un administrateur avant d'être utilisé.
	</div>
	<?php $membre->passwd = "" ?>
	<?= $this->Form->create($membre) ?>
	<fieldset>
		<legend><?= $membre->id == 0 ? __('Formulaire d\'inscription') : __('Edition d\'un membre'); ?></legend>
		<?php
		echo $this->Form->hidden('role', ['value' => Membre::MEMBRE]);
		echo $this->Form->control('equipe_id', ['options' => $equipes, 'empty' => true]);
		echo $this->Form->control('nom');
		echo $this->Form->control('prenom');
		echo $this->Form->control('email', ['required' => true, 'label' => 'Email (requis)']);
		echo $this->Form->control('passwd', ['required' => true, 'label' => "Mot de passe (requis)"]);
		echo $this->Form->control('adresse_agent_1');
		echo $this->Form->control('adresse_agent_2');
		echo $this->Form->control('residence_admin_1');
		echo $this->Form->control('residence_admin_2');
		echo $this->Form->control('type_personnel');
		echo $this->Form->control('intitule');
		echo $this->Form->control('grade');
		echo $this->Form->control('im_vehicule');
		echo $this->Form->control('pf_vehicule');
		echo $this->Form->control('login_cas');
		echo $this->Form->control('carte_sncf');
		echo $this->Form->control('matricule');
		echo $this->Form->control('date_naissance', ['empty' => true, 'minYear' => 1901, 'maxYear' => 2019]);
		echo $this->Form->control('lieu_travail_id', ['options' => $lieuTravails, 'empty' => false, 'label' => "lieu de travail"]);
		echo $this->Form->control('nationalite');
		echo $this->Form->control('est_francais');
		echo $this->Form->select('genre', $optionsGenre);
		echo $this->Form->control('hdr');
		echo $this->Form->control('permanent', ['label' => "Membre permanent"]);
		echo $this->Form->control('est_porteur', ['label' => "Membre porteur"]);
		?>
	</fieldset>
	<?= $this->Form->hidden('actif', ['value' => false]) ?>
	<?= $this->Form->button(__('Valider')) ?>
	<?= $this->Form->end() ?>
</div>
