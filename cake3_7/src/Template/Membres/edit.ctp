<?php

use App\Model\Entity\Membre;
use App\View\AppView;

/**
 * @var AppView $this
 * @var Membre $membre
 */

$optionsMembres = [
    Membre::ADMIN => 'Administrateur',
    Membre::MEMBRE => 'Membre', //    La dernière option est celle par défaut
    Membre::SECRETAIRE => 'Secretaire',
];
$optionsGenre = [
    'H' => 'Homme',
    'F' => 'Femme',
];
?>
<div class="membres form large-12 medium-8 columns content">
	<?php $membre->passwd = ""?>
	<?=$this->Form->create($membre, ['type' => 'file'])?>
	<fieldset>
		<legend><?=$membre->id == 0 ? __('Ajout d\'un membre') : __('Edition d\'un membre');?></legend>
		<?php
//    Un admin peut changer le rôle des autres mais ne peut pas se demote lui-même
if ($user['role'] === Membre::ADMIN && $membre->id != $user['id']) {
    echo $this->Form->select('role', $optionsMembres);
} else {
    echo $this->Form->hidden('role');
}
echo $this->Form->control('equipe_id', ['options' => $equipes, 'empty' => true]);
//    Si un user non-admin modifie quelqu'un d'autre, il ne peut rien modifier d'autre que l'équipe
if ($user['role'] === Membre::ADMIN || $user['id'] == $membre->id) {
    echo $this->Form->control('nom');
    echo $this->Form->control('prenom');
    echo $this->Form->control('email', ['label' => 'Email (requis)', 'required' => true]);
    echo $this->Form->control('passwd', ['value' => '', 'label' => "Mot de passe (vide pour conservation du mot de passe actuel)"]);
    echo $this->Form->control('adresse_agent_1');
    echo $this->Form->control('adresse_agent_2');
    echo $this->Form->control('residence_admin_1');
    echo $this->Form->control('residence_admin_2');
    echo $this->Form->control('type_personnel');
    echo $this->Form->control('intitule');
    echo $this->Form->control('grade');
    echo $this->Form->control('im_vehicule');
    echo $this->Form->control('pf_vehicule');

    // $RootDir = $_SERVER['DOCUMENT_ROOT']; $RootDir.'/PRD-Porjet-LIFAT/cake3_7/webroot
    // $signaturePath = '/Signatures/'.$membre->signature_name;
    $signaturePath = $_SERVER['DOCUMENT_ROOT'] . '/PRD-Projet-LIFAT/cake3_7/webroot/Signatures/' . $membre->signature_name;

    // $verifSignature = file_exists($signaturePath);
    // echo $this->Form->control();
    echo $this->Form->control('signature_name', ['required' => false, 'label' => 'Fichier signature (jpg,png | 10Mo max)', 'type' => 'file', 'accept' => 'image/png, image/jpeg, image/jpg']);
    //echo $this->Form->control('signature',['required' => true,'lable' => 'Aperçu de la signature actuelle :', 'type' => 'image']);

    //affichage de la signature ou d'un message d'erreur
    // if ($verifSignature == false) {
    //     echo $signaturePath;
    //     echo '<div class="note">Merci de bien vouloir ajouter votre signature éléctronique.<br/>
    //     Sans cette signature vous devrez aller signer l\'OdM au secrétariat.</div>';
    // }
    if ($membre->signature_name != null) {
        // print_r($membre);
        //  print_r($signaturePath);
        echo $this->Html->div('signature_name',
            '<p>Aperçu de la signature actuelle : </p>' .
            $this->Html->image('/Signatures/' . $membre->signature_name, ['alt' => 'signature', 'width' => '235', 'height' => '50', 'class' => 'signature_img'])
        );
    } else {
        // echo file_exists($signaturePath);
        // print_r( $signaturePath);
        echo '<div class="note">Merci de bien vouloir ajouter votre signature éléctronique.<br/>
				Sans cette signature vous devrez aller signer l\'OdM au secrétariat.</div>';
    }

    echo $this->Form->control('login_cas');
    echo $this->Form->control('carte_sncf');
    echo $this->Form->control('matricule');
    echo $this->Form->control('date_naissance', ['minYear' => 1901, 'maxYear' => 2019]);
    echo $this->Form->control('lieu_travail_id', ['options' => $lieuTravails, 'empty' => false, 'label' => "Lieu de travail"]);
    echo $this->Form->control('nationalite');
    echo $this->Form->control('est_francais');
    echo $this->Form->select('genre', $optionsGenre);
    echo $this->Form->control('hdr');
    echo $this->Form->control('permanent', ['label' => "Membre permanent"]);
    echo $this->Form->control('est_porteur', ['label' => "Membre porteur"]);

}
?>
	</fieldset>
	<?php
//    Seuls les admins peuvent rendre les comptes actifs
if ($user['role'] === Membre::ADMIN) {
    //    Nouveau membre = compte pas activé par défaut (autrement la valeur existante sera reprise)
    if ($membre->id == 0) {
        echo $this->Form->control('actif', ['value' => false]);
    } else {
        echo $this->Form->control('actif');
    }
} else {
    //    Nouveau membre = compte pas activé par défaut (autrement la valeur existante sera reprise)
    if ($membre->id == 0) {
        echo $this->Form->hidden('actif', ['value' => false]);
    } else {
        echo $this->Form->hidden('actif');
    }
}
?>
	<?=$this->Form->button(__('Valider'))?>
	<?=$this->Form->end()?>
</div>
