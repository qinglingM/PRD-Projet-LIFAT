<div class="theses index large-9 medium-8 columns content">
	<h3><?= __('Theses') ?></h3>
	<table cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('sujet') ?></th>
			<th scope="col"><?= $this->Paginator->sort('type') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_debut') ?></th>
			<th scope="col"><?= $this->Paginator->sort('date_fin') ?></th>
			<th scope="col"><?= $this->Paginator->sort('autre_info') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($Theses as $thesis): ?>
			<tr>
				<td><?= $this->Number->format($thesis->id) ?></td>
				<td><?= h($thesis->sujet) ?></td>
				<td><?= h($thesis->type) ?></td>
				<td><?= h($thesis->date_debut) ?></td>
				<td><?= h($thesis->date_fin) ?></td>
				<td><?= h($thesis->autre_info) ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>