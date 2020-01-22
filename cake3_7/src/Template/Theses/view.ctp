<?php
/**
 * @var AppView $this
 * @var theses $theses
 */

use App\Model\Entity\Membre;
use App\Model\Entity\theses;
use App\View\AppView; ?>
<div class="theses view columns content">
	<h3><?= h($theses->sujet) ?> <font size="+1">
			<?php
			if ($user['permanent'] === true || $user['role'] === Membre::ADMIN) {
				//	Seuls les membres permanents (& admins) peuvent edit les thèses
				echo '[' . $this->Html->link(__('Editer'), ['action' => 'edit', $theses->id]) . ']';
			}
			?></font size></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Sujet') ?></th>
			<td><?= h($theses->sujet) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Type') ?></th>
			<td><?= h($theses->type) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Auteur') ?></th>
			<td><?= $theses->has('membre') ? $this->Html->link($theses->membre->nom . " " . $theses->membre->prenom, ['controller' => 'Membres', 'action' => 'view', $theses->membre->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date début') ?></th>
			<td><?= h($theses->date_debut) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date fin') ?></th>
			<td><?= h($theses->date_fin) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Autre Info') ?></th>
			<td><?= h($theses->autre_info) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Est HDR') ?></th>
			<td><?= $theses->est_hdr ? 'Oui' : 'Non' ?></td>
		</tr>
	</table>
	<div class="related">
		<h4><?= __('Dirigeant(s)') ?></h4>
		<?php if (!empty($theses->dirigeants)): ?>
			<table cellpadding="0" cellspacing="0">
				<?php foreach ($theses->dirigeants as $dirigeants): ?>
					<tr>
						<td class="actions">
							<?= $this->Html->link(__($dirigeants->nom . " " . $dirigeants->prenom), ['controller' => 'Membres', 'action' => 'view', $dirigeants->id]) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4><?= __('Encadrant(s)') ?></h4>
		<?php if (!empty($theses->encadrants)): ?>
			<table cellpadding="0" cellspacing="0">
				<?php foreach ($theses->encadrants as $encadrants): ?>
					<tr>
						<td class="actions">
							<?= $this->Html->link(__($encadrants->nom . " " . $encadrants->prenom), ['controller' => 'Membres', 'action' => 'view', $encadrants->id]) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4><?= __('Financement') ?></h4>
		<?= !empty($theses->financement) ? $this->Html->link('Détail du financement', ['controller' => 'Financements', 'action' => 'view', $theses->financement->id]) : 'Pas de financement' ?>
	</div>
</div>
