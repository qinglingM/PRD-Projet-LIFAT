<?php
/**
 * @var AppView $this
 * @var Mission $mission
 */

use App\Model\Entity\Mission;
use App\View\AppView; ?>



<h2>Soumission de l'Ordre de Mission</h2>

<div class="users form">
    <?= $this->Form->create($mission) ?>
        <fieldset>
        <!-- <legend><?= __('Add User') ?></legend> -->
        <?= $this->Form->control('id', ['type'=>'hidden']) ?>
        <?= $this->Form->control('nb_nuites',['label'=>'Nombre de nuités', 'type' => 'number', 'empty' => true]) ?>
        <?= $this->Form->control('nb_repas',['label'=>'Nombre de repas', 'type' => 'number', 'empty' => true]) ?>
        </fieldset>
    <?= $this->Form->button(__('Soumettre')); ?>
    <?= $this->Form->end() ?>
</div>

<div class="note">En cliquant sur le bouton « Soumettre » votre Ordre de Mission sera envoyé au responsable d’équipe pour signature.</div>
