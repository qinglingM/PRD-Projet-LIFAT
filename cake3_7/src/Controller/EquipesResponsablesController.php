<?php

namespace App\Controller;

use App\Model\Entity\EquipesResponsable;
use App\Model\Table\EquipesResponsablesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * EquipesResponsables Controller
 *
 * @property EquipesResponsablesTable $EquipesResponsables
 *
 * @method EquipesResponsable[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipesResponsablesController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Equipes', 'Membres']
		];
		$equipesResponsables = $this->paginate($this->EquipesResponsables);

		$this->set(compact('equipesResponsables'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Equipes Responsable id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$equipesResponsable = $this->EquipesResponsables->get($id, [
			'contain' => ['Equipes', 'Membres']
		]);

		$this->set('equipesResponsable', $equipesResponsable);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$equipesResponsable = $this->EquipesResponsables->newEntity();
		if ($this->request->is('post')) {
			$equipesResponsable = $this->EquipesResponsables->patchEntity($equipesResponsable, $this->request->getData());
			if ($this->EquipesResponsables->save($equipesResponsable)) {
				$this->Flash->success(__('Le responsable de l\'équipe a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du responsable de l\'équipe a échoué. Merci de ré-essayer.'));
		}
		$equipes = $this->EquipesResponsables->Equipes->find('list', ['limit' => 200]);
		$membres = $this->EquipesResponsables->Membres->find('list', ['limit' => 200]);
		$this->set(compact('equipesResponsable', 'equipes', 'membres'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Equipes Responsable id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$equipesResponsable = $this->EquipesResponsables->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$equipesResponsable = $this->EquipesResponsables->patchEntity($equipesResponsable, $this->request->getData());
			if ($this->EquipesResponsables->save($equipesResponsable)) {
				$this->Flash->success(__('Le responsable de l\'équipe a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du responsable de l\'équipe a échoué. Merci de ré-essayer.'));
		}
		$equipes = $this->EquipesResponsables->Equipes->find('list', ['limit' => 200]);
		$membres = $this->EquipesResponsables->Membres->find('list', ['limit' => 200]);
		$this->set(compact('equipesResponsable', 'equipes', 'membres'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Equipes Responsable id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$equipesResponsable = $this->EquipesResponsables->get($id);
		if ($this->EquipesResponsables->delete($equipesResponsable)) {
			$this->Flash->success(__('Le responsable de l\'équipe à été supprimé .'));
		} else {
			$this->Flash->error(__('La suppression du responsable de l\'équipe à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
