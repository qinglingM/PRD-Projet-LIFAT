<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FichiersFixture
 */
class FichiersFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
		'nom' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'titre' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'description' => ['type' => 'string', 'length' => 500, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
		'date_upload' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
		'membre_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'membre_id' => ['type' => 'index', 'columns' => ['membre_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
			'nom' => ['type' => 'unique', 'columns' => ['nom'], 'length' => []],
			'fk_fichiers_1' => ['type' => 'foreign', 'columns' => ['membre_id'], 'references' => ['membres', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
				'id' => 1,
				'nom' => 'Lorem ipsum dolor sit amet',
				'titre' => 'Lorem ipsum dolor sit amet',
				'description' => 'Lorem ipsum dolor sit amet',
				'date_upload' => '2019-05-22',
				'membre_id' => 1
			],
		];
		parent::init();
	}
}
