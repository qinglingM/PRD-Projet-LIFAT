<?php
/**
 * @var AppView $this
 * @var Mission[]|CollectionInterface $missions
 */

use App\Model\Entity\Membre;
use App\Model\Entity\Mission;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<div class="col s12 m8 l4 offset-m4 offset-l8">
	<h3><?= __('Liste des Ordres de Missions validées') ?> <font size="+1">
		</font></h3>
	<table cellpadding="0" cellspacing="0" style="margin: auto">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('N°') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Nom') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Prenom') ?></th>
            <th scope="col"><?= $this->Paginator->sort('Email') ?></th>
            <th scope="col"><?= $this->Paginator->sort('Motif') ?></th>
            <th scope="col"><?= $this->Paginator->sort('Lieu') ?></th>
            <th scope="col"><?= $this->Paginator->sort('Date départ') ?></th>
			<th scope="col"><?= $this->Paginator->sort('Date retour') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
        <?php if(!empty($missions)){ ?>
		<?php foreach ($missions as $mission): ?>
			<tr>
				<td><?= h($this->Number->format($mission->id) )?></td>
                <td><?= $mission->has('membre') ? $mission->membre->nom : ''?></td>
                <td><?= $mission->has('membre') ? $mission->membre->prenom : '' ?></td>
				<td><?= $mission->has('membre') ? $mission->membre->email : '' ?></td>
				<td><?= $mission->has('motif') ? $mission->motif->nom_motif : '' ?></td>
				<td><?= $mission->has('lieus') ? $mission->lieus->nom_lieu : ''?></td>
				<td><?= h($mission->date_depart) ?></td>
				<td><?= h($mission->date_retour) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Details'), ['action' => 'generation', $mission->id]) ?>
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
	</div>
</div>

