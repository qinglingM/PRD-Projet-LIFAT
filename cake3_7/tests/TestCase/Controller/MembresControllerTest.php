<?php

namespace App\Test\TestCase\Controller;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MembresController Test Case
 */
class MembresControllerTest extends TestCase
{
	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Membres',
		'app.LieuTravails'
	];

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex()
	{
		// debug_to_console("testfhgfhfvvvv");
		// $this->get('/membres/index');
		// $this->assertResponseOk();

		$this->markTestIncomplete('Not implemented yet.');
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
