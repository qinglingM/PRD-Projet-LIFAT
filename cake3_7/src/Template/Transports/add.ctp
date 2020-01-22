<?php
/**
 * @var AppView $this
 * @var Transport $transport
 */

use App\Model\Entity\Transport;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Transports'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="transports form large-9 medium-8 columns content">
	<?= $this->Form->create($transport) ?>
	<fieldset>
		<legend><?= __('Add Transport') ?></legend>
		<?php
		echo $this->Form->control('type_transport');
		echo $this->Form->control('im_vehicule');
		echo $this->Form->control('pf_vehicule');
		echo $this->Form->control('missions._ids', ['options' => $missions]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
