<?php
/**
 * @var AppView $this
 * @var Projet $projet
 */

use App\Model\Entity\Projet;
use App\View\AppView; ?>
<div class="projets form large-9 medium-8 columns content">
	<?= $this->Form->create($projet) ?>
	<fieldset>
		<legend><?= $projet->id == 0 ? __('Ajout d\'un projet') : __('Edition d\'un projet'); ?></legend>
		<?php
		echo $this->Form->control('titre');
		echo $this->Form->control('description');
		echo $this->Form->control('type');
		echo $this->Form->control('budget');
		echo $this->Form->control('date_debut', ['empty' => true, 'minYear' => 1950, 'maxYear' => 2050]);
		echo $this->Form->control('date_fin', ['empty' => true, 'minYear' => 1950, 'maxYear' => 2050]);
		echo $this->Form->control('financement_id', ['options' => $financements, 'empty' => true]);
		echo $this->Form->control('equipes._ids', ['options' => $equipes]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Valider')) ?>
	<?= $this->Form->end() ?>
</div>
