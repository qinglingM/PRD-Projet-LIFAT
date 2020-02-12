<?php

namespace App\Controller;

use App\Model\Entity\Mission;
use App\Model\Entity\Membre;
use App\Model\Entity\Motif;
use App\Model\Entity\Lieu;
use App\Model\Entity\Transport;
use App\Model\Table\MissionsTable;
use App\Model\Table\TransportsTable;
use App\Controller\TransportsController;
use App\Template;

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
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Network\Socket;
use Cake\View\View;
use Cake\Controller\Controller;


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
		$this->set('searchLabelExtra', "Id du mission");

		$query = $this->Missions
			// Use the plugins 'search' custom finder and pass in the processed query params
			->find('search', ['search' => $this->request->getQueryParams()]);

		$this->paginate = [
			'contain' => ['Projets','Lieus','Motifs']
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
	 * Add method
	 *
	 * @param string|null $id Mission id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function add($id = null)
	{
		$this->loadModel("Membres");
		$this->loadModel("Lieus");
		$this->loadModel("Motifs");
		$this->loadModel('Transports');

		$transportsController = new TransportsController();

			$mission = $this->Missions->newEntity();
			if ($this->request->is(['patch', 'post', 'put'])) {										
				$mission = $this->Missions->patchEntity($mission, $this->request->getData());
				// print_r($this->request->getData());
				// $transport = $transportsController->Transports->patchEntity($transport, $this->request->getData());
				// print_r($transport);
				$mission->responsable_id = $this->Auth->user('id');
				$types = $this->request->getData()['mul'];
				$commentaire_t = $this->request->getData()['commentaire_transport'];
				
				if (isset($this->request->getData()['passagers'])) {
					$passagersUniques = $this->request->getData()['passagers'];
				}

				$typetransport=null;
				if ($mission->date_depart < $mission->date_retour){
					$dateTimeDebut = $mission->date_depart;
						$dateTimeRetour = $mission->date_retour;
						// $dateTimeRetour = new FrozenTime("$newDateRetour $heureRetour");
						// Calcul du nombre de repas de de nuitées
						$arrayRepasNuit = $this->_calculNombreRepasNuite($dateTimeDebut, $dateTimeRetour);
						// print_r($arrayRepasNuit);
						if ($mission->nb_repas == null) {
							$mission->nb_repas = $arrayRepasNuit['nb_repas'];
						}
						if ($mission->nb_nuites == null) {
							$mission->nb_nuites = $arrayRepasNuit['nb_nuites'];
						}
					if ($this->Missions->save($mission) ){
						//add  transports
						foreach($types as $type) {
							$transport = $transportsController->Transports->newEntity();
							$transport = $transportsController->Transports->patchEntity($transport,$this->request->getData());
							if ( $type === 'Value1') {
								$transport->type_transport = 'train';
								$transport->im_vehicule = null;
								$transport->pf_vehicule = null;
							}elseif($type === 'Value2') {
								$typetransport = 'avion';
								$transport->type_transport = 'avion';
								$transport->im_vehicule = null;
								$transport->pf_vehicule = null;
							}elseif($type === 'Value3'){
								$typetransport = 'Véhicule_Personnel';
								$transport->type_transport = 'Véhicule_Personnel';
								$transport->im_vehicule = $this->request->getData()['im_vehicule'];
								$transport->pf_vehicule = $this->request->getData()['pf_vehicule'];

							}elseif($type === 'Value4'){
								$typetransport = 'Véhicule_service';
								$transport->type_transport = 'Véhicule_service';
								$transport->im_vehicule = $this->request->getData()['im_vehicule'];
								 $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];

							}elseif($type === 'Value5'){
								$typetransport = 'Autre ';
								$transport->type_transport = 'Autre';

							}
							$transport->mission_id = $mission->id;
							if($transportsController->Transports->save($transport)){
								// print_r($transport);
							}	
						}
						TransportFactory::setConfig('gmail', [
							'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
							]);


						
						//generate pdf
						$fileName = $mission->id.'.pdf';
						$pdf = $this->_fileGeneration($mission->id,$fileName);
							if ($this->_sendSubmit($mission->id)){
								// On récupère motif_id et lieu_id pour les associer aux ordres de missions des passagers
								$motifId = $this->Missions->Motifs->id;
								$lieuId = $this->Missions->Lieus->id;
		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.nom']);})->where(['Missions.id' => $mission->id])->all()->toList();
		$nom_send = array_column(array_column($result,'membres'),'nom')[0];
		print_r($nom_send);
		$result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.prenom']);})->where(['Missions.id' => $mission->id])->all()->toList();
		$prenom_send = array_column(array_column($result1,'membres'),'prenom')[0];

								$date_depart =  $mission->date_depart;
								$date_retour = $mission->date_retour;
								// Génération des ordres de mission pour chaque passager
								if ($passagersUniques != null) {
									foreach ($passagersUniques as $passager) {
										print_r($passager);
										$mission1 = $this->Missions->newEntity();
										$this->Missions->id = null;
										$missionTemp = $mission1;
										$missionTemp->id = null;
										$missionTemp->responsable_id = $passager;
										$missionTemp->motif_id = $motifId;
										$missionTemp->lieu_id = $lieuId;
										$missionTemp->date_depart = $date_depart;
										$missionTemp->date_retour = $date_retour;
										$this->Missions->save($missionTemp);
										//$this->_sendConfirmModif($this->Mission->field('id'));
										$this->_sendPassager($missionTemp->id,$fileName,$commentaire_t,$nom_send,$prenom_send); 
										// print_r('send');
									}
									// $this->Flash->success(__('Mission enregistré et soumis au chef d\'équipe.'));
									// return $this->redirect(['action' => 'index']);
								
								}else{
									$this->request->getData()['passagers']=null;
								}
									// Si le nombre de missions associées à un lieu est supérieur au nombre défini, il est ajouté à la liste.
									// $lieu = $this->Missions->Lieus->find()->where(['id'=> $lieuId]);
									// $nombreMissions = 0;
									// foreach ($lieu as $missions) {
									// 	$nombreMissions++;
									// }
									// if ($nombreMissions == 10) {
									// 	$lieu->est_dans_liste = 1;
									// 	$this->Lieus->save($lieu);
									// }

								$this->Flash->success(__('Mission enregistré et soumis au chef d\'équipe.'));
								return $this->redirect(['action' => 'index']);
							}
				}else{
						$this->Flash->error(__('The mission could not be saved. Please, try again.'));
					}
				}else{
					$this->Flash->error(__('La date de début doit être avant la date de fin.'));
					return $this->redirect(['action' => 'edit']);
				}
			}

			$projets = $this->Missions->Projets->find('list', ['limit' => 200]);
			$lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
			$motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
			$transports = $this->Transports->find('list', ['limit' => 200]);
			$membres = $this->Missions->Membres->find('list',['limit' => 200]);
			$this->set(compact('mission', 'projets', 'lieus', 'motifs', 'transports','membres'));

		
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
		$this->loadModel("Lieus");
		$this->loadModel("Motifs");
		$this->loadModel('Transports');

		$transportsController = new TransportsController();

		if ($id == null){
			$mission = $this->Missions->newEntity();
		}
		else{
			$mission = $this->Missions->get($id, [
				'contain' => ['Membres','Lieus','Motifs']
			]);
			// print_r($mission);
			$transportids = array_column($transportsController->Transports->find()->select('id')->where(['mission_id' => $id])->all()->toArray(),'id');
			// print_r($transportids);

			foreach($transportids as $transportid){
				$transports = $transportsController->Transports->get($transportid);
				// print_r($transport);
				// $transport->type_transport;
				// print_r($transport->getDefaultProperties());
			}
		}
		if ($this->Auth->user('id') === $mission->responsable_id || $this->Auth->user('role') === Membre::ADMIN)  {

			if ($mission->etat === 'soumis') {
				if ($this->request->is(['patch', 'post'])) {										
					$mission = $this->Missions->patchEntity($mission, $this->request->getData());

					$mission->responsable_id = $this->Auth->user('id');
					$types = $this->request->getData()['mul'];
					if (isset($this->request->getData()['passagers'])) {
						$passagersUniques = $this->request->getData()['passagers'];
					}
					$typetransport=null;
					// $nomTrans = $types->count();
					if ($mission->date_depart < $mission->date_retour){
						if ($this->Missions->save($mission) ){
							//add  transports
							foreach($types as $type) {
								$transport = $transportsController->Transports->newEntity();
								$transport = $transportsController->Transports->patchEntity($transport,$this->request->getData());
							
								if ( $type === 'Value1') {
									// $typetransport = 'train';
									$transport->type_transport = 'train';
									$transport->im_vehicule = null;
									$transport->pf_vehicule = null;
								}elseif($type === 'Value2') {
									$typetransport = 'avion';
									$transport->type_transport = 'avion';
									$transport->im_vehicule = null;
									$transport->pf_vehicule = null;
								}elseif($type === 'Value3'){
									$typetransport = 'Véhicule_Personnel';
									$transport->type_transport = 'Véhicule_Personnel';
									$transport->im_vehicule = $this->request->getData()['im_vehicule'];
									$transport->pf_vehicule = $this->request->getData()['pf_vehicule'];

								}elseif($type === 'Value4'){
									$typetransport = 'Véhicule_service';
									$transport->type_transport = 'Véhicule_service';
									$transport->im_vehicule = $this->request->getData()['im_vehicule'];
									$transport->pf_vehicule = $this->request->getData()['pf_vehicule'];

								}elseif($type === 'Value5'){
									$typetransport = 'Autre ';
									$transport->type_transport = 'Autre';

								}
							
								$transport->mission_id = $mission->id;
								if($transportsController->Transports->save($transport)){
									// print_r($transport);
								}	
							}
							TransportFactory::setConfig('gmail', [
								'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
								]);
							//generate pdf
							$fileName = $mission->id.'.pdf';
							$pdf = $this->_fileGeneration($mission->id,$fileName);

							// if($this->_sendConfirmModif($mission->id)){
								// print_r('send to myself success');
								// $this->Flash->success(__('Mission send to myself.'));
								
								//------------TO DO ---------------
								if ($this->_sendSubmit($mission->id)){

										// On récupère motif_id et lieu_id pour les associer aux ordres de missions des passagers
									$motifId = $this->Missions->Motifs->id;
									$lieuId = $this->Missions->Lieus->id;
									// Génération des ordres de mission pour chaque passager
									if (isset($this->request->getData()['passagers'])) {
										foreach ($passagersUniques as $passager) {
											$mission1 = $this->Missions->newEntity();
											$this->Missions->id = null;
											$missionTemp = $mission1;
											$missionTemp->id = null;
											$missionTemp->responsable_id = $passager['id'];
											$missionTemp->motif_id = $motifId;
											$missionTemp->lieu_id = $lieuId;
											$this->Missions->save($missionTemp);
											//$this->_sendConfirmModif($this->Mission->field('id'));
											$this->_sendSubmit($mission->id); 
										}
										
									}

									// END TO DO

									$this->Flash->success(__('Mission enregistré et soumis au chef d\'équipe.'));
									return $this->redirect(['action' => 'index']);
								}
							// }	
							
						}else{
							$this->Flash->error(__('The mission could not be saved. Please, try again.'));
						}
					}else{
						$this->Flash->error(__('La date de début doit être avant la date de fin.'));
						return $this->redirect(['action' => 'edit']);
					}
				}

				$projets = $this->Missions->Projets->find('list', ['limit' => 200]);
				$lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
				$motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
				$membres = $this->Missions->Membres->find('list',['limit' => 200]);
				
				$this->set(compact('mission', 'projets', 'lieus', 'motifs','membres'));
			}else {
				$this->Flash->error(__('Modification impossible, OdM déjà validé'));
				$this->redirect(['action' => 'index']);
			}
		} else {
			$this->Flash->error(__('Modification impossible : permissions insuffisantes'));
			$this->redirect(['action' => 'index']);
		}
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
		$this->loadModel('MissionsTransports');

		// Modification GTHWeb 20-01-2020
		include(dirname(__FILE__) . '/Component/generator.php');

		$generator = new \MyGenerator();
		// Fin modification
		$this->Missions->id = $id;
		//-------------- // =  $this->Mission->field('motif_id'); //--------------------------
		// print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id'));
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
		$this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];
		$this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(),'lieu_id')[0];
		//  print_r($this->Missions->Lieus->id);
		//----------------- // = $this->Mission->User->Equipe->id = $this->Mission->User->field('equipe_id'); //-----
		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
		$this->Missions->Membres->Equipes->id = array_column(array_column($result,'membres'),'equipe_id')[0];
		// print_r($this->Missions->Membres->Equipes->id);
		$this->Missions->Projets->id = array_column($this->Missions->find()->select(['projet_id'])->where(['id' => $id])->all()->toArray(),'projet_id');

		//---------------  // transports = $this->Transport->findAllByMissionId($missionId); //--------

		// $transports = array_column($this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->all()->toArray(),'type_transport');
		// $objectTransports = $this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->all()->toList();

		// print_r ($objectTransports);

		$transports = $this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->all()->toList();

		// foreach($objectTransports as $objectTransport){
		// 	// array_push($transports,$objectTransport);
		// 	echo ("----");
		// 	trans
		// 	print_r($objectTransport);
		// }
		// print_r($transports);

		// $result1 = $this->Missions->find('all')->InnerJoinWith('MissionsTransports')->select(['MissionsTransports.transport_id'])->where(['Missions.id' => $id])->all()->toArray();
		// echo $result1;
		// $result2 = array_column($result1, '_matchingData');
		// $result3 = array_column($result2,'MissionsTransports');
		// $result4 = array_column($result3,'transport_id');

		// $transports = array() ;
		// foreach($result4 as $key => $value){
		// 	if(is_array($value)){
		// 		getValue($value);

		// 	}else{
		// 	$result5 = $this->Missions->MissionsTransports->find('all')->InnerJoinWith('Transports')
		// 		 ->select(['Transports.type_transport'])
		// 		 ->distinct('Transports.type_transport')
		// 		 ->where(['MissionsTransports.transport_id' => $value])->all()->toArray();

		// 	 $result6 = array_column($result5, '_matchingData');
		// 	 $result7 = array_column($result6,'Transports');
		// 	 array_push($transports,$result7[0]);
		// 	}
		// }
	//---------------  // End transports//------------------------------------

