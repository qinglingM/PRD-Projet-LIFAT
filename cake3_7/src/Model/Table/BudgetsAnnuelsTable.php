<?php

namespace App\Model\Table;

use App\Model\Entity\BudgetsAnnuel;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BudgetsAnnuels Model
 *
 * @property ProjetsTable|BelongsTo $Projets
 *
 * @method BudgetsAnnuel get($primaryKey, $options = [])
 * @method BudgetsAnnuel newEntity($data = null, array $options = [])
 * @method BudgetsAnnuel[] newEntities(array $data, array $options = [])
 * @method BudgetsAnnuel|bool save(EntityInterface $entity, $options = [])
 * @method BudgetsAnnuel saveOrFail(EntityInterface $entity, $options = [])
 * @method BudgetsAnnuel patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method BudgetsAnnuel[] patchEntities($entities, array $data, array $options = [])
 * @method BudgetsAnnuel findOrCreate($search, callable $callback = null, $options = [])
 */
class BudgetsAnnuelsTable extends Table
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

		$this->setTable('budgets_annuels');
		$this->setDisplayField('projet_id');
		$this->setPrimaryKey(['projet_id', 'annee']);

		$this->belongsTo('Projets', [
			'foreignKey' => 'projet_id',
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
			->integer('annee')
			->allowEmptyString('annee', 'create');

		$validator
			->integer('budget')
			->allowEmptyString('budget');

		return $validator;
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
		$rules->add($rules->existsIn(['projet_id'], 'Projets'));

		return $rules;
	}
}
