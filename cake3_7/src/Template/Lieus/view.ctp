<?php
/**
 * @var AppView $this
 * @var Lieus $lieus
 */

use App\Model\Entity\Lieus;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('Edit Lieus'), ['action' => 'edit', $lieus->id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Lieus'), ['action' => 'delete', $lieus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lieus->id)]) ?> </li>
		<li><?= $this->Html->link(__('List Lieus'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Lieus'), ['action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="lieus view large-9 medium-8 columns content">
	<h3><?= h($lieus->id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Nom Lieu') ?></th>
			<td><?= h($lieus->nom_lieu) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($lieus->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Est Dans Liste') ?></th>
			<td><?= $lieus->est_dans_liste ? __('Yes') : __('No'); ?></td>
		</tr>
	</table>
</div>