// //-----------------------TO DO-------------------------------
		//Ne rajoute la signature du chef d'équipe que si la mission a été validée
		$etat = array_column($this->Missions->find()->select('etat')->where(['id' => $id])->all()->toArray(),'etat')[0];

		if ($etat == 'valide') {
			// selectionnne la signature du chef de l'équipe dont fait partie l'utilisateur
			
			$result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
			$equipeid= array_column(array_column($result_1,'membres'),'equipe_id')[0];
			// print_r($equipeid);
			$chefid= array_column($this->Missions->Membres->Equipes->find()->where(['id'=>$equipeid])->all()->toArray(),'responsable_id')[0];
			// print_r($chefid);
			$chefsign= array_column($this->Missions->Membres->find()->where(['id'=>$chefid])->all()->toArray(),'signature_name')[0];
			
			// $cheif = $this->Membres->find('first', array('conditions' => array('User.role' => 'admin', 'User.equipe_id' => $this->Mission->User->field('equipe_id'))));
			// génère la signature du chef
			$cheifSignaturePath = "./img/Signatures/".$chefsign;
		} else {
			$cheifSignaturePath = "";
		}

	$result = $this->Missions->find()->contain('Membres', function (Query $q) {
		return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
	$var1 = array_column(array_column($result,'membres'),'equipe_id')[0];
	$equipenom = array_column( $this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $var1])->all()->toArray(),'nom_equipe')[0];
	// print_r($equipenom);
	
	// print_r(array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
	// 	return $q ->select(['membres.signature_name']);})
	// 	->where(['Missions.id' => $id])
	// 	->all()->toList(),'membres'),'signature_name')[0]);
		
		$sign = array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.signature_name']);})
			->where(['Missions.id' => $id])
			->all()->toList(),'membres'),'signature_name')[0];
		// print_r($sign);
		$signaturePath = "/Signatures/".$sign;
		// print_r($signaturePath);
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
			$signaturePath,
			//------------- TO DO ----------------
			$cheifSignaturePath,
			// $equipenom,
			array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
				return $q ->select(['membres.date_naissance']);})
				->where(['Missions.id' => $id])
				->all()->toList(),'membres'),'date_naissance')[0]
		);

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

		$generator->setFinance(
			array_column(array_column($this->Missions->find()->contain('Projets', function (Query $q) {
				return $q ->select(['projets.titre']);})->where(['Missions.id' => $id])->all()->toList(),'projets'),'titre')[0]

		);

		$im_vehicule = '';
		$pf_vehicule = '';
		// print_r($transports);
		// decision about imatriculation
		foreach ($transports as $transport) {
			// print_r($transport);
			if ($transport -> type_transport === 'vehicule_service' || $transport->type_transport === 'vehicule_personnel') {
				$im_vehicule = $transport->im_vehicule;
				$pf_vehicule = $transport->pf_vehicule;
				// print_r("---");
				break;
			}
		}
		// print_r($transports);

		$generator->setTransport($transports);
		// print_r($generator->getTransport());
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

		return $generator->generate($sansFrais, $fileName);

	}

	public function generation($id = null) {
		$this->loadModel('Membres');
		if ($id != null) {
			$mission = $this->Missions->get($id, [
				'contain' => ['Projets', 'Lieus', 'Motifs','Membres']
			]);
				// print_r($mission->etat);
			if ($this->Auth->user('id') === $mission->responsable_id || $this->Auth->user('role') === Membre::ADMIN || $this->Auth->user('role') === Membre::SECRETAIRE ||$this->Auth->user('role') === Membre::CHEFDEQUIPE)  {
				// $fileName = $mission->id.'.pdf';
				$this->_fileGeneration($id);
			} else {
				$this->Flash->error(__('Lecture de l\'OdM impossible : Permission insuffisante'));
				$this->redirect(['action' => 'index']);
			}
		} else {
			$this->Flash->error(__('L\'ordre de mission inexistant.'));
			// $this->redirect(array('controller' => 'missions', 'action' => 'index'));
			$this->redirect(['action' => 'index']);
		}
	}



	// Utilisé par la fonction edit(), permet d'estimer le nombre de repas et de nuité à partir des dates rentrées par l'utilisateur
	function _calculNombreRepasNuite($dateDebut, $dateFin) {
		$diff = date_diff($dateDebut, $dateFin);
		// print_r($diff);
		$nombreNuite = $diff->days;
		$nombreRepas = round(($diff->format("%h")+$diff->days*24)/12, 0);
		return array('nb_nuites' => $nombreNuite, 'nb_repas' => $nombreRepas);
	}


	/**
	* envoie la soumission 提交 au chef d'équipe après avoir saisie une estimation des dépenses
	**/
	function submission($id = null, $save = false) {

		if ($id == null) {
			$this->redirect(['action' => 'index']);
		} else {
			$this->Missions->id = $id;
			$this->set('id',$id);

			// permet de ne pas soumettre un OdM déjà soumis
			if ($this->Mission->field('etat') === 'soumis') {
				$this->Flash->error(__('Erreur : OdM déjà soumis.'));
				$this->redirect(['action' => 'index']);
			}
			// s'il y a des données et que l'on veut soumettre l'OdM
			if ($save && $this->data != null ) {
				// si l'enregistrement de l'estimation est bien sauvé on envoie un mail au chef
				$this->Mission->set('etat','soumis');
				if($this->Mission->save($this->data)) {
					$this->_sendSubmit($id);
					$this->Flash->success(__('OdM envoyé au chef d\'équipe.'));
					$this->redirect(['action' => 'index']);
				} else {
					// sinon on signale l'erreur
					$this->Flash->error(__('Erreur lors de l\'enregistrement.'));
				}
			} else {
				//sinon on récupére l'OdM pour remplir le formulaire de soumission
				$this->data = $this->Mission->findById($id);
			}

		}
	}
	/**
	* send mail of submission which is sent to team cheif
	**/
	function _sendSubmit($id) {
		$this->Missions->id = $id;
		// print_r($this->Missions->id);
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
		$this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];

		// print_r($this->Missions->Motifs->id);
		// $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
		$this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
		// print_r($this->Missions->Lieus->id);
		// récupère les emails des chefs d'équipe
		$result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
		$equipeid= array_column(array_column($result_1,'membres'),'equipe_id')[0];
		// print_r($equipeid);

		$chefid= array_column($this->Missions->Membres->Equipes->find()->where(['id'=>$equipeid])->all()->toArray(),'responsable_id')[0];
		// print_r($chefid);

		$chefemail= array_column($this->Missions->Membres->find()->where(['id'=>$chefid])->all()->toArray(),'email')[0];

		// print_r($chefemail);

		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
		$nom_send = array_column(array_column($result,'membres'),'nom')[0];
		$result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
		$prenom_send = array_column(array_column($result1,'membres'),'prenom')[0];

		$result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
		$email_send = array_column(array_column($result2,'membres'),'email')[0];

		$result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
			return $q ->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
		// print_r($result_3);
		// print_r(array_column($result_3,'motifs'));
		$nommotif = array_column(array_column($result_3,'motif'),'nom_motif')[0];

		// print_r($nommotif);
		$result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
			return $q ->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
		$nomlieu = array_column(array_column($result_4,'lieus'),'nom_lieu')[0];
		// print_r($nomlieu);
		// $nommotif = array_column($this->Missions->find()->select(['nom_motif'])->where(['id' => $id])->all()->toArray(),'nom_motif')[0];
		// $nomlieu = array_column($this->Missions->find()->select(['nom_lieu'])->where(['missions.id' => $id])->all()->toArray(),'nom_lieu')[0];
		// print_r($id);
		// print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
		$date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('d/m/Y');
		$date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('d/m/Y');
		$commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0];


		// $this->_fileGeneration($mission->id);

		// Interaction avec le view
		$email = new Email();
		$email->set('nom',$nom_send);
		$email->set('prenom',$prenom_send);
		$email->set('lieu',$nomlieu);
		$email->set('motif',$nommotif);
		$email->set('date_depart',$date_d);
		$email->set('date_retour',$date_r);
		$email->set('commentaire',$commentaire_t);
		// cake3_7/webroot/147.pdf
		// $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

		// $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
		//  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';

		// TransportFactory::setConfig('gmail', [
		// 	'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
		// 	]);

		return $email
		->template('submit_om')
		->emailFormat('text')
		->from('21707371t@gmail.com')
		->to($chefemail)
		->subject('Ordre de mission de '.$prenom_send.' '.$nom_send.' à valider')
		->cc($email_send)
		->setTransport('gmail')
		// ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'pdf'])
		->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'.pdf'])
		->send();
	}


	/**
	* send mail of submission which is sent to team cheif
	**/
	function _sendPassager($id,$fileName,$commentaire_t,$nom,$prenom) {
		$this->Missions->id = $id;
		// print_r($this->Missions->id);
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
		$this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];

		// print_r($this->Missions->Motifs->id);
		// $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
		$this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
		// print_r($this->Missions->Lieus->id);
		// récupère les emails des chefs d'équipe

		

		$result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
		$email_send = array_column(array_column($result2,'membres'),'email')[0];
			print_r($email_send);

		// $result_5 = $this->Missions->find()->contain('Membres', function (Query $q) {
		// 	return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
		// $email_to = array_column(array_column($result,'membres'),'email')[0];

		$result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
			return $q ->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
		// print_r($result_3);
		// print_r(array_column($result_3,'motifs'));
		$nommotif = array_column(array_column($result_3,'motif'),'nom_motif')[0];

		// print_r($nommotif);
		$result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
			return $q ->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
		$nomlieu = array_column(array_column($result_4,'lieus'),'nom_lieu')[0];
		// print_r($nomlieu);
		// $nommotif = array_column($this->Missions->find()->select(['nom_motif'])->where(['id' => $id])->all()->toArray(),'nom_motif')[0];
		// $nomlieu = array_column($this->Missions->find()->select(['nom_lieu'])->where(['missions.id' => $id])->all()->toArray(),'nom_lieu')[0];
		// print_r($id);
		// print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
		$date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('d/m/Y');
		$date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('d/m/Y');
		// $commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0];


		// $this->_fileGeneration($mission->id);

		// Interaction avec le view
		$email = new Email();
		$email->set('nom',$nom);
		$email->set('prenom',$prenom);
		$email->set('lieu',$nomlieu);
		$email->set('motif',$nommotif);
		$email->set('date_depart',$date_d);
		$email->set('date_retour',$date_r);
		$email->set('commentaire',$commentaire_t);
		// cake3_7/webroot/147.pdf
		// $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

		// $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
		//  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';

		// TransportFactory::setConfig('gmail', [
		// 	'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
		// 	]);

		return $email
		->template('submit_om')
		->emailFormat('text')
		->from('21707371t@gmail.com')
		->to($email_send)
		->subject('Ordre de mission de '.$nom.' '.$prenom.' à valider')
		// ->cc($email_send)
		->setTransport('gmail')
		// ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'pdf'])
		->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$fileName])
		->send();
	}


