<?php
/**
 * @var AppView $this
 * @var Equipe $equipe
 */

use App\Model\Entity\Equipe;
use App\Model\Entity\Membre;
use App\View\AppView; ?>
<div class="equipes view large-9 medium-8 columns content">
	<h3><?= h($equipe->nom_equipe) ?><font size="+1">
			<?php
			if ($user['role'] === Membre::ADMIN) {
				//	Seuls les admins peuvent edit des équipes
				echo '[' . $this->Html->link(__('Editer'), ['action' => 'edit', $equipe->id]) . ']';
			}
			?>
		</font size></h3>
	<table class="vertical-table">
		<h4><?= __('Membres') ?></h4>
		<?php foreach ($equipe->membres as $membre): ?>
			<tr>
				<td><?= $this->Html->link($membre['nom'] . ' ' . $membre['prenom'], ['controller' => 'Membres', 'action' => 'view', $membre['id']]) ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="related">
		<h4><?= __('Projets associés') ?></h4>
		<?php if (!empty($equipe->projets)): ?>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th scope="col"><?= __('Titre') ?></th>
					<th scope="col"><?= __('Type') ?></th>
					<th scope="col"><?= __('Budget') ?></th>
					<th scope="col"><?= __('Date Debut') ?></th>
					<th scope="col"><?= __('Date Fin') ?></th>
					<th scope="col"><?= __('Financement') ?></th>
				</tr>
				<?php foreach ($equipe->projets as $projets): ?>
					<tr>
						<td><?= $this->Html->link($projets->titre, ['controller' => 'Projets', 'action' => 'Détails', $projets->id]) ?></td>
						<td><?= h($projets->type) ?></td>
						<td><?= h($projets->budget) ?></td>
						<td><?= h($projets->date_debut) ?></td>
						<td><?= h($projets->date_fin) ?></td>
						<td><?= $this->Html->link(__('Détails du financement'), ['controller' => 'Financements', 'action' => 'view', $projets->financement_id]) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4><?= __('Responsable d\'équipe') ?></h4>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td><?= $this->Html->link($equipe->equipes_responsables['nom'] . ' ' . $equipe->equipes_responsables['prenom'], ['controller' => 'Membres', 'action' => 'view', $equipe->equipes_responsables['id']]) ?></td>
			</tr>
		</table>
	</div>
</div>
