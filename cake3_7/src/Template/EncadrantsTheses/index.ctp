<?php
/**
 * @var AppView $this
 * @var EncadrantsThesis[]|CollectionInterface $encadrantsTheses
 */

use App\Model\Entity\EncadrantsThesis;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Encadrants Thesis'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Encadrants'), ['controller' => 'Encadrants', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Encadrant'), ['controller' => 'Encadrants', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Theses'), ['controller' => 'Theses', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Thesis'), ['controller' => 'Theses', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="encadrantsTheses index large-9 medium-8 columns content">
	<h3><?= __('Encadrants Theses') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('encadrant_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('these_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($encadrantsTheses as $encadrantsThesis): ?>
			<tr>
				<td><?= $encadrantsThesis->has('encadrant') ? $this->Html->link($encadrantsThesis->encadrant->id, ['controller' => 'Encadrants', 'action' => 'view', $encadrantsThesis->encadrant->id]) : '' ?></td>
				<td><?= $encadrantsThesis->has('thesis') ? $this->Html->link($encadrantsThesis->thesis->id, ['controller' => 'Theses', 'action' => 'view', $encadrantsThesis->thesis->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $encadrantsThesis->encadrant_id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $encadrantsThesis->encadrant_id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $encadrantsThesis->encadrant_id], ['confirm' => __('Are you sure you want to delete # {0}?', $encadrantsThesis->encadrant_id)]) ?>
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
