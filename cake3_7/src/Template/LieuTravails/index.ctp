<?php
/**
 * @var AppView $this
 * @var LieuTravail[]|CollectionInterface $lieuTravails
 */

use App\Model\Entity\LieuTravail;
use App\Model\Entity\Membre;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="col s12 m8 l4 offset-m4 offset-l8">
	<h3><?= __('Lieux de travail') ?> <font size="+1">
			<?php
			if ($user['role'] === Membre::ADMIN) {
				//	Seuls les admins peuvent ajouter des lieux de travail
				echo '[' . $this->Html->link(__('Nouveau lieu de travail'), ['action' => 'edit']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0" style="margin: auto">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('nom_lieu') ?></th>
			<th scope="col"><?= $this->Paginator->sort('est_dans_liste') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($lieuTravails as $lieuTravail): ?>
			<tr>
				<td><?= h($lieuTravail->nom_lieu) ?></td>
				<td><?= $lieuTravail->est_dans_liste ? h("Oui") : h("Non"); ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'view', $lieuTravail->id]) ?>
					<?php
					if ($user['role'] === Membre::ADMIN) {
						//	Seuls les admins peuvent edit / delete des lieux de travail
						echo $this->Html->link(__('Modifier'), ['action' => 'edit', $lieuTravail->id]);
						echo ' ';
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $lieuTravail->id], ['confirm' => __('Confirmer la suppression du lieu de travail {0} ?', $lieuTravail->nom_lieu)]);
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
		<!-- <p><?= $this->Paginator->counter(['format' => __('Page {{page}} sur {{pages}}, affiche {{current}} lieu de travail sur {{count}}')]) ?></p> -->
	</div>
</div>
