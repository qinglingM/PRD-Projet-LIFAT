<?php

namespace App\Model\Table;

use App\Model\Entity\Membre;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * Membres Model
 *
 * @property LieuTravailsTable|BelongsTo $LieuTravails
 *
 * @method Membre get($primaryKey, $options = [])
 * @method Membre newEntity($data = null, array $options = [])
 * @method Membre[] newEntities(array $data, array $options = [])
 * @method Membre|bool save(EntityInterface $entity, $options = [])
 * @method Membre saveOrFail(EntityInterface $entity, $options = [])
 * @method Membre patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Membre[] patchEntities($entities, array $data, array $options = [])
 * @method Membre findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin SearchBehavior
 */
class MembresTable extends Table
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

		$this->setTable('membres');
		$this->setDisplayField('nom');
		$this->setPrimaryKey('id');

		$this->belongsTo('LieuTravails', [
			'foreignKey' => 'lieu_travail_id'
		]);

		$this->belongsTo('Equipes', [
			'foreignKey' => 'equipe_id'
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
				'field' => ['nom', 'prenom']
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
			->scalar('role')
			->requirePresence('role', 'create')
			->allowEmptyString('role', false);

		$validator
			->scalar('nom')
			->maxLength('nom', 25)
			->allowEmptyString('nom');

		$validator
			->scalar('prenom')
			->maxLength('prenom', 25)
			->allowEmptyString('prenom');

		$validator
			->email('email')
			->allowEmptyString('email')
			->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator
			->scalar('passwd')
			->maxLength('passwd', 60)
			->allowEmptyString('passwd');

		$validator
			->scalar('adresse_agent_1')
			->maxLength('adresse_agent_1', 80)
			->allowEmptyString('adresse_agent_1');

		$validator
			->scalar('adresse_agent_2')
			->maxLength('adresse_agent_2', 60)
			->allowEmptyString('adresse_agent_2');

		$validator
			->scalar('residence_admin_1')
			->maxLength('residence_admin_1', 80)
			->allowEmptyString('residence_admin_1');

		$validator
			->scalar('residence_admin_2')
			->maxLength('residence_admin_2', 80)
			->allowEmptyString('residence_admin_2');

		$validator
			->scalar('type_personnel')
			->allowEmptyString('type_personnel');

		$validator
			->scalar('intitule')
			->maxLength('intitule', 30)
			->allowEmptyString('intitule');

		$validator
			->scalar('grade')
			->maxLength('grade', 30)
			->allowEmptyString('grade');

		$validator
			->scalar('im_vehicule')
			->maxLength('im_vehicule', 10)
			->requirePresence('im_vehicule', 'create')
			->allowEmptyString('im_vehicule');

		$validator
			->integer('pf_vehicule')
			->requirePresence('pf_vehicule', 'create')
			->allowEmptyString('pf_vehicule');

		$validator
			->scalar('signature_name')
			->maxLength('signature_name', 20)
			->allowEmptyString('signature_name');
			
		$validator
			->scalar('login_cas')
			->maxLength('login_cas', 60)
			->allowEmptyString('login_cas')
			->add('login_cas', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator
			->scalar('carte_sncf')
			->maxLength('carte_sncf', 40)
			->allowEmptyString('carte_sncf');

		$validator
			->integer('matricule')
			->allowEmptyString('matricule');

		$validator
			->date('date_naissance')
			->allowEmptyDateTime('date_naissance');

		$validator
			->boolean('actif')
			->allowEmptyString('actif');

		$validator
			->scalar('nationalite')
			->maxLength('nationalite', 20)
			->allowEmptyString('nationalite');

		$validator
			->boolean('est_francais')
			->allowEmptyString('est_francais');

		$validator
			->scalar('genre')
			->maxLength('genre', 1)
			->allowEmptyString('genre');

		$validator
			->boolean('hdr')
			->allowEmptyString('hdr');

		$validator
			->boolean('permanent')
			->allowEmptyString('permanent');

		$validator
			->boolean('est_porteur')
			->allowEmptyString('est_porteur');

		$validator
			->dateTime('date_creation')
			->allowEmptyDateTime('date_creation');

		$validator
			->dateTime('date_sortie')
			->allowEmptyDateTime('date_sortie');

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
		$rules->add($rules->isUnique(['email']));
		$rules->add($rules->existsIn(['lieu_travail_id'], 'LieuTravails'));
		$rules->add($rules->existsIn(['equipe_id'], 'Equipes'));

		return $rules;
	}
}
