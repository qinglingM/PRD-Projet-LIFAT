<?php
/**
 * @var AppView $this
 * @var MissionsTransport[]|CollectionInterface $missionsTransports
 */

use App\Model\Entity\MissionsTransport;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('New Missions Transport'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Transports'), ['controller' => 'Transports', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Transport'), ['controller' => 'Transports', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="missionsTransports index large-9 medium-8 columns content">
	<h3><?= __('Missions Transports') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('mission_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('transport_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($missionsTransports as $missionsTransport): ?>
			<tr>
				<td><?= $missionsTransport->has('mission') ? $this->Html->link($missionsTransport->mission->id, ['controller' => 'Missions', 'action' => 'view', $missionsTransport->mission->id]) : '' ?></td>
				<td><?= $missionsTransport->has('transport') ? $this->Html->link($missionsTransport->transport->id, ['controller' => 'Transports', 'action' => 'view', $missionsTransport->transport->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $missionsTransport->mission_id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $missionsTransport->mission_id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $missionsTransport->mission_id], ['confirm' => __('Are you sure you want to delete # {0}?', $missionsTransport->mission_id)]) ?>
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
