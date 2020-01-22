<?php

namespace App\Controller;

use App\Model\Entity\MissionsTransport;
use App\Model\Table\MissionsTransportsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * MissionsTransports Controller
 *
 * @property MissionsTransportsTable $MissionsTransports
 *
 * @method MissionsTransport[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class MissionsTransportsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Missions', 'Transports']
		];
		$missionsTransports = $this->paginate($this->MissionsTransports);

		$this->set(compact('missionsTransports'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Missions Transport id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$missionsTransport = $this->MissionsTransports->get($id, [
			'contain' => ['Missions', 'Transports']
		]);

		$this->set('missionsTransport', $missionsTransport);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$missionsTransport = $this->MissionsTransports->newEntity();
		if ($this->request->is('post')) {
			$missionsTransport = $this->MissionsTransports->patchEntity($missionsTransport, $this->request->getData());
			if ($this->MissionsTransports->save($missionsTransport)) {
				$this->Flash->success(__('The missions transport has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The missions transport could not be saved. Please, try again.'));
		}
		$missions = $this->MissionsTransports->Missions->find('list', ['limit' => 200]);
		$transports = $this->MissionsTransports->Transports->find('list', ['limit' => 200]);
		$this->set(compact('missionsTransport', 'missions', 'transports'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Missions Transport id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$missionsTransport = $this->MissionsTransports->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$missionsTransport = $this->MissionsTransports->patchEntity($missionsTransport, $this->request->getData());
			if ($this->MissionsTransports->save($missionsTransport)) {
				$this->Flash->success(__('The missions transport has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The missions transport could not be saved. Please, try again.'));
		}
		$missions = $this->MissionsTransports->Missions->find('list', ['limit' => 200]);
		$transports = $this->MissionsTransports->Transports->find('list', ['limit' => 200]);
		$this->set(compact('missionsTransport', 'missions', 'transports'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Missions Transport id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$missionsTransport = $this->MissionsTransports->get($id);
		if ($this->MissionsTransports->delete($missionsTransport)) {
			$this->Flash->success(__('The missions transport has been deleted.'));
		} else {
			$this->Flash->error(__('The missions transport could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
