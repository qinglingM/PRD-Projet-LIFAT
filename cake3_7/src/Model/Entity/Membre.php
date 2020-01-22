<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Membre Entity
 *
 * @property int $id
 * @property string $role
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $email
 * @property string|null $passwd
 * @property string|null $adresse_agent_1
 * @property string|null $adresse_agent_2
 * @property string|null $residence_admin_1
 * @property string|null $residence_admin_2
 * @property string|null $type_personnel
 * @property string|null $intitule
 * @property string|null $grade
 * @property string $im_vehicule
 * @property int $pf_vehicule
 * @property string $signature_name
 * @property string|null $login_cas
 * @property string|null $carte_sncf
 * @property int|null $matricule
 * @property FrozenTime|null $date_naissance
 * @property bool|null $actif
 * @property int|null $lieu_travail_id
 * @property int|null $equipe_id
 * @property string|null $nationalite
 * @property bool|null $est_francais
 * @property string|null $genre
 * @property bool|null $hdr
 * @property bool|null $permanent
 * @property bool|null $est_porteur
 * @property FrozenTime|null $date_creation
 * @property FrozenTime|null $date_sortie
 *
 * @property LieuTravail $lieu_travail
 * @property Equipe $equipe
 */
class Membre extends Entity
{
	/**
	 * Class constant for the 'admin' role ($membre['role']).
	 */
	const ADMIN = 'admin';

	/**
	 * Class constant for the 'membre' role ($membre['role']).
	 */
	const MEMBRE = 'membre';

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'role' => true,
		'nom' => true,
		'prenom' => true,
		'email' => true,
		'passwd' => true,
		'adresse_agent_1' => true,
		'adresse_agent_2' => true,
		'residence_admin_1' => true,
		'residence_admin_2' => true,
		'type_personnel' => true,
		'intitule' => true,
		'grade' => true,
		'im_vehicule' => true,
		'pf_vehicule' => true,
		'signature_name' => true,
		'login_cas' => true,
		'carte_sncf' => true,
		'matricule' => true,
		'date_naissance' => true,
		'actif' => true,
		'lieu_travail_id' => true,
		'equipe_id' => true,
		'nationalite' => true,
		'est_francais' => true,
		'genre' => true,
		'hdr' => true,
		'permanent' => true,
		'est_porteur' => true,
		'date_creation' => true,
		'date_sortie' => true,
		'lieu_travail' => true
	];

	/**
	 * Fields that are excluded from JSON versions of the entity.
	 *
	 * @var array
	 */
	protected $_hidden = [
		'passwd'
	];

	/**
	 * Teste si le membre ($this) est le chef de l'équipe dont l'id est $equipe_id.
	 * Si $equipe_id est null (ou non renseigné) la fonction teste si le membre est chef d'au moins une équipe.
	 *
	 * @param $equipe_id
	 * @return boolean
	 */
	public function estChefEquipe($equipe_id = null)
	{
		$equipes = TableRegistry::getTableLocator()->get('Equipes');
		$query = $equipes->find()
			->where(['responsable_id' => $this['id']]);

		if (!is_null($equipe_id)) {
			$query->andWhere(['id' => $equipe_id]);
		}

		$query->first();

		return boolval($query->count());
	}

	/**
	 * Function that hashes the user password.
	 * Returns the current hashed password if $value is empty.
	 *
	 * @param $value
	 * @return mixed
	 */
	protected function _setPasswd($value)
	{
		if (strlen($value) > 0) {
			$hasher = new DefaultPasswordHasher();
			return $hasher->hash($value);
		} else {
			return $this['passwd'];
		}
	}
}
