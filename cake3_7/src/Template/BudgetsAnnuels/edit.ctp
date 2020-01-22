<?php
/**
 * @var AppView $this
 * @var BudgetsAnnuel $budgetsAnnuel
 */

use App\Model\Entity\BudgetsAnnuel;
use App\View\AppView; ?>
<div class="budgetsAnnuels form large-9 medium-8 columns content">
	<?= $this->Form->create($budgetsAnnuel) ?>
	<fieldset>
		<legend><?= __('Changer le budget du projet '.$budgetsAnnuel->titre_projet.' pour l\'année '.$budgetsAnnuel->annee) ?></legend>
		<?php
		echo $this->Form->control('budget');
		?>
	</fieldset>
	<?= $this->Form->button(__('Sauvegarder')) ?>
	<?= $this->Form->end() ?>
</div>
