<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EncadrantsFixture
 */
class EncadrantsFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'encadrant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'encadrant_id' => ['type' => 'index', 'columns' => ['encadrant_id'], 'length' => []],
		],
		'_constraints' => [
			'fk_encadrants_1' => ['type' => 'foreign', 'columns' => ['encadrant_id'], 'references' => ['membres', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
		],
		'_options' => [
			'engine' => 'InnoDB',
			'collation' => 'utf8mb4_general_ci'
		],
	];
	// @codingStandardsIgnoreEnd

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init()
	{
		$this->records = [
			[
				'encadrant_id' => 1
			],
		];
		parent::init();
	}
}
