<?php

namespace App\Controller;

use App\Model\Entity\Lieus;
use App\Model\Table\LieusTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Lieus Controller
 *
 * @property LieusTable $Lieus
 *
 * @method Lieus[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class LieusController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$lieus = $this->paginate($this->Lieus);

		$this->set(compact('lieus'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Lieus id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$lieus = $this->Lieus->get($id, [
			'contain' => []
		]);

		$this->set('lieus', $lieus);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$lieus = $this->Lieus->newEntity();
		if ($this->request->is('post')) {
			$lieus = $this->Lieus->patchEntity($lieus, $this->request->getData());
			if ($this->Lieus->save($lieus)) {
				$this->Flash->success(__('Le lieu a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du lieu a échoué. Merci de ré-essayer.'));
		}
		$this->set(compact('lieus'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Lieus id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$lieus = $this->Lieus->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$lieus = $this->Lieus->patchEntity($lieus, $this->request->getData());
			if ($this->Lieus->save($lieus)) {
				$this->Flash->success(__('Le lieu a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du lieu a échoué. Merci de ré-essayer.'));
		}
		$this->set(compact('lieus'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Lieus id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$lieus = $this->Lieus->get($id);
		if ($this->Lieus->delete($lieus)) {
			$this->Flash->success(__('Le lieu à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du lieu à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
