<?php

namespace App\Controller;

use App\Model\Entity\Mission;
use App\Model\Entity\Membre;

use App\Model\Table\MissionsTable;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\ORM\Entity;
use Cake\Collection\CollectionInterface;
use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;



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
		// echo phpversion();
		$this->set('searchLabelExtra', "Numéro de mission");

		$query = $this->Missions
		// Use the plugins 'search' custom finder and pass in the
		// processed query params
		->find('search', ['search' => $this->request->getQueryParams()]);
		//Association tables
		$this->paginate = [
			'contain' => [ 'Projets', 'Lieus', 'Motifs']
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
		$this->loadModel("Membres");

		if ($id == null){
			$mission = $this->Missions->newEntity();
		}
		else{
			$mission = $this->Missions->get($id, [
				'contain' => ['Transports','Membres']
			]);
		}
		// print_r($mission);
		if ($this->request->is(['patch', 'post', 'put'])) {

			$mission = $this->Missions->patchEntity($mission, $this->request->getData());
			$mission->responsable_id = $this->Auth->user('id');
			if ($mission->date_depart < $mission->date_retour){

			if ($this->Missions->save($mission)) {
				$this->Flash->success(__('The mission has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The mission could not be saved. Please, try again.'));
			}
			$this->Flash->error(__('La date de début doit être avant la date de fin.'));
				 return $this->redirect(['action' => 'edit']);

		}
		$projets = $this->Missions->Projets->find('list', ['limit' => 200]);
		$lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
		$motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
		$transports = $this->Missions->Transports->find('list', ['limit' => 200]);
		$membres = $this->Missions->Membres->find('list',['limit' => 200]);
		// $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];

		// $queryy =  $this->Missions->Membres->find()->select(['id','nom','prenom'])->where(['id' => $this->Auth->user('id')])->all()->toArray();
		// $propArray = array('id','nom','prenom');
		// $queryy1 = $queryy[0]->toArray();
		// print_r($queryy[0]->extract($propArray));
		// $membres = $queryy[0]->extract($propArray);
		// print_r(array_slice($queryy1,0,3)) ;
		// $membres = array_column($this->Missions->Membres->find()->select(['id','nom','prenom'])->where(['id' => $this->Auth->user('id')])->all()->toArray(),'responsable_id')[0];
		//$responsableinfo
		//$membres = $this->Missions->Membres->get($this->Auth->user('id'));

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
		// $mission = $this->Missions->patchEntity($mission, $this->request->getData());
		$generator = new \MyGenerator();
		// Fin modification
		$this->Missions->id = $id;
		// echo $this->Missions->id;

		// $this->Missions->Membres->id = $this->Missions->find()->select(['responsable_id'])->where(['id' => $id]);
		// $var1 = $this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray();
		// print_r (array_column($var1,'responsable_id'));

		//-------------- // =  $this->Mission->field('motif_id'); //--------------------------
		// print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id'));
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
		// print_r($this->Missions->Membres->id);
		$this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];
		// print_r($this->Missions->Motifs->id);
		$this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(),'lieu_id')[0];
		//  print_r($this->Missions->Lieus->id);
		//----------------- // = $this->Mission->User->Equipe->id = $this->Mission->User->field('equipe_id'); //-----
		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
		$this->Missions->Membres->Equipes->id = array_column(array_column($result,'membres'),'equipe_id')[0];
		// print_r($this->Missions->Membres->Equipes->id);
		$this->Missions->Projets->id = array_column($this->Missions->find()->select(['projet_id'])->where(['id' => $id])->all()->toArray(),'projet_id');

		//---------------  // transports = $this->Transport->findAllByMissionId($missionId); //--------
		$result1 = $this->Missions->find('all')->InnerJoinWith('MissionsTransports')->select(['MissionsTransports.transport_id'])->where(['Missions.id' => $id])->all()->toArray();
		// echo $result1;
		$result2 = array_column($result1, '_matchingData');
		$result3 = array_column($result2,'MissionsTransports');
		$result4 = array_column($result3,'transport_id');

		$transports = array() ;
		foreach($result4 as $key => $value){
			if(is_array($value)){
				getValue($value);

			}else{
			//  echo $value."<br>";
			$result5 = $this->Missions->MissionsTransports->find('all')->InnerJoinWith('Transports')
				 ->select(['Transports.type_transport'])
				 ->distinct('Transports.type_transport')
				 ->where(['MissionsTransports.transport_id' => $value])->all()->toArray();

				 // ->all()->toArray();
			 $result6 = array_column($result5, '_matchingData');
			 $result7 = array_column($result6,'Transports');
			//  $result8 = array_column($result7,'type_transport');
			// print_r($result7[0]);
			 array_push($transports,$result7[0]);
			//  print_r($transports."<br>");
			}
		}
	//---------------  // End transports//------------------------------------

