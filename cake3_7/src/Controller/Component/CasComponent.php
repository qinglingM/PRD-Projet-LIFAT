<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\View\Helper\SessionHelper;
use phpCAS;

// fichier de configuration de CAS
include_once ('/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/config/cas.php');

// sources de CAS
// include_once ('/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/vendor/CAS/CAS.php');

// require('CAS/CAS.php');

class CasComponent extends Component{
	var $login_cas = null;
	var $components = ['Session'];
	var $connected_cas = false;

	function login()
	{
		$return = false;

		// print_r(require('CAS/CAS.php'));
		global $connected_cas;
		// Permet d'éviter d'appeler plusieurs fois phpCas::client()
		if (!$connected_cas) {
			phpCAS::client(CAS_VERSION_2_0, CAS_SERVER, CAS_SERVER_PORT, CAS_SERVER_DIR, false);
			$connected_cas = true;
		}
		
		// no SSL validation for the CAS server
		phpCAS::setNoCasServerValidation();

		if(phpCAS::forceAuthentication())
		{
			$this->login_cas = phpCAS::getUser();
			$return = true;
		}

		return $return;
	}

	function checkAuthentication() {
		global $connected_cas;
		// Permet d'éviter d'appeler plusieurs fois phpCas::client()
		if (!$connected_cas) {
			phpCAS::client(CAS_VERSION_2_0, CAS_SERVER, CAS_SERVER_PORT, CAS_SERVER_DIR, false);
			$connected_cas = true;
		}
		phpCAS::setNoCasServerValidation();
		return phpCas::checkAuthentication();
	}

	function isAuthenticated() {
		global $connected_cas;
		// Permet d'éviter d'appeler plusieurs fois phpCas::client()
		if (!$connected_cas) {
			phpCAS::client(CAS_VERSION_2_0, CAS_SERVER, CAS_SERVER_PORT, CAS_SERVER_DIR, false);
			$connected_cas = true;
		}
		return phpCAS::isAuthenticated();
	}

	function logout() {
		global $connected_cas;
		// Permet d'éviter d'appeler plusieurs fois phpCas::client()
		if (!$connected_cas) {
			phpCAS::client(CAS_VERSION_2_0, CAS_SERVER, CAS_SERVER_PORT, CAS_SERVER_DIR, false);
			$connected_cas = true;
		}	
		phpCAS::logoutWithRedirectService(Router::url('/', true));
	}

	function getLogin()
	{
		return $this->login_cas;
	}
}
?>