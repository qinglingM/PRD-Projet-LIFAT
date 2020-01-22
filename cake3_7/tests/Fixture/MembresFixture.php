<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembresFixture
 */
class MembresFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
		'role' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'user', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'nom' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'prenom' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'email' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'passwd' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'adresse_agent_1' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'adresse_agent_2' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'residence_admin_1' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'residence_admin_2' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'type_personnel' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'intitule' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'grade' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'im_vehicule' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'immatriculation du véhicule principal', 'precision' => null, 'fixed' => null],
		'pf_vehicule' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'puissance ficale du véhicule principal', 'precision' => null, 'autoIncrement' => null],
		'signature_name' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'login_cas' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'carte_sncf' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'matricule' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'date_naissance' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
		'actif' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
		'lieu_travail_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'nationalite' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'est_francais' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
		'genre' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
		'hdr' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Certification HDR', 'precision' => null],
		'permanent' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
		'est_porteur' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
		'date_creation' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
		'date_sortie' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
		'_indexes' => [
			'lieu_travail_id' => ['type' => 'index', 'columns' => ['lieu_travail_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
			'signature_name' => ['type' => 'unique', 'columns' => ['signature_name'], 'length' => []],
			'email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
			'login_cas' => ['type' => 'unique', 'columns' => ['login_cas'], 'length' => []],
			'fk_membre_1' => ['type' => 'foreign', 'columns' => ['lieu_travail_id'], 'references' => ['lieu_travails', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
		],
		'_options' => [
			'engine' => 'InnoDB',
			'collation' => 'utf8mb4_general_ci'
		],
	];
	// @codingStandardsIgnoreEnd

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init()
	{
		$this->records = [
			[
				'id' => 1,
				'role' => 'Lorem ipsum dolor sit amet',
				'nom' => 'Lorem ipsum dolor sit a',
				'prenom' => 'Lorem ipsum dolor sit a',
				'email' => 'Lorem ipsum dolor sit amet',
				'passwd' => 'Lorem ipsum dolor sit amet',
				'adresse_agent_1' => 'Lorem ipsum dolor sit amet',
				'adresse_agent_2' => 'Lorem ipsum dolor sit amet',
				'residence_admin_1' => 'Lorem ipsum dolor sit amet',
				'residence_admin_2' => 'Lorem ipsum dolor sit amet',
				'type_personnel' => 'Lorem ipsum dolor sit amet',
				'intitule' => 'Lorem ipsum dolor sit amet',
				'grade' => 'Lorem ipsum dolor sit amet',
				'im_vehicule' => 'Lorem ip',
				'pf_vehicule' => 1,
				'signature_name' => 'Lorem ipsum dolor ',
				'login_cas' => 'Lorem ipsum dolor sit amet',
				'carte_sncf' => 'Lorem ipsum dolor sit amet',
				'matricule' => 1,
				'date_naissance' => '2019-03-27 08:14:34',
				'actif' => 1,
				'lieu_travail_id' => 1,
				'nationalite' => 'Lorem ipsum dolor ',
				'est_francais' => 1,
				'genre' => 'L',
				'hdr' => 1,
				'permanent' => 1,
				'est_porteur' => 1,
				'date_creation' => '2019-03-27 08:14:34',
				'date_sortie' => '2019-03-27 08:14:34'
			],
		];
		parent::init();
	}
}
