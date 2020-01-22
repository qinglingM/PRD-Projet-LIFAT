<?php

namespace App\Model\Table;

use App\Model\Entity\Encadrant;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * Encadrants Model
 *
 * @property EncadrantsTable|BelongsTo $Encadrants
 * @property EncadrantsTable|HasMany $Encadrants
 * @property ThesesTable|BelongsToMany $Theses
 *
 * @method Encadrant get($primaryKey, $options = [])
 * @method Encadrant newEntity($data = null, array $options = [])
 * @method Encadrant[] newEntities(array $data, array $options = [])
 * @method Encadrant|bool save(EntityInterface $entity, $options = [])
 * @method Encadrant saveOrFail(EntityInterface $entity, $options = [])
 * @method Encadrant patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Encadrant[] patchEntities($entities, array $data, array $options = [])
 * @method Encadrant findOrCreate($search, callable $callback = null, $options = [])
 */
class EncadrantsTable extends Table
{
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setTable('encadrants');

		$this->primaryKey('encadrant_id');

		$this->belongsTo('Membres', [
			'foreignKey' => 'encadrant_id',
			'joinType' => 'INNER'
		]);
		$this->hasMany('Membres', [
			'foreignKey' => 'encadrant_id'
		]);
		$this->belongsToMany('Theses', [
			'foreignKey' => 'encadrant_id',
			'targetForeignKey' => 'thesis_id',
			'joinTable' => 'encadrants_theses'
		]);
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param RulesChecker $rules The rules object to be modified.
	 * @return RulesChecker
	 */
	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->existsIn(['encadrant_id'], 'Encadrants'));

		return $rules;
	}
}
