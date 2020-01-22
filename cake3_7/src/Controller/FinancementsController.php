<?php

namespace App\Controller;

use App\Model\Entity\Financement;
use App\Model\Table\FinancementsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Financements Controller
 *
 * @property FinancementsTable $Financements
 *
 * @method Financement[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinancementsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->set('searchLabelExtra', 'nationalité et/ou nom');

		$query = $this->Financements
			// Use the plugins 'search' custom finder and pass in the
			// processed query params
			->find('search', ['search' => $this->request->getQueryParams()]);

		$this->set('financements', $this->paginate($query));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Financement id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$financement = $this->Financements->get($id, [
			'contain' => ['Projets']
		]);

		$this->set('financement', $financement);
	}

	/**
	 * Edit method ; if $id is null it behaves like an add method instead.
	 *
	 * @param string|null $id Financement id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ($id == null)
			$financement = $this->Financements->newEntity();
		else
			$financement = $this->Financements->get($id, [
				'contain' => []
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$financement = $this->Financements->patchEntity($financement, $this->request->getData());
			if ($this->Financements->save($financement)) {
				$this->Flash->success(__('Le financement a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du financement a échoué. Merci de ré-essayer.'));
		}
		$this->set(compact('financement'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Financement id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$financement = $this->Financements->get($id);
		if ($this->Financements->delete($financement)) {
			$this->Flash->success(__('Le financement à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du financement à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/*
	 * Autorisations (isAuthorized()) : rien de plus, donc seul l'admin peut ajouter / modifier / supprimer les financements.
	 */
}
