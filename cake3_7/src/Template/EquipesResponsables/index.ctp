<?php
/**
 * @var AppView $this
 * @var EquipesResponsable[]|CollectionInterface $equipesResponsables
 */

use App\Model\Entity\EquipesResponsable;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Equipes Responsable'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Membres'), ['controller' => 'Membres', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Membre'), ['controller' => 'Membres', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="equipesResponsables index large-9 medium-8 columns content">
	<h3><?= __('Equipes Responsables') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('equipe_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('responsable_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($equipesResponsables as $equipesResponsable): ?>
			<tr>
				<td><?= $equipesResponsable->has('equipe') ? $this->Html->link($equipesResponsable->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $equipesResponsable->equipe->id]) : '' ?></td>
				<td><?= $equipesResponsable->has('membre') ? $this->Html->link($equipesResponsable->membre->id, ['controller' => 'Membres', 'action' => 'view', $equipesResponsable->membre->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $equipesResponsable->equipe_id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipesResponsable->equipe_id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $equipesResponsable->equipe_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipesResponsable->equipe_id)]) ?>
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
