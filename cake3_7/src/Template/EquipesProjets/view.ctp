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
		<li><?= $this->Html->link(__('Edit Equipes Projet'), ['action' => 'edit', $equipesProjet->equipe_id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Equipes Projet'), ['action' => 'delete', $equipesProjet->equipe_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipesProjet->equipe_id)]) ?> </li>
		<li><?= $this->Html->link(__('List Equipes Projets'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Equipes Projet'), ['action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="equipesProjets view large-9 medium-8 columns content">
	<h3><?= h($equipesProjet->equipe_id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Equipe') ?></th>
			<td><?= $equipesProjet->has('equipe') ? $this->Html->link($equipesProjet->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $equipesProjet->equipe->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Projet') ?></th>
			<td><?= $equipesProjet->has('projet') ? $this->Html->link($equipesProjet->projet->id, ['controller' => 'Projets', 'action' => 'view', $equipesProjet->projet->id]) : '' ?></td>
		</tr>
	</table>
</div>
