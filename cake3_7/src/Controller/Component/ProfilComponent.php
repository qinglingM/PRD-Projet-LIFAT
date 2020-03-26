<?php
namespace App\Controller\Component;
use Cake\Controller\Component;

class ProfilComponent extends Component {

	var $components = ['Auth'];

	// Vérifie les informations renseignées dans le profil de l'utilisateur. S'il manque des informations, retourne false. Si tout est renseigné, retourne true.
	function verifProfil() {
		$user = $this->Auth->user();
		if ($user['User']['name'] === '' || $user['User']['name'] === null) {
			return false;
		}
		if ($user['User']['first_name'] === '' || $user['User']['first_name'] === null) {
			return false;
		}
		if ($user['User']['email'] === '' || $user['User']['email'] === null) {
			return false;
		}
		if ($user['User']['adresse_agent_1'] === '' || $user['User']['adresse_agent_1'] === null) {
			return false;
		}
		if ($user['User']['residence_admin_1'] === '' || $user['User']['residence_admin_1'] === null) {
			return false;
		}
		if ($user['User']['date_naissance'] === '' || $user['User']['date_naissance'] === null) {
			return false;
		}
		return true;
	}
}
?>