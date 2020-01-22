<?php
/**
 * @var AppView $this
 * @var Fichier $fichier
 */

use App\Model\Entity\Fichier;
use App\View\AppView; ?>
<div class="fichiers view large-9 medium-8 columns content">
	<h3><?= h($fichier->nom) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Titre') ?></th>
			<td><?= h($fichier->titre) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Description') ?></th>
			<td><?= h($fichier->description) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Auteur de l\'upload') ?></th>
			<td><?= $fichier->has('membre') ? $this->Html->link($fichier->membre->nom, ['controller' => 'Membres', 'action' => 'view', $fichier->membre->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date d\'upload') ?></th>
			<td><?= h($fichier->date_upload) ?></td>
		</tr>
	</table>
</div>
