<?php
/**
 * @var AppView $this
 * @var EquipesResponsable $equipesResponsable
 */

use App\Model\Entity\EquipesResponsable;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Equipes Responsables'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Membres'), ['controller' => 'Membres', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Membre'), ['controller' => 'Membres', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="equipesResponsables form large-9 medium-8 columns content">
	<?= $this->Form->create($equipesResponsable) ?>
	<fieldset>
		<legend><?= __('Add Equipes Responsable') ?></legend>
		<?php
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