// //-----------------------TO DO-------------------------------
// 		//Ne rajoute la signature du chef d'équipe que si la mission a été validée
// 		if ($this->Missions->find()->select(['etat']) == 'valide') {
// 			// selectionnne la signature du chef de l'équipe dont fait partie l'utilisateur
// 			$cheif = $this->Membres->find('first', array('conditions' => array('User.role' => 'admin', 'User.equipe_id' => $this->Mission->User->field('equipe_id'))));
// 			// génère la signature du chef
// 			$cheifSignaturePath = "./img/sign/".$cheif['User']['signature_name'];
// 		} else {
// 			$cheifSignaturePath = "";
// 		}

	$result = $this->Missions->find()->contain('Membres', function (Query $q) {
		return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
	$var1 = array_column(array_column($result,'membres'),'equipe_id')[0];
	$equipenom = array_column( $this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $var1])->all()->toArray(),'nom_equipe')[0];
	// print_r($equipenom);

// //---------------------------TO DO END----------------------------------
		$generator->setAgent(
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.id']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'id')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.nom']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'nom')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.prenom']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'prenom')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.adresse_agent_1']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'adresse_agent_1')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.adresse_agent_2']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'adresse_agent_2')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.residence_admin_1']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'residence_admin_1')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.residence_admin_2']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'residence_admin_2')[0],
			$equipenom,
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.intitule']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'intitule')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.grade']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'grade')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.type_personnel']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'type_personnel')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.signature_name']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'signature_name')[0],
			//------------- TO DO ----------------
				// $cheifSignaturePath,
			$equipenom,
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.date_naissance']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'date_naissance')[0]
		);




// $varr = array_column($this->Missions->find()->select(['nb_nuites'])->where(['id' => $id])->all()->toArray(),'nb_nuites')[0];

// print_r($varr);

// $varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
// 	return $q ->select(['lieus.nom_lieu']);})
// 	->where(['Missions.id' => $id])
// 	->all()->toList(),'lieus'),'nom_lieu')[0];

