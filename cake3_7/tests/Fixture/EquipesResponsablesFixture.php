<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipesResponsablesFixture
 */
class EquipesResponsablesFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'equipe_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'responsable_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'equipe_id' => ['type' => 'index', 'columns' => ['equipe_id'], 'length' => []],
			'responsable_id' => ['type' => 'index', 'columns' => ['responsable_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['equipe_id', 'responsable_id'], 'length' => []],
			'fk_equipes_responsables_1' => ['type' => 'foreign', 'columns' => ['responsable_id'], 'references' => ['membres', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
			'fk_equipes_responsables_2' => ['type' => 'foreign', 'columns' => ['equipe_id'], 'references' => ['equipes', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
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
				'equipe_id' => 1,
				'responsable_id' => 1
			],
		];
		parent::init();
	}
}
