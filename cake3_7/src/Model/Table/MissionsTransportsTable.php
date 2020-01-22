<?php

namespace App\Model\Table;

use App\Model\Entity\MissionsTransport;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * MissionsTransports Model
 *
 * @property MissionsTable|BelongsTo $Missions
 * @property TransportsTable|BelongsTo $Transports
 *
 * @method MissionsTransport get($primaryKey, $options = [])
 * @method MissionsTransport newEntity($data = null, array $options = [])
 * @method MissionsTransport[] newEntities(array $data, array $options = [])
 * @method MissionsTransport|bool save(EntityInterface $entity, $options = [])
 * @method MissionsTransport saveOrFail(EntityInterface $entity, $options = [])
 * @method MissionsTransport patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method MissionsTransport[] patchEntities($entities, array $data, array $options = [])
 * @method MissionsTransport findOrCreate($search, callable $callback = null, $options = [])
 */
class MissionsTransportsTable extends Table
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

		$this->setTable('missions_transports');
		$this->setDisplayField('mission_id');
		$this->setPrimaryKey(['mission_id', 'transport_id']);

		$this->belongsTo('Missions', [
			'foreignKey' => 'mission_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Transports', [
			'foreignKey' => 'transport_id',
			'joinType' => 'INNER'
		]);
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
		$rules->add($rules->existsIn(['mission_id'], 'Missions'));
		$rules->add($rules->existsIn(['transport_id'], 'Transports'));

		return $rules;
	}
}
