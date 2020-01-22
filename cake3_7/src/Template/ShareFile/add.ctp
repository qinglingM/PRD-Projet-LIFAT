<?php
/**
 * @var ShareFileForm $shareFile
 */

use App\Form\ShareFileForm; ?>
<div class="theses form large-9 medium-8 columns content">
	<?= $this->Form->create($shareFile, ['type' => 'file']) ?>
	<fieldset>
		<legend><?= __('Partager un fichier PDF (<10Mo)') ?></legend>
		<?php
		echo $this->Form->control('nomfichier', ['type' => 'file']);
		?>
	</fieldset>
	<?= $this->Form->button(__('Envoyer')) ?>
	<?= $this->Form->end() ?>
</div>