<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirigeantsFixture
 */
class DirigeantsFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'dirigeant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'dirigeant_id' => ['type' => 'index', 'columns' => ['dirigeant_id'], 'length' => []],
		],
		'_constraints' => [
			'fk_dirigeants_1' => ['type' => 'foreign', 'columns' => ['dirigeant_id'], 'references' => ['membres', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
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
				'dirigeant_id' => 1
			],
		];
		parent::init();
	}
}
