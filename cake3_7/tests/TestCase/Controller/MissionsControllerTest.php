<?php

namespace App\Test\TestCase\Controller;

use Cake\Event\EventList;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MissionsController Test Case
 */
class MissionsControllerTest extends TestCase
{
    use IntegrationTestTrait;
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Missions',
        'app.Projets',
        'app.Lieus',
        'app.Motifs',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->Missions = TableRegistry::getTableLocator()->get('Missions');
        // enable event tracking
        $this->Missions->getEventManager()->setEventList(new EventList());
    }

    public function enableRememberFlashMessages()
    {
        $this->_rememberFlashMessages = true;
    }

    public function setUserSession()
    {
        // Set session data
        $auth = [
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'role' => 'admin',
                    'nom' => 'Admin',
                    'prenom' => 'Admin',
                    'email' => 'admin@admin.fr',
                    'passwd' => 'admin',
                    'adresse_agent_1' => '',
                    'adresse_agent_2' => '',
                    'residence_admin_1' => '',
                    'residence_admin_2' => '',
                    'type_personnel' => 'PU',
                    'intitule' => '',
                    'grade' => '',
                    'im_vehicule' => 11,
                    'pf_vehicule' => 11,
                    'signature_name' => 'signatu.jpg',
                    'login_cas' => '',
                    'carte_sncf' => '',
                    'matricule' => null,
                    'date_naissance' => '2019-02-11',
                    'actif' => 1,
                    'lieu_travail_id' => 2,
                    'nationalite' => '',
                    'est_francais' => 1,
                    'genre' => 'F',
                    'hdr' => 0,
                    'permanent' => 1,
                    'est_porteur' => 0,
                    'date_creation' => '2020-02-12 11:14:46',
                    'date_sortie' => '',
                    // other keys.
                ],
            ],
        ];
        return $auth;
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->withoutExceptionHandling();

        $this->session($this->setUserSession());
        $this->get('/missions');
        $this->assertResponseSuccess(500);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $token = 'my-csrf-token';
        $this->cookie('csrfToken', $token);

        $this->configRequest([
            'headers' => [
                'X-CSRF-Token' => $token,
                // ...
            ],
        ]);
        $data = [
            'id' => 800,
            'projet_id' => 1,
            'lieu_id' => 3,
            'motif_id' => 3,
            'sans_frais' => 1,
            'date_depart' => '2017-05-05 04:07:00',
            'date_arrive' => '2017-05-04 04:07:00',
        ];
        $this->post('/missions', $data);
        $this->assertFlashMessage('La date de début doit être avant la date de fin.', 'flash');
        $data1 = [
            'id' => 801,
            'projet_id' => 1,
            'lieu_id' => 3,
            'motif_id' => 3,
            'sans_frais' => 1,
        ];
        $this->post('/missions', $data);
        $this->assertRedirect(['controller' => 'Missions', 'action' => 'index']);
        $this->assertFlashMessage('Mission enregistré et soumis au chef d\'équipe.', 'flash');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/missions/edit/664');
        $missions = TableRegistry::getTableLocator()->get('Missions');
        // $query = $missions->find()->where(['id' => 664]);
        $this->assertEquals(664, $missions->find()->select('id')->where(['id' => 664])->all->toArray());
        $this->assertEquals(1, $missions->find()->select('projet_id')->where(['id' => 664])->all->toArray());
        $this->assertEquals(3, $missions->find()->select('lieu_id')->where(['id' => 664])->all->toArray());
        $this->assertEquals(3, $missions->find()->select('motif_id')->where(['id' => 664])->all->toArray());
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->enableRetainFlashMessages();
        $this->get('/missions/delete/544');
        $this->assertFlashMessage('Suppression impossible, OdM déjà validé', 'flash');
        $this->get('/missions/delete/190');
        $this->assertFlashMessage('The mission has been deleted.', 'flash');
    }

    /**
     * Test generation method
     *
     * @return void
     */
    public function testGeneration()
    {
        $this->withoutExceptionHandling();
        $this->get('/missions/generate');
        $this->assertResponseSuccess();
    }

    /**
     * Test generationValid method
     *
     * @return void
     */
    public function testGenerationValid()
    {
        $this->withoutExceptionHandling();
        $this->get('/missions/generateValid');
        $this->assertResponseSuccess();
    }

    /**
     * Test CalculNombreRepasNuite method
     *
     * @return void
     */
    public function testCalculNombreRepasNuite()
    {
        $date_depart = mktime(15, 23, 30, 2, 16, 2019);
        $date_retour = mktime(15, 23, 30, 2, 21, 2019);

        $missions = TableRegistry::getTableLocator()->get('Missions');
        $this->get('/missions/_calculNombreRepasNuite/date_depart,date_retour');

        $this->assertEquals(5, ($date_retour - $date_depart) / 86400);
        $this->assertEquals(10, ($date_retour - $date_depart) / 86400 * 2);
    }
    /**
     * Test sendSubmit method
     *
     * @return void
     */
    public function testSendSubmit()
    {
        $this->withoutExceptionHandling();
        $this->get('/missions/_sendSubmit');
        $this->assertResponseSuccess();
    }
    /**
     * Test sendPassager method
     *
     * @return void
     */
    public function testSendPassager()
    {
        $this->withoutExceptionHandling();
        $this->get('/missions/_sendPassager');
        $this->assertResponseSuccess();
    }

    /**
     * Test valid method
     *
     * @return void
     */
    public function testValid()
    {
        $this->enableRetainFlashMessages();
        $this->get('/missions/valid/190');
        $this->assertFlashMessage('Mission déjà validé', 'flash');

        $this->get('/missions/valid/677');
        $this->assertFlashMessage('Mission validée', 'flash');

        $this->get('/missions/valid/9999');
        $this->assertFlashMessage('Mission inexistante', 'flash');

    }

    /**
     * Test needValidation method
     *
     * @return void
     */
    public function testNeedValidation()
    {
        $this->session($this->setUserSession());
        $this->get('/missions/needValidation');
        $missions = TableRegistry::getTableLocator()->get('Missions');
        $query = $missions->find()->where(['etat' => 'soumis']);
        $this->assertEquals($this->get('/missions/needValidation')->count(), $query->count());

    }

    /**
     * Test alreadyValid method
     *
     * @return void
     */
    public function testAlreadyvalid()
    {
        $this->session($this->setUserSession());
        $this->get('/missions/alreadyvalid');
        $missions = TableRegistry::getTableLocator()->get('Missions');
        $query = $missions->find()->where(['etat' => 'valid']);
        $this->assertEquals($this->get('/missions/alreadyvalid')->count(), $query->count());
    }

    /**
     * Test sendConfirmMotif method
     *
     * @return void
     */
    public function testSendConfirmModif()
    {
        $this->withoutExceptionHandling();

        $this->session($this->setUserSession());
        $this->get('/missions/_sendConfirmModif');
        $this->assertResponseSuccess();

    }

}
