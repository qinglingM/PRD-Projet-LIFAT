<?php
/**
 * @var AppView $this
 * @var Mission $mission
 */

use App\Model\Entity\Mission;
use App\View\AppView;?>

<div class="note">Rappel :Vous devez remplir les options marquées qui avec *.
</div>

<div class="missions form large-12 medium-8 columns content">
	<?=$this->Form->create($mission)?>
	<fieldset>
		<legend><?=__('Mission *')?></legend>
		<?php
echo $this->Form->control('projet_id', ['label' => 'Projet associé', 'options' => $projets, 'empty' => true]);
echo $this->Form->control('sans_frais', ['label' => 'Mission Sans Frais', 'type' => 'checkbox']);
?>
	</fieldset>

	<fieldset>
		<legend><?=__('Motif *')?></legend>
		<?php
echo $this->Form->control('motif_id', ['label' => 'Motif', 'options' => $motifs, 'empty' => true]);
echo $this->Form->control('complement_motif', ['label' => 'Complément du motif (Par exemple : Nom de la conférence, etc.))']);
?>
	</fieldset>

	<fieldset>
		<legend><?=__('Lieu *')?></legend>
		<?php
echo $this->Form->control('lieu_id', ['options' => $lieus, 'empty' => true]);
echo $this->Form->control('nouveau_lieu', ['label' => 'Nouveau lieu (si non présent parmis les propositions)']);
// TODO : nouveau lieu si non présent
 ?>
	</fieldset>

	<fieldset>
		<legend><?=__('Dates *')?></legend>
		<?php
echo $this->Form->control('date_depart', ['label' => 'Date et heure départ du départ', 'type' => 'datetime', 'empty' => true]);
// echo $this->Form->control('depart_arrive', ['label' => 'Date et heure arrivée du départ', 'type' => 'datetime', 'empty' => true]);
echo $this->Form->control('date_depart_arrive', ['label' => 'Date et heure arrive du départ ', 'type' => 'datetime', 'empty' => true]);

echo $this->Form->control('date_retour', ['label' => 'Date et heure départ du retour', 'type' => 'datetime', 'empty' => true]);
// echo $this->Form->control('retour_arrive', ['label' => 'Date et heure arrivée du retour', 'type' => 'datetime', 'empty' => true]);
echo $this->Form->control('date_retour_arrive', ['label' => 'Date et heure arrive du retour ', 'type' => 'datetime', 'empty' => true]);

// echo $this->Form->control('test_field', ['label' => 'Test field ']);

?>
	</fieldset>

	<!-- <fieldset>
		<legend><?=__('Transport')?></legend>
		 -->
		<?php
$options = [
    'Transport' => [
        'Value1' => ' Train',
        'Value2' => ' Avion',
        'Value3' => ' Véhicule Personnel',
        'Value4' => ' Véhicule de service',
        'Value5' => ' Autre',
    ],
];
echo $this->Form->select('mul', $options, [
    'multiple' => 'checkbox',
]);
// echo $this->Form->control('transports.type_transports', ['options' => $transports]);
// echo $this->Form->control('missions._ids', ['options' => $missions]);
// echo $this->Form->control('transports', ['options' => $transports],['multiple' => 'checkbox']);

?>


	<!-- </fieldset> -->

	<fieldset>
		<legend><?=__('Autres Passagers')?></legend>
		<?php
echo $this->Form->control('passagers',
    ['label' => 'Vous pouvez générer un ordre de mission identique pour d\'autres utilisateurs (Utile lors d\'un covoiturage, par exemple)',
        'options' => $membres,
        'multiple' => true,
        'empty' => true,
    ]);
?>
		<hr>

		<div id="aucunPassager">
		Aucun nouveau passager n'a été ajouté. Veuillez maintenir ‘Ctrl’ pour en ajouter un.
		</div>

		<div id="passagerAffichage"></div>
	</fieldset>

	<fieldset>
		<legend><?=__('Informations complémentaires sur le transport')?></legend>
		<?php
echo $this->Form->control('billet_agence', ['label' => 'Laisser le secrétariat commander les billets', 'type' => 'checkbox', 'checked' => true]);
echo $this->Form->control('commentaire_transport', ['label' => 'Commentaires supplémentaires pour le secrétariat (horaires, etc.)', 'type' => 'textarea']);
?>
	</fieldset>

	<fieldset>
		<legend><?=__('Si utilisation d\'un véhicule')?></legend>
		<?php
// TODO : si utilisation d'un véhicule, utiliser ces valeurs pour la génération de la mission
echo $this->Form->label('im_vehicule', 'Immatriculation véhicule');
echo $this->Form->text('im_vehicule'); ?>


		<?php echo $this->Form->label('pf_vehicule', 'Puissance fiscale véhicule');
echo $this->Form->number('pf_vehicule');

// TODO : Enregistrement de ces infos dans le membre si coché
echo $this->Form->control('er_vehicule', ['label' => 'Enregistrer le véhicule dans mon profil (En remplacement de l\'ancien véhicule)', 'type' => 'checkbox', 'checked' => false]);
?>
	</fieldset>

	<fieldset>
		<legend><?=__('Nuités et repas')?></legend>
		<?php
echo $this->Form->control('nb_nuites', ['label' => 'Nombre de nuitées (Si le champ est laissé vide, le nombre de nuitées sera calculé automatiquement', 'type' => 'number', 'empty' => true]);
echo $this->Form->control('nb_repas', ['label' => 'Nombre de repas (Si le champ est laissé vide, le nombre de repas sera calculé automatiquement', 'type' => 'number', 'empty' => true]);
?>
	</fieldset>

	<?=$this->Form->hidden('etat', ['id' => 'etat', 'value' => 'soumis'])?>
	<?=$this->Form->button('Enregistrer la missions', ['type' => 'submit'])?>
	<?=$this->Form->end()?>
</div>
