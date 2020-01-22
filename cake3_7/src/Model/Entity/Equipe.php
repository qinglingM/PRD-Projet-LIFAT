<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipe Entity
 *
 * @property int $id
 * @property string $nom_equipe
 * @property int|null $responsable_id
 *
 * @property Membre $membre
 * @property EquipesResponsable[] $equipes_responsables
 * @property Projet[] $projets
 */
class Equipe extends Entity
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
		'nom_equipe' => true,
		'responsable_id' => true,
		'membre' => true,
		'equipes_responsables' => true,
		'projets' => true
	];
}
