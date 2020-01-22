<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirigeantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirigeantsTable Test Case
 */
class DirigeantsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var DirigeantsTable
	 */
	public $Dirigeants;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Dirigeants',
		'app.Theses'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('Dirigeants') ? [] : ['className' => DirigeantsTable::class];
		$this->Dirigeants = TableRegistry::getTableLocator()->get('Dirigeants', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Dirigeants);

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
