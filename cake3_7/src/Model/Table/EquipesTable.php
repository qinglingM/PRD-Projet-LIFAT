<?php

namespace App\Model\Table;

use App\Model\Entity\Equipe;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * Equipes Model
 *
 * @property MembresTable|BelongsTo $Membres
 * @property EquipesResponsablesTable|HasMany $EquipesResponsables
 * @property ProjetsTable|BelongsToMany $Projets
 *
 * @method Equipe get($primaryKey, $options = [])
 * @method Equipe newEntity($data = null, array $options = [])
 * @method Equipe[] newEntities(array $data, array $options = [])
 * @method Equipe|bool save(EntityInterface $entity, $options = [])
 * @method Equipe saveOrFail(EntityInterface $entity, $options = [])
 * @method Equipe patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Equipe[] patchEntities($entities, array $data, array $options = [])
 * @method Equipe findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin SearchBehavior
 */
class EquipesTable extends Table
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

		$this->setTable('equipes');
		$this->setDisplayField('nom_equipe');
		$this->setPrimaryKey('id');

		$this->belongsTo('Membres', [
			'foreignKey' => 'responsable_id'
		]);
		$this->hasMany('EquipesResponsables', [
			'foreignKey' => 'equipe_id'
		]);
		$this->belongsToMany('Projets', [
			'foreignKey' => 'equipe_id',
			'targetForeignKey' => 'projet_id',
			'joinTable' => 'equipes_projets'
		]);

		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `Equipes.nom_equipe` field, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'field' => ['nom_equipe']
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
			->scalar('nom_equipe')
			->maxLength('nom_equipe', 25)
			->requirePresence('nom_equipe', 'create')
			->allowEmptyString('nom_equipe', false)
			->add('nom_equipe', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
		$rules->add($rules->isUnique(['nom_equipe']));
		$rules->add($rules->existsIn(['responsable_id'], 'Membres'));

		return $rules;
	}
}
