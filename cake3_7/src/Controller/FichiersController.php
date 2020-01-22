<?php

namespace App\Controller;

use App\Model\Entity\Fichier;
use App\Model\Table\FichiersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * Fichiers Controller
 *
 * @property FichiersTable $Fichiers
 *
 * @method Fichier[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichiersController extends AppController
{
	/**
	 * If you change this, make sure to move existing files to the new folder.
	 */
	const uploadFolder = "./UploadedFiles";

	/**
	 * Index method
	 *
	 * @return Response|void
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Membres']
		];
		$fichiers = $this->paginate($this->Fichiers);

		$this->set(compact('fichiers'));
		$this->set('uploadfolder', substr(self::uploadFolder, 1));
		//	Alors oui il n'aime pas le point au début
	}

	/**
	 * View method
	 *
	 * @param string|null $id Fichier id.
	 * @return Response|void
	 * @throws RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$fichier = $this->Fichiers->get($id, [
			'contain' => ['Membres']
		]);

		$this->set('fichier', $fichier);
	}

	/**
	 * Add method
	 *
	 * @return Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$fichier = $this->Fichiers->newEntity();
		if ($this->request->is('post')) {

			if (!file_exists(self::uploadFolder))
				mkdir(self::uploadFolder);

			$file = $this->request->getData()['nom'];

			// Erreur
			if ($file['error'] > 0) {
				$this->Flash->error('Erreur lors de la récupération du fichier !');
				return $this->redirect(['action' => 'index']);
			}

			// Limitation à 10Mo
			if ($file['size'] > 10000000) {
				$this->Flash->error('Votre fichier est trop volumineux (>10Mo) !');
				return $this->redirect(['action' => 'index']);
			}

			// Type de fichier
			if ($file['type'] != 'application/pdf') {
				$this->Flash->error('Vous ne pouvez envoyer que des fichiers PDF (.pdf) !');
				return $this->redirect(['action' => 'index']);
			}

			// Enregistrement parsage manuel
			$this->loadModel('Membres');
			$fichier->nom = $this->request->getData()['nom']['name'];
			$fichier->titre = $this->request->getData()['titre'];
			$fichier->description = $this->request->getData()['description'];
			$fichier->membre = $this->Membres->get($this->Auth->user('id'));

			if ($this->Fichiers->save($fichier)) {
				$savedFile = self::uploadFolder . '/' .  $file['name'];
				if (move_uploaded_file($file['tmp_name'], $savedFile)) {
					$this->Flash->Success($file['name'] . ' enregistré avec succès !');
					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('Le fichier n\'a pa pu être sauvegardé.'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('Erreur lors de l\'enregistrement du fichier dans la base.');
				return $this->redirect(['action' => 'index']);
			}
		}
		$membres = $this->Fichiers->Membres->find('list', ['limit' => 200]);
		$this->set(compact('fichier', 'membres'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Fichier id.
	 * @return Response|null Redirects on successful edit, renders view otherwise.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$fichier = $this->Fichiers->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			// File renaming
			$oldname = self::uploadFolder . '/' . $fichier->nom;
			$newname = self::uploadFolder . '/' . $this->request->getData()['nom'];
			$fichier = $this->Fichiers->patchEntity($fichier, $this->request->getData());
			if (rename($oldname, $newname)) {
				if ($this->Fichiers->save($fichier)) {
					$this->Flash->success(__('Le fichier a été modifié.'));

					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('Erreur lors de l\'enregistrement dans la base.'));
			}
			$this->Flash->error(__('Le nom du fichier est invalide.'));
		}
		$membres = $this->Fichiers->Membres->find('list', ['limit' => 200]);
		$this->set(compact('fichier', 'membres'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Fichier id.
	 * @return Response|null Redirects to index.
	 * @throws RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$fichier = $this->Fichiers->get($id);
		$name = self::uploadFolder . '/' . $fichier->nom;
		if (unlink($name)) {
			if ($this->Fichiers->delete($fichier)) {
				$this->Flash->success(__('Le fichier a bien été supprimé.'));
			} else {
				$this->Flash->error(__('Le fichier a physiquement été supprimé mais pas son entrée dans la liste.'));
			}
		} else {
			$this->Flash->error(__('Impossible de supprimer le fichier, veuillez réessayer.'));
		}

		return $this->redirect(['action' => 'index']);
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
		} else if ($user['permanent'] === true) {
			//	Seuls les membres permanents ont des droits sur les fichiers, pour commencer

			$action = $this->request->getParam('action');
			$fichier_slug = $this->request->getParam('pass.0');

			if ($fichier_slug && ($action === 'edit' || $action === 'delete')) {
				//	Fichier existant : seul son owner peut l'edit / delete
				$fichier = $this->Fichiers->findById($fichier_slug)->first();
				return $user['id'] === $fichier['membre_id'];
			}
		}
		return false;
	}
}
