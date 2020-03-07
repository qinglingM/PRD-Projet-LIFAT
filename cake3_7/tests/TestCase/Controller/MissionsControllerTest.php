<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\Fixture\FixtureManager;
/**
 * App\Controller\MissionsController Test Case
 */
class MissionsControllerTest extends TestCase
{
	use IntegrationTestTrait;
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Missions',
		'app.Projets',
		'app.Lieus',
		'app.Motifs',
	];

	public function setUserSession() 
	{
		// Set session data
		$auth=[
			'Auth' => [
				'User' => [
					'id' => 1,
					'role' => 'admin',
					'nom' => 'Admin',
					'prenom' => 'Admin',
					'email' => 'admin@admin.fr',
					'passwd' => 'admin',
					'adresse_agent_1' => '',
					'adresse_agent_2' => '',
					'residence_admin_1' => '',
					'residence_admin_2' => '',
					'type_personnel' => 'PU',
					'intitule' => '',
					'grade' => '',
					'im_vehicule' => 11,
					'pf_vehicule' => 11,
					'signature_name' => 'signatu.jpg',
					'login_cas' => '',
					'carte_sncf' => '',
					'matricule' => NULL,
					'date_naissance' => '2019-02-11',
					'actif' => 1,
					'lieu_travail_id' => 2,
					'nationalite' => '',
					'est_francais' => 1,
					'genre' => 'F',
					'hdr' => 0,
					'permanent' => 1,
					'est_porteur' => 0,
					'date_creation' => '2020-02-12 11:14:46',
					'date_sortie' => ''
					// other keys.
					]
				]
		];
		return $auth;
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex()
	{

		$this->session($this->setUserSession());
		$this->get('/missions/index');
		$this->assertResponseOk();		
		// $this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test view method
	 *
	 * @return void
	 */
	public function testView()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test add method
	 *
	 * @return void
	 */
	public function testAdd()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test edit method
	 *
	 * @return void
	 */
	public function testEdit()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test delete method
	 *
	 * @return void
	 */
	public function testDelete()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

}
