<?php
/**
 * @var AppView $this
 * @var LieuTravail $lieuTravail
 */

use App\Model\Entity\LieuTravail;
use App\View\AppView; ?>
<div class="lieuTravails form large-9 medium-8 columns content">
	<?= $this->Form->create($lieuTravail) ?>
	<fieldset>
		<legend><?= $lieuTravail->id == 0 ? __('Ajout d\'un lieu de travail') : __('Edition d\'un lieu de travail'); ?></legend>
		<?php
		echo $this->Form->control('nom_lieu');
		echo $this->Form->control('est_dans_liste');
		?>
	</fieldset>
	<?= $this->Form->button(__('Valider')) ?>
	<?= $this->Form->end() ?>
</div>
