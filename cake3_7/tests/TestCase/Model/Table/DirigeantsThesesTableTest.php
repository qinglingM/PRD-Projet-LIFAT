<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirigeantsThesesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirigeantsThesesTable Test Case
 */
class DirigeantsThesesTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var DirigeantsThesesTable
	 */
	public $DirigeantsTheses;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.DirigeantsTheses',
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
		$config = TableRegistry::getTableLocator()->exists('DirigeantsTheses') ? [] : ['className' => DirigeantsThesesTable::class];
		$this->DirigeantsTheses = TableRegistry::getTableLocator()->get('DirigeantsTheses', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->DirigeantsTheses);

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
