<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirigeantsThesesFixture
 */
class DirigeantsThesesFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'dirigeant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'these_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'these_key' => ['type' => 'index', 'columns' => ['these_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['dirigeant_id', 'these_id'], 'length' => []],
			'dirigeant_key' => ['type' => 'foreign', 'columns' => ['dirigeant_id'], 'references' => ['dirigeants', 'dirigeant_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
			'these_key' => ['type' => 'foreign', 'columns' => ['these_id'], 'references' => ['theses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
				'dirigeant_id' => 1,
				'these_id' => 1
			],
		];
		parent::init();
	}
}
