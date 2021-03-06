<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;

class ExportForm extends Form
{

	protected function _buildSchema(Schema $schema)
	{
		return $schema->addField('exportGraphe', ['type' => 'boolean'])
			->addField('exportListe', ['type' => 'boolean'])
			->addField('exportRapportAnnuel', ['type' => 'boolean'])
			->addField('typeGraphe', ['type' => 'string'])
			->addField('typeListe', ['type' => 'string'])
			->addField('typeRapportAnnuel',['type' => 'string'])
			->addField('dateDebut', ['type' => 'date'])
			->addField('dateFin', ['type' => 'date'])
			->addField('encadrant', ['type' => 'string'])
			->addField('equipe', ['type' => 'string'])
			->addField('membre', ['type' => 'string']);
	}

	protected function _execute(array $data)
	{
		return true;
	}
}