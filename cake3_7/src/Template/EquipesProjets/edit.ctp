<?php
/**
 * @var AppView $this
 * @var EquipesProjet $equipesProjet
 */

use App\Model\Entity\EquipesProjet;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $equipesProjet->equipe_id],
				['confirm' => __('Are you sure you want to delete # {0}?', $equipesProjet->equipe_id)]
			)
			?></li>
		<li><?= $this->Html->link(__('List Equipes Projets'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="equipesProjets form large-9 medium-8 columns content">
	<?= $this->Form->create($equipesProjet) ?>
	<fieldset>
		<legend><?= __('Edit Equipes Projet') ?></legend>
		<?php
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
