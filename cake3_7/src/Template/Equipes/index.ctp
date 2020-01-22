<?php
/**
 * @var AppView $this
 * @var Equipe[]|CollectionInterface $equipes
 */

use App\Model\Entity\Equipe;
use App\Model\Entity\Membre;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="equipes index large-9 medium-8 columns content">
	<h3><?= __('Equipes') ?><font size="+1">
			<?php
			if ($user['role'] === Membre::ADMIN) {
				//	Seuls les admins peuvent ajouter des équipes
				echo '[' . $this->Html->link(__('Nouvelle équipe'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('nom_equipe') ?></th>
			<th scope="col"><?= $this->Paginator->sort('responsable_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($equipes as $equipe): ?>
			<tr>
				<td><?= h($equipe->nom_equipe) ?></td>
				<td><?= $equipe->has('membre') ? $this->Html->link($equipe->membre->nom . " " . $equipe->membre->prenom, ['controller' => 'Membres', 'action' => 'view', $equipe->membre->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'view', $equipe->id]) ?>
					<?php
					if ($user['role'] === Membre::ADMIN) {
						//	Seuls les admins peuvent edit / delete des équipes
						echo $this->Html->link(__('Editer'), ['action' => 'edit', $equipe->id]);
						echo ' ';
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $equipe->id], ['confirm' => __('Confirmer la suppression de l\'équipe "{0}"?', $equipe->nom_equipe)]);
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
