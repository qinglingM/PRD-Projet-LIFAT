<?php

use App\Model\Entity\Membre;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var Membre[]|CollectionInterface $membres
 */
?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="membres index index columns content">
	<h3><?= __('Membres du laboratoire') ?> <font size="+1">
			<?php if ($user['role'] === Membre::ADMIN) {
				//	Seul l'admin peut ajouter des membres avec l'action 'edit'
				echo '[' . $this->Html->link(__('Nouveau membre'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('role') ?></th>
			<th scope="col"><?= $this->Paginator->sort('nom') ?></th>
			<th scope="col"><?= $this->Paginator->sort('prenom') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_naissance') ?></th>
			<th scope="col"><?= $this->Paginator->sort('lieu_travail_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('equipe_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('hdr') ?></th>
			<th scope="col"><?= $this->Paginator->sort('permanent') ?></th>
			<th scope="col"><?= $this->Paginator->sort('est_porteur') ?></th>
			<th scope="col"><?= $this->Paginator->sort('actif') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($membres as $membre): ?>
			<tr>
				<td><?= h($membre->role) ?></td>
				<td><?= h($membre->nom) ?></td>
				<td><?= h($membre->prenom) ?></td>
				<td><?= h($membre->date_naissance) ?></td>
				<td><?= $membre->has('lieu_travail') ? $this->Html->link($membre->lieu_travail->nom_lieu, ['controller' => 'LieuTravails', 'action' => 'view', $membre->lieu_travail->id]) : '' ?></td>
				<td><?= $membre->has('equipe') ? $this->Html->link($membre->equipe->nom_equipe, ['controller' => 'Equipes', 'action' => 'view', $membre->equipe->id]) : '' ?></td>
				<td><?= $membre->hdr ? h("Oui") : h("Non"); ?></td>
				<td><?= $membre->permanent ? h("Oui") : h("Non"); ?></td>
				<td><?= $membre->est_porteur ? h("Oui") : h("Non"); ?></td>
				<td><?= $membre->actif ? h("Oui") : h("Non"); ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'view', $membre->id]) ?>
					<?= $this->Html->link(__('Modifier'), ['action' => 'edit', $membre->id]) ?>
					<!--	TODO : edit link only if $user can edit this member	-->
					<?php if ($user['role'] === Membre::ADMIN) {
						//	Seul l'admin peut supprimer des membres
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $membre->id], ['confirm' => __('Confirmer la suppression du membre {0} {1} ?', $membre->nom, $membre->prenom)]);
					} ?>
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
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}, affiche {{current}} membres sur {{count}}')]) ?></p>
	</div>
</div>
