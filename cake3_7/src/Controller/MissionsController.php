<?php

namespace App\Controller;

use App\Controller\TransportsController;
use App\Model\Entity\Membre;
use App\Model\Entity\Mission;
use App\Model\Table\MissionsTable;
use App\Template;
use Cake\Controller\Controller;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\View\View;

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
        // print_r(phpinfo());
        $this->set('searchLabelExtra', "Numéro et/ou État du mission");
        $query = $this->Missions
        // Use the plugins 'search' custom finder and pass in the processed query params
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->where(['responsable_id' => $this->Auth->user('id')]);

        $this->paginate = [
            'contain' => ['Projets', 'Lieus', 'Motifs'],
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
            'contain' => ['Projets', 'Lieus', 'Motifs', 'Transports', 'Membres'],
        ]);

        $this->set('mission', $mission);

    }

/**
 * Add method
 *
 * @param string|null $id Mission id.
 *
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
        $passagersUniques = null;
        $this->Missions = TableRegistry::getTableLocator()->get('Missions');

        $mission = $this->Missions->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $mission = $this->Missions->patchEntity($mission, $this->request->getData());

            $mission->responsable_id = $this->Auth->user('id');
            $types = $this->request->getData()['mul'];
            $commentaire_t = $this->request->getData()['commentaire_transport'];

            if (isset($this->request->getData()['passagers'])) {
                $passagersUniques = $this->request->getData()['passagers'];
            }

            $typetransport = null;

            if ($mission->date_depart < $mission->date_retour) {
                $dateTimeDebut = $mission->date_depart;
                $dateTimeRetour = $mission->date_retour;
                // Calcul du nombre de repas de de nuitées
                $arrayRepasNuit = $this->_calculNombreRepasNuite($dateTimeDebut, $dateTimeRetour);
                // print_r($arrayRepasNuit);
                if ($mission->nb_repas == null) {
                    $mission->nb_repas = $arrayRepasNuit['nb_repas'];
                }
                if ($mission->nb_nuites == null) {
                    $mission->nb_nuites = $arrayRepasNuit['nb_nuites'];
                }
                // print_r($mission->date_depart_arrive);
                // print_r($mission->date_retour_arrive);
                // print_r($mission);

                // $mission->date_depart_arrive = new FrozenTime($mission->date_depart_arrive);
                // $mission->date_retour_arrive = new FrozenTime($mission->date_retour_arrive);

                // print_r($this->Missions->save($mission));
                if ($this->Missions->save($mission)) {
                    // print_r($mission);
                    //add  transports
                    foreach ($types as $type) {
                        $transport = $transportsController->Transports->newEntity();
                        $transport = $transportsController->Transports->patchEntity($transport, $this->request->getData());
                        if ($type === 'Value1') {
                            $transport->type_transport = 'train';
                            $transport->im_vehicule = null;
                            $transport->pf_vehicule = null;
                        } elseif ($type === 'Value2') {
                            $typetransport = 'avion';
                            $transport->type_transport = 'avion';
                            $transport->im_vehicule = null;
                            $transport->pf_vehicule = null;
                        } elseif ($type === 'Value3') {
                            $typetransport = 'vehicule_personnel';
                            $transport->type_transport = 'Véhicule_Personnel';
                            $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                            $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                        } elseif ($type === 'Value4') {
                            $typetransport = 'vehicule_service';
                            $transport->type_transport = 'Véhicule_service';
                            $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                            $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                        } elseif ($type === 'Value5') {
                            $typetransport = 'autre ';
                            $transport->type_transport = 'Autre';
                        }
                        $transport->mission_id = $mission->id;
                        if ($transportsController->Transports->save($transport)) {
                            // print_r($transport);
                        }
                    }

                    if (is_numeric($mission->projet_id) === true && is_numeric($mission->lieu_id) === true && is_numeric($mission->motif_id) === true) {

                        TransportFactory::setConfig('gmail', [
                            'url' => 'smtp://21707371t@gmail.com:sbCNM123@smtp.gmail.com:587?tls=true',
                        ]);

                        //generate pdf
                        $fileName = $mission->id . '.pdf';
                        $pdf = $this->_fileGeneration($mission->id, $fileName);
                        if ($this->_sendSubmit($mission->id)) {
                            // On récupère motif_id et lieu_id pour les associer aux ordres de missions des passagers
                            $motifId = $this->Missions->Motifs->id;
                            $lieuId = $this->Missions->Lieus->id;
                            $result = $this->Missions->find()->contain('Membres', function (Query $q) {
                                return $q->select(['membres.nom']);})->where(['Missions.id' => $mission->id])->all()->toList();
                            $nom_send = array_column(array_column($result, 'membres'), 'nom')[0];
                            // print_r($nom_send);
                            $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
                                return $q->select(['membres.prenom']);})->where(['Missions.id' => $mission->id])->all()->toList();
                            $prenom_send = array_column(array_column($result1, 'membres'), 'prenom')[0];

                            $date_depart = $mission->date_depart;
                            $date_retour = $mission->date_retour;
                            // Génération des ordres de mission pour chaque passager
                            if ($passagersUniques != null) {
                                foreach ($passagersUniques as $passager) {
                                    // print_r($passager);
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
                                    $this->_sendPassager($missionTemp->id, $fileName, $commentaire_t, $nom_send, $prenom_send);
                                    // print_r('send');
                                }
                            } else {
                                $this->request->getData()['passagers'] = null;
                            }

                            if ($this->request->getData()['er_vehicule']) {
                                $user = $this->Membres->get($mission->responsable_id);
                                $user['im_vehicule'] = $this->request->getData()['im_vehicule'];
                                $user['pf_vehicule'] = $this->request->getData()['pf_vehicule'];
                                $this->Membres->save($user);
                            }
                            // print_r('saved');
                            $this->Flash->success(__('Mission enregistré et soumis au chef d\'équipe.'));
                            return $this->redirect(['action' => 'index']);
                        }

                    } else {
                        $this->Flash->error(__('Veuillez compléter les informations pertinentes sur le Projet 、 Motif 、 Lieu.'));

                    }

                } else {
                    $this->Flash->error(__('The mission could not be saved. Please, try again.'));
                }

            } else {
                $this->Flash->error(__('La date de début doit être avant la date de fin.'));
                return $this->redirect(['action' => 'edit']);
            }

            // $this->Missions->save($mission);

        }

        $projets = $this->Missions->Projets->find('list', ['limit' => 200]);
        $lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
        $motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
        $membres = $this->Missions->Membres->find('list', ['limit' => 200]);

        $tmp_query = $transportsController->Transports->find()->select('type_transport')->distinct('type_transport')->where(['mission_id' => $id])
            ->all()->toArray();

        $mission_trans_type = array_column($tmp_query, 'type_transport'); //array
        // debug($this->Missions->getErrors());

        $this->set(compact('mission', 'projets', 'lieus', 'motifs', 'mission_trans_type', 'membres', 'passagersUniques'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Mission id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $this->loadModel("Membres");
        $this->loadModel("Lieus");
        $this->loadModel("Motifs");
        $this->loadModel('Transports');

        $transportsController = new TransportsController();
        // $passagersUniques = null;
        $mission = $this->Missions->get($id, [
            'contain' => ['Membres', 'Lieus', 'Motifs'],
        ]);

        // $mission['Mission']['user_id'] == $this->Auth->user('id')
        if ($mission->responsable_id == $this->Auth->user('id') || $this->Auth->user('role') === Membre::CHEFDEQUIPE || $this->Auth->user('role') === Membre::ADMIN) {
            if ($mission->etat === 'soumis') {
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $mission = $this->Missions->patchEntity($mission, $this->request->getData());
                    // print_r("getData()");
                    // print_r('getData'.$this->request->getData());
                    // print_r($this->request->getData());
                    // $transport = $transportsController->Transports->patchEntity($transport, $this->request->getData());

                    $type_trans = array('vehicule_service', 'vehicule_personnel');
                    $transport_vehicule = $transportsController->Transports->find()->select(['im_vehicule', 'pf_vehicule'])->where(['mission_id' => $id, 'type_transport IN' => $type_trans])
                        ->first();
                    $data = $this->request->getData();
                    $types = $this->request->getData()['mul'];

                    if (isset($transport_vehicule)) {
                        //如果data里面有这两项，就赋值给界面
                        $im_vehicule = array_column($transport_vehicule->toArray(), 'im_vehicule');
                        $pf_vehicule = array_column($transport_vehicule->toArray(), 'pf_vehicule');
                        $data['im_vehicule'] = $im_vehicule;
                        $data['pf_vehicule'] = $pf_vehicule;
                        // print_r($transport_vehicule['im_vehicule']);
                        // print_r($transport_vehicule['pf_vehicule']);

                    } else {
                        // //如果data里面没有这两项，就把用户的vehicule信息返回到界面
                        // $this->Missions->Membres->id = $this->Auth->user('id');
                        // // print_r($this->Missions->Membres->id);

                        // $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
                        //     return $q ->select(['membres.im_vehicule']);})->where(['Missions.id' => $this->Auth->user('id')])->all()->toList();

                        // if ($data['im_vehicule'] == null ) {
                        //     $data['im_vehicule'] = array_column(array_column($result1,'membres'),'im_vehicule')[0];
                        // }
                        // if ($data['pf_vehicule'] == null) {
                        //     $data['pf_vehicule'] = array_column(array_column($result1,'membres'),'pf_vehicule')[0];
                        // }
                    }

                    $mission->responsable_id = $this->Auth->user('id');

                    // $types = $this->request->getData()['mul'];
                    // $transport_types =  $this->request->getData()['transport_id'];
                    // print_r('transport_types : '.$transport_types);
                    $commentaire_t = $this->request->getData()['commentaire_transport'];

                    if (isset($this->request->getData()['passagers'])) {
                        $passagersUniques = $this->request->getData()['passagers'];
                    }

                    $typetransport = null;
                    $transport = null;
                    if ($mission->date_depart < $mission->date_retour) {
                        $dateTimeDebut = $mission->date_depart;
                        $dateTimeRetour = $mission->date_retour;
                        // Calcul du nombre de repas de de nuitées
                        $arrayRepasNuit = $this->_calculNombreRepasNuite($dateTimeDebut, $dateTimeRetour);
                        if ($mission->nb_repas == null) {
                            $mission->nb_repas = $arrayRepasNuit['nb_repas'];
                        }
                        if ($mission->nb_nuites == null) {
                            $mission->nb_nuites = $arrayRepasNuit['nb_nuites'];
                        }

                        // print_r("------------");

                        if ($this->Missions->save($mission)) {
                            //edit transports
                            //1 取transport的id 2 调用edit（）
                            $transport_ids = $transportsController->Transports->find()->select('id')->where(['mission_id' => $id])->all()->toArray();
                            // print_r("transport id = ");
                            // print_r($transportsController->Transports->find()->select('id')->where(['mission_id' => $id]));

                            foreach ($transport_ids as $transport_id) {
                                // $transportsController->Transports->edit($transport_id->id);
                                $transport_id2 = $transportsController->Transports->get($transport_id->id);
                                //methode2 : delete exist transport, apres renew transport
                                $transportsController->request->allowMethod(['post', 'delete']);
                                $transport = $transportsController->Transports->get($transport_id2->id);
                                if ($transportsController->Transports->delete($transport)) {
                                    // $transportsController->Flash->success(__('The transport has been deleted.'));
                                } else {
                                    // $transportsController->Flash->error(__('The transport could not be deleted. Please, try again.'));
                                }

                                // methode1 : 调用edit（）
                                // if ($transportsController->request->is(['patch', 'post', 'put'])) {
                                //     $transport = $transportsController->Transports->patchEntity($transport_id2, $transportsController->request->getData());
                                //     $type = $this->request->getData()['mul'][0];
                                //     // foreach($types as $type) {
                                //         if ( $type === 'Value1') {
                                //             $transport->type_transport = 'train';
                                //             $transport->im_vehicule = null;
                                //             $transport->pf_vehicule = null;
                                //         }elseif($type === 'Value2') {
                                //             $typetransport = 'avion';
                                //             $transport->type_transport = 'avion';
                                //             $transport->im_vehicule = null;
                                //             $transport->pf_vehicule = null;
                                //         }elseif($type === 'Value3'){
                                //             $typetransport = 'vehicule_personnel';
                                //             $transport->type_transport = 'Véhicule_Personnel';
                                //             $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                                //             $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                                //         }elseif($type === 'Value4'){
                                //             $typetransport = 'vehicule_service';
                                //             $transport->type_transport = 'Véhicule_service';
                                //             $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                                //             $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                                //         }elseif($type === 'Value5'){
                                //             $typetransport = 'autre ';
                                //             $transport->type_transport = 'Autre';
                                //         }

                                //         if ($transportsController->Transports->save($transport)) {
                                //             print_r($transport);
                                //             // $this->Flash->success(__('The transport has been saved.'));
                                //             // break;
                                //             // return $transportsController->redirect(['action' => 'index']);
                                //         }else{
                                //             // $this->Flash->error(__('The transport could not be saved. Please, try again.'));
                                //         }
                                //     // }
                                // }
                                // $transportsController->set(compact('transport'));
                            }
                            foreach ($types as $type) {
                                $transport = $transportsController->Transports->newEntity();
                                $transport = $transportsController->Transports->patchEntity($transport, $this->request->getData());
                                if ($type === 'Value1') {
                                    $transport->type_transport = 'train';
                                    $transport->im_vehicule = null;
                                    $transport->pf_vehicule = null;
                                } elseif ($type === 'Value2') {
                                    $typetransport = 'avion';
                                    $transport->type_transport = 'avion';
                                    $transport->im_vehicule = null;
                                    $transport->pf_vehicule = null;
                                } elseif ($type === 'Value3') {
                                    $typetransport = 'vehicule_personnel';
                                    $transport->type_transport = 'Véhicule_Personnel';
                                    $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                                    $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                                } elseif ($type === 'Value4') {
                                    $typetransport = 'vehicule_service';
                                    $transport->type_transport = 'Véhicule_service';
                                    $transport->im_vehicule = $this->request->getData()['im_vehicule'];
                                    $transport->pf_vehicule = $this->request->getData()['pf_vehicule'];
                                } elseif ($type === 'Value5') {
                                    $typetransport = 'autre ';
                                    $transport->type_transport = 'Autre';
                                }
                                $transport->mission_id = $mission->id;
                                if ($transportsController->Transports->save($transport)) {
                                    // print_r($transport);
                                }
                            }
                            $transportsController->set(compact('transport'));
                            // end edit transport

                            TransportFactory::setConfig('gmail', [
                                'url' => 'smtp://21707371t@gmail.com:sbCNM123@smtp.gmail.com:587?tls=true',
                            ]);

                            //generate pdf
                            $fileName = $mission->id . '.pdf';
                            $pdf = $this->_fileGeneration($mission->id, $fileName);
                            if ($this->_sendSubmit($mission->id)) {
                                // On récupère motif_id et lieu_id pour les associer aux ordres de missions des passagers
                                $motifId = $mission->motif_id;
                                $lieuId = $mission->lieu_id;

                                $result = $this->Missions->find()->contain('Membres', function (Query $q) {
                                    return $q->select(['membres.nom']);})->where(['Missions.id' => $mission->id])->all()->toList();
                                $nom_send = array_column(array_column($result, 'membres'), 'nom')[0];
                                // print_r($nom_se0nd);
                                $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
                                    return $q->select(['membres.prenom']);})->where(['Missions.id' => $mission->id])->all()->toList();
                                $prenom_send = array_column(array_column($result1, 'membres'), 'prenom')[0];

                                $date_depart = $mission->date_depart;
                                $date_retour = $mission->date_retour;
                                // Génération des ordres de mission pour chaque passager
                                if ($passagersUniques != null) {
                                    foreach ($passagersUniques as $passager) {
                                        // print_r($passager);
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
                                        print_r($missionTemp);
                                        //$this->_sendConfirmModif($this->Mission->field('id'));
                                        $this->_sendPassager($missionTemp->id, $fileName, $commentaire_t, $nom_send, $prenom_send);
                                        // print_r('send');
                                    }
                                    // $this->Flash->success(__('Mission enregistré et soumis au chef d\'équipe.'));
                                    // return $this->redirect(['action' => 'index']);

                                } else {
                                    $this->request->getData()['passagers'] = null;
                                }

                                if ($this->request->getData()['er_vehicule']) {
                                    $user = $this->Membres->get($mission->responsable_id);
                                    $user['im_vehicule'] = $this->request->getData()['im_vehicule'];
                                    $user['pf_vehicule'] = $this->request->getData()['pf_vehicule'];
                                    $this->Membres->save($user);
                                }
                                $this->Flash->success(__('Mission modifié et soumis au chef d\'équipe.'));
                                return $this->redirect(['action' => 'index']);
                            }
                        } else {
                            $this->Flash->error(__('The mission could not be saved. Please, try again.'));
                        }
                    } else {
                        $this->Flash->error(__('La date de début doit être avant la date de fin.'));
                        return $this->redirect(['action' => 'edit']);
                    }
                }
                $projets = $this->Missions->Projets->find('list', ['limit' => 200]);
                $lieus = $this->Missions->Lieus->find('list', ['limit' => 200]);
                $motifs = $this->Missions->Motifs->find('list', ['limit' => 200]);
                $membres = $this->Missions->Membres->find('list', ['limit' => 200]);
                //transports
                // $transports = ['Train','Avion','Véhicule Personnel','Véhicule de service','Autre'];
                //selected types when user create a mission
                $tmp_query = $transportsController->Transports->find()->select('type_transport')->distinct('type_transport')->where(['mission_id' => $id])
                    ->all()->toArray();

                $mission_trans_type = array_column($tmp_query, 'type_transport'); //array

                $type_trans = array('vehicule_service', 'vehicule_personnel');
                $transport_vehicule = $transportsController->Transports->find()->select(['im_vehicule', 'pf_vehicule'])->where(['mission_id' => $id, 'type_transport IN' => $type_trans])
                    ->first();
                if (isset($transport_vehicule)) {
                    //如果data里面有这两项，就赋值给界面
                    $im_vehicule = $transport_vehicule['im_vehicule'];
                    $pf_vehicule = $transport_vehicule['pf_vehicule'];

                } else {}
                //selected passagers when user create a mission

                if (isset($im_vehicule) && isset($pf_vehicule)) {
                    $this->set(compact('mission', 'projets', 'lieus', 'motifs', 'membres', 'mission_trans_type', 'im_vehicule', 'pf_vehicule'));

                } else {
                    $this->set(compact('mission', 'projets', 'lieus', 'motifs', 'membres', 'mission_trans_type'));

                }
            } else {
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

        if ($mission->responsable_id == $this->Auth->user('id') || $this->Auth->user('role') === Membre::CHEFDEQUIPE || $this->Auth->user('role') === Membre::ADMIN) {
            if ($mission->etat === 'soumis') {
                //delete transport associe d'abord
                $transportsController = new TransportsController();
                $transids = $transportsController->Transports->find()->where(['mission_id' => $id])->all()->toArray();
                foreach ($transids as $transid) {
                    $transportsController->Transports->delete($transid);
                }
                if ($this->Missions->delete($mission)) {

                    $this->Flash->success(__('The mission has been deleted.'));

                } else {
                    $this->Flash->error(__('The mission could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Suppression impossible, OdM déjà validé'));
                $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->error(__('Suppression impossible : permissions insuffisantes'));
            $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);

        // $this->request->allowMethod(['post', 'delete']);
        // $membre = $this->Missions->get($id);
        // if ($this->Missions->delete($membre)) {
        //     $this->Flash->success(__('Le Missions a été supprimé.'));
        // } else {
        //     $this->Flash->error(__('La Missions du budget à échoué.'));
        // }
        // return $this->redirect(['action' => 'index']);
    }

    /**
     * Generate the  order pdf method
     *
     * @param string|null $id Mission id.
     * @param string|null $fileName the filename.
     * @return Response|null un pdf.
     */

    public function _fileGeneration($id, $fileName = null)
    {

        $this->loadModel('Membres');
        $this->loadModel('Transports');
        $this->loadModel('MissionsTransports');

        // Modification GTHWeb 20-01-2020
        include dirname(__FILE__) . '/Component/generator.php';

        $generator = new \MyGenerator();
        // Fin modification
        $this->Missions->id = $id;
        //-------------- // =  $this->Mission->field('motif_id'); //--------------------------
        // print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id'));
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(), 'lieu_id')[0];
        //  print_r($this->Missions->Lieus->id);
        //----------------- // = $this->Mission->User->Equipe->id = $this->Mission->User->field('equipe_id'); //-----
        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $this->Missions->Membres->Equipes->id = array_column(array_column($result, 'membres'), 'equipe_id')[0];
        // print_r($this->Missions->Membres->Equipes->id);
        $this->Missions->Projets->id = array_column($this->Missions->find()->select(['projet_id'])->where(['id' => $id])->all()->toArray(), 'projet_id');

        //---------------  // transports = $this->Transport->findAllByMissionId($missionId); //--------

        // $transports = array_column($this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->all()->toArray(),'type_transport');
        // $objectTransports = $this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->all()->toList();

        // print_r ($objectTransports);

        // $transports = $this->Transports->find()->select('type_transport')->where(['mission_id' => $id])->distinct('type_transport')->all()->toList();
        $transports = $this->Transports->find()->where(['mission_id' => $id])->all()->toList();

        //---------------  // End transports//------------------------------------

        //-----------------------TO DO-------------------------------
        //Ne rajoute la signature du chef d'équipe que si la mission a été validée
        $etat = array_column($this->Missions->find()->select('etat')->where(['id' => $id])->all()->toArray(), 'etat')[0];

        if ($etat == 'valide') {
            // selectionnne la signature du chef de l'équipe dont fait partie l'utilisateur
            $result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
            $equipeid = array_column(array_column($result_1, 'membres'), 'equipe_id')[0];
            // print_r($equipeid);
            $chefid = array_column($this->Missions->Membres->Equipes->find()->where(['id' => $equipeid])->all()->toArray(), 'responsable_id')[0];
            // print_r($chefid);
            $chefsign = array_column($this->Missions->Membres->find()->where(['id' => $chefid])->all()->toArray(), 'signature_name')[0];

            // print_r($chefsign);
            // $cheif = $this->Membres->find('first', array('conditions' => array('User.role' => 'admin', 'User.equipe_id' => $this->Mission->User->field('equipe_id'))));
            // génère la signature du chef
            // $cheifSignaturePath = "./img/Signatures/".$chefsign;
            $cheifSignaturePath = "./img/Signatures/" . $chefsign;

        } else {
            $cheifSignaturePath = "";
        }

        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $var1 = array_column(array_column($result, 'membres'), 'equipe_id')[0];
        $equipenom = array_column($this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $var1])->all()->toArray(), 'nom_equipe')[0];
        // print_r($equipenom);

        // print_r(array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
        //     return $q ->select(['membres.signature_name']);})
        //     ->where(['Missions.id' => $id])
        //     ->all()->toList(),'membres'),'signature_name')[0]);

        $sign = array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.signature_name']);})
                ->where(['Missions.id' => $id])
                ->all()->toList(), 'membres'), 'signature_name')[0];
        // print_r($sign);
        $signaturePath = "/Signatures/" . $sign;
        // print_r($signaturePath);
        // //---------------------------TO DO END----------------------------------
        $generator->setAgent(
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.id']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'id')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.nom']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'nom')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.prenom']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'prenom')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.adresse_agent_1']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'adresse_agent_1')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.adresse_agent_2']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'adresse_agent_2')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.residence_admin_1']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'residence_admin_1')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.residence_admin_2']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'residence_admin_2')[0],
            $equipenom,
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.intitule']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'intitule')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.grade']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'grade')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.type_personnel']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'type_personnel')[0],
            $signaturePath,
            //------------- TO DO ----------------
            $cheifSignaturePath,
            // $equipenom,
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.date_naissance']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'date_naissance')[0]
        );

        $generator->setMission(
            array_column(array_column($this->Missions->find()->contain('Motifs', function (Query $q) {
                return $q->select(['motifs.nom_motif']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'motifs'), 'nom_motif')[0],

            array_column($this->Missions->find()->select(['complement_motif'])
                    ->where(['id' => $id])->all()->toArray(), 'complement_motif')[0],
            $varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.nom_lieu']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'nom_lieu')[0],
            array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('H:i'),
            array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('H:i'),
            array_column($this->Missions->find()->select(['nb_repas'])->where(['id' => $id])->all()->toArray(), 'nb_repas')[0],
            array_column($this->Missions->find()->select(['nb_nuites'])->where(['id' => $id])->all()->toArray(), 'nb_nuites')[0]
        );

        $generator->setCadreAdmin(
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.matricule']);})->where(['Missions.id' => $id])->all()->toList(), 'membres'), 'matricule')[0]
        );

        $generator->setFinance(
            array_column(array_column($this->Missions->find()->contain('Projets', function (Query $q) {
                return $q->select(['projets.titre']);})->where(['Missions.id' => $id])->all()->toList(), 'projets'), 'titre')[0]

        );

        $im_vehicule = '';
        $pf_vehicule = '';
        // print_r($transports);
        // decision about imatriculation
        foreach ($transports as $transport) {
            // print_r($transport);
            // print_r($transport->im_vehicule);
            // print_r('transport'.$transport->pf_vehicule);

            if ($transport->type_transport === 'vehicule_service' || $transport->type_transport === 'vehicule_personnel') {
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
            array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(), 'commentaire_transport')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.carte_sncf']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'carte_sncf')[0],
            array_column($this->Missions->find()->select(['billet_agence'])->where(['id' => $id])->all()->toArray(), 'billet_agence')[0]

        );

        $sansFrais = false;
        if (array_column($this->Missions->find()->select(['sans_frais'])->where(['id' => $id])->all()->toArray(), 'sans_frais')[0]
        ) {
            $sansFrais = true;
        }

        return $generator->generate($sansFrais, $fileName);

    }

    /**
     * Generate the valid pdf method
     *
     * @param string|null $id Mission id.
     * @param string|null $fileName the filename.
     * @return Response|null un pdf.
     */
    public function _fileValidGeneration($id, $fileName = null)
    {
        $this->loadModel('Membres');
        $this->loadModel('Transports');

        // Modification GTHWeb 20-01-2020
        include dirname(__FILE__) . '/Component/generatorValid.php';

        $generator = new \MyValidGenerator();
        // Fin modification
        $this->Missions->id = $id;
        // print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id'));
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(), 'lieu_id')[0];
        //  print_r($this->Missions->Lieus->id);
        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $this->Missions->Membres->Equipes->id = array_column(array_column($result, 'membres'), 'equipe_id')[0];
        // print_r($this->Missions->Membres->Equipes->id);
        $this->Missions->Projets->id = array_column($this->Missions->find()->select(['projet_id'])->where(['id' => $id])->all()->toArray(), 'projet_id');

        $transports = $this->Transports->find()->where(['mission_id' => $id])->all()->toList();

        $etat = array_column($this->Missions->find()->select('etat')->where(['id' => $id])->all()->toArray(), 'etat')[0];

        if ($etat == 'valide') {
            //selectionnne la signature du chef de l'équipe dont fait partie l'utilisateur
            $result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
            $equipeid = array_column(array_column($result_1, 'membres'), 'equipe_id')[0];
            $chefid = array_column($this->Missions->Membres->Equipes->find()->where(['id' => $equipeid])->all()->toArray(), 'responsable_id')[0];
            $chefsign = array_column($this->Missions->Membres->find()->where(['id' => $chefid])->all()->toArray(), 'signature_name')[0];
            // print_r($chefsign);
            // print_r('jnas'.$chefsign);
            // génère la signature du chef
            $cheifSignaturePath = "/Signatures/" . $chefsign;
        } else {
            $cheifSignaturePath = "";
        }

        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $var1 = array_column(array_column($result, 'membres'), 'equipe_id')[0];
        $equipenom = array_column($this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $var1])->all()->toArray(), 'nom_equipe')[0];

        $sign = array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.signature_name']);})
                ->where(['Missions.id' => $id])
                ->all()->toList(), 'membres'), 'signature_name')[0];
        // print_r($sign);
        $signaturePath = "/Signatures/" . $sign;
        // print_r($signaturePath);

        $dataCurrent = date("d/m/Y");
        $generator->setLIFAT(
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.matricule']);})->where(['Missions.id' => $id])->all()->toList(), 'membres'), 'matricule')[0],
            $dataCurrent
        );

        $lieutravailTmp = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.lieu_travail_id']);})->where(['Missions.id' => $id])->all()->toList();
        // print_r($this->Missions->find()->contain('Membres', function (Query $q) {
        // return $q ->select(['membres.lieu_travail_id']);})->where(['Missions.id' => $id]));
        $Tmp1 = array_column(array_column($lieutravailTmp, 'membres'), 'lieu_travail_id')[0];
        $lieutravail = array_column($this->Missions->Membres->LieuTravails->find()->select(['LieuTravails.nom_lieu'])->where(['LieuTravails.id' => $Tmp1])->all()->toArray(), 'nom_lieu')[0];
        // print_r($lieutravail);

        $generator->setAgent(
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.id']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'id')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.nom']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'nom')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.prenom']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'prenom')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.email']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'email')[0],
            $equipenom,
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.date_naissance']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'date_naissance')[0],
        );

        $generator->setMission(
            array_column(array_column($this->Missions->find()->contain('Motifs', function (Query $q) {
                return $q->select(['motifs.nom_motif']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'motifs'), 'nom_motif')[0],

            array_column($this->Missions->find()->select(['complement_motif'])
                    ->where(['id' => $id])->all()->toArray(), 'complement_motif')[0],

            $varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.nom_lieu']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'nom_lieu')[0],
            array_column(array_column($this->Missions->find()->contain('Membres', function (Query $q) {
                return $q->select(['membres.type_personnel']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'membres'), 'type_personnel')[0]
        );

        $generator->setDepart(
            array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('H:i'),
            array_column($this->Missions->find()->select(['date_depart_arrive'])->where(['id' => $id])->all()->toArray(), 'date_depart_arrive')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_depart_arrive'])->where(['id' => $id])->all()->toArray(), 'date_depart_arrive')[0]->format('H:i'),

            $varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.nom_lieu']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'nom_lieu')[0],
            $lieutravail,
            array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.pays']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'pays')[0]
        );

        $generator->setArrivee(
            array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('H:i'),
            array_column($this->Missions->find()->select(['date_retour_arrive'])->where(['id' => $id])->all()->toArray(), 'date_retour_arrive')[0]->format('d/m/Y'),
            array_column($this->Missions->find()->select(['date_retour_arrive'])->where(['id' => $id])->all()->toArray(), 'date_retour_arrive')[0]->format('H:i'),
            $varr = array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.nom_lieu']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'nom_lieu')[0],
            $lieutravail,
            array_column(array_column($this->Missions->find()->contain('Lieus', function (Query $q) {
                return $q->select(['lieus.pays']);})
                    ->where(['Missions.id' => $id])
                    ->all()->toList(), 'lieus'), 'pays')[0]
        );

        $im_vehicule = '';
        $pf_vehicule = '';
        // print_r($transports);
        // decision about imatriculation
        foreach ($transports as $transport) {
            if ($transport->type_transport === 'vehicule_service' || $transport->type_transport === 'vehicule_personnel') {
                $im_vehicule = $transport->im_vehicule;
                $pf_vehicule = $transport->pf_vehicule;
                break;
            }
        }

        $generator->setTransport($transports);
        $generator->setSignatures(
            $signaturePath,
            $cheifSignaturePath,
            $juridiqueSignaturePath = "/Signatures/lifat.jpg",
            $presidentSignaturePath = "/Signatures/universite.jpg"
        );

        return $generator->generate($fileName);
    }

    public function generationValid($id = null)
    {
        $this->loadModel('Membres');
        if ($id != null) {
            $mission = $this->Missions->get($id, [
                'contain' => ['Projets', 'Lieus', 'Motifs', 'Membres'],
            ]);
            // print_r($mission->etat);
            if ($this->Auth->user('id') === $mission->responsable_id || $this->Auth->user('role') === Membre::ADMIN || $this->Auth->user('role') === Membre::SECRETAIRE || $this->Auth->user('role') === Membre::CHEFDEQUIPE) {
                // $fileName = $mission->id.'.pdf';
                $this->_fileValidGeneration($id);
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

    public function generation($id = null)
    {
        $this->loadModel('Membres');
        if ($id != null) {
            $mission = $this->Missions->get($id, [
                'contain' => ['Projets', 'Lieus', 'Motifs', 'Membres'],
            ]);
            // print_r($mission->etat);
            if ($this->Auth->user('id') === $mission->responsable_id || $this->Auth->user('role') === Membre::ADMIN || $this->Auth->user('role') === Membre::SECRETAIRE || $this->Auth->user('role') === Membre::CHEFDEQUIPE) {
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
    public function _calculNombreRepasNuite($dateDebut, $dateFin)
    {
        $diff = date_diff($dateDebut, $dateFin);
        // print_r($diff);
        $nombreNuite = $diff->days;
        $nombreRepas = round(($diff->format("%h") + $diff->days * 24) / 12, 0);
        return array('nb_nuites' => $nombreNuite, 'nb_repas' => $nombreRepas);
    }

    /**
     * envoie la soumission 提交 au chef d'équipe après avoir saisie une estimation des dépenses
     **/
    public function submission($id = null, $save = false)
    {

        if ($id == null) {
            $this->redirect(['action' => 'index']);
        } else {
            $this->Missions->id = $id;
            $this->set('id', $id);

            // permet de ne pas soumettre un OdM déjà soumis
            if ($this->Mission->field('etat') === 'soumis') {
                $this->Flash->error(__('Erreur : OdM déjà soumis.'));
                $this->redirect(['action' => 'index']);
            }
            // s'il y a des données et que l'on veut soumettre l'OdM
            if ($save && $this->data != null) {
                // si l'enregistrement de l'estimation est bien sauvé on envoie un mail au chef
                $this->Mission->set('etat', 'soumis');
                if ($this->Mission->save($this->data)) {
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
    public function _sendSubmit($id)
    {
        $this->Missions->id = $id;
        // print_r($this->Missions->id);
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];

        // print_r($this->Missions->Motifs->id);
        // $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(), 'lieu_id')[0];
        // print_r($this->Missions->Lieus->id);
        // récupère les emails des chefs d'équipe
        $result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $equipeid = array_column(array_column($result_1, 'membres'), 'equipe_id')[0];
        // print_r($equipeid);

        $chefid = array_column($this->Missions->Membres->Equipes->find()->where(['id' => $equipeid])->all()->toArray(), 'responsable_id')[0];
        // print_r($chefid);

        $chefemail = array_column($this->Missions->Membres->find()->where(['id' => $chefid])->all()->toArray(), 'email')[0];

        // print_r($chefemail);

        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
        $nom_send = array_column(array_column($result, 'membres'), 'nom')[0];
        $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
        $prenom_send = array_column(array_column($result1, 'membres'), 'prenom')[0];

        $result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
        $email_send = array_column(array_column($result2, 'membres'), 'email')[0];

        $result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
            return $q->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
        // print_r($result_3);
        // print_r(array_column($result_3,'motifs'));
        $nommotif = array_column(array_column($result_3, 'motif'), 'nom_motif')[0];

        // print_r($nommotif);
        $result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
            return $q->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
        $nomlieu = array_column(array_column($result_4, 'lieus'), 'nom_lieu')[0];
        // print_r($nomlieu);
        // $nommotif = array_column($this->Missions->find()->select(['nom_motif'])->where(['id' => $id])->all()->toArray(),'nom_motif')[0];
        // $nomlieu = array_column($this->Missions->find()->select(['nom_lieu'])->where(['missions.id' => $id])->all()->toArray(),'nom_lieu')[0];
        // print_r($id);
        // print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
        $date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y');
        $date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y');
        $commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(), 'commentaire_transport')[0];

        // $this->_fileGeneration($mission->id);

        // Interaction avec le view
        $email = new Email();
        $email->set('nom', $nom_send);
        $email->set('prenom', $prenom_send);
        $email->set('lieu', $nomlieu);
        $email->set('motif', $nommotif);
        $email->set('date_depart', $date_d);
        $email->set('date_retour', $date_r);
        $email->set('commentaire', $commentaire_t);
        // cake3_7/webroot/147.pdf
        // $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

        // $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
        //  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';

        // TransportFactory::setConfig('gmail', [
        //     'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
        //     ]);

        return $email
            ->template('submit_om')
            ->emailFormat('text')
            ->from('21707371t@gmail.com')
            ->to($chefemail)
            ->subject('Ordre de mission de ' . $prenom_send . ' ' . $nom_send . ' à valider')
            ->cc($email_send)
            ->setTransport('gmail')
            // ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'pdf'])
            ->attachments(['ODM.pdf' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/' . $this->Missions->id . '.pdf'])
            ->send();
    }

    /**
     * send mail of submission which is sent to team passager
     **/
    public function _sendPassager($id, $fileName, $commentaire_t, $nom, $prenom)
    {
        $this->Missions->id = $id;
        // print_r($this->Missions->id);
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];

        print_r($this->Missions->Motifs->id);
        // $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(),'lieu_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(), 'lieu_id')[0];
        print_r($this->Missions->Lieus->id);
        // récupère les emails des chefs d'équipe

        $result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
        $email_send = array_column(array_column($result2, 'membres'), 'email')[0];
        // print_r($email_send);

        // $result_5 = $this->Missions->find()->contain('Membres', function (Query $q) {
        //     return $q ->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
        // $email_to = array_column(array_column($result,'membres'),'email')[0];

        $result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
            return $q->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
        // print_r($result_3);
        // print_r(array_column($result_3,'motifs'));
        $nommotif = array_column(array_column($result_3, 'motif'), 'nom_motif')[0];

        // print_r($nommotif);
        $result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
            return $q->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
        $nomlieu = array_column(array_column($result_4, 'lieus'), 'nom_lieu')[0];
        // print_r($nomlieu);
        // $nommotif = array_column($this->Missions->find()->select(['nom_motif'])->where(['id' => $id])->all()->toArray(),'nom_motif')[0];
        // $nomlieu = array_column($this->Missions->find()->select(['nom_lieu'])->where(['missions.id' => $id])->all()->toArray(),'nom_lieu')[0];
        // print_r($id);
        // print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
        $date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y');
        $date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y');
        // $commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(),'commentaire_transport')[0];

        // $this->_fileGeneration($mission->id);

        // Interaction avec le view
        $email = new Email();
        $email->set('nom', $nom);
        $email->set('prenom', $prenom);
        $email->set('lieu', $nomlieu);
        $email->set('motif', $nommotif);
        $email->set('date_depart', $date_d);
        $email->set('date_retour', $date_r);
        $email->set('commentaire', $commentaire_t);
        // cake3_7/webroot/147.pdf
        // $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

        // $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
        //  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';

        // TransportFactory::setConfig('gmail', [
        //     'url' => 'smtp://21707371t@gmail.com:CNMsb123@smtp.gmail.com:587?tls=true',
        //     ]);

        return $email
            ->template('submit_om')
            ->emailFormat('text')
            ->from('21707371t@gmail.com')
            ->to($email_send)
            ->subject('Ordre de mission de ' . $nom . ' ' . $prenom . ' à valider')
            // ->cc($email_send)
            ->setTransport('gmail')
            // ->attachments(['mission_info' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/'.$this->Missions->id.'pdf'])
            ->attachments(['ODM.pdf' => '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/webroot/' . $fileName])
            ->send();
    }

// /**
    //     * validation of an mission orders
    //     */
    public function valid($id = null)
    {

        if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef_equipe') {

            $mission = $this->Missions->get($id);

            $this->Missions->id = $id;
            // print_r($mission->id);
            // if mission exist
            // print_r(array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(),'responsable_id')[0]);
            if (array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0] != 0) {
                //if ($this->Mission->field('valide') == false) {
                $etat = array_column($this->Missions->find()->select('etat')->where(['id' => $id])->all()->toArray(), 'etat')[0];
                // print_r($etat);
                if ($etat != 'valide') {
                    // financial element have to be set
                    if (empty($mission)) {
                        $mission = $this->Missions->get($id);
                    } else {
                        // validate mission
                        $mission->set('etat', 'valide');
                        $this->Missions->save($mission);
                        $this->set('mission', $mission);

                        $this->_sendValidation($mission->id);

                        $this->Flash->success(__('Mission validée'));
                        $this->redirect(array('controller' => 'missions', 'action' => 'needValidation'));
                    }
                } else {
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

//     /**
    //     * send mail to secretaries after confirmation from cheif team
    //     * Load User model cause of the needed to know mail team cheif
    //     **/
    public function _sendValidation($id)
    {

        $this->Missions->id = $id;
        // print_r($this->Missions->id );
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['id' => $id])->all()->toArray(), 'lieu_id')[0];
        $result_1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.equipe_id']);})->where(['Missions.id' => $id])->all()->toList();
        $this->Missions->Membres->Equipes->id = array_column(array_column($result_1, 'membres'), 'equipe_id')[0];
        // print_r($this->Missions->Membres->Equipes->id);

        // emails of secretaries
        $result_2 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role' => 'secretaire'])
            ->all()->toArray();
        $secretaries = array_column(array_column($result_2, 'membres'), 'email');

        // $result_7 =     $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.id'=> $this->Missions->Membres->id])
        // ->all()->toArray();
        // // $membreemail =
        // print_r($result_7);

        // $mails = "";
        // $i = count($secretaries) - 1;
        // foreach ($secretaries as $secretary => $mail ) {
        //     if ( $i == 0 )
        //         $mails .= $mail;
        //     else
        //         $mails .= $mail." , ";
        //     $i--;
        // }

        $mails = array();
        foreach ($secretaries as $secretary => $mail) {
            array_push($mails, $mail);
        }
        // print_r($mails);

        //Noms des secrétaires
        // $secretaries = null;
        // $secretaries = $this->Missions->User->find('list', array(
        //     'fields' => array('User.first_name'),
        //     'conditions' => array('User.role' => 'secretary')
        //      ));

        $result_3 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role' => 'secretaire'])
            ->all()->toArray();
        $secretaries = array_column(array_column($result_3, 'membres'), 'nom');

        $secretaryNames = "";
        $i = count($secretaries) - 1;
        foreach ($secretaries as $secretary => $name) {
            if ($i == 0) {
                $secretaryNames .= $name;
            } else {
                $secretaryNames .= $name . ", ";
            }

            $i--;
        }
        //  print_r($secretaryNames);

        // emails of team cheifs
        $result_7 = $this->Missions->Membres->find()->select(['membres.email'])->where(['membres.role' => 'chef_equipe', 'membres.equipe_id' => $this->Missions->Membres->Equipes->id])
            ->all()->toArray();
        // print_r($result_7);
        $cheifs = array_column(array_column($result_7, 'membres'), 'email')[0];

        // // Ajoute en cc l'utilisateur (s'il ne s'agit pas du chef car le chef est déjà en copie)
        // if (array_search($this->Mission->User->field('email'), $ccMails) === FALSE)
        //     array_push($ccMails, $this->Mission->User->field('email'));

        // generation of the OdM
        $tmpfname = tempnam("/tmp", "FOO");
        $tmpfname2 = tempnam("/tmp", "BAR");
        //echo $tmpfname;
        $this->_fileGeneration($id, $tmpfname);
        $this->_fileValidGeneration($id, $tmpfname2);
        // Génération du fichier texte
        // $fp = @fopen($tmpfname2, "w+");

        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
        $nom_send = array_column(array_column($result, 'membres'), 'nom')[0];

        $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
        $prenom_send = array_column(array_column($result1, 'membres'), 'prenom')[0];

        $result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
        $email_send = array_column(array_column($result2, 'membres'), 'email')[0];
        // print_r($email_send);
        $result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
            return $q->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
        // print_r(array_column($result_3,'motifs'));
        $nommotif = array_column(array_column($result_3, 'motif'), 'nom_motif')[0];

        // print_r($nommotif);
        $result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
            return $q->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
        $nomlieu = array_column(array_column($result_4, 'lieus'), 'nom_lieu')[0];

        $var1 = $this->Missions->Membres->Equipes->find()->select(['Equipes.nom_equipe'])->where(['Equipes.id' => $this->Missions->Membres->Equipes->id])->all()->toArray();
        $nomequipe = array_column($var1, 'nom_equipe')[0];

        // print_r($this->Missions->find()->select(['date_depart'])->where(['id' => $id]));
        $date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y');
        $date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y');
        $commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(), 'commentaire_transport')[0];

        $nom = $nom_send;
        $prenom = $prenom_send;
        $equipe = $nomequipe;
        $date_d = $date_d;
        $date_r = $date_r;
        $lieu = $nomlieu;
        $motif = $nommotif;

        // fwrite($fp, $nom." ".$prenom."\t".$equipe."\t\t\t".$date_d."\t".$date_r."\t".$lieu."\t".$motif);
        // fclose($fp);

        //cc给chef自己一份，cc给membre一份
        $ccMails = array();
        array_push($ccMails, $email_send);
        array_push($ccMails, $cheifs);
        // print_r($ccMails);
        // print_r('ccMails'+$ccMails);

        // Interaction avec le view
        $email = new Email();
        $email->set('nom', $nom_send);
        $email->set('prenom', $prenom_send);
        $email->set('lieu', $nomlieu);
        $email->set('motif', $nommotif);
        $email->set('date_depart', $date_d);
        $email->set('date_retour', $date_r);
        $email->set('commentaire', $commentaire_t);
        $email->set('secretaryName', $secretaryNames);

        // cake3_7/webroot/147.pdf
        // $email->attachments(["OM.pdf" => './cake3_7/tmp/']);

        // $email->profile(['from' => ['Site de gestion des OdM' => 'donotreply@odm.li.univ-tours.fr']]);
        //  = 'Site de gestion des OdM <donotreply@odm.li.univ-tours.fr>';
        TransportFactory::setConfig('gmail', [
            'url' => 'smtp://21707371t@gmail.com:sbCNM123@smtp.gmail.com:587?tls=true',
        ]);
        // $nom_pdf =
        return $email
            ->template('validation_om')
            ->emailFormat('text')
            ->from('21707371t@gmail.com')
            // ->to('qingling.meng@etu.univ-tours.fr')
            ->to($mails)
            ->subject('Ordre de mission de ' . $prenom_send . ' ' . $nom_send . ' validé')
            ->cc($ccMails)
            ->setTransport('gmail')
            // ->attachments(["OM.pdf" => $tmpfname, "VM.pdf" => $tmpfname2]);
            ->attachments(["DOM.pdf" => $tmpfname, "VOM.pdf" => $tmpfname2])
            ->send();

        // erase file
        unlink($tmpfname);
        unlink($tmpfname2);
    }

//     /**
    //     * liste des missions à valider par le chef d'équipe
    //     **/
    public function needValidation()
    {
        if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef_equipe') {
            //admin看的是自己所在的equipe生效的mission
            $this->set('searchLabelExtra', "Numéro");

            $query = $this->Missions->find('search', ['search' => $this->request->getQueryParams()])
                ->contain('Membres', function (Query $q) {
                    return $q;})
                ->where(['Missions.etat' => 'soumis', 'Membres.equipe_id' => $this->Auth->user('equipe_id')]);
            //Association tables
            $this->paginate = [
                'contain' => ['Lieus', 'Motifs', 'Membres'],
            ];
            $this->set('missions', $this->paginate($query));
        } else {
            //$this->Session->setFlash('Permission insuffisante pour afficher la liste des missions à valider','flash_failure');
            $this->Flash->error(__('Permission insuffisante pour afficher la liste des missions à valider'));
            $this->redirect(array('controller' => 'missions', 'action' => 'index'));
        }

        // print_r(phpinfo());
        // $this->set('searchLabelExtra', "Numéro et/ou État du mission");
        // $query = $this->Missions
        // // Use the plugins 'search' custom finder and pass in the processed query params
        //     ->find('search', ['search' => $this->request->getQueryParams()])
        //     ->where(['responsable_id' => $this->Auth->user('id')]);

        //  $this->paginate = [
        //      'contain' => ['Projets', 'Lieus', 'Motifs'],
        //  ];
        //  $this->set('missions', $this->paginate($query));

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
                'contain' => ['Lieus', 'Motifs', 'Membres'],
            ];
            $this->set('missions', $this->paginate($query));
        } elseif ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'chef_equipe') {
            $this->set('searchLabelExtra', "Numéro");

            //admin看的是自己所在的equipe生效的mission
            $query = $this->Missions->find('search', ['search' => $this->request->getQueryParams()])
                ->contain('Membres', function (Query $q) {
                    return $q;})
                ->where(['Missions.etat' => 'valide', 'Membres.equipe_id' => $this->Auth->user('equipe_id')]);
            //Association tables
            $this->paginate = [
                'contain' => ['Lieus', 'Motifs', 'Membres'],
            ];
            $this->set('missions', $this->paginate($query));
        } else {
            $this->Flash->error(__('Impossible d\'afficher la liste des ODM : Permission insuffisante. '));
            $this->redirect(['action' => 'index']);
        }
    }

/**
 * send modification notify by of an OdM to the OdM's creator
 **/
    public function _sendConfirmModif($id)
    {

        $this->Missions->id = $id;
        $this->Missions->Membres->id = array_column($this->Missions->find()->select(['responsable_id'])->where(['id' => $id])->all()->toArray(), 'responsable_id')[0];
        $this->Missions->Motifs->id = array_column($this->Missions->find()->select(['motif_id'])->where(['id' => $id])->all()->toArray(), 'motif_id')[0];
        $this->Missions->Lieus->id = array_column($this->Missions->find()->select(['lieu_id'])->where(['missions.id' => $id])->all()->toArray(), 'lieu_id')[0];

        $result = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.nom']);})->where(['Missions.id' => $id])->all()->toList();
        $nom_send = array_column(array_column($result, 'membres'), 'nom')[0];
        $result1 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.prenom']);})->where(['Missions.id' => $id])->all()->toList();
        $prenom_send = array_column(array_column($result1, 'membres'), 'prenom')[0];

        $result2 = $this->Missions->find()->contain('Membres', function (Query $q) {
            return $q->select(['membres.email']);})->where(['Missions.id' => $id])->all()->toList();
        $email_send = array_column(array_column($result2, 'membres'), 'email')[0];

        $result_3 = $this->Missions->find()->contain('Motifs', function (Query $q) {
            return $q->select(['Motifs.nom_motif']);})->where(['Missions.id' => $id])->all()->toList();
        // print_r($result_3);
        $nommotif = array_column(array_column($result_3, 'motif'), 'nom_motif')[0];
        // print_r($nommotif);
        $result_4 = $this->Missions->find()->contain('Lieus', function (Query $q) {
            return $q->select(['Lieus.nom_lieu']);})->where(['Missions.id' => $id])->all()->toList();
        $nomlieu = array_column(array_column($result_4, 'lieus'), 'nom_lieu')[0];
        // print_r($nomlieu);

        $date_d = array_column($this->Missions->find()->select(['date_depart'])->where(['id' => $id])->all()->toArray(), 'date_depart')[0]->format('d/m/Y');
        $date_r = array_column($this->Missions->find()->select(['date_retour'])->where(['id' => $id])->all()->toArray(), 'date_retour')[0]->format('d/m/Y');
        $commentaire_t = array_column($this->Missions->find()->select(['commentaire_transport'])->where(['id' => $id])->all()->toArray(), 'commentaire_transport')[0];

        // $this->Email->to = $this->Mission->User->field('email');
        // Interaction avec le view
        $email = new Email();
        $email->set('nom', $nom_send);
        $email->set('prenom', $prenom_send);
        $email->set('lieu', $nomlieu);
        $email->set('motif', $nommotif);
        $email->set('date_depart', $date_d);
        $email->set('date_retour', $date_r);
        $email->set('commentaire', $commentaire_t);
        TransportFactory::setConfig('gmail', [
            'url' => 'smtp://21707371t@gmail.com:sbCNM123@smtp.gmail.com:587?tls=true',
        ]);

        return $email
            ->template('modification_odm')
            ->emailFormat('text')
            ->from('21707371t@gmail.com')
            ->to($email_send)
            // ->to('mql951002@gmail.com')
            ->subject('Ordre de mission de ' . $nommotif)
            ->setTransport('gmail')
            ->send();

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
            //    Les comptes non activés n'ont aucun droit
            return false;
        } else {
            //    Tous les membres permanents ont tous les droits sur les thèses
            if ($user['permanent'] == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne la liste des missions pour une année donnée en paramètre
     * @return array : liste des missions
     */
    public function listeMissionsParAnnee($annee = null)
    {
        $result = $this->Missions->find('all')->where(['YEAR(date_depart) = ' => $annee])->toArray();
        return $result;
    }

}
