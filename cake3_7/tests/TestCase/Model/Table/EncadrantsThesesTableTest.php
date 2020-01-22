<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EncadrantsThesesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EncadrantsThesesTable Test Case
 */
class EncadrantsThesesTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var EncadrantsThesesTable
	 */
	public $EncadrantsTheses;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.EncadrantsTheses',
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
		$config = TableRegistry::getTableLocator()->exists('EncadrantsTheses') ? [] : ['className' => EncadrantsThesesTable::class];
		$this->EncadrantsTheses = TableRegistry::getTableLocator()->get('EncadrantsTheses', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->EncadrantsTheses);

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
