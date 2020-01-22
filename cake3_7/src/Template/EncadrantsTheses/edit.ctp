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
		<li><?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $encadrantsThesis->encadrant_id],
				['confirm' => __('Are you sure you want to delete # {0}?', $encadrantsThesis->encadrant_id)]
			)
			?></li>
		<li><?= $this->Html->link(__('List Encadrants Theses'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Encadrants'), ['controller' => 'Encadrants', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Encadrant'), ['controller' => 'Encadrants', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Theses'), ['controller' => 'Theses', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Thesis'), ['controller' => 'Theses', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="encadrantsTheses form large-9 medium-8 columns content">
	<?= $this->Form->create($encadrantsThesis) ?>
	<fieldset>
		<legend><?= __('Edit Encadrants Thesis') ?></legend>
		<?php
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
