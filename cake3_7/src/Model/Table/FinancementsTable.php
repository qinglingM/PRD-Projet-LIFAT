<?php

namespace App\Model\Table;

use App\Model\Entity\Financement;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * Financements Model
 *
 * @property ProjetsTable|HasMany $Projets
 *
 * @method Financement get($primaryKey, $options = [])
 * @method Financement newEntity($data = null, array $options = [])
 * @method Financement[] newEntities(array $data, array $options = [])
 * @method Financement|bool save(EntityInterface $entity, $options = [])
 * @method Financement saveOrFail(EntityInterface $entity, $options = [])
 * @method Financement patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Financement[] patchEntities($entities, array $data, array $options = [])
 * @method Financement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin SearchBehavior
 */
class FinancementsTable extends Table
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

		$this->setTable('financements');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->hasMany('Projets', [
			'foreignKey' => 'financement_id'
		]);

		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `Financements.nationalite_financement` and `Financements.financement` fields, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'fieldMode' => 'OR',
				'field' => ['nationalite_financement', 'financement']
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
			->boolean('international')
			->allowEmptyString('international');

		$validator
			->scalar('nationalite_financement')
			->maxLength('nationalite_financement', 60)
			->allowEmptyString('nationalite_financement');

		$validator
			->boolean('financement_prive')
			->allowEmptyString('financement_prive');

		$validator
			->scalar('financement')
			->maxLength('financement', 60)
			->allowEmptyString('financement');

		return $validator;
	}
}
