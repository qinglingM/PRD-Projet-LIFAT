<?php

namespace App\Controller;

use App\Model\Entity\Equipe;
use App\Model\Table\EquipesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Equipes Controller
 *
 * @property EquipesTable $Equipes
 *
 * @method Equipe[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipesController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->set('searchLabelExtra', "nom d'équipe");

		$query = $this->Equipes
			// Use the plugins 'search' custom finder and pass in the
			// processed query params
			->find('search', ['search' => $this->request->getQueryParams()]);

		$this->paginate = [
			'contain' => ['Membres']
		];

		$this->set('equipes', $this->paginate($query));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Equipe id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$equipe = $this->Equipes->get($id, [
			'contain' => ['Membres', 'Projets', 'EquipesResponsables']
		]);

		// Chargement des entités membres en tant que membres de l'équipe
		$this->loadModel('Membres');
		$query = $this->Membres->find('all')
			->where(['Membres.equipe_id =' => $equipe->id]);
		$equipe->membres = $query->all();

		// Chargement de l'entité membre en tant que responsables de l'équipe
		$query = $this->Membres->find('all')
			->where(['Membres.id =' => $equipe->responsable_id])
			->limit(1);
		$equipe->equipes_responsables = $query->first();

		$this->set('equipe', $equipe);
	}

	/**
	 * Edit method ; if $id is null it behaves like an add method instead.
	 *
	 * @param string|null $id Equipe id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ($id == null)
			$equipe = $this->Equipes->newEntity();
		else
			$equipe = $this->Equipes->get($id, [
				'contain' => ['Projets']
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$equipe = $this->Equipes->patchEntity($equipe, $this->request->getData());
			if ($this->Equipes->save($equipe)) {
				$this->Flash->success(__('L\'équipe a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de l\'équipe a échoué. Merci de ré-essayer.'));
		}
		$membres = $this->Equipes->Membres->find('list', ['limit' => 200]);
		$projets = $this->Equipes->Projets->find('list', ['limit' => 200]);
		$this->set(compact('equipe', 'membres', 'projets'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Equipe id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$equipe = $this->Equipes->get($id);
		if ($this->Equipes->delete($equipe)) {
			$this->Flash->success(__('L\'équipe à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression de l\'équipe à échoué..'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Renvoies le nom de l'equipe selectionnee
	 *
	 * @param string|null $id Equipe id.
	 * @return string nom de l'equipe
	 */
	public function getNomParId($id = null)
	{
		$result = $this->Equipes->find("all")
			->where(['id' => $id])
			->select(['nom_equipe'])
			->first()
			->toArray();

		return $result["nom_equipe"];
	}

	/*
	 * Autorisations (isAuthorized()) : rien de plus, donc seul l'admin peut modifier / supprimer les équipes.
	 */
}
