<?php

namespace App\Model\Table;

use App\Model\Entity\LieuTravail;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * LieuTravails Model
 *
 * @property MembresTable|HasMany $Membres
 *
 * @method LieuTravail get($primaryKey, $options = [])
 * @method LieuTravail newEntity($data = null, array $options = [])
 * @method LieuTravail[] newEntities(array $data, array $options = [])
 * @method LieuTravail|bool save(EntityInterface $entity, $options = [])
 * @method LieuTravail saveOrFail(EntityInterface $entity, $options = [])
 * @method LieuTravail patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method LieuTravail[] patchEntities($entities, array $data, array $options = [])
 * @method LieuTravail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin SearchBehavior
 */
class LieuTravailsTable extends Table
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

		$this->setTable('lieu_travails');
		$this->setDisplayField('nom_lieu');
		$this->setPrimaryKey('id');

		$this->hasMany('Membres', [
			'foreignKey' => 'lieu_travail_id'
		]);

		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `LieuTravails.nom_lieu` field, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'field' => ['nom_lieu']
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
			->scalar('nom_lieu')
			->maxLength('nom_lieu', 60)
			->requirePresence('nom_lieu', 'create')
			->allowEmptyString('nom_lieu', false)
			->add('nom_lieu', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator
			->boolean('est_dans_liste')
			->allowEmptyString('est_dans_liste');

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
		$rules->add($rules->isUnique(['nom_lieu']));

		return $rules;
	}
}
