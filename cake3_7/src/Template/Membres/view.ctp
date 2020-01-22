<?php
/**
 * @var AppView $this
 * @var Membre $membre
 */

use App\Model\Entity\Membre;
use App\View\AppView; ?>
<div class="membres view large-9 medium-8 columns content">
	<h3><?= h($membre->nom . ' ' . $membre->prenom) ?><font
				size="+1">[<?= $this->Html->link(__('Editer'), ['action' => 'edit', $membre->id]) ?>]</font size></h3>
	<!--	TODO : edit link only if $user can edit this member	-->
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Rôle') ?></th>
			<td><?= h($membre->role) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Nom') ?></th>
			<td><?= h($membre->nom) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Prénom') ?></th>
			<td><?= h($membre->prenom) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td><?= h($membre->email) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Adresse Agent 1') ?></th>
			<td><?= h($membre->adresse_agent_1) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Adresse Agent 2') ?></th>
			<td><?= h($membre->adresse_agent_2) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Residence Admin 1') ?></th>
			<td><?= h($membre->residence_admin_1) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Residence Admin 2') ?></th>
			<td><?= h($membre->residence_admin_2) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Type Personnel') ?></th>
			<td><?= h($membre->type_personnel) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Intitulé') ?></th>
			<td><?= h($membre->intitule) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Grade') ?></th>
			<td><?= h($membre->grade) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Immatriculation du Véhicule') ?></th>
			<td><?= h($membre->im_vehicule) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Login Cas') ?></th>
			<td><?= h($membre->login_cas) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Lieu Travail') ?></th>
			<td><?= $membre->has('lieu_travail') ? $this->Html->link($membre->lieu_travail->nom_lieu, ['controller' => 'LieuTravails', 'action' => 'view', $membre->lieu_travail->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Nationalite') ?></th>
			<td><?= h($membre->nationalite) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Genre') ?></th>
			<td><?php
				if ($membre->genre == 'H')
					echo "homme";
				else if ($membre->genre == 'F')
					echo "femme";
				else
					echo "autre"; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date Naissance') ?></th>
			<td><?= h($membre->date_naissance) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date Creation') ?></th>
			<td><?= h($membre->date_creation) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date Sortie') ?></th>
			<td><?= h($membre->date_sortie) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Est Francais') ?></th>
			<td><?= $membre->est_francais ? __('Oui') : __('Non'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Certification HDR') ?></th>
			<td><?= $membre->hdr ? __('Oui') : __('Non'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Membre Permanent ?') ?></th>
			<td><?= $membre->permanent ? __('Oui') : __('Non'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Membre Porteur ?') ?></th>
			<td><?= $membre->est_porteur ? __('Oui') : __('Non'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Actif') ?></th>
			<td><?= $membre->actif ? __('Oui') : __('Non'); ?></td>
		</tr>
		<?php
			if ($user['role'] === Membre::ADMIN && $membre->signature_name != null) {
				echo "<tr><th>Signature</th><td>";
				echo $this->Html->link('Télécharger', '/Signatures/'.$membre->signature_name);
				echo "</td></tr>"; 
			}
		?>
	</table>
</div>
