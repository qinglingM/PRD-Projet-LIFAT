<?php
/**
 * @var AppView $this
 * @var Equipe $equipe
 */

use App\Model\Entity\Equipe;
use App\View\AppView; ?>
<div class="equipes form large-9 medium-8 columns content">
	<?= $this->Form->create($equipe) ?>
	<fieldset>
		<legend><?= $equipe->id == 0 ? __('Ajout d\'une equipe') : __('Edition d\'une equipe'); ?></legend>
		<?php
		echo $this->Form->control('nom_equipe', ['label' => 'Nom']);
		echo $this->Form->control('responsable_id', ['options' => $membres, 'empty' => true]);
		echo $this->Form->control('projets._ids', ['options' => $projets]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Envoyer')) ?>
	<?= $this->Form->end() ?>
</div>
