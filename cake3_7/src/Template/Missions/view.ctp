<?php
/**
 * @var AppView $this
 * @var Mission $mission
 */

use App\Model\Entity\Mission;
use App\View\AppView;?>

<div class="col s12 m8 l4 offset-m4 offset-l8">
	<h3><?=h($mission->id)?></h3>
	<table class="vertical-table" style="margin: auto">
		<tr>
			<th scope="row"><?=__('Complement Motif')?></th>
			<td><?=h($mission->complement_motif)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Etat')?></th>
			<td><?=h($mission->etat)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Projet')?></th>
			<td><?=$mission->has('projet') ? $this->Html->link($mission->projet->titre, ['controller' => 'Projets', 'action' => 'view', $mission->projet->id]) : ''?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Lieus')?></th>
			<td><?=$mission->has('lieus') ? $this->Html->link($mission->lieus->nom_lieu, ['controller' => 'Lieus', 'action' => 'view', $mission->lieus->id]) : ''?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Motif')?></th>
			<td><?=$mission->has('motif') ? $this->Html->link($mission->motif->nom_motif, ['controller' => 'Motifs', 'action' => 'view', $mission->motif->id]) : ''?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Id')?></th>
			<td><?=$this->Number->format($mission->id)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Nb Nuites')?></th>
			<td><?=$this->Number->format($mission->nb_nuites)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Nb Repas')?></th>
			<td><?=$this->Number->format($mission->nb_repas)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Date Depart')?></th>
			<td><?=h($mission->date_depart)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Date Retour')?></th>
			<td><?=h($mission->date_retour)?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Sans Frais')?></th>
			<td><?=$mission->sans_frais ? __('Yes') : __('No');?></td>
		</tr>
		<tr>
			<th scope="row"><?=__('Billet Agence')?></th>
			<td><?=$mission->billet_agence ? __('Yes') : __('No');?></td>
		</tr>
	</table>
	<div class="row">
		<h4><?=__('Commentaire Transport')?></h4>
		<?=$this->Text->autoParagraph(h($mission->commentaire_transport));?>
	</div>
	<div class="related">
		<h4><?=__('Related Transports')?></h4>
		<?php if (!empty($mission->transports)): ?>
			<table cellpadding="0" cellspacing="0" style="margin: auto">
				<tr>
					<th scope="col"><?=__('Id')?></th>
					<th scope="col"><?=__('Type Transport')?></th>
					<th scope="col"><?=__('Im Vehicule')?></th>
					<th scope="col"><?=__('Pf Vehicule')?></th>
					<th scope="col" class="actions"><?=__('Actions')?></th>
				</tr>
				<?php foreach ($mission->transports as $transports): ?>
					<tr>
						<td><?=h($transports->id)?></td>
						<td><?=h($transports->type_transport)?></td>
						<td><?=h($transports->im_vehicule)?></td>
						<td><?=h($transports->pf_vehicule)?></td>
						<td class="actions">
							<?=$this->Html->link(__('View'), ['controller' => 'Transports', 'action' => 'view', $transports->id])?>
							<?=$this->Html->link(__('Edit'), ['controller' => 'Transports', 'action' => 'edit', $transports->id])?>
							<?=$this->Form->postLink(__('Delete'), ['controller' => 'Transports', 'action' => 'delete', $transports->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transports->id)])?>
						</td>
					</tr>
				<?php endforeach;?>
			</table>
		<?php endif;?>
	</div>
</div>
