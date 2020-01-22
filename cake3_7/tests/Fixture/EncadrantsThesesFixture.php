<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EncadrantsThesesFixture
 */
class EncadrantsThesesFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'encadrant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'these_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'encadrant_id' => ['type' => 'index', 'columns' => ['encadrant_id'], 'length' => []],
			'these_id' => ['type' => 'index', 'columns' => ['these_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['encadrant_id', 'these_id'], 'length' => []],
			'fk_encadrants_theses_1' => ['type' => 'foreign', 'columns' => ['encadrant_id'], 'references' => ['encadrants', 'encadrant_id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
			'fk_encadrants_theses_2' => ['type' => 'foreign', 'columns' => ['these_id'], 'references' => ['theses', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
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
				'encadrant_id' => 1,
				'these_id' => 1
			],
		];
		parent::init();
	}
}
