<?php
/**
 * @var AppView $this
 * @var Theses $theses
 */

use App\Model\Entity\Theses;
use App\View\AppView; ?>
<div class="theses form large-9 medium-8 columns content">
	<?= $this->Form->create($theses) ?>
	<fieldset>
		<legend><?= __('Editer une thèse') ?></legend>
		<?php
		echo $this->Form->control('sujet');
		echo $this->Form->control('type');
		echo $this->Form->control('date_debut', ['empty' => true, 'type' => 'date', 'minYear' => 1950, 'maxYear' => 2050]);
		echo $this->Form->control('date_fin', ['empty' => true, 'minYear' => 1950, 'maxYear' => 2050]);
		echo $this->Form->control('est_hdr', ['empty' => true]);
		echo $this->Form->control('autre_info');
		echo $this->Form->control('auteur_id', ['options' => $membres, 'empty' => true]);
		echo $this->Form->control('dirigeants._ids', ['options' => $membres]);
		echo $this->Form->control('encadrants._ids', ['options' => $membres]);
		echo $this->Form->control('financement_id', ['options' => $financements, 'empty' => true]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Envoyer')) ?>
	<?= $this->Form->end() ?>
</div>