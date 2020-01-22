<?php

namespace App\Model\Entity;

use Cake\I18n\FrozenDate;
use Cake\ORM\Entity;

/**
 * Projet Entity
 *
 * @property int $id
 * @property string|null $titre
 * @property string|null $description
 * @property string|null $type
 * @property int|null $budget
 * @property FrozenDate|null $date_debut
 * @property FrozenDate|null $date_fin
 * @property int|null $financement_id
 *
 * @property Financement $financement
 * @property Mission[] $missions
 * @property Equipe[] $equipes
 */
class Projet extends Entity
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
		'titre' => true,
		'description' => true,
		'type' => true,
		'budget' => true,
		'date_debut' => true,
		'date_fin' => true,
		'financement_id' => true,
		'financement' => true,
		'missions' => true,
		'equipes' => true
	];
}
