<?php

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use App\Model\Entity\Membre;
use App\Model\Table\MembresTable;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\I18n\Time;
use Cake\ORM\Query;

/**
 * Membres Controller
 *
 * @property MembresTable $Membres
 *
 * @method Membre[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class MembresController extends AppController
{
	/**
	 * Makes the /membres/register action public.
	 *
	 * @param Event $event
	 * @return Response|null
	 */
	public function beforeFilter(Event $event)
	{
		$this->Auth->allow('register');
		return parent::beforeFilter($event);
	}

	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->set('searchLabelExtra', 'nom et/ou prénom');

		$query = $this->Membres
			// Use the plugins 'search' custom finder and pass in the
			// processed query params
			->find('search', ['search' => $this->request->getQueryParams()]);

		$this->paginate = [
			'contain' => ['LieuTravails', 'Equipes']
		];

		$this->set('membres', $this->paginate($query));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Membre id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$membre = $this->Membres->get($id, [
			'contain' => ['LieuTravails', 'Equipes']
		]);

		$this->set('membre', $membre);
	}

	/**
	 * Register method
	 *
	 * @return Response|null Redirects on successful registration, renders view otherwise.
	 */
	public function register()
	{
		$membre = $this->Membres->newEntity();
		if ($this->request->is(['patch', 'post', 'put'])) {
			$membre = $this->Membres->patchEntity($membre, $this->request->getData());
			$membre->date_creation = Time::now();
			if ($this->Membres->save($membre)) {
				// Récupération du Membre.id créé
				$query = $this->Membres->find('all')
					->where(['Membres.email =' => $this->request->getData()['email']])
					->limit(1);
				$membreId = $query->first();

				// INSERT dans Dirigeants en Encadrants
				$this->loadModel('Encadrants');
				$this->loadModel('Dirigeants');

				$query = $this->Dirigeants->query();
				$query->insert(['dirigeant_id'])->values(['dirigeant_id' => $membreId['id']])->execute();

				$query = $this->Encadrants->query();
				$query->insert(['encadrant_id'])->values(['encadrant_id' => $membreId['id']])->execute();
				$this->Flash->success(__('Enregistrement effectué, en attente de validation du compte.'));

				return $this->redirect(['controller' => 'pages', 'action' => 'index']);
			}
			$this->Flash->error(__('Impossible d\'enregistrer le compte.'));
		}
		$lieuTravails = $this->Membres->LieuTravails->find('list', ['limit' => 200]);
		$equipes = $this->Membres->Equipes->find('list', ['limit' => 200]);
		$this->set(compact('membre', 'lieuTravails', 'equipes'));
	}

	/**
	 * Edit method ; if $id is null it behaves like an add method instead.
	 *
	 * @param string|null $id Membre id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ($id == null)
			$membre = $this->Membres->newEntity();
		else
			$membre = $this->Membres->get($id, [
				'contain' => []
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			// Champs à conserver
			$old_signature = $membre->signature_name;
			$old_password = $membre->passwd;
			
			$membre = $this->Membres->patchEntity($membre, $this->request->getData());
			$membre->date_creation = Time::now();
			
			// Upload de la signature
			$file = $this->request->getData()['signature_name'];
			if($file['name'] != null) {
				$signatureFolder = './Signatures';
				
				if (!file_exists($signatureFolder))
					mkdir($signatureFolder);

				// Erreur
				if ($file['error'] > 0) {
					$this->Flash->error('Erreur lors de la récupération du fichier signature.');
					return $this->redirect(['action' => 'index']);
				}

				// Limitation à 10Mo
				if ($file['size'] > 10000000) {
					$this->Flash->error('Votre fichier signature est trop volumineux (>10Mo) !');
					return $this->redirect(['action' => 'index']);
				}

				// Enregistrement
				$extension = array_values(array_slice(explode('.', $file['name']), -1))[0];
				// Hashage du nom de fichier
				$hasher = new DefaultPasswordHasher();
				$hash = $hasher->hash($file['name']).'.'.$extension;
				$hash1 = str_replace('\\', '', $hash);
				$hash2 = str_replace('/', '', $hash1);
				$membre->signature_name = $hash2;
				if (!move_uploaded_file($file['tmp_name'], $signatureFolder . '/' . $membre->signature_name)) {
					$this->Flash->error('Erreur lors de l\'enregistrement du fichier signature.');
					// Suppression de l'ancienne signature si non nulle
					return $this->redirect(['action' => 'index']);
				}
				else {
					// On supprime l'ancienne signature
					if($old_signature != null) {
						unlink($signatureFolder . '/' . $old_signature);
					}
				}
			}
			else { // On conserve la signature actuelle
				$membre->signature_name = $old_signature;
			}
			
			// Test de conservation du mot de passe
			if($this->request->getData()['passwd'] == null) {
				$membre->passwd = '';
			}
			
			if ($this->Membres->save($membre)) {
				if ($id == null) {
					$this->Flash->success(__('Nouveau membre'));
					// Récupération du Membre.id créé
					$query = $this->Membres->find('all')
						->where(['Membres.email =' => $this->request->getData()['email']])
						->limit(1);
					$membreId = $query->first();

					// INSERT dans Dirigeants en Encadrants
					$this->loadModel('Encadrants');
					$this->loadModel('Dirigeants');

					$query = $this->Dirigeants->query();
					$query->insert(['dirigeant_id'])->values(['dirigeant_id' => $membreId['id']])->execute();

					$query = $this->Encadrants->query();
					$query->insert(['encadrant_id'])->values(['encadrant_id' => $membreId['id']])->execute();
				}
				$this->Flash->success(__('Le membre a été édité avec succès.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('L\'édition du membre a échoué. Merci de ré-essayer.'));
		}
		$lieuTravails = $this->Membres->LieuTravails->find('list', ['limit' => 200]);

		$equipes = $this->Membres->Equipes->find('list', ['limit' => 200]);

		//	Si l'user actuel n'est pas admin, les équipes dans lesquelles il peut bouger le membre cible sont limitées (seulement l'equipe actuelle de la cible / les équipes que le user mène / dont il fait partie)
		if ($this->Auth->user('role') != Membre::ADMIN) {
			$equipes->where(['responsable_id' => $this->Auth->user('id')]);
			$equipes->orWhere(['id' => $this->Auth->user('equipe_id')]);
			$equipes->orWhere(['id' => $membre->equipe_id]);
		}

		$this->set(compact('membre', 'lieuTravails', 'equipes'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Membre id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$membre = $this->Membres->get($id);
		if ($this->Membres->delete($membre)) {
			$this->Flash->success(__('Le membre a été supprimé.'));
		} else {
			$this->Flash->error(__('La membre du budget à échoué.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	public function login()
	{
		if ($this->request->is('post')) {
			$membre = $this->Auth->identify();
			if ($membre) {
				$this->Auth->setUser($membre);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Votre identifiant ou votre mot de passe est incorrect.');
		}
	}

	public function logout()
	{
		$this->Flash->success('Vous avez été déconnecté.');
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * Retourne la liste des doctorants en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des doctorants
	 */
	public function listeDoctorant($dateEntree = null, $dateFin = null)
	{
		$this->loadModel('Membres');
		$result = $this->Membres->find('all')
			->where(['type_personnel' => 'DO']);

		if ($dateEntree && $dateFin) {
			$result = $result->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_creation', $dateEntree, $dateFin);
			});
		}
		return $result->toArray();
	}

	/**
	 * Retourne la liste des membres par equipe en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des membres
	 */
	public function listeMembreParEquipe($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$this->loadModel('Membres');
			$result = $this->Membres->find('all')
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				});
		} else {
			$result = $this->Membres->find('all');
		}
		$result->toArray();
		foreach ($result as $key => $row) {
			$equipe_id[$key] = $row['equipe_id'];
		}
		array_multisort($equipe_id, SORT_NUMERIC, SORT_DESC, $result);
		return $result;
	}

	/**
	 * Retourne une liste des type avec leur effectifs respectifs en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des types/effectif
	 */
	public function effectifParType($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$do = $this->Membres->find('all')
				->where(['type_personnel' => 'DO']);
			$pe = $this->Membres->find('all')
				->where(['type_personnel' => 'PE']);
			$pu = $this->Membres->find('all')
				->where(['type_personnel' => 'PU']);
			$do = $do->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_creation', $dateEntree, $dateFin);
			})->count();
			$pe = $pe->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_creation', $dateEntree, $dateFin);
			})->count();
			$pu = $pu->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
				return $exp->between('date_creation', $dateEntree, $dateFin);
			})->count();
		} else {
			$do = $this->Membres->find('all')
				->where(['type_personnel' => 'DO'])
				->count();
			$pe = $this->Membres->find('all')
				->where(['type_personnel' => 'PE'])
				->count();
			$pu = $this->Membres->find('all')
				->where(['type_personnel' => 'PU'])
				->count();
		}
		$resultset = ["Do" => $do,
			"PE" => $pe,
			"PU" => $pu
		];
		return $resultset;
	}

	/**
	 * Retourne une liste d'effectifs trie par type en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des types/effectif
	 */
	public function listeEffectifParType($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$result = $this->Membres->find('all')
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->toArray();

			foreach ($result as $key => $row) {
				$type_personnel[$key] = $row['type_personnel'];
			}
			array_multisort($type_personnel, SORT_STRING, SORT_ASC, $result);
		} else {
			$result = $this->Membres->find('all')
				->toArray();

			foreach ($result as $key => $row) {
				$type_personnel[$key] = $row['type_personnel'];
			}
			array_multisort($type_personnel, SORT_STRING, SORT_ASC, $result);

		}
		return $result;
	}

	/**
	 * Retourne la liste des effectifs selon leur sexe et nationalite en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des effectifs
	 */
	public function effectifParNationaliteSexe($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$hommeFrancais = $this->Membres
				->find('all')
				->where(['genre' => 'H',
					'est_francais' => '1'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->count();
			$hommeEtranger = $this->Membres->find('all')
				->where(['genre' => 'H',
					'est_francais' => '0'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->count();
			$femmeFrancaise = $this->Membres->find('all')
				->where(['genre' => 'F',
					'est_francais' => '1'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->count();
			$femmeEtrangere = $this->Membres->find('all')
				->where(['genre' => 'F',
					'est_francais' => '0'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->count();
		} else {
			$hommeFrancais = $this->Membres->find('all')
				->where(['genre' => 'H',
					'est_francais' => '1'])
				->count();
			$hommeEtranger = $this->Membres->find('all')
				->where(['genre' => 'H',
					'est_francais' => '0'])
				->count();
			$femmeFrancaise = $this->Membres->find('all')
				->where(['genre' => 'F',
					'est_francais' => '1'])
				->count();
			$femmeEtrangere = $this->Membres->find('all')
				->where(['genre' => 'F',
					'est_francais' => '0'])
				->count();
		}
		$resultset = ["hommeFrancais" => $hommeFrancais,
			"hommeEtranger" => $hommeEtranger,
			"femmeFrancaise" => $femmeFrancaise,
			"femmeEtrangere" => $femmeEtrangere
		];
		return $resultset;
	}

	/**
	 * Retourne la liste des doctorants par equipe en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des doctorants
	 */
	public function listeDoctorantParEquipe($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$result = $this->Membres->find('all')
				->where(['type_personnel' => 'DO'])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->toArray();
		} else {
			$result = $this->Membres->find('all')
				->where(['type_personnel' => 'DO'])
				->toArray();
		}

		foreach ($result as $key => $row) {
			$equipe_id[$key] = $row['equipe_id'];
		}
		array_multisort($equipe_id, SORT_NUMERIC, SORT_ASC, $result);
		return $result;
	}

	/**
	 * Retourne le nombre d'effectif par equipe en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : nombre de doctorant avec le nom de leur equipe
	 */
	public function nombreEffectifParEquipe($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$equipe_id = $this->Membres->find('all')
				->distinct(['equipe_id'])
				->select("equipe_id")
				->toArray();

			$result = array();
			//die(strval($equipe_id[2]));
			foreach ($equipe_id as $row) {
				if ($row["equipe_id"] != null) {

					$nombre = $this->Membres->find("all")
						->where(["equipe_id" => $row["equipe_id"]])
						->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
							return $exp->between('date_creation', $dateEntree, $dateFin);
						})
						->count();

					$this->loadModel('Equipes');
					$nom = $this->Equipes->find('all')
						->where(["id" => $row["equipe_id"]])
						->select('nom_equipe')
						->first();
					$tmp = array($nom["nom_equipe"], $nombre);
					$result[] = $tmp;
				}
			}
		} else {
			$equipe_id = $this->Membres->find('all')
				->distinct(['equipe_id'])
				->select("equipe_id")
				->toArray();

			$result = array();
			//die(strval($equipe_id[2]));
			foreach ($equipe_id as $row) {
				if ($row["equipe_id"] != null) {

					$nombre = $this->Membres->find("all")
						->where(["equipe_id" => $row["equipe_id"]])
						->count();

					$this->loadModel('Equipes');
					$nom = $this->Equipes->find('all')
						->where(["id" => $row["equipe_id"]])
						->select('nom_equipe')
						->first();
					$tmp = array($nom["nom_equipe"], $nombre);
					$result[] = $tmp;
				}
			}
		}
		return $result;
	}

	/**
	 * Retourne le nombre de doctorants par equipe en prenant en compte une fenetre de temps
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : nombre de doctorant avec le nom de leur equipe
	 */
	public function nombreDoctorantParEquipe($dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$equipe_id = $this->Membres->find('all')
				->distinct(['equipe_id'])
				->select("equipe_id")
				->toArray();

			$result = array();
			//die(strval($equipe_id[2]));
			foreach ($equipe_id as $row) {
				if ($row["equipe_id"] != null) {

					$nombre = $this->Membres->find("all")
						->where(["equipe_id" => $row["equipe_id"]])
						->where(['type_personnel' => 'DO'])
						->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
							return $exp->between('date_creation', $dateEntree, $dateFin);
						})
						->count();

					$this->loadModel('Equipes');
					$nom = $this->Equipes->find('all')
						->where(["id" => $row["equipe_id"]])
						->select('nom_equipe')
						->first();
					$tmp = array($nom["nom_equipe"], $nombre);
					$result[] = $tmp;
				}
			}
		} else {
			$equipe_id = $this->Membres->find('all')
				->distinct(['equipe_id'])
				->select("equipe_id")
				->toArray();

			$result = array();
			//die(strval($equipe_id[2]));
			foreach ($equipe_id as $row) {
				if ($row["equipe_id"] != null) {

					$nombre = $this->Membres->find("all")
						->where(["equipe_id" => $row["equipe_id"]])
						->where(['type_personnel' => 'DO'])
						->count();

					$this->loadModel('Equipes');
					$nom = $this->Equipes->find('all')
						->where(["id" => $row["equipe_id"]])
						->select('nom_equipe')
						->first();
					$tmp = array($nom["nom_equipe"], $nombre);
					$result[] = $tmp;
				}
			}
		}
		return $result;
	}

	/**
	 * Retourne la liste des projets auquel un membre participe en prenant en compte une fenetre de temps
	 * @param $id : identifiant du membre
	 * @param $dateEntree : date d'entree de la fenetre de temps
	 * @param $dateFin : date de fin de la fenetre de temps
	 * @return array : liste des doctorants
	 */
	public function listeProjetMembre($id = null, $dateEntree = null, $dateFin = null)
	{
		if ($dateEntree && $dateFin) {
			$equipeId = $this->Membres->find('all')
				->select(['equipe_id'])
				->where(['id' => $id])
				->where(function (QueryExpression $exp, Query $q) use ($dateEntree, $dateFin) {
					return $exp->between('date_creation', $dateEntree, $dateFin);
				})
				->toArray();

			$this->loadModel('EquipesProjets');
			$projet_id = $this->EquipesProjets->find('all')
				->where(['equipe_id' => $equipeId[0]['equipe_id']])
				->select(['projet_id'])
				->toArray();

			$result = array();
			foreach ($projet_id as $row) {
				$this->loadModel('Projets');
				$tmp = $this->Projets->find('all')
					->where(['id' => $row['projet_id']])
					->toArray();
				array_push($result, $tmp[0]);
			}
		} else {
			$this->loadModel('Membres');
			$equipeId = $this->Membres->find('all')
				->select(['equipe_id'])
				->where(['id' => $id])
				->toArray();

			$this->loadModel('EquipesProjets');
			$projet_id = $this->EquipesProjets->find('all')
				->where(['equipe_id' => $equipeId[0]['equipe_id']])
				->select(['projet_id'])
				->toArray();

			$result = array();
			foreach ($projet_id as $row) {
				$this->loadModel('Projets');
				$tmp = $this->Projets->find('all')
					->where(['id' => $row['projet_id']])
					->toArray();
				array_push($result, $tmp[0]);
			}
		}
		return $result;
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
		} else {
			$userEntity = $this->Membres->findById($user['id'])->first();
			$action = $this->request->getParam('action');
			$membre_slug = $this->request->getParam('pass.0');

			if ($action === 'edit' && $membre_slug) {
				$membre = $this->Membres->findById($membre_slug)->first();

				//	Edit membre existant (=> action pour chef d'équipe -actif- de la cible, ou soi-même)
				return ($userEntity['id'] === $membre['id']) || (!is_null($membre['equipe_id']) && $user['actif'] === true && $userEntity->estChefEquipe($membre['equipe_id']));

				//	Add (edit sans slug) et Delete => admin (déjà true avec parent::isAuthorized())
			}
		}
		return false;
	}
}
