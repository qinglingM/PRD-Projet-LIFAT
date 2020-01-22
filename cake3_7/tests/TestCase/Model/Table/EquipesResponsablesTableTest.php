<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipesResponsablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipesResponsablesTable Test Case
 */
class EquipesResponsablesTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var EquipesResponsablesTable
	 */
	public $EquipesResponsables;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.EquipesResponsables',
		'app.Equipes',
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
		$config = TableRegistry::getTableLocator()->exists('EquipesResponsables') ? [] : ['className' => EquipesResponsablesTable::class];
		$this->EquipesResponsables = TableRegistry::getTableLocator()->get('EquipesResponsables', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->EquipesResponsables);

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
