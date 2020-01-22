<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Model\Entity\Membre;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler', [
			'enableBeforeRedirect' => false,
		]);
		//charge le composant flash de cake php
		$this->loadComponent('Flash');

		//charge le composant d'authentification de cakephp
		$this->loadComponent('Auth', [
			'authorize' => 'Controller',
			'authenticate' => [
				'Form' => [
					'fields' => ['username' => 'email', 'password' => 'passwd'],
					'userModel' => 'Membres'
				]
			],
			'loginAction' => [
				'controller' => 'Membres',
				'action' => 'login'
			],
			// Si pas autorisé, on renvoie sur la page précédente
			'unauthorizedRedirect' => $this->referer()
		]);

		//	la page de garde est accessible publiquement (mais que cette page)
		$this->Auth->allow(array('controller' => 'pages', 'action' => 'display'));
		//	cf. fonctions "beforeFilter" pour les autres actions publiques
		//	cf. fonctions "isAuthorized" pour les permissions des membres connectés

		/*
		 * Enable the following component for recommended CakePHP security settings.
		 * see https://book.cakephp.org/3.0/en/controllers/components/security.html
		 */
		//$this->loadComponent('Security');

		//	Permet d'utiliser friendsofcake/search
		$this->loadComponent('Search.Prg', [
			// This is default config. You can modify "actions" as needed to make
			// the PRG component work only for specified methods.
			'actions' => ['index']
		]);
	}

	/**
	 * Before filter : makes some user data accessible in the views.
	 * (example : $user['nom']).
	 * Unfortunately, for some odd reason putting the whole Membre entity does NOT work.
	 * @param Event $event
	 * @return Response|null
	 */
	public function beforeFilter(Event $event)
	{
		$session = $this->request->getSession();
		$user = $session->read('Auth.User');
		$this->set('user', $user);
		return parent::beforeFilter($event);
	}

	/**
	 * Checks the currently logged in user's rights to access a page (called when changing pages).
	 * @param $user : the user currently logged in
	 * @return bool : whether the user is allowed (or not) to access the requested page
	 */
	public function isAuthorized($user)
	{
		//	Quoi qu'il arrive, l'admin a tous les droits
		if ($user['role'] === Membre::ADMIN) {
			return true;
		}

		$action = $this->request->getParam('action');

		//	Les membres dont le compte n'est pas activé ne peuvent rien faire par défaut (sauf se déconnecter)
		if ($user['actif'] != true && $action != 'logout') {
			return false;
		}

		//	Quoi qu'il arrive, n'importe quel membre connecté avec un compte actif peut avoir accès aux fontions 'index', 'view' et 'logout'
		if (in_array($action, ['index', 'view', 'logout'])) {
			return true;
		}

		//	Rien d'autre par défaut (À ce point-là les droits + spécifiques sont vus dans les autres controllers)
		return false;
		//	Donc, toutes les autres méthodes "isAuthorized" devront ressembler à ça :
		/*
			if(parent::isAuthorized($user) === true)
			{
				return true;
			}
			else
			{
				...
			}
			return false;
		 */
	}
}
