<?php

namespace App\Model\Table;

use App\Model\Entity\Theses;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * Theses Model
 *
 * @property MembresTable|BelongsTo $Membres
 * @property FinancementsTable|BelongsTo $Financements
 * @property DirigeantsTable|BelongsToMany $Dirigeants
 * @property EncadrantsTable|BelongsToMany $Encadrants
 *
 * @method Theses get($primaryKey, $options = [])
 * @method Theses newEntity($data = null, array $options = [])
 * @method Theses[] newEntities(array $data, array $options = [])
 * @method Theses|bool save(EntityInterface $entity, $options = [])
 * @method Theses saveOrFail(EntityInterface $entity, $options = [])
 * @method Theses patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Theses[] patchEntities($entities, array $data, array $options = [])
 * @method Theses findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin SearchBehavior
 */
class ThesesTable extends Table
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

		$this->setTable('theses');
		$this->setDisplayField('sujet');
		$this->setPrimaryKey('id');

		$this->belongsTo('Membres', [
			'foreignKey' => 'auteur_id'
		]);
		$this->belongsTo('Financements', [
			'foreignKey' => 'financement_id'
		]);
		$this->belongsToMany('Dirigeants', [
			'foreignKey' => 'these_id',
			'targetForeignKey' => 'dirigeant_id',
			'joinTable' => 'dirigeants_theses'
		]);
		$this->belongsToMany('Encadrants', [
			'foreignKey' => 'these_id',
			'targetForeignKey' => 'encadrant_id',
			'joinTable' => 'encadrants_theses'
		]);

		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `Theses.sujet` and `Theses.type` fields, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'fieldMode' => 'OR',
				'field' => ['sujet', 'type']
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
			->integer('id')
			->allowEmptyString('id', 'create');

		$validator
			->scalar('sujet')
			->maxLength('sujet', 160)
			->requirePresence('sujet', 'create')
			->allowEmptyString('sujet', false);

		$validator
			->scalar('type')
			->maxLength('type', 80)
			->allowEmptyString('type');

		$validator
			->date('date_debut')
			->allowEmptyDate('date_debut');

		$validator
			->date('date_fin')
			->allowEmptyDate('date_fin');

		$validator
			->scalar('autre_info')
			->maxLength('autre_info', 160)
			->allowEmptyString('autre_info');

		$validator
			->boolean('est_hdr')
			->allowEmptyString('est_hdr');

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
		$rules->add($rules->existsIn(['auteur_id'], 'Membres'));
		$rules->add($rules->existsIn(['financement_id'], 'Financements'));

		return $rules;
	}
}
