<?php
/**
 * @var AppView $this
 * @var Motif $motif
 */

use App\Model\Entity\Motif;
use App\View\AppView; ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('Edit Motif'), ['action' => 'edit', $motif->id]) ?> </li>
		<li><?= $this->Form->postLink(__('Delete Motif'), ['action' => 'delete', $motif->id], ['confirm' => __('Are you sure you want to delete # {0}?', $motif->id)]) ?> </li>
		<li><?= $this->Html->link(__('List Motifs'), ['action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Motif'), ['action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Missions'), ['controller' => 'Missions', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Mission'), ['controller' => 'Missions', 'action' => 'add']) ?> </li>
	</ul>
</nav>
<div class="motifs view large-9 medium-8 columns content">
	<h3><?= h($motif->id) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Nom Motif') ?></th>
			<td><?= h($motif->nom_motif) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($motif->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Est Dans Liste') ?></th>
			<td><?= $motif->est_dans_liste ? __('Yes') : __('No'); ?></td>
		</tr>
	</table>
	<div class="related">
		<h4><?= __('Related Missions') ?></h4>
		<?php if (!empty($motif->missions)): ?>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th scope="col"><?= __('Id') ?></th>
					<th scope="col"><?= __('Complement Motif') ?></th>
					<th scope="col"><?= __('Date Depart') ?></th>
					<th scope="col"><?= __('Date Retour') ?></th>
					<th scope="col"><?= __('Sans Frais') ?></th>
					<th scope="col"><?= __('Etat') ?></th>
					<th scope="col"><?= __('Nb Nuites') ?></th>
					<th scope="col"><?= __('Nb Repas') ?></th>
					<th scope="col"><?= __('Billet Agence') ?></th>
					<th scope="col"><?= __('Commentaire Transport') ?></th>
					<th scope="col"><?= __('Projet Id') ?></th>
					<th scope="col"><?= __('Lieu Id') ?></th>
					<th scope="col"><?= __('Motif Id') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
				</tr>
				<?php foreach ($motif->missions as $missions): ?>
					<tr>
						<td><?= h($missions->id) ?></td>
						<td><?= h($missions->complement_motif) ?></td>
						<td><?= h($missions->date_depart) ?></td>
						<td><?= h($missions->date_retour) ?></td>
						<td><?= h($missions->sans_frais) ?></td>
						<td><?= h($missions->etat) ?></td>
						<td><?= h($missions->nb_nuites) ?></td>
						<td><?= h($missions->nb_repas) ?></td>
						<td><?= h($missions->billet_agence) ?></td>
						<td><?= h($missions->commentaire_transport) ?></td>
						<td><?= h($missions->projet_id) ?></td>
						<td><?= h($missions->lieu_id) ?></td>
						<td><?= h($missions->motif_id) ?></td>
						<td class="actions">
							<?= $this->Html->link(__('View'), ['controller' => 'Missions', 'action' => 'view', $missions->id]) ?>
							<?= $this->Html->link(__('Edit'), ['controller' => 'Missions', 'action' => 'edit', $missions->id]) ?>
							<?= $this->Form->postLink(__('Delete'), ['controller' => 'Missions', 'action' => 'delete', $missions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $missions->id)]) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>
