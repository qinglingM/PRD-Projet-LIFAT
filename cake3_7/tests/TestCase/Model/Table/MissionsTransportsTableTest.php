<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MissionsTransportsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MissionsTransportsTable Test Case
 */
class MissionsTransportsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var MissionsTransportsTable
	 */
	public $MissionsTransports;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.MissionsTransports',
		'app.Missions',
		'app.Transports'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('MissionsTransports') ? [] : ['className' => MissionsTransportsTable::class];
		$this->MissionsTransports = TableRegistry::getTableLocator()->get('MissionsTransports', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->MissionsTransports);

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
	 * Test buildRules method
	 *
	 * @return void
	 */
	public function testBuildRules()
	{
		$this->markTestIncomplete('Not implemented yet.');
	}
}
