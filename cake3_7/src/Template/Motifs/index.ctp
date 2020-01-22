<?php
/**
 * @var AppView $this
 * @var Motif[]|CollectionInterface $motifs
 */

use App\Model\Entity\Motif;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Motif'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="motifs index large-9 medium-8 columns content">
	<h3><?= __('Motifs') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('nom_motif') ?></th>
			<th scope="col"><?= $this->Paginator->sort('est_dans_liste') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($motifs as $motif): ?>
			<tr>
				<td><?= $this->Number->format($motif->id) ?></td>
				<td><?= h($motif->nom_motif) ?></td>
				<td><?= h($motif->est_dans_liste) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $motif->id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $motif->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $motif->id], ['confirm' => __('Are you sure you want to delete # {0}?', $motif->id)]) ?>
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
