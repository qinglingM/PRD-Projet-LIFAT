<?php
/**
 * @var AppView $this
 * @var Mission[]|CollectionInterface $missions
 */

use App\Model\Entity\Mission;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>

<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>


<div class="projets index large-9 medium-8 columns content">
	<h3><?= __('Mes missions') ?> <font size="+1">
			<?php
			if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
				//	Seuls les membres permanents (& admins) peuvent ajouter des projets
				echo '[' . $this->Html->link(__('Nouveau mission'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('motif_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('lieu_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_depart') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_retour') ?></th>
			<th scope="col"><?= $this->Paginator->sort('etat') ?></th>

			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if(!empty($missions)){ ?>

		
		<?php foreach ($missions as $mission): ?>
			<tr>
				<td><?= $this->Number->format($mission->id) ?></td>
				<td><?= $mission->has('motif') ? $this->Html->link($mission->motif->nom_motif, ['controller' => 'Motifs', 'action' => 'view', $mission->motif->id]) : '' ?></td>
				<td><?= $mission->has('lieus') ? $this->Html->link($mission->lieus->nom_lieu, ['controller' => 'Lieus', 'action' => 'view', $mission->lieus->id]) : '' ?></td>

				<td><?= h($mission->date_depart) ?></td>
				<td><?= h($mission->date_retour) ?></td>
				<td><?= h($mission->etat) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'generation', $mission->id]) ?>
					<?= $this->Html->link(__('Modifier'), ['action' => 'edit', $mission->id]) ?>
					<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $mission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mission->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php } ?>
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


