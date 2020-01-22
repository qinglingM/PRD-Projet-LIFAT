<?php

namespace App\Model\Table;

use App\Model\Entity\Projet;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * Projets Model
 *
 * @property FinancementsTable|BelongsTo $Financements
 * @property MissionsTable|HasMany $Missions
 * @property EquipesTable|BelongsToMany $Equipes
 *
 * @method Projet get($primaryKey, $options = [])
 * @method Projet newEntity($data = null, array $options = [])
 * @method Projet[] newEntities(array $data, array $options = [])
 * @method Projet|bool save(EntityInterface $entity, $options = [])
 * @method Projet saveOrFail(EntityInterface $entity, $options = [])
 * @method Projet patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Projet[] patchEntities($entities, array $data, array $options = [])
 * @method Projet findOrCreate($search, callable $callback = null, $options = [])
 * @mixin SearchBehavior
 */
class ProjetsTable extends Table
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

		$this->setTable('projets');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->belongsTo('Financements', [
			'foreignKey' => 'financement_id'
		]);
		$this->hasMany('Missions', [
			'foreignKey' => 'projet_id'
		]);
		$this->belongsToMany('Equipes', [
			'foreignKey' => 'projet_id',
			'targetForeignKey' => 'equipe_id',
			'joinTable' => 'equipes_projets'
		]);

		$this->displayField('titre');

		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `Projets.titre` field, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'field' => ['titre']
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
			->scalar('titre')
			->maxLength('titre', 20)
			->allowEmptyString('titre');

		$validator
			->scalar('description')
			->maxLength('description', 80)
			->allowEmptyString('description');

		$validator
			->scalar('type')
			->allowEmptyString('type');

		$validator
			->integer('budget')
			->allowEmptyString('budget');

		$validator
			->date('date_debut')
			->allowEmptyDate('date_debut');

		$validator
			->date('date_fin')
			->allowEmptyDate('date_fin');

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
		$rules->add($rules->existsIn(['financement_id'], 'Financements'));

		return $rules;
	}
}
