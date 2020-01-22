<?php

namespace App\Controller;

use App\Model\Entity\Transport;
use App\Model\Table\TransportsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Transports Controller
 *
 * @property TransportsTable $Transports
 *
 * @method Transport[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransportsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$transports = $this->paginate($this->Transports);

		$this->set(compact('transports'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Transport id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$transport = $this->Transports->get($id, [
			'contain' => ['Missions']
		]);

		$this->set('transport', $transport);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$transport = $this->Transports->newEntity();
		if ($this->request->is('post')) {
			$transport = $this->Transports->patchEntity($transport, $this->request->getData());
			if ($this->Transports->save($transport)) {
				$this->Flash->success(__('The transport has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The transport could not be saved. Please, try again.'));
		}
		$missions = $this->Transports->Missions->find('list', ['limit' => 200]);
		$this->set(compact('transport', 'missions'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Transport id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$transport = $this->Transports->get($id, [
			'contain' => ['Missions']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$transport = $this->Transports->patchEntity($transport, $this->request->getData());
			if ($this->Transports->save($transport)) {
				$this->Flash->success(__('The transport has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The transport could not be saved. Please, try again.'));
		}
		$missions = $this->Transports->Missions->find('list', ['limit' => 200]);
		$this->set(compact('transport', 'missions'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Transport id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$transport = $this->Transports->get($id);
		if ($this->Transports->delete($transport)) {
			$this->Flash->success(__('The transport has been deleted.'));
		} else {
			$this->Flash->error(__('The transport could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
