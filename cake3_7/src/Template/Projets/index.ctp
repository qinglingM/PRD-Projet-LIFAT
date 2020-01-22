<?php
/**
 * @var AppView $this
 * @var Projet[]|CollectionInterface $projets
 */

use App\Model\Entity\Membre;
use App\Model\Entity\Projet;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="projets index large-9 medium-8 columns content">
	<p><?= $this->Html->link('Liste des budgets annuels des projets', ['controller' => 'budgetsAnnuels', 'action' => 'index']) ?></p>
	<h3><?= __('Projets du laboratoire') ?> <font size="+1">
			<?php
			if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
				//	Seuls les membres permanents (& admins) peuvent ajouter des projets
				echo '[' . $this->Html->link(__('Nouveau projet'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('titre') ?></th>
			<th scope="col"><?= $this->Paginator->sort('type') ?></th>
			<th scope="col"><?= $this->Paginator->sort('budget') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_debut') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_fin') ?></th>
			<th scope="col"><?= $this->Paginator->sort('financement_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($projets as $projet): ?>
			<tr>
				<td><?= h($projet->titre) ?></td>
				<td><?= h($projet->type) ?></td>
				<td><?= $this->Number->format($projet->budget) ?></td>
				<td><?= h($projet->date_debut) ?></td>
				<td><?= h($projet->date_fin) ?></td>
				<td><?= $projet->has('financement') ? $this->Html->link('Voir financement', ['controller' => 'Financements', 'action' => 'view', $projet->financement->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'view', $projet->id]) ?>
					<?php
					if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
						//	Seuls les membres permanents (& admins) peuvent edit / delete les projets
						echo $this->Html->link(__('Modifier'), ['action' => 'edit', $projet->id]);
						echo ' ';
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $projet->id], ['confirm' => __('Etes-vous sûr de vouloir supprimer le projet "{0}" ?', $projet->titre)]);
					}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('début')) ?>
			<?= $this->Paginator->prev('< ' . __('précedente')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('suivante') . ' >') ?>
			<?= $this->Paginator->last(__('fin') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}, affiche {{current}} projet sur {{count}}')]) ?></p>
	</div>
</div>
