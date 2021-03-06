<?php

namespace App\Model\Table;

use App\Model\Entity\Lieus;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lieus Model
 *
 * @method Lieus get($primaryKey, $options = [])
 * @method Lieus newEntity($data = null, array $options = [])
 * @method Lieus[] newEntities(array $data, array $options = [])
 * @method Lieus|bool save(EntityInterface $entity, $options = [])
 * @method Lieus saveOrFail(EntityInterface $entity, $options = [])
 * @method Lieus patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Lieus[] patchEntities($entities, array $data, array $options = [])
 * @method Lieus findOrCreate($search, callable $callback = null, $options = [])
 */
class LieusTable extends Table
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

		$this->setTable('lieus');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');
		$this->displayField('nom_lieu');
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
			->allowEmptyString('nom_lieu');

		$validator
			->boolean('est_dans_liste')
			->allowEmptyString('est_dans_liste');

			$validator
			->boolean('pays')
			->allowEmptyString('pays');	
			
		return $validator;
	}
}
