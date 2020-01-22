<?php

namespace App\Controller;

use App\Model\Entity\Dirigeant;
use App\Model\Table\DirigeantsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Dirigeants Controller
 *
 * @property DirigeantsTable $Dirigeants
 *
 * @method Dirigeant[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class DirigeantsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$dirigeants = $this->paginate($this->Dirigeants);

		$this->set(compact('dirigeants'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Dirigeant id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$dirigeant = $this->Dirigeants->get($id, [
			'contain' => ['Theses', 'Dirigeants']
		]);

		$this->set('dirigeant', $dirigeant);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$dirigeant = $this->Dirigeants->newEntity();
		if ($this->request->is('post')) {
			$dirigeant = $this->Dirigeants->patchEntity($dirigeant, $this->request->getData());
			if ($this->Dirigeants->save($dirigeant)) {
				$this->Flash->success(__('Le dirigeant à été ajouté.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du dirigeant a échoué. Merci de ré-essayer.'));
		}
		$theses = $this->Dirigeants->Theses->find('list', ['limit' => 200]);
		$this->set(compact('dirigeant', 'theses'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Dirigeant id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$dirigeant = $this->Dirigeants->get($id, [
			'contain' => ['Theses']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$dirigeant = $this->Dirigeants->patchEntity($dirigeant, $this->request->getData());
			if ($this->Dirigeants->save($dirigeant)) {
				$this->Flash->success(__('Le dirigeant à été ajouté.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du budget a échoué. Merci de ré-essayer.'));
		}
		$theses = $this->Dirigeants->Theses->find('list', ['limit' => 200]);
		$this->set(compact('dirigeant', 'theses'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Dirigeant id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$dirigeant = $this->Dirigeants->get($id);
		if ($this->Dirigeants->delete($dirigeant)) {
			$this->Flash->success(__('Le dirigeant à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du dirigeant à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
