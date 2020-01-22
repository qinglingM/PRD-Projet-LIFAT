<?php
/**
 * @var AppView $this
 * @var Equipe $equipe
 */

use App\Model\Entity\Equipe;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Membres'), ['controller' => 'Membres', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Membre'), ['controller' => 'Membres', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Equipes Responsables'), ['controller' => 'EquipesResponsables', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipes Responsable'), ['controller' => 'EquipesResponsables', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="equipes form large-9 medium-8 columns content">
	<?= $this->Form->create($equipe) ?>
	<fieldset>
		<legend><?= __('Add Equipe') ?></legend>
		<?php
		echo $this->Form->control('nom_equipe');
		echo $this->Form->control('responsable_id', ['options' => $membres, 'empty' => true]);
		echo $this->Form->control('projets._ids', ['options' => $projets]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
