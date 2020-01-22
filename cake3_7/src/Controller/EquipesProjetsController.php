<?php

namespace App\Controller;

use App\Model\Entity\EquipesProjet;
use App\Model\Table\EquipesProjetsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * EquipesProjets Controller
 *
 * @property EquipesProjetsTable $EquipesProjets
 *
 * @method EquipesProjet[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipesProjetsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Equipes', 'Projets']
		];
		$equipesProjets = $this->paginate($this->EquipesProjets);

		$this->set(compact('equipesProjets'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Equipes Projet id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$equipesProjet = $this->EquipesProjets->get($id, [
			'contain' => ['Equipes', 'Projets']
		]);

		$this->set('equipesProjet', $equipesProjet);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$equipesProjet = $this->EquipesProjets->newEntity();
		if ($this->request->is('post')) {
			$equipesProjet = $this->EquipesProjets->patchEntity($equipesProjet, $this->request->getData());
			if ($this->EquipesProjets->save($equipesProjet)) {
				$this->Flash->success(__('Le projet de l\'équipe a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du projet de l\'équipe a échoué. Merci de ré-essayer.'));
		}
		$equipes = $this->EquipesProjets->Equipes->find('list', ['limit' => 200]);
		$projets = $this->EquipesProjets->Projets->find('list', ['limit' => 200]);
		$this->set(compact('equipesProjet', 'equipes', 'projets'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Equipes Projet id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$equipesProjet = $this->EquipesProjets->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$equipesProjet = $this->EquipesProjets->patchEntity($equipesProjet, $this->request->getData());
			if ($this->EquipesProjets->save($equipesProjet)) {
				$this->Flash->success(__('Le projet de l\'équipe a été ajouté avec succès.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'ajout du projet de l\'équipe a échoué. Merci de ré-essayer.'));
		}
		$equipes = $this->EquipesProjets->Equipes->find('list', ['limit' => 200]);
		$projets = $this->EquipesProjets->Projets->find('list', ['limit' => 200]);
		$this->set(compact('equipesProjet', 'equipes', 'projets'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Equipes Projet id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$equipesProjet = $this->EquipesProjets->get($id);
		if ($this->EquipesProjets->delete($equipesProjet)) {
			$this->Flash->success(__('Le projet de l\'équipe à été supprimé.'));
		} else {
			$this->Flash->error(__('La suppression du projet de l\'équipe à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}

    /**
     * Retourne la liste des projets auxquels une equipe participe en prenant en compte une fenetre de temps
     * @param $id : identifiant de l'equipe
     * @param $dateEntree : date d'entree de la fenetre de temps
     * @param $dateFin : date de fin de la fenetre de temps
     * @return array : liste des projets
     */
    public function listeProjetEquipe($dateEntree = null, $dateFin = null){
        if($dateEntree && $dateFin){
            $this->loadModel('EquipesProjets');
            $tmp = $this->EquipesProjets->find('all')
                ->contain(['Projets'])
                ->toArray();

			$result = array();
			foreach ($tmp as $row) {
				$timeProjet = strtotime($row['projet']['date_debut']);
				$dateIn = strtotime($dateEntree);
				$dateOut = strtotime($dateFin);

                if($timeProjet>=$dateIn && $timeProjet<=$dateOut){
                    array_push($result,$row['projet']);
                }
            }
        }else {
            $this->loadModel('EquipesProjets');
            $tmp = $this->EquipesProjets->find('all')
                ->contain(['Projets'])
            ->toArray();

			$result = array();
			foreach ($tmp as $row) {
				array_push($result, $row['projet']);
			}
		}
		return $result;
	}
}