// /**
// 	* validation of an mission orders
// 	*/
 	function valid($id = null) {

 		if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef d\'equipe') {

			$mission = $this->Missions->get($id);
			
 			$this->Missions->id = $id;
 			// print_r($mission->id);
 			// if mission exist
 			// print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0]);
 			if ( array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0] != 0 ) {
 				//if ($this->Mission->field('valide') == false) {
				$etat = array_column($this->Missions->find()->select('etat')->where(['id' => $id])->all()->toArray(),'etat')[0];
				// print_r($etat);
					if ($etat != 'valide') {
 					// financial element have to be set
						if ( empty($mission) ) {
							$mission = $this->Missions->get($id);
						} else {
							// validate mission
							$mission->set('etat','valide');
							$this->Missions->save($mission);
							$this->set('mission', $mission);

							$this->_sendValidation($mission->id);

							$this->Flash->success(__('Mission validée'));
							$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
						}
 				}else {
 					//la mission est déjà validé
 					$this->Flash->error(__('Mission déjà validé'));
 					$id = null;
 					$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
 				}
 			} else {
 				//mission does not exist
 				$this->Flash->error(__('Mission inexistante'));
 				$id = null;
 				$this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
 			}
 		} else {
 			//droit insuffisant pour valider une mission
 			$this->Flash->error(__('Permission insuffisante pour valider la mission'));
 			$id = null;
 			$this->redirect(array('controller' => 'missions', 'action' => 'index'));
 		}

 	}


