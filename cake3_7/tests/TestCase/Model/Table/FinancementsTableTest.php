<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FinancementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FinancementsTable Test Case
 */
class FinancementsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var FinancementsTable
	 */
	public $Financements;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Financements',
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
		$config = TableRegistry::getTableLocator()->exists('Financements') ? [] : ['className' => FinancementsTable::class];
		$this->Financements = TableRegistry::getTableLocator()->get('Financements', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Financements);

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
}
