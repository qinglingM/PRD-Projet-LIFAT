<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Encadrant Entity
 *
 * @property int $encadrant_id
 *
 * @property Encadrant[] $encadrants
 * @property Thesis[] $theses
 */
class Encadrant extends Entity
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
		'encadrant_id' => true,
		'encadrants' => true,
		'theses' => true
	];
}
