<?php
/**
 * @var AppView $this
 * @var Financement $financement
 */

use App\Model\Entity\Financement;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Financements'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="financements form large-9 medium-8 columns content">
	<?= $this->Form->create($financement) ?>
	<fieldset>
		<legend><?= __('Add Financement') ?></legend>
		<?php
		echo $this->Form->control('international');
		echo $this->Form->control('nationalite_financement');
		echo $this->Form->control('financement_prive');
		echo $this->Form->control('financement');
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
