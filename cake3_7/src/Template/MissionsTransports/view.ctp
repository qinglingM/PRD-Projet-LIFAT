<?php
/**
 * @var AppView $this
 * @var MissionsTransport $missionsTransport
 */

use App\Model\Entity\MissionsTransport;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('Edit Missions Transport'), ['action' => 'edit', $missionsTransport->mission_id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Missions Transport'), ['action' => 'delete', $missionsTransport->mission_id], ['confirm' => __('Are you sure you want to delete # {0}?', $missionsTransport->mission_id)]) ?> </li>
		<li><?= $this->Html->link(__('List Missions Transports'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Missions Transport'), ['action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Transports'), ['controller' => 'Transports', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Transport'), ['controller' => 'Transports', 'action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="missionsTransports view large-9 medium-8 columns content">
	<h3><?= h($missionsTransport->mission_id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Mission') ?></th>
			<td><?= $missionsTransport->has('mission') ? $this->Html->link($missionsTransport->mission->id, ['controller' => 'Missions', 'action' => 'view', $missionsTransport->mission->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Transport') ?></th>
			<td><?= $missionsTransport->has('transport') ? $this->Html->link($missionsTransport->transport->id, ['controller' => 'Transports', 'action' => 'view', $missionsTransport->transport->id]) : '' ?></td>
		</tr>
	</table>
</div>
