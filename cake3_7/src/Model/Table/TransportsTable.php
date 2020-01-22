<?php

namespace App\Model\Table;

use App\Model\Entity\Transport;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transports Model
 *
 * @property MissionsTable|BelongsToMany $Missions
 *
 * @method Transport get($primaryKey, $options = [])
 * @method Transport newEntity($data = null, array $options = [])
 * @method Transport[] newEntities(array $data, array $options = [])
 * @method Transport|bool save(EntityInterface $entity, $options = [])
 * @method Transport saveOrFail(EntityInterface $entity, $options = [])
 * @method Transport patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Transport[] patchEntities($entities, array $data, array $options = [])
 * @method Transport findOrCreate($search, callable $callback = null, $options = [])
 */
class TransportsTable extends Table
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

		$this->setTable('transports');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->belongsToMany('Missions', [
			'foreignKey' => 'transport_id',
			'targetForeignKey' => 'mission_id',
			'joinTable' => 'missions_transports'
		]);

		$this->displayField('type_transport');
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
			->scalar('type_transport')
			->allowEmptyString('type_transport');

		$validator
			->scalar('im_vehicule')
			->maxLength('im_vehicule', 10)
			->allowEmptyString('im_vehicule');

		$validator
			->integer('pf_vehicule')
			->allowEmptyString('pf_vehicule');

		return $validator;
	}
}