// 	/**
// 	* send mail to secretaries after confirmation from cheif team
// 	* Load User model cause of the needed to know mail team cheif
// 	**/
 	function _sendValidation($id) {

        $this->Missions->id = $id;
		print_r($this->Missions->id );
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
        $result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q ->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $this->Missions->Membres->Equipes->id= array_column(array_column($result_1,'membres'),'equipe_id')[0];
        print_r($this->Missions->Membres->Equipes->id);

		// emails of secretaries
		$result_2 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role'=> 'secretaire'])
			->all()->toArray();
		$secretaries= array_column(array_column($result_2,'membres'),'email');

		// $result_7 = 	$this->Missions->Membres->find()->select(['membres.email'])->where(['membres.id'=> $this->Missions->Membres->id])
		// ->all()->toArray();	
		// // $membreemail = 
		// print_r($result_7);

 		// $mails = "";
 		// $i = count($secretaries) - 1;
 		// foreach ($secretaries as $secretary => $mail ) {
 		// 	if ( $i == 0 )
 		// 		$mails .= $mail;
 		// 	else
 		// 		$mails .= $mail." , ";
 		// 	$i--;
		 // }
		 
		 $mails = array();
		 foreach ($secretaries as $secretary => $mail ) {
			 array_push($mails,$mail);
		 }
		print_r($mails);

 		//Noms des secrétaires
 		// $secretaries = null;
 		// $secretaries = $this->Missions->User->find('list', array(
 		// 	'fields' => array('User.first_name'),
 		// 	'conditions' => array('User.role' => 'secretary')
		// 	 ));
			 
		$result_3 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role'=> 'secretaire'])
			 ->all()->toArray();
		$secretaries= array_column(array_column($result_3,'membres'),'nom');

 		$secretaryNames = "";
 		$i = count($secretaries) - 1;
 		foreach ($secretaries as $secretary => $name ) {
 			if ( $i == 0 )
 				$secretaryNames .= $name;
 			else
 				$secretaryNames .= $name.", ";
 			$i--;
 		}
		//  print_r($secretaryNames);

 		  // emails of team cheifs
		$result_7 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role'=> 'chef d\'equipe', 'membres.equipe_id'=>$this->Missions->Membres->Equipes->id ])
			 ->all()->toArray();	 
		$cheifs = array_column(array_column($result_7,'membres'),'email')[0];

 		// $ccMails = array();
 		// foreach ($cheifs as $cheif => $mail ) {
 		// 	array_push($ccMails, $mail);
 		// }

 		// // Ajoute en cc l'utilisateur (s'il ne s'agit pas du chef car le chef est déjà en copie)
 		// if (array_search($this->Mission->User->field('email'), $ccMails) === FALSE)
 		// 	array_push($ccMails, $this->Mission->User->field('email'));

 		// generation of the OdM
 		$tmpfname = tempnam("/tmp", "FOO");
 		$tmpfname2 = tempnam("/tmp", "BAR");
 		//echo $tmpfname;
 		$this->_fileGeneration($id, $tmpfname);

 		// Génération du fichier texte
		 $fp = @fopen($tmpfname2, "w+");
		 
		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
		$nom_send = array_column(array_column($result,'membres'),'nom')[0];
		
		$result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
		$prenom_send = array_column(array_column($result1,'membres'),'prenom')[0];

		$result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
		$email_send = array_column(array_column($result2,'membres'),'email')[0];
			// print_r($email_send);
		$result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
			return $q ->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
		// print_r($result_3);
		// print_r(array_column($result_3,'motifs'));
		$nommotif = array_column(array_column($result_3,'motif'),'nom_motif')[0];

		// print_r($nommotif);
		$result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
			return $q ->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
		$nomlieu = array_column(array_column($result_4,'lieus'),'nom_lieu')[0];

		$var1 = $this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $this->Missions->Membres->Equipes->id])->all()->toArray();
		$nomequipe = array_column($var1,'nom_equipe')[0];
		print_r($nomequipe);

		// $nommotif = array_column($this->Missions->find()->select(['nom_motif'])->where(['id' => $id])->all()->toArray(),'nom_motif')[0];
		// $nomlieu = array_column($this->Missions->find()->select(['nom_lieu'])->where(['missions.id' => $id])->all()->toArray(),'nom_lieu')[0];
		// print_r($id);
		// print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
		$date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('d/m/Y');
		$date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('d/m/Y');
		$commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0];

		$nom = $nom_send;
 		$prenom = $prenom_send;
 		$equipe = $nomequipe;
 		$date_d = $date_d;
 		$date_r = $date_r;
 		$lieu = $nomlieu;
		$motif = $nommotif;

 		fwrite($fp, $nom." ".$prenom."\t".$equipe."\t\t\t".$date_d."\t".$date_r."\t".$lieu."\t".$motif);
 		fclose($fp);

		//cc给chef自己一份，cc给membre一份
		$ccMails = array();
		array_push($ccMails,$email_send);
		array_push($ccMails,$cheifs);
		// print_r($ccMails);

		// Interaction avec le view
		$email = new Email();
		$email->set('nom',$nom_send);
		$email->set('prenom',$prenom_send);
		$email->set('lieu',$nomlieu);
		$email->set('motif',$nommotif);
		$email->set('date_depart',$date_d);
		$email->set('date_retour',$date_r);
		$email->set('commentaire',$commentaire_t);
		$email->set('secretaryName', $secretaryNames);

		// cake3_7/webroot/147.pdf
		// $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

		// $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
		//  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';
		TransportFactory::setConfig('gmail', [
			'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
			]);
		// $nom_pdf =
		return $email
		->template('validation_om')
		->emailFormat('text')
		->from('21707371t@gmail.com')
		->to($mails)
		->subject('Ordre de mission de '.$prenom_send.' '.$nom_send.' validé')
		->cc($ccMails)
		->setTransport('gmail')
		// ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'pdf'])
		// ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'.pdf'])
		->attachments(["OM.pdf" => $tmpfname, "OM.txt" => $tmpfname2])
		->send();
		// -------------------

 		// fill mail form
 		// $this->Email->to = $mails;
 		// $this->Email->cc = $ccMails;
 		// $this->Email->subject = 'Ordre de mission de '.$this->Mission->User->field('first_name').' '.$this->Mission->User->field('name').' validé';
 		// $this->Email->from = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';
 		// $this->Email->attachments = array("OM.pdf" => $tmpfname, "OM.txt" => $tmpfname2);

 		// $this->Email->template = 'validation_om';
		// $this->Email->sendAs = 'text';
		 
 		// $this->set('name',$name);
 		// $this->set('first_name',$first_name);
 		// $this->set('lieu',$this->Mission->Lieu->field('nom_lieu'));
 		// $this->set('motif',$motif);
 		// $this->set('date_d',$date_d);
 		// $this->set('date_r',$date_r);
 		// $this->set('commentaire',$this->Mission->field('commentaire_transport'));
 		// $this->set('equipe',$equipe);

 		// $this->set('secretaryName', $secretaryNames);

 		// //$this->Email->delivery = 'debug';
 		// $this->Email->delivery = 'smtp';

 		// $this->Email->send();

 		// erase file
 		unlink($tmpfname);
 		unlink($tmpfname2);
 	}


