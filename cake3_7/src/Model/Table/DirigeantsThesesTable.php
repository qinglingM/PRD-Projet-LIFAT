<?php

namespace App\Model\Table;

use App\Model\Entity\DirigeantsThesis;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirigeantsTheses Model
 *
 * @property DirigeantsTable|BelongsTo $Dirigeants
 * @property ThesesTable|BelongsTo $Theses
 *
 * @method DirigeantsThesis get($primaryKey, $options = [])
 * @method DirigeantsThesis newEntity($data = null, array $options = [])
 * @method DirigeantsThesis[] newEntities(array $data, array $options = [])
 * @method DirigeantsThesis|bool save(EntityInterface $entity, $options = [])
 * @method DirigeantsThesis saveOrFail(EntityInterface $entity, $options = [])
 * @method DirigeantsThesis patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DirigeantsThesis[] patchEntities($entities, array $data, array $options = [])
 * @method DirigeantsThesis findOrCreate($search, callable $callback = null, $options = [])
 */
class DirigeantsThesesTable extends Table
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

		$this->setTable('dirigeants_theses');
		$this->setDisplayField('dirigeant_id');
		$this->setPrimaryKey(['dirigeant_id', 'these_id']);

		$this->belongsTo('Dirigeants', [
			'foreignKey' => 'dirigeant_id',
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
		$rules->add($rules->existsIn(['dirigeant_id'], 'Dirigeants'));
		$rules->add($rules->existsIn(['these_id'], 'Theses'));

		return $rules;
	}
}
