<?php
/**
 * @var AppView $this
 * @var Projet $projet
 */

use App\Model\Entity\Projet;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Financements'), ['controller' => 'Financements', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Financement'), ['controller' => 'Financements', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="projets form large-9 medium-8 columns content">
	<?= $this->Form->create($projet) ?>
	<fieldset>
		<legend><?= __('Add Projet') ?></legend>
		<?php
		echo $this->Form->control('titre');
		echo $this->Form->control('description');
		echo $this->Form->control('type');
		echo $this->Form->control('budget');
		echo $this->Form->control('date_debut', ['empty' => true]);
		echo $this->Form->control('date_fin', ['empty' => true]);
		echo $this->Form->control('financement_id', ['options' => $financements, 'empty' => true]);
		echo $this->Form->control('equipes._ids', ['options' => $equipes]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
