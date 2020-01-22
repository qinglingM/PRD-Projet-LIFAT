<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LieusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LieusTable Test Case
 */
class LieusTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var LieusTable
	 */
	public $Lieus;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Lieus'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('Lieus') ? [] : ['className' => LieusTable::class];
		$this->Lieus = TableRegistry::getTableLocator()->get('Lieus', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Lieus);

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
