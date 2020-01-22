<?php

namespace App\Controller;

use App\Model\Entity\EncadrantsTheses;
use App\Model\Table\EncadrantsThesesTable;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * EncadrantsTheses Controller
 *
 * @property EncadrantsThesesTable $EncadrantsTheses
 *
 * @method EncadrantsTheses[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EncadrantsThesesController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Encadrants', 'Theses']
		];
		$encadrantsTheses = $this->paginate($this->EncadrantsTheses);

		$this->set(compact('encadrantsTheses'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Encadrants Theses id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$encadrantsTheses = $this->EncadrantsTheses->get($id, [
			'contain' => ['Encadrants', 'Theses']
		]);

		$this->set('encadrantsTheses', $encadrantsTheses);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$encadrantsTheses = $this->EncadrantsTheses->newEntity();
		if ($this->request->is('post')) {
			$encadrantsTheses = $this->EncadrantsTheses->patchEntity($encadrantsTheses, $this->request->getData());
			if ($this->EncadrantsTheses->save($encadrantsTheses)) {
				$this->Flash->success(__('L\'encadrant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de l\'encadrant a échoué. Merci de ré-essayer.'));
		}
		$encadrants = $this->EncadrantsTheses->Encadrants->find('list', ['limit' => 200]);
		$theses = $this->EncadrantsTheses->Theses->find('list', ['limit' => 200]);
		$this->set(compact('encadrantsTheses', 'encadrants', 'theses'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Encadrants Theses id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$encadrantsTheses = $this->EncadrantsTheses->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$encadrantsTheses = $this->EncadrantsTheses->patchEntity($encadrantsTheses, $this->request->getData());
			if ($this->EncadrantsTheses->save($encadrantsTheses)) {
				$this->Flash->success(__('L\'encadrant a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de l\'encadrant a échoué. Merci de ré-essayer.'));
		}
		$encadrants = $this->EncadrantsTheses->Encadrants->find('list', ['limit' => 200]);
		$theses = $this->EncadrantsTheses->Theses->find('list', ['limit' => 200]);
		$this->set(compact('encadrantsTheses', 'encadrants', 'theses'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Encadrants Theses id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$encadrantsTheses = $this->EncadrantsTheses->get($id);
		if ($this->EncadrantsTheses->delete($encadrantsTheses)) {
			$this->Flash->success(__('L\'encadrant à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression de l\'encadrant à échoué'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Retourne le nombre de theses qu'un encadrant encadre en tenant compte d'un lapse de temps s'il est renseigne
	 * @param $id : id de l'encadrant a chercher
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return int : nombre de theses
	 */
	public function nombreDeThesesParEncadrant($id = null, $dateEntree = null, $dateFin = null)
	{
		$result = $this->EncadrantsTheses->find('all', [
			'conditions' => ['encadrant_id' => $id],
		]);

		if ($dateEntree && $dateFin) {

			$tmp = 0;
			foreach ($result as $row) {
				$this->loadModel('Theses');
				$query = $this->Theses->find('all');
				$query->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('theses.date_fin', $dateEntree, $dateFin);
				})
					->where(['id' => $row->these_id]);
				if ($query->first()) {
					$tmp++;
				}
			}
			$count = $query->count();
			return $count;
		} else {
			$count = $result->count();
			return $count;
		}
	}

	/**
	 * Retourne la liste des theses qu'un encadrant encadre en tenant compte d'un lapse de temps s'il est renseigne
	 * @param $id : id de l'encadrant
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des theses
	 */
	public function listeThesesParEncadrant($id = null, $dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$query = $this->EncadrantsTheses->find('all');
			$query->contain(['Theses']);
			$query->where(['encadrant_id' => $id]);
			$query->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('theses.date_fin', $dateEntree, $dateFin);
			});

			$resultset = array();

			foreach ($query as $row) {
				$resultset[] = $row["thesis"];
			}

			return $resultset;
		} else {
			$this->loadModel('EncadrantsTheses');
			$result = $this->EncadrantsTheses->find('all', [
				'conditions' => ['encadrant_id' => $id],
				'contain' => ['Theses']
			]);

			$resultset = array();
			foreach ($result as $row) {
				$resultset[] = $row["thesis"];
			}

			return $resultset;
		}
	}

	/**
	 * Retourne le nombres des theses qu'un encadrant encadre en tenant compte d'un lapse de temps s'il est renseigne
	 * @param $id : id de l'encadrant
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des theses
	 */
	public function NombreThesesParEncadrant($id = null, $dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$query = $this->EncadrantsTheses->find('all');
			$query->contain(['Theses']);
			$query->where(['encadrant_id' => $id]);
			$query->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('theses.date_fin', $dateEntree, $dateFin);
			});
			$result = $query->count();

			return $result;
		} else {
			$this->loadModel('EncadrantsTheses');
			$result = $this->EncadrantsTheses->find('all', [
				'conditions' => ['encadrant_id' => $id],
				'contain' => ['Theses']
			])
				->count();

			die(strval($result));


			return $result;
		}
	}


	/**
	 * Retourne la liste des encadrants avec leur taux d'encadrement pour une these donnee
	 * @return array : liste des encadrants
	 */
	public function listeEncadrantsAvecTaux($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$this->loadModel('Membres');
			$result = $this->EncadrantsTheses->find()
				->select(['taux'])
				->select($this->Membres)
				->innerJoin(['Membres' => 'membres'], ['encadrant_id = membres.id'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->toArray();

		} else {
			$this->loadModel('Membres');
			$result = $this->EncadrantsTheses->find()
				->select(['taux'])
				->select($this->Membres)
				->innerJoin(['Membres' => 'membres'], ['encadrant_id = membres.id'])
				->toArray();
		}
		return $result;
	}

}

