<?php

namespace App\Model\Table;

use App\Model\Entity\EncadrantsThesis;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EncadrantsTheses Model
 *
 * @property EncadrantsTable|BelongsTo $Encadrants
 * @property ThesesTable|BelongsTo $Theses
 *
 * @method EncadrantsThesis get($primaryKey, $options = [])
 * @method EncadrantsThesis newEntity($data = null, array $options = [])
 * @method EncadrantsThesis[] newEntities(array $data, array $options = [])
 * @method EncadrantsThesis|bool save(EntityInterface $entity, $options = [])
 * @method EncadrantsThesis saveOrFail(EntityInterface $entity, $options = [])
 * @method EncadrantsThesis patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method EncadrantsThesis[] patchEntities($entities, array $data, array $options = [])
 * @method EncadrantsThesis findOrCreate($search, callable $callback = null, $options = [])
 */
class EncadrantsThesesTable extends Table
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

		$this->setTable('encadrants_theses');
		$this->setDisplayField('encadrant_id');
		$this->setPrimaryKey(['encadrant_id', 'these_id']);

		$this->belongsTo('Encadrants', [
			'foreignKey' => 'encadrant_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Theses', [
			'foreignKey' => 'these_id',
			'joinType' => 'INNER'
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param Validator $validator Validator instance.
	 * @return Validator
	 */
	public function validationDefault(Validator $validator)
	{
		$validator
			->integer('taux')
			->allowEmptyString('taux');
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
		$rules->add($rules->existsIn(['these_id'], 'Theses'));

		return $rules;
	}
}
