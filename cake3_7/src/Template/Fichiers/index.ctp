<?php
/**
 * @var AppView $this
 * @var Fichier[]|CollectionInterface $fichiers
 */

use App\Model\Entity\Fichier;
use App\Model\Entity\Membre;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<div class="fichiers index large-9 medium-8 columns content">
	<h3><?= __('Fichiers') ?><font size="+1">
			<?php
			if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
				//	Seuls les membres permanents (& admins) peuvent ajouter des fichiers
				echo '[' . $this->Html->link(__('Envoyer un fichier'), ['action' => 'add']) . ']';
			}
			?>
		</font></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('nom') ?></th>
			<th scope="col"><?= $this->Paginator->sort('titre') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_upload') ?></th>
			<th scope="col"><?= $this->Paginator->sort('membre_id') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($fichiers as $fichier): ?>
			<tr>
				<td><?= $this->Html->link($fichier->nom, $uploadfolder . '/' . $fichier->nom) ?></td>
				<td><?= h($fichier->titre) ?></td>
				<td><?= h($fichier->date_upload) ?></td>
				<td><?= $fichier->has('membre') ? $this->Html->link($fichier->membre->nom, ['controller' => 'Membres', 'action' => 'view', $fichier->membre->id]) : '' ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Détails'), ['action' => 'view', $fichier->id]) ?>
					<?php
					if (($user['id'] === $fichier->membre->id && $user['permanent'] === true) || $user['role'] === Membre::ADMIN) {
						//	Seuls les membres permanents qui sont owner du fichier (& admins) peuvent edit / delete les fichiers
						echo $this->Html->link(__('Modifier'), ['action' => 'edit', $fichier->id]);
						echo ' ';
						echo $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $fichier->id], ['confirm' => __('Confirmer la suppression du fichier {0} ?', $fichier->nom)]);
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