// 	/**
// 	* liste des missions à valider par le chef d'équipe
// 	**/
	function needValidation() {
		if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef d\'equipe') {
			//admin看的是自己所在的equipe生效的mission
			$query = $this->Missions->find()->contain('Membres', function (Query $q) {
				return $q;})
				->where(['Missions.etat' => 'soumis','Membres.equipe_id' => $this->Auth->user('equipe_id') ]);
			//Association tables
			$this->paginate = [
				'contain' => ['Lieus', 'Motifs','Membres']
			];
			$this->set('missions', $this->paginate($query));	
		} else {
			//$this->Session->setFlash('Permission insuffisante pour afficher la liste des missions à valider','flash_failure');
			$this->Flash->error(__('Permission insuffisante pour afficher la liste des missions à valider'));
			$this->redirect(array('controller' => 'missions', 'action' => 'index'));
		}

	}

	/**
	 * liste tous les validées missions
	 * 
	 */
	public function alreadyvalid()
    {
		$this->loadModel("Membres");
		$this->loadModel("Lieus");
		$this->loadModel("Motifs");
		if ($this->Auth->user('role') == 'secretaire') {	
			$query = $this->Missions
			->find()->where(['etat' => 'valide']);
			//Association tables
			$this->paginate = [
				'contain' => ['Lieus', 'Motifs','Membres']
			];
			$this->set('missions', $this->paginate($query));
		} elseif ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef d\'equipe') {
			//admin看的是自己所在的equipe生效的mission
			$query = $this->Missions->find()->contain('Membres', function (Query $q) {
				return $q;})
				->where(['Missions.etat' => 'valide','Membres.equipe_id' => $this->Auth->user('equipe_id') ]);
			//Association tables
			$this->paginate = [
				'contain' => ['Lieus', 'Motifs','Membres']
			];
			$this->set('missions', $this->paginate($query));
		} else {
			// $this->Session->setFlash('Impossible d\'afficher la liste des ODM : Permission insuffisante','flash_failure');
			$this->Flash->error(__('Impossible d\'afficher la liste des ODM : Permission insuffisante. '));
			$this->redirect(['action' => 'index']);
		}
    }


