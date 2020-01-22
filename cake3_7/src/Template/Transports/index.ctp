<?php
/**
 * @var AppView $this
 * @var Transport[]|CollectionInterface $transports
 */

use App\Model\Entity\Transport;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Transport'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="transports index large-9 medium-8 columns content">
	<h3><?= __('Transports') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('type_transport') ?></th>
			<th scope="col"><?= $this->Paginator->sort('im_vehicule') ?></th>
			<th scope="col"><?= $this->Paginator->sort('pf_vehicule') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($transports as $transport): ?>
			<tr>
				<td><?= $this->Number->format($transport->id) ?></td>
				<td><?= h($transport->type_transport) ?></td>
				<td><?= h($transport->im_vehicule) ?></td>
				<td><?= $this->Number->format($transport->pf_vehicule) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $transport->id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $transport->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transport->id)]) ?>
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
