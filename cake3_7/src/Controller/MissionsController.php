<?php

namespace App\Controller;

use App\Model\Entity\Mission;
use App\Model\Entity\Membre;
use App\Model\Table\MissionsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;


/**
 * Missions Controller
 *
 * @property MissionsTable $Missions
 *
 * @method Mission[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class MissionsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->set('searchLabelExtra', "Numéro de mission");

		$query = $this->Missions
		// Use the plugins 'search' custom finder and pass in the
		// processed query params
		->find('search', ['search' => $this->request->getQueryParams()]);

		$this->paginate = [
			'contain' => ['Projets', 'Lieus', 'Motifs']
		];
		$this->set('missions', $this->paginate($query));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Mission id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$mission = $this->Missions->get($id, [
			'contain' => ['Projets', 'Lieus', 'Motifs', 'Transports','Membres']
		]);

		$this->set('mission', $mission);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Mission id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ($id == null)
			$mission = $this->Missions->newEntity();
		else
			$mission = $this->Missions->get($id, [
				'contain' => ['Transports']
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$mission = $this->Missions->patchEntity($mission, $this->request->getData());
			if ($this->Missions->save($mission)) {
				$this->Flash->success(__('The mission has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The mission could not be saved. Please, try again.'));
		}
		$projets = $this->Missions->Projets->find('list', ['limit' => 200]);
		$lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
		$motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
		$transports = $this->Missions->Transports->find('list', ['limit' => 200]);
		$membres = $this->Missions->Membres->find('list',['limit' => 200]);
		$this->set(compact('mission', 'projets', 'lieus', 'motifs', 'transports','membres'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Mission id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$mission = $this->Missions->get($id);
		if ($this->Missions->delete($mission)) {
			$this->Flash->success(__('The mission has been deleted.'));
		} else {
			$this->Flash->error(__('The mission could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}



	function _fileGeneration($id, $fileName = null) {
	
		$this->loadModel('Membres');
		$this->loadModel('Transports');

		// Modification GTHWeb 20-01-2020
	
		include(dirname(__FILE__) . '/Component/generator.php');
		//require '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/src/Controller/Component/generator.php';

		$generator = new \MyGenerator();

		// Fin modification
		$this->Missions->id = $id;
		// $this->Missionsa->set('id',$id);
		// echo $this->Missions->get('membre_id');
		$this->Missions->Membres->id = $this->Missions->find()->select(['membre_id']);
		$this->Missions->Motifs->id = $this->Missions->find()->select(['motif_id']);
		$this->Missions->Lieus->id = $this->Missions->find()->select(['lieu_id']);
		
		$query = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q
			->select(['equipe_id']);
		});

		$this->Missions->Membres->Equipes->id = $query;

		$this->Missions->Projets->id = $this->Missions->find()->select(['projet_id']);

		// $transports = $this->Transport->findAllById($id);

//-----------------------TO DO-------------------------------
		//Ne rajoute la signature du chef d'équipe que si la mission a été validée
		if ($this->Missions->find()->select(['etat']) == 'valide') {
			// selectionnne la signature du chef de l'équipe dont fait partie l'utilisateur
			$cheif = $this->Membres->find('first', array('conditions' => array('User.role' => 'admin', 'User.equipe_id' => $this->Mission->User->field('equipe_id'))));
			// génère la signature du chef
			$cheifSignaturePath = "./img/sign/".$cheif['User']['signature_name'];
		} else {
			$cheifSignaturePath = ""; 
		}
//---------------------------TO DO END----------------------------------
		$generator->setAgent(
			$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['id']);
			}),
			$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['name']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['first_name']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['adresse_agent_1']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['adresse_agent_2']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['residence_admin_1']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['residence_admin_2']);
			}),$this->Missions->find()->contain([
				'Membre',
				'Equipes.id' => function (Query $q) {
				return $q ->select(['nom_equipe']);
				}
			]),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['intitule']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['grade']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['personnel_type']);
			}),$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['signature_name']);
			}),
			// $this->Mission->User->Equipe->field('nom_equipe'),
			$cheifSignaturePath,
			$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['date_naissance']);
			})
		);

		$generator->setMission(
			$this->Missions->find()->contain('Motifs', function (Query $q) {
				return $q
				->select(['nom_motif']);
			}),
			$this->Missions->find()->select(['complement_motif']),
			$this->Missions->find()->contain('Lieus', function (Query $q) {
				return $q
				->select(['nom_lieu']);
			}),
			strftime("%d %B %Y", strtotime($this->Missions->find()->select(['date_depart']))),
			strftime("%Hh%M", strtotime($this->Missions->find()->select(['date_depart']))),
			strftime("%d %B %Y", strtotime($this->Missions->find()->select(['date_retour']))),
			strftime("%Hh%M", strtotime($this->Missions->find()->select(['date_retour']))),
			$this->Missions->find()->select(['nb_repas']),
			$this->Missions->find()->select(['nb_nuites'])
			);

		$generator->setCadreAdmin(
			$this->Missions->Membres->find()->select(['matricule'])
		);

		//debug($generator);

		$generator->setFinance(
			$this->Missions->find()->contain('Projets', function (Query $q) {
				return $q
				->select(['nom_projet']);
			})
			);

		$im_vehicule = '';
		$pf_vehicule = '';
		$transports = $this->Missions->Transports->find();
		// decision about imatriculation
		foreach ($transports as $transport) {
			if ($transport -> type_transport === 'vehicule_service' || $transport->type_transport === 'vehicule_personnel') {
				$im_vehicule = $transport->im_vehicule;
				$pf_vehicule = $transport->pf_vehicule;
				break;
			}
		}

		$generator->setTransport($transports);
		$generator->setTransportBis(
			$im_vehicule,
			$pf_vehicule,
			$this->Missions->find()->select(['commentaire_transport']),
			$this->Missions->find()->contain('Membres', function (Query $q) {
				return $q
				->select(['carte_sncf']);
			}),
			$this->Missions->find()->select(['billet_agence'])
			);

		$sansFrais = false;
		if ($this->Missions->find()->select(['sans_frais'])) 
			$sansFrais = true;

		return $generator->generate($sansFrais, $fileName);

	}


	public function generation($id = null) {
		if ($id != null) {
			$mission = $this->Missions->get($id, [
				'contain' => []
			]);

			if ($this->Auth->user('id') == $mission->membre_id || $this->Auth->user('role') == Membre::ADMIN || $this->Auth->user('role') == Membre::SECRETAIRE )  {
				$this->_fileGeneration($id);
			} else {
				// $this->Session->setFlash('Lecture de l\'OdM impossible : Permission insuffisante','flash_failure');
				$this->Flash->error(__('Lecture de l\'OdM impossible : Permission insuffisante'));
				// $this->redirect(array('controller' => 'missions', 'action' => 'index'));
				$this->redirect(['action' => 'index']);
			}
		} else {
			// $this->Session->setFlash('OdM inexistant','flash_failure');
			$this->Flash->error(__('L\'ordre de mission inexistant.'));
			// $this->redirect(array('controller' => 'missions', 'action' => 'index'));
			$this->redirect(['action' => 'index']);
		}
	}



}
