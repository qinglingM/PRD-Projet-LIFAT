<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EncadrantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EncadrantsTable Test Case
 */
class EncadrantsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var EncadrantsTable
	 */
	public $Encadrants;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Encadrants',
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
		$config = TableRegistry::getTableLocator()->exists('Encadrants') ? [] : ['className' => EncadrantsTable::class];
		$this->Encadrants = TableRegistry::getTableLocator()->get('Encadrants', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Encadrants);

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
