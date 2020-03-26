<?php

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Mission Entity
 *
 * @property int $id
 * @property string|null $complement_motif
 * @property FrozenTime|null $date_depart
 * @property FrozenTime|null $date_retour
 * @property FrozenTime|null $date_depart_arrive
 * @property FrozenTime|null $date_retour_arrive
 * @property bool|null $sans_frais
 * @property string|null $etat
 * @property int|null $nb_nuites
 * @property int|null $nb_repas
 * @property bool|null $billet_agence
 * @property string|null $commentaire_transport
 * @property int|null $projet_id
 * @property int|null $lieu_id
 * @property int|null $motif_id
 * @property int|null $responsable_id
 *
 * @property Projet $projet
 * @property Lieus $lieus
 * @property Motif $motif
 * @property Membre $membre
 * @property Transport[] $transports
 */
class Mission extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'complement_motif' => true,
        'date_depart' => true,
        'date_depart_arrive' => true,
        'date_retour' => true,
        'date_retour_arrive' => true,
        'sans_frais' => true,
        'etat' => true,
        'nb_nuites' => true,
        'nb_repas' => true,
        'billet_agence' => true,

        'commentaire_transport' => true,
        'projet_id' => true,
        'lieu_id' => true,
        'motif_id' => true,
        'responsable_id' => true,

        'projet' => true,
        'lieus' => true,
        'motif' => true,
        'transports' => true,
        'membre' => true,
    ];

}
