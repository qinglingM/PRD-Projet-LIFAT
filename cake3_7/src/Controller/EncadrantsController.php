<?php

namespace App\Controller;

use App\Model\Entity\Encadrant;
use App\Model\Table\EncadrantsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Encadrants Controller
 *
 * @property EncadrantsTable $Encadrants
 *
 * @method Encadrant[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EncadrantsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$encadrants = $this->paginate($this->Encadrants);

		$this->set(compact('encadrants'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Encadrant id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$encadrant = $this->Encadrants->get($id, [
			'contain' => ['Theses', 'Encadrants']
		]);

		$this->set('encadrant', $encadrant);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$encadrant = $this->Encadrants->newEntity();
		if ($this->request->is('post')) {
			$encadrant = $this->Encadrants->patchEntity($encadrant, $this->request->getData());
			if ($this->Encadrants->save($encadrant)) {
				$this->Flash->success(__('L\'encadrant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de l\'encadrant a échoué. Merci de ré-essayer.'));
		}
		$theses = $this->Encadrants->Theses->find('list', ['limit' => 200]);
		$this->set(compact('encadrant', 'theses'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Encadrant id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$encadrant = $this->Encadrants->get($id, [
			'contain' => ['Theses']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$encadrant = $this->Encadrants->patchEntity($encadrant, $this->request->getData());
			if ($this->Encadrants->save($encadrant)) {
				$this->Flash->success(__('L\'encadrant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de l\'encadrant a échoué. Merci de ré-essayer.'));
		}
		$theses = $this->Encadrants->Theses->find('list', ['limit' => 200]);
		$this->set(compact('encadrant', 'theses'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Encadrant id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$encadrant = $this->Encadrants->get($id);
		if ($this->Encadrants->delete($encadrant)) {
			$this->Flash->success(__('L\'encadrant à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression de l\'encadrant à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}