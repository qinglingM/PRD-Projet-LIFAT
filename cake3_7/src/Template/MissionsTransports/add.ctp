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
		<li><?= $this->Html->link(__('List Missions Transports'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Transports'), ['controller' => 'Transports', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Transport'), ['controller' => 'Transports', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="missionsTransports form large-9 medium-8 columns content">
	<?= $this->Form->create($missionsTransport) ?>
	<fieldset>
		<legend><?= __('Add Missions Transport') ?></legend>
		<?php
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
