<?php
/**
 * @var AppView $this
 * @var Fichier $fichier
 */

use App\Model\Entity\Fichier;
use App\View\AppView; ?>
<div class="fichiers form large-9 medium-8 columns content">
	<?= $this->Form->create($fichier, ['type' => 'file']) ?>
	<fieldset>
		<legend><?= __('Ajouter un fichier PDF (<10Mo)') ?></legend>
		<?php
		echo $this->Form->control('nom', ['type' => 'file', 'accept' => 'application/pdf']);
		echo $this->Form->control('titre');
		echo $this->Form->control('description');
		echo $this->Form->control('membre_id', ['type' => 'hidden', 'value' => $user['id']]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Envoyer')) ?>
	<?= $this->Form->end() ?>
</div>