// print_r(array_column($vararray,'timezone'));




		$generator->setMission(
			array_column(array_column($this->Missions->find()->contain('Motifs', function (Query $q) {
				return $q ->select(['motifs.nom_motif']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'motifs'),'nom_motif')[0],

			array_column($this->Missions->find()->select(['complement_motif'])
				->where(['id' => $id])->all()->toArray(),'complement_motif')[0],
			$varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
				return $q ->select(['lieus.nom_lieu']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'lieus'),'nom_lieu')[0],
			array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('d/m/Y'),
			array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('H:i'),
			array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('d/m/Y'),
			array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('H:i'),
			array_column($this->Missions->find()->select(['nb_repas'])->where(['id' => $id])->all()->toArray(),'nb_repas')[0],
			array_column($this->Missions->find()->select(['nb_nuites'])->where(['id' => $id])->all()->toArray(),'nb_nuites')[0]
		);


		$generator->setCadreAdmin(
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.matricule']);})->where(['Missions.id' => $id])->all()->toList(),'membres'),'matricule')[0]
		);

		// //debug($generator);

		$generator->setFinance(
			array_column(array_column($this->Missions->find()->contain('Projets', function (Query $q) {
				return $q ->select(['projets.titre']);})->where(['Missions.id' => $id])->all()->toList(),'projets'),'titre')[0]

		);


// $varr = array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
// 	return $q ->select(['membres.carte_sncf']);})
// 	->where(['Missions.id' => $id])
// 	->all()->toList(),'membres'),'carte_sncf')[0];

// print_r($varr);

		$im_vehicule = '';
		$pf_vehicule = '';
		// print_r($transports);
		// decision about imatriculation
		foreach ($transports as $transport) {
			// print_r($transport);
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
			array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0],
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.carte_sncf']);})
			->where(['Missions.id' => $id])
			->all()->toList(),'membres'),'carte_sncf')[0],
			array_column($this->Missions->find()->select(['billet_agence'])->where(['id' => $id])->all()->toArray(),'billet_agence')[0]

		);



		$sansFrais = false;
		if(array_column($this->Missions->find()->select(['sans_frais'])->where(['id' => $id])->all()->toArray(),'sans_frais')[0]
		)
		$sansFrais = true;

		// print_r($sansFrais);

		return $generator->generate($sansFrais, $fileName);

	}

	public function generation($id = null) {
		$this->loadModel('Membres');
				// printf ($this->Auth->user('id'));

		if ($id != null) {

			$mission = $this->Missions->get($id, [
				'contain' => ['Projets', 'Lieus', 'Motifs', 'Transports','Membres']
			]);
				// print_r($mission->etat);
			if ($this->Auth->user('id') === $mission->responsable_id || $this->Auth->user('role') === Membre::ADMIN || $this->Auth->user('role') === Membre::SECRETAIRE )  {
				$this->_fileGeneration($id);
			} else {
				// $this->Flash->error(__( $mission->responsable_id));
				$this->Flash->error(__('Lecture de l\'OdM impossible : Permission insuffisante'));
				// $this->redirect(array('controller' => 'missions', 'action' => 'index'));
				// echo $mission->responsable_id;
				// printf ($this->Auth->user('id'));
				$this->redirect(['action' => 'index']);
			}
		} else {
			// $this->Session->setFlash('OdM inexistant','flash_failure');
			$this->Flash->error(__('L\'ordre de mission inexistant.'));
			// $this->redirect(array('controller' => 'missions', 'action' => 'index'));
			$this->redirect(['action' => 'index']);
		}
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




	/**
	* validation of an mission order
	*/
	function valid($missionId = null) {

		if ($this->Auth->user('role') == 'admin') {
			$this->Mission->id = $missionId;
			// if mission exist
			if ( $this->Mission->field('user_id') != 0 ) {
				//if ($this->Mission->field('valide') == false) {
				if ($this->Mission->field('etat') != 'valide') {
					// financial element have to be set
					if ( empty($this->data) ) {
						$this->data = $this->Mission->read();
					} else {
						// validate mission
						$this->Mission->set('etat', 'valide');
						$this->Mission->save($this->data);
						$this->_sendValidation($this->Mission->field('id'));
						$this->Session->setFlash('Mission validée','flash_success');
						$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
					}
				}else {
					//la mission est déjà validé
					$this->Session->setFlash('Mission déjà validé','flash_failure');
					$missionId = null;
					$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
				}
			} else {
				//mission does not exist
				$this->Session->setFlash('Mission inexistante','flash_failure');
				$missionId = null;
				$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
			}
		} else {
			//droit insuffisant pour valider une mission
			$this->Session->setFlash('Permission insuffisante pour valider la mission','flash_failure');
			$missionId = null;
			$this->redirect(array('controller' => 'missions', 'action' => 'listMissions'));
		}

	}

}
