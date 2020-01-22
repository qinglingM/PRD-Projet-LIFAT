<?php

namespace App\Model\Table;

use App\Model\Entity\Dirigeant;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * Dirigeants Model
 *
 * @property DirigeantsTable|BelongsTo $Dirigeants
 * @property DirigeantsTable|HasMany $Dirigeants
 * @property ThesesTable|BelongsToMany $Theses
 *
 * @method Dirigeant get($primaryKey, $options = [])
 * @method Dirigeant newEntity($data = null, array $options = [])
 * @method Dirigeant[] newEntities(array $data, array $options = [])
 * @method Dirigeant|bool save(EntityInterface $entity, $options = [])
 * @method Dirigeant saveOrFail(EntityInterface $entity, $options = [])
 * @method Dirigeant patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Dirigeant[] patchEntities($entities, array $data, array $options = [])
 * @method Dirigeant findOrCreate($search, callable $callback = null, $options = [])
 */
class DirigeantsTable extends Table
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

		$this->setTable('dirigeants');

		$this->primaryKey('dirigeant_id');

		$this->belongsTo('Membres', [
			'foreignKey' => 'dirigeant_id',
			'joinType' => 'INNER'
		]);
		$this->hasMany('Membres', [
			'foreignKey' => 'dirigeant_id'
		]);
		$this->belongsToMany('Theses', [
			'foreignKey' => 'dirigeant_id',
			'targetForeignKey' => 'thesis_id',
			'joinTable' => 'dirigeants_theses'
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
		$rules->add($rules->existsIn(['dirigeant_id'], 'Dirigeants'));

		return $rules;
	}
}
