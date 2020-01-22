<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MissionsTransportsFixture
 */
class MissionsTransportsFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'mission_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'transport_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'transport_id' => ['type' => 'index', 'columns' => ['transport_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['mission_id', 'transport_id'], 'length' => []],
			'missions_transports_ibfk_1' => ['type' => 'foreign', 'columns' => ['mission_id'], 'references' => ['missions', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
			'missions_transports_ibfk_2' => ['type' => 'foreign', 'columns' => ['transport_id'], 'references' => ['transports', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
				'mission_id' => 1,
				'transport_id' => 1
			],
		];
		parent::init();
	}
}
