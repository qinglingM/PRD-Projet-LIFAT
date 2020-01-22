<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LieuTravailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LieuTravailsTable Test Case
 */
class LieuTravailsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var LieuTravailsTable
	 */
	public $LieuTravails;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.LieuTravails',
		'app.Membres'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('LieuTravails') ? [] : ['className' => LieuTravailsTable::class];
		$this->LieuTravails = TableRegistry::getTableLocator()->get('LieuTravails', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->LieuTravails);

		parent::tearDown();
	}

	/**
	 * Test initialize method
	 *
	 * @return void
	 */
	public function testInitialize()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test validationDefault method
	 *
	 * @return void
	 */
	public function testValidationDefault()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test buildRules method
	 *
	 * @return void
	 */
	public function testBuildRules()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}
}
