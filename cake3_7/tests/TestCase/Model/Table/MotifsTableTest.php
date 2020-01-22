<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MotifsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MotifsTable Test Case
 */
class MotifsTableTest extends TestCase
{
	/**
	 * Test subject
	 *
	 * @var MotifsTable
	 */
	public $Motifs;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.Motifs',
		'app.Missions'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('Motifs') ? [] : ['className' => MotifsTable::class];
		$this->Motifs = TableRegistry::getTableLocator()->get('Motifs', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown()
	{
		unset($this->Motifs);

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
