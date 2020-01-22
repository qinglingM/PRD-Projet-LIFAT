<?php
/**
 * @var AppView $this
 * @var EquipesProjet[]|CollectionInterface $equipesProjets
 */

use App\Model\Entity\EquipesProjet;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Equipes Projet'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Projets'), ['controller' => 'Projets', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Projet'), ['controller' => 'Projets', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="equipesProjets index large-9 medium-8 columns content">
	<h3><?= __('Equipes Projets') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('equipe_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('projet_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($equipesProjets as $equipesProjet): ?>
			<tr>
				<td><?= $equipesProjet->has('equipe') ? $this->Html->link($equipesProjet->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $equipesProjet->equipe->id]) : '' ?></td>
				<td><?= $equipesProjet->has('projet') ? $this->Html->link($equipesProjet->projet->id, ['controller' => 'Projets', 'action' => 'view', $equipesProjet->projet->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $equipesProjet->equipe_id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipesProjet->equipe_id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $equipesProjet->equipe_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipesProjet->equipe_id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('first')) ?>
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>
</div>
