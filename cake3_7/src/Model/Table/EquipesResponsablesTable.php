<?php

namespace App\Model\Table;

use App\Model\Entity\EquipesResponsable;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * EquipesResponsables Model
 *
 * @property EquipesTable|BelongsTo $Equipes
 * @property MembresTable|BelongsTo $Membres
 *
 * @method EquipesResponsable get($primaryKey, $options = [])
 * @method EquipesResponsable newEntity($data = null, array $options = [])
 * @method EquipesResponsable[] newEntities(array $data, array $options = [])
 * @method EquipesResponsable|bool save(EntityInterface $entity, $options = [])
 * @method EquipesResponsable saveOrFail(EntityInterface $entity, $options = [])
 * @method EquipesResponsable patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method EquipesResponsable[] patchEntities($entities, array $data, array $options = [])
 * @method EquipesResponsable findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipesResponsablesTable extends Table
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

		$this->setTable('equipes_responsables');
		$this->setDisplayField('equipe_id');
		$this->setPrimaryKey(['equipe_id', 'responsable_id']);

		$this->belongsTo('Equipes', [
			'foreignKey' => 'equipe_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Membres', [
			'foreignKey' => 'responsable_id',
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
		$rules->add($rules->existsIn(['equipe_id'], 'Equipes'));
		$rules->add($rules->existsIn(['responsable_id'], 'Membres'));

		return $rules;
	}
}
