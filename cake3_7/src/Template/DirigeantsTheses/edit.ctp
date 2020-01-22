<?php
/**
 * @var AppView $this
 * @var DirigeantsThesis $dirigeantsThesis
 */

use App\Model\Entity\DirigeantsThesis;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $dirigeantsThesis->dirigeant_id],
				['confirm' => __('Are you sure you want to delete # {0}?', $dirigeantsThesis->dirigeant_id)]
			)
			?></li>
		<li><?= $this->Html->link(__('List Dirigeants Theses'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Dirigeants'), ['controller' => 'Dirigeants', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Dirigeant'), ['controller' => 'Dirigeants', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Theses'), ['controller' => 'Theses', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Thesis'), ['controller' => 'Theses', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="dirigeantsTheses form large-9 medium-8 columns content">
	<?= $this->Form->create($dirigeantsThesis) ?>
	<fieldset>
		<legend><?= __('Edit Dirigeants Thesis') ?></legend>
		<?php
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
