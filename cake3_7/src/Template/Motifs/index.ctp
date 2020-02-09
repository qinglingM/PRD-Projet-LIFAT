<?php
/**
 * @var AppView $this
 * @var Motif[]|CollectionInterface $motifs
 */

use App\Model\Entity\Motif;
use App\View\AppView;
use Cake\Collection\CollectionInterface; ?>
<!-- Barre de recherche -->
<?php
echo $this->element('searchbar');
?>
<!-- <div class="motifs index columns content "> -->
<div class = 'col s12 m8 l4 offset-m4 offset-l8'>
	<h3><?= __('Motifs') ?><font size="+1">
		</font></h3>
	<table cellpadding="0" cellspacing="0" style="margin: auto">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('nom_motif') ?></th>
			<th scope="col"><?= $this->Paginator->sort('est_dans_liste') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($motifs as $motif): ?>
			<tr>
				<td><?= $this->Number->format($motif->id) ?></td>
				<td><?= h($motif->nom_motif) ?></td>
				<td><?= h($motif->est_dans_liste) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $motif->id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $motif->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $motif->id], ['confirm' => __('Are you sure you want to delete # {0}?', $motif->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('first')) ?>
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<!-- <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p> -->
	</div>
</div>
