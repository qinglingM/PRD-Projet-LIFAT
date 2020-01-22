<?php

namespace App\Controller;

use App\Model\Entity\Theses;
use App\Model\Table\ThesesTable;
use Cake\Chronos\Date;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * Theses Controller
 *
 * @property ThesesTable $Theses
 *
 * @method Theses[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ThesesController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->set('searchLabelExtra', "sujet et/ou type");

		$query = $this->Theses
			// Use the plugins 'search' custom finder and pass in the
			// processed query params
			->find('search', ['search' => $this->request->getQueryParams()]);

		$this->paginate = [
			'contain' => ['Membres', 'Financements']
		];

		$this->set('theses', $this->paginate($query));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Theses id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$theses = $this->Theses->get($id, [
			'contain' => ['Membres', 'Financements', 'Dirigeants', 'Encadrants']
		]);

		$this->loadModel('Membres');

		foreach ($theses->dirigeants as &$dirigeants) {
			$dirigeants = $this->Membres->get($dirigeants->dirigeant_id);
		}

		foreach ($theses->encadrants as &$encadrants) {
			$encadrants = $this->Membres->get($encadrants->encadrant_id);
		}

		$this->set('theses', $theses);
	}

	/**
	 * Edit method ; if $id is null it behaves like an add method instead.
	 *
	 * @param string|null $id Theses id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ($id == null)
			$theses = $this->Theses->newEntity();
		else
			$theses = $this->Theses->get($id, [
				'contain' => ['Dirigeants', 'Encadrants']
			]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$theses = $this->Theses->patchEntity($theses, $this->request->getData());
			if ($this->Theses->save($theses)) {
				$this->Flash->success(__('La theses a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout de la theses a échoué. Merci de ré-essayer.'));
		}
		$membres = $this->Theses->Membres->find('list', ['limit' => 200]);
		$financements = $this->Theses->Financements->find('list', ['limit' => 200]);
		$dirigeants = $this->Theses->Dirigeants->find('list', ['limit' => 200]);
		$encadrants = $this->Theses->Encadrants->find('list', ['limit' => 200]);
		$this->set(compact('theses', 'membres', 'financements', 'dirigeants', 'encadrants'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Theses id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$theses = $this->Theses->get($id);
		if ($this->Theses->delete($theses)) {
			$this->Flash->success(__('La these à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression de la these à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}


	/**
	 * Retourne le nombre de soutenance en tenant compte d'un lapse de temps s'il est renseigne
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return int : nombre de soutenances
	 */
	public function nombreDeSoutenances($dateEntree = null, $dateFin = null)
	{
		$query = $this->Theses->find();
		if ($dateEntree && $dateFin) {
			$query->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_fin', $dateEntree, $dateFin);
			});
		}
		$count = $query->count();
		//die(strval($count));
		$this->set(compact('query', 'count'));
	}

	/**
	 * Retourne la liste des types trie selon leur type en tenant compte d'un lapse de temps s'il est renseigne
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return int : nombre de soutenances
	 */
	public function listeTheseParType($dateEntree = null, $dateFin = null)
	{
		$this->loadModel('Theses');
		$result = $this->Theses->find('all');

		if ($dateEntree && $dateFin) {
			$result = $result->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_fin', $dateEntree, $dateFin);
			});
		}
		$result = $result->toArray();

		foreach ($result as $key => $row) {
			$type[$key] = $row['type'];
		}
		array_multisort($type, SORT_ASC, SORT_STRING, $result);

		return $result;
	}

	/**
	 * Retourne la liste des theses en cours
	 * @return array : liste des theses
	 */
	public function listeThesesEnCours()
	{
		$now = strval(Date::now());
		$result = $this->Theses->find('all')->where(['date_debut <= ' => $now])->andWhere(['date_fin >= ' => $now])->toArray();
		return $result;
	}

	/**
	 * Retourne le nombre de soutenances pour une année donnée en paramètre
	 * @param null $annee
	 * @return $count
	 */
	public function nombreSoutenancesParAnnee($annee = null)
	{
		$result = $this->Theses->find('all')->where(['YEAR(date_fin) = ' => $annee]);
		$count = $result->count();
		return $count;
	}

	/**
	 * Retourne la liste des soutenances pour une année donnée en paramètre
	 * @return array : liste des soutenances
	 */
	public function listeSoutenancesParAnnee($annee = null)
	{
		$result = $this->Theses->find('all')->where(['YEAR(date_fin) = ' => $annee])->toArray();
		return $result;
	}


	/**
	 * Retourne la liste des soutenances
	 * @return array : liste des soutenances
	 */
	public function listeSoutenances()
	{
		$result = $this->Theses->find('all')->toArray();
		return $result;
	}


	/**
	 * Retourne le nombre de soutenances d'Habilitation à Diriger les Recherches
	 * @param null $dateEntree , dateFin
	 * @return $count : nombre de soutenances
	 */
	public function nombreSoutenancesHDR($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$result = $this->Theses->find('all')
				->where(['est_hdr' => 1])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_debut', $dateEntree, $dateFin);
				});
			$count = $result->count();
		} else {
			$result = $this->Theses->find('all')
				->where(['est_hdr' => 1]);
			$count = $result->count();
		}
		return $count;
	}

	/**
	 * Retourne la liste des soutenances d'Habilitation à Diriger les Recherches
	 * @param null $dateEntree , dateFin
	 * @return array : liste des soutenances
	 */
	public function listeSoutenancesHDR($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$result = $this->Theses->find('all')
				->where(['est_hdr' => 1])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_debut', $dateEntree, $dateFin);
				})
				->toArray();
		} else {
			$result = $this->Theses->find('all')
				->where(['est_hdr' => 1])
				->toArray();
		}
		return $result;
	}

	/**
	 * Retourne la liste des thèses par équipe selon l'id donné
	 * @param null $idEquipe
	 * @param null $dateEntree
	 * @param null $dateFin
	 * @return array
	 */
	public function listeThesesParEquipe($idEquipe = null, $dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$this->loadModel('Membres');
			$result = $this->Membres->find()
				->select(['id'])
				->where(['equipe_id' => $idEquipe])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_debut', $dateEntree, $dateFin);
				})
				->toArray();
			$result2 = $this->Theses->find('all')
				->where(['auteur_id' => $result[0]['id']])
				->toArray();
		} else {
			$this->loadModel('Membres');
			$result = $this->Membres->find()
				->select(['id'])
				->where(['equipe_id' => $idEquipe])
				->toArray();
			$result2 = $this->Theses->find('all')
				->where(['auteur_id' => $result[0]['id']])
				->toArray();
		}
		return $result2;
	}

	/**
	 * Checks the currently logged in user's rights to access a page (called when changing pages).
	 * @param $user : the user currently logged in
	 * @return bool : whether the user is allowed (or not) to access the requested page
	 */
	public function isAuthorized($user)
	{
		if (parent::isAuthorized($user) === true) {
			return true;
		} else if ($user['actif'] != true) {
			//	Les comptes non activés n'ont aucun droit
			return false;
		} else {
			//	Tous les membres permanents ont tous les droits sur les thèses
			if ($user['permanent'] === true) {
				return true;
			}
		}
		return false;
	}
}
