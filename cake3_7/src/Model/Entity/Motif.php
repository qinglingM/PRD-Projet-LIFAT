<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Motif Entity
 *
 * @property int $id
 * @property string|null $nom_motif
 * @property bool|null $est_dans_liste
 *
 * @property Mission[] $missions
 */
class Motif extends Entity
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
		'nom_motif' => true,
		'est_dans_liste' => true,
		'missions' => true
	];
}
