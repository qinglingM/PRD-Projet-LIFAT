<?php
/**
 * @var AppView $this
 * @var LieuTravail $lieuTravail
 */

use App\Model\Entity\LieuTravail;
use App\Model\Entity\Membre;
use App\View\AppView; ?>
<div class="col s12 m8 l4 offset-m4 offset-l8">
	<h3><?= h("Lieu de travail") ?> <font size="+1">
			<?php
			if ($user['role'] === Membre::ADMIN) {
				//	Seuls les admins peuvent edit des lieux de travail
				echo '[' . $this->Html->link(__('Editer'), ['action' => 'edit', $lieuTravail->id]) . ']';
			}
			?>
		</font></h3>
	<table class="vertical-table" style="margin: auto">
		<tr>
			<th scope="row"><?= __('Nom du lieu de travail') ?></th>
			<td><?= h($lieuTravail->nom_lieu) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Ce lieu est dans la liste') ?></th>
			<td><?= $lieuTravail->est_dans_liste ? __('Oui') : __('Non'); ?></td>
		</tr>
	</table>
	<div class="related">
		<h4><?= __('Membres associés') ?></h4>
		<?php if (!empty($lieuTravail->membres)): ?>
			<table cellpadding="0" cellspacing="0" style="margin: auto">
				<tr>
					<th scope="col"><?= __('Role') ?></th>
					<th scope="col"><?= __('Nom') ?></th>
					<th scope="col"><?= __('Prenom') ?></th>
					<th scope="col"><?= __('Email') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
				</tr>
				<?php foreach ($lieuTravail->membres as $membres): ?>
					<tr>
						<td><?= h($membres->role) ?></td>
						<td><?= h($membres->nom) ?></td>
						<td><?= h($membres->prenom) ?></td>
						<td><?= h($membres->email) ?></td>
						<td class="actions">
							<?= $this->Html->link(__('Details'), ['controller' => 'Membres', 'action' => 'view', $membres->id]) ?>
							<?= $this->Html->link(__('Modifier'), ['controller' => 'Membres', 'action' => 'edit', $membres->id]) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>
