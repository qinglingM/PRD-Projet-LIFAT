<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BudgetsAnnuelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BudgetsAnnuelsTable Test Case
 */
class BudgetsAnnuelsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var BudgetsAnnuelsTable
	 */
	public $BudgetsAnnuels;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.BudgetsAnnuels',
		'app.Projets'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('BudgetsAnnuels') ? [] : ['className' => BudgetsAnnuelsTable::class];
		$this->BudgetsAnnuels = TableRegistry::getTableLocator()->get('BudgetsAnnuels', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->BudgetsAnnuels);

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
