<?php
/**
 * @var AppView $this
 * @var BudgetsAnnuel $budgetsAnnuel
 */

use App\Model\Entity\BudgetsAnnuel;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Budgets Annuels'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="budgetsAnnuels form large-9 medium-8 columns content">
	<?= $this->Form->create($budgetsAnnuel) ?>
	<fieldset>
		<legend><?= __('Add Budgets Annuel') ?></legend>
		<?php
		echo $this->Form->control('budget');
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
