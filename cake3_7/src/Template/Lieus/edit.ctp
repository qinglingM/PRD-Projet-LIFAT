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
		<li><?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $lieus->id],
				['confirm' => __('Are you sure you want to delete # {0}?', $lieus->id)]
			)
			?></li>
		<li><?= $this->Html->link(__('List Lieus'), ['action' => 'index']) ?></li>
	</ul>
</nav>
<div class="lieus form large-9 medium-8 columns content">
	<?= $this->Form->create($lieus) ?>
	<fieldset>
		<legend><?= __('Edit Lieus') ?></legend>
		<?php
		echo $this->Form->control('nom_lieu');
		echo $this->Form->control('est_dans_liste');
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
