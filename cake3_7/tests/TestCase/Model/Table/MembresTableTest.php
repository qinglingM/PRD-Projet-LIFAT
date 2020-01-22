<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MembresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MembresTable Test Case
 */
class MembresTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var MembresTable
	 */
	public $Membres;

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
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('Membres') ? [] : ['className' => MembresTable::class];
		$this->Membres = TableRegistry::getTableLocator()->get('Membres', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Membres);

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
