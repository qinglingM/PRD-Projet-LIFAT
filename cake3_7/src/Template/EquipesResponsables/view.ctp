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
		<li><?= $this->Html->link(__('Edit Equipes Responsable'), ['action' => 'edit', $equipesResponsable->equipe_id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Equipes Responsable'), ['action' => 'delete', $equipesResponsable->equipe_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipesResponsable->equipe_id)]) ?> </li>
		<li><?= $this->Html->link(__('List Equipes Responsables'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Equipes Responsable'), ['action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Membres'), ['controller' => 'Membres', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Membre'), ['controller' => 'Membres', 'action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="equipesResponsables view large-9 medium-8 columns content">
	<h3><?= h($equipesResponsable->equipe_id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Equipe') ?></th>
			<td><?= $equipesResponsable->has('equipe') ? $this->Html->link($equipesResponsable->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $equipesResponsable->equipe->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Membre') ?></th>
			<td><?= $equipesResponsable->has('membre') ? $this->Html->link($equipesResponsable->membre->id, ['controller' => 'Membres', 'action' => 'view', $equipesResponsable->membre->id]) : '' ?></td>
		</tr>
	</table>
</div>
