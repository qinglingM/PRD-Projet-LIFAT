<?php

namespace App\Model\Table;

use App\Model\Entity\EquipesProjet;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * EquipesProjets Model
 *
 * @property EquipesTable|BelongsTo $Equipes
 * @property ProjetsTable|BelongsTo $Projets
 *
 * @method EquipesProjet get($primaryKey, $options = [])
 * @method EquipesProjet newEntity($data = null, array $options = [])
 * @method EquipesProjet[] newEntities(array $data, array $options = [])
 * @method EquipesProjet|bool save(EntityInterface $entity, $options = [])
 * @method EquipesProjet saveOrFail(EntityInterface $entity, $options = [])
 * @method EquipesProjet patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method EquipesProjet[] patchEntities($entities, array $data, array $options = [])
 * @method EquipesProjet findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipesProjetsTable extends Table
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

		$this->setTable('equipes_projets');
		$this->setDisplayField('equipe_id');
		$this->setPrimaryKey(['equipe_id', 'projet_id']);

		$this->belongsTo('Equipes', [
			'foreignKey' => 'equipe_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Projets', [
			'foreignKey' => 'projet_id',
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
		$rules->add($rules->existsIn(['projet_id'], 'Projets'));

		return $rules;
	}
}
