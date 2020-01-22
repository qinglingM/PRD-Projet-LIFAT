<?php

namespace App\Controller;

use App\Model\Entity\BudgetsAnnuel;
use App\Model\Table\BudgetsAnnuelsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * BudgetsAnnuels Controller
 *
 * @property BudgetsAnnuelsTable $BudgetsAnnuels
 *
 * @method BudgetsAnnuel[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class BudgetsAnnuelsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Projets']
		];
		$budgetsAnnuels = $this->paginate($this->BudgetsAnnuels);

		$this->set(compact('budgetsAnnuels'));
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$budgetsAnnuel = $this->BudgetsAnnuels->newEntity();
		if ($this->request->is('post')) {
			$budgetsAnnuel = $this->BudgetsAnnuels->patchEntity($budgetsAnnuel, $this->request->getData());
			if ($this->BudgetsAnnuels->save($budgetsAnnuel)) {
				$this->Flash->success(__('Le budget a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du budget a échoué. Merci de ré-essayer.'));
		}
		$projets = $this->BudgetsAnnuels->Projets->find('list', ['limit' => 200]);
		$this->set(compact('budgetsAnnuel', 'projets'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Budgets Annuel id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if($id != null) {
			$projet_id = explode('.', $id)[0];
			$annee = explode('.', $id)[1];
			$budgetsAnnuel = $this->BudgetsAnnuels->get([$projet_id, $annee], [
				'contain' => ['Projets']
			]);
		}
		else {
			$budgetsAnnuel = $this->BudgetsAnnuels->get($id, [
				'contain' => []
			]);
		}
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$budgetsAnnuel = $this->BudgetsAnnuels->patchEntity($budgetsAnnuel, $this->request->getData());
			if ($this->BudgetsAnnuels->save($budgetsAnnuel)) {
				$this->Flash->success(__('Le budget a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du budget a échoué. Merci de ré-essayer.'));
		}
		$projets = $this->BudgetsAnnuels->Projets->find('list', ['limit' => 200]);
		$this->loadModel('Projets');
		$budgetsAnnuel->titre_projet = $this->Projets->get($budgetsAnnuel->projet_id)['titre'];
		$this->set(compact('budgetsAnnuel', 'projets'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Budgets Annuel id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$budgetsAnnuel = $this->BudgetsAnnuels->get($id);
		if ($this->BudgetsAnnuels->delete($budgetsAnnuel)) {
			$this->Flash->success(__('Le budget à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du budget à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
