<?php

namespace App\Model\Table;

use App\Model\Entity\Mission;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Missions Model
 *
 * @property ProjetsTable|BelongsTo $Projets
 * @property LieusTable|BelongsTo $Lieus
 * @property MotifsTable|BelongsTo $Motifs
 * @property TransportsTable|BelongsToMany $Transports
 * @property MembresTable|BelongsTo $Membres
 *
 * @method Mission get($primaryKey, $options = [])
 * @method Mission newEntity($data = null, array $options = [])
 * @method Mission[] newEntities(array $data, array $options = [])
 * @method Mission|bool save(EntityInterface $entity, $options = [])
 * @method Mission saveOrFail(EntityInterface $entity, $options = [])
 * @method Mission patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Mission[] patchEntities($entities, array $data, array $options = [])
 * @method Mission findOrCreate($search, callable $callback = null, $options = [])
 */
class MissionsTable extends Table
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

		$this->setTable('missions');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');


		$this->belongsTo('Membres', [
			'foreignKey' => 'responsable_id'
		]);
		$this->belongsTo('Projets', [
			'foreignKey' => 'projet_id'
		]);
		$this->belongsTo('Lieus', [
			'foreignKey' => 'lieu_id'
		]);
		$this->belongsTo('Motifs', [
			'foreignKey' => 'motif_id'
		]);
		$this->belongsToMany('Transports', [
			'foreignKey' => 'mission_id',
			'targetForeignKey' => 'transport_id',
			'joinTable' => 'missions_transports'
		]);

		
		// Add the behaviour to your table
		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
		$this->searchManager()
			/*	Here we will alias the 'id' query param to search the `Membres.nom` and `Membres.prenom` fields, using a LIKE match, with `%` both before and after.	*/
			->add('Recherche', 'Search.Like', [
				'before' => true,
				'after' => true,
				'multiValue' => true,
				'multiValueSeparator' => ' ',
				'valueMode' => 'OR',
				'comparison' => 'LIKE',
				'fieldMode' => 'OR',
				'field' => ['id']
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
			->scalar('complement_motif')
			->maxLength('complement_motif', 40)
			->allowEmptyString('complement_motif');

		$validator
			->dateTime('date_depart')
			->allowEmptyDateTime('date_depart');

		$validator
			->dateTime('heure_depart_d')
			->allowEmptyDateTime('heure_depart_d');		

		$validator
			->dateTime('date_retour')
			->allowEmptyDateTime('date_retour');

		$validator
			->dateTime('heure_depart_r')
			->allowEmptyDateTime('heure_depart_r');

		
		
		$validator
			->boolean('sans_frais')
			->allowEmptyString('sans_frais');

		$validator
			->scalar('etat')
			->allowEmptyString('etat');

		$validator
			->integer('nb_nuites')
			->allowEmptyString('nb_nuites');

		$validator
			->integer('nb_repas')
			->allowEmptyString('nb_repas');

		$validator
			->boolean('billet_agence')
			->allowEmptyString('billet_agence');

		$validator
			->scalar('commentaire_transport')
			->allowEmptyString('commentaire_transport');

		$validator
			->scalar('nouveau_lieu')
			->allowEmptyString('nouveau_lieu');	

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
		$rules->add($rules->existsIn(['projet_id'], 'Projets'));
		$rules->add($rules->existsIn(['lieu_id'], 'Lieus'));
		$rules->add($rules->existsIn(['motif_id'], 'Motifs'));
		$rules->add($rules->existsIn(['responsable_id'], 'Membres'));

		return $rules;
	}
}
