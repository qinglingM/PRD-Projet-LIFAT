<?php

namespace App\Model\Table;

use App\Model\Entity\Motif;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Motifs Model
 *
 * @property MissionsTable|HasMany $Missions
 *
 * @method Motif get($primaryKey, $options = [])
 * @method Motif newEntity($data = null, array $options = [])
 * @method Motif[] newEntities(array $data, array $options = [])
 * @method Motif|bool save(EntityInterface $entity, $options = [])
 * @method Motif saveOrFail(EntityInterface $entity, $options = [])
 * @method Motif patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Motif[] patchEntities($entities, array $data, array $options = [])
 * @method Motif findOrCreate($search, callable $callback = null, $options = [])
 */
class MotifsTable extends Table
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

		$this->setTable('motifs');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');
		
		$this->hasMany('Missions', [
			'foreignKey' => 'motif_id'
		]);

		$this->displayField('nom_motif');
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
			->scalar('nom_motif')
			->maxLength('nom_motif', 60)
			->allowEmptyString('nom_motif');

		$validator
			->boolean('est_dans_liste')
			->allowEmptyString('est_dans_liste');

		return $validator;
	}
}
