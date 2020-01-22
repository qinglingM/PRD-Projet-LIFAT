<?php
/**
 * @var AppView $this
 * @var EncadrantsThesis $encadrantsThesis
 */

use App\Model\Entity\EncadrantsThesis;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('Edit Encadrants Thesis'), ['action' => 'edit', $encadrantsThesis->encadrant_id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Encadrants Thesis'), ['action' => 'delete', $encadrantsThesis->encadrant_id], ['confirm' => __('Are you sure you want to delete # {0}?', $encadrantsThesis->encadrant_id)]) ?> </li>
		<li><?= $this->Html->link(__('List Encadrants Theses'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Encadrants Thesis'), ['action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Encadrants'), ['controller' => 'Encadrants', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Encadrant'), ['controller' => 'Encadrants', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Theses'), ['controller' => 'Theses', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Thesis'), ['controller' => 'Theses', 'action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="encadrantsTheses view large-9 medium-8 columns content">
	<h3><?= h($encadrantsThesis->encadrant_id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Encadrant') ?></th>
			<td><?= $encadrantsThesis->has('encadrant') ? $this->Html->link($encadrantsThesis->encadrant->id, ['controller' => 'Encadrants', 'action' => 'view', $encadrantsThesis->encadrant->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Thesis') ?></th>
			<td><?= $encadrantsThesis->has('thesis') ? $this->Html->link($encadrantsThesis->thesis->id, ['controller' => 'Theses', 'action' => 'view', $encadrantsThesis->thesis->id]) : '' ?></td>
		</tr>
	</table>
</div>
