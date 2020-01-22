<?php

namespace App\Controller;

use App\Model\Entity\DirigeantsTheses;
use App\Model\Table\DirigeantsThesesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * DirigeantsTheses Controller
 *
 * @property DirigeantsThesesTable $DirigeantsTheses
 *
 * @method DirigeantsTheses[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class DirigeantsThesesController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Dirigeants', 'Theses']
		];
		$dirigeantsTheses = $this->paginate($this->DirigeantsTheses);

		$this->set(compact('dirigeantsTheses'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Dirigeants Theses id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$dirigeantsTheses = $this->DirigeantsTheses->get($id, [
			'contain' => ['Dirigeants', 'Theses']
		]);

		$this->set('dirigeantsTheses', $dirigeantsTheses);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$dirigeantsTheses = $this->DirigeantsTheses->newEntity();
		if ($this->request->is('post')) {
			$dirigeantsTheses = $this->DirigeantsTheses->patchEntity($dirigeantsTheses, $this->request->getData());
			if ($this->DirigeantsTheses->save($dirigeantsTheses)) {
				$this->Flash->success(__('Le dirigeant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du dirigeant a échoué. Merci de ré-essayer.'));
		}
		$dirigeants = $this->DirigeantsTheses->Dirigeants->find('list', ['limit' => 200]);
		$theses = $this->DirigeantsTheses->Theses->find('list', ['limit' => 200]);
		$this->set(compact('dirigeantsTheses', 'dirigeants', 'theses'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Dirigeants Theses id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$dirigeantsTheses = $this->DirigeantsTheses->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$dirigeantsTheses = $this->DirigeantsTheses->patchEntity($dirigeantsTheses, $this->request->getData());
			if ($this->DirigeantsTheses->save($dirigeantsTheses)) {
				$this->Flash->success(__('Le dirigeant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du dirigeant a échoué. Merci de ré-essayer.'));
		}
		$dirigeants = $this->DirigeantsTheses->Dirigeants->find('list', ['limit' => 200]);
		$theses = $this->DirigeantsTheses->Theses->find('list', ['limit' => 200]);
		$this->set(compact('dirigeantsTheses', 'dirigeants', 'theses'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Dirigeants Theses id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$dirigeantsTheses = $this->DirigeantsTheses->get($id);
		if ($this->DirigeantsTheses->delete($dirigeantsTheses)) {
			$this->Flash->success(__('Le dirigeant à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du dirigeant à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
