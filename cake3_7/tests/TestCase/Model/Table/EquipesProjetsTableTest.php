<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipesProjetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipesProjetsTable Test Case
 */
class EquipesProjetsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var EquipesProjetsTable
	 */
	public $EquipesProjets;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.EquipesProjets',
		'app.Equipes',
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
		$config = TableRegistry::getTableLocator()->exists('EquipesProjets') ? [] : ['className' => EquipesProjetsTable::class];
		$this->EquipesProjets = TableRegistry::getTableLocator()->get('EquipesProjets', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->EquipesProjets);

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
