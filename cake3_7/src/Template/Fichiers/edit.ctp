<?php
/**
 * @var AppView $this
 * @var Fichier $fichier
 */

use App\Model\Entity\Fichier;
use App\View\AppView; ?>
<div class="fichiers form large-9 medium-8 columns content">
	<?= $this->Form->create($fichier) ?>
	<fieldset>
		<legend><?= __('Edit Fichier') ?></legend>
		<?php
		echo $this->Form->control('nom');
		echo $this->Form->control('titre');
		echo $this->Form->control('description');
		?>
	</fieldset>
	<?= $this->Form->button(__('Sauvegarder')) ?>
	<?= $this->Form->end() ?>
</div>
