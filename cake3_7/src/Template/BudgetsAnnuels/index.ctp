<?php
/**
 * @var AppView $this
 * @var BudgetsAnnuel[]|CollectionInterface $budgetsAnnuels
 */

use App\Model\Entity\BudgetsAnnuel;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<div class="budgetsAnnuels index large-9 medium-8 columns content">
	<h3><?= __('Budgets Annuels') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('projet_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('annee') ?></th>
			<th scope="col"><?= $this->Paginator->sort('budget') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($budgetsAnnuels as $budgetsAnnuel): ?>
			<tr>
				<td><?= $budgetsAnnuel->has('projet') ? $this->Html->link($budgetsAnnuel->projet->titre, ['controller' => 'Projets', 'action' => 'view', $budgetsAnnuel->projet->id]) : '' ?></td>
				<td><?= $this->Number->format($budgetsAnnuel->annee) ?></td>
				<td><?= $this->Number->format($budgetsAnnuel->budget) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Modifier'), ['action' => 'edit', $budgetsAnnuel->projet_id.'.'.$budgetsAnnuel->annee]) ?>
					<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $budgetsAnnuel->projet_id], ['confirm' => __('Confirmez la suppression de ce budget annuel ?', $budgetsAnnuel->projet_id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('début')) ?>
			<?= $this->Paginator->prev('< ' . __('précédent')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('suivant') . ' >') ?>
			<?= $this->Paginator->last(__('dernier') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}, {{current}} entrée(s) sur {{count}} au total')]) ?></p>
	</div>
</div>
