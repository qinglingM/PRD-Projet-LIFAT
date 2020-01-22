<?php
/**
 * @var AppView $this
 * @var DirigeantsThesis[]|CollectionInterface $dirigeantsTheses
 */

use App\Model\Entity\DirigeantsThesis;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Dirigeants Thesis'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Dirigeants'), ['controller' => 'Dirigeants', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Dirigeant'), ['controller' => 'Dirigeants', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Theses'), ['controller' => 'Theses', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Thesis'), ['controller' => 'Theses', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="dirigeantsTheses index large-9 medium-8 columns content">
	<h3><?= __('Dirigeants Theses') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('dirigeant_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('these_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($dirigeantsTheses as $dirigeantsThesis): ?>
			<tr>
				<td><?= $dirigeantsThesis->has('dirigeant') ? $this->Html->link($dirigeantsThesis->dirigeant->id, ['controller' => 'Dirigeants', 'action' => 'view', $dirigeantsThesis->dirigeant->id]) : '' ?></td>
				<td><?= $dirigeantsThesis->has('thesis') ? $this->Html->link($dirigeantsThesis->thesis->id, ['controller' => 'Theses', 'action' => 'view', $dirigeantsThesis->thesis->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $dirigeantsThesis->dirigeant_id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $dirigeantsThesis->dirigeant_id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dirigeantsThesis->dirigeant_id], ['confirm' => __('Are you sure you want to delete # {0}?', $dirigeantsThesis->dirigeant_id)]) ?>
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
