<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipesProjetsFixture
 */
class EquipesProjetsFixture extends TestFixture
{
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'equipe_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'projet_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'_indexes' => [
			'equipe_id' => ['type' => 'index', 'columns' => ['equipe_id'], 'length' => []],
			'projet_id' => ['type' => 'index', 'columns' => ['projet_id'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['equipe_id', 'projet_id'], 'length' => []],
			'fk_equipes_projets_1' => ['type' => 'foreign', 'columns' => ['equipe_id'], 'references' => ['equipes', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
			'fk_equipes_projets_2' => ['type' => 'foreign', 'columns' => ['projet_id'], 'references' => ['projets', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
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
				'projet_id' => 1
			],
		];
		parent::init();
	}
}
