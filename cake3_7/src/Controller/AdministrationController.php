<?php
namespace App\Controller;

use App\Model\Entity\Membre;

class AdministrationController extends AppController {
	var $uses = array();

	// Affiche la page d'accueil de l'administration, qui mène vers les autres pages d'administration
	function index() {
		if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'secretaire' || $this->Auth->user('role') == 'chef_equipe') {
			
		} else {
			$this->Flash->error(__('Administration impossible : Permission insuffisante.'));
			// $this->Session->setFlash('Administration impossible : Permission insuffisante','flash_failure');
			$this->redirect(['action' => 'index']);
		}
	}

	// Page de gestion des paramètre mail
	function mail() {
		if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'secretarire' || $this->Auth->user('role') == 'chef_equipe') {
			if (! empty($this->data) ) {
				$fp = @fopen("config.txt", "w+");
				foreach ($this->data as $param) {
					fwrite($fp, "$param\r\n");
				}
				fclose($fp);
			} else {
				$emailConfig = file("config.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				if (count($emailConfig) >= 3) {
					$this->data['port'] = $emailConfig['0'];
					$this->data['timeout'] = $emailConfig['1'];
					$this->data['host'] = $emailConfig['2'];
				}
			}
		} else {
			$this->Session->setFlash('Administration impossible : Permission insuffisante','flash_failure');
			$this->redirect(array('controller' => 'users', 'action' => 'listMissions'));
		}
	}
}

?>