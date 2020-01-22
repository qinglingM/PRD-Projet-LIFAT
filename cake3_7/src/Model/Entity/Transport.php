<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transport Entity
 *
 * @property int $id
 * @property string|null $type_transport
 * @property string|null $im_vehicule
 * @property int|null $pf_vehicule
 *
 * @property Mission[] $missions
 */
class Transport extends Entity
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
		'type_transport' => true,
		'im_vehicule' => true,
		'pf_vehicule' => true,
		'missions' => true
	];
}
