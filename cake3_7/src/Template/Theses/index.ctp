<?php

use App\Model\Entity\Membre;
use App\Model\Entity\Theses;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var Theses[]|CollectionInterface $theses
 */
?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="theses index columns content">
	<h3><?= __('Thèses') ?><font size="+1">
			<?php
			if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
				//	Seuls les membres permanents (& admins) peuvent ajouter des thèses
				echo '[' . $this->Html->link(__('Nouvelle thèse'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('Sujet') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Type') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Date de début') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Date de fin') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Auteur') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Financement') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($theses as $theses): ?>
			<tr>
				<td><?= h($theses->sujet) ?></td>
				<td><?= h($theses->type) ?></td>
				<td><?= h($theses->date_debut) ?></td>
				<td><?= h($theses->date_fin) ?></td>
				<td><?= $theses->has('membre') ? $this->Html->link($theses->membre->nom . " " . $theses->membre->prenom, ['controller' => 'Membres', 'action' => 'view', $theses->membre->id]) : '' ?></td>
				<td><?= $theses->has('financement') ? $this->Html->link("Financement", ['controller' => 'Financements', 'action' => 'view', $theses->financement->id]) : 'Pas de financement' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'view', $theses->id]) ?>
					<?php
					if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
						//	Seuls les membres permanents (& admins) peuvent edit / delete les thèses
						echo $this->Html->link(__('Editer'), ['action' => 'edit', $theses->id]);
						echo ' ';
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $theses->id], ['confirm' => __('Confirmer la suppression de la thèse "{0}" ?', $theses->sujet)]);
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
			<?= $this->Paginator->prev('< ' . __('précédent')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('suivant') . ' >') ?>
			<?= $this->Paginator->last(__('dernier') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}, {{current}} entrée(s) sur {{count}} au total')]) ?></p>
	</div>
</div>
