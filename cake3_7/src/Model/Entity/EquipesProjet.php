<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipesProjet Entity
 *
 * @property int $equipe_id
 * @property int $projet_id
 *
 * @property Equipe $equipe
 * @property Projet $projet
 */
class EquipesProjet extends Entity
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
		'equipe' => true,
		'projet' => true
	];
}