/**
	* send modification notify by of an OdM to the OdM's creator
	**/
	function _sendConfirmModif($id) {

		$this->Missions->id = $id;
		$this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0];
		$this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(),'motif_id')[0];
		$this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(),'lieu_id')[0];

		$result = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
		$nom_send = array_column(array_column($result,'membres'),'nom')[0];
		$result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
		$prenom_send = array_column(array_column($result1,'membres'),'prenom')[0];

		$result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
			return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
		$email_send = array_column(array_column($result2,'membres'),'email')[0];

		$result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
			return $q ->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
		// print_r($result_3);
		$nommotif = array_column(array_column($result_3,'motif'),'nom_motif')[0];
		// print_r($nommotif);
		$result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
			return $q ->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
		$nomlieu = array_column(array_column($result_4,'lieus'),'nom_lieu')[0];
		// print_r($nomlieu);
	
		$date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(),'date_depart')[0]->format('d/m/Y');
		$date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(),'date_retour')[0]->format('d/m/Y');
		$commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0];


		// $this->Email->to = $this->Mission->User->field('email');
		// Interaction avec le view
		$email = new Email();
		$email->set('nom',$nom_send);
		$email->set('prenom',$prenom_send);
		$email->set('lieu',$nomlieu);
		$email->set('motif',$nommotif);
		$email->set('date_depart',$date_d);
		$email->set('date_retour',$date_r);
		$email->set('commentaire',$commentaire_t);
		TransportFactory::setConfig('gmail', [
			'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
			]);

		return $email
		->template('modification_odm')
		->emailFormat('text')
		->from('21707371t@gmail.com')
		// ->to($email_send)
		->to('mql951002@gmail.com')
		->subject('Ordre de mission de '.$nommotif)
		->setTransport('gmail')
		->send();

// -------------------

		// $this->Email->to = $this->Mission->User->field('email');
		// $this->Email->subject = 'Ordre de mission pour '.$this->Mission->Motif->field('nom_motif');
		// $this->Email->from = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';
		// $this->Email->template = 'modification_odm';

		// $this->Email->sendAs = 'text';

		// $this->set('name',$this->Mission->User->field('name'));
		// $this->set('first_name',$this->Mission->User->field('first_name'));
		// $this->set('lieu',$this->Mission->Lieu->field('nom_lieu'));
		// $this->set('motif',$this->Mission->Motif->field('nom_motif'));
		// $this->set('date_d',date("d/m/Y", strtotime($this->Mission->field('date_d'))));
		// $this->set('date_r',date("d/m/Y", strtotime($this->Mission->field('date_r'))));
		// $this->set('commentaire',$this->Mission->field('commentaire_transport'));

		// //$this->Email->delivery = 'debug';
		// $this->Email->delivery = 'smtp';

		// $this->Email->send();
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
