<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dirigeant Entity
 *
 * @property int $dirigeant_id
 *
 * @property Dirigeant[] $dirigeants
 * @property Thesis[] $theses
 */
class Dirigeant extends Entity
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
		'dirigeant_id' => true,
		'dirigeants' => true,
		'theses' => true
	];
}
