<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ExportForm;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use App\Model\Entity\Membre;
use App\Model\Entity\EncadrantsTheses;
use Graph;
use Barplot;
use PieGraph;
use PiePlot;

/**
 * Class ExportController
 * @package App\Controller
 */
class ExportController extends AppController
{
    /**
     * Index method
     *
     */
    public function index()
    {
        $export = new ExportForm();
        if ($this->request->is('post')) {
            if ($export->execute($this->request->getData())) {
                $export->setData($this->request->getData());
                $this->results();
                $this->Flash->success('Nous traitons votre demande.'.$export->getData('typeExport'));
            } else {
                $this->Flash->error('Il y a eu un problème lors de la soumission de votre formulaire.');
            }
        }
        $this->loadModel('Membres');
        $encadrants = $this->Membres
            ->find()
            ->select(['id','nom', 'prenom'])
            ->join([
                'table' => 'encadrants',
                'alias' => 'e',
                'conditions' => 'e.encadrant_id = id',
            ]);

        $this->loadModel('Equipes');
        $equipes = $this->Equipes
            ->find()
            ->select(['id','nom_equipe']);

        $membres = $this->Membres->find();

        $this->set('export', $export);
        $this->set(compact('encadrants','equipes', 'membres'));
    }

    /**
     * Results method
     * Permet de choisir le graphique et/ou tableau à afficher selon le formulaire
     */
    public function results(){
        $export = new ExportForm();
        if ($this->request->is('post')) {
            if ($export->execute($this->request->getData())) {
                $export->setData($this->request->getData());
            } else {
                $this->Flash->error('Il y a eu un problème lors de la soumission de votre formulaire.');
            }
        }


        $boolGraph = $export->getData('exportGraphe');
        $boolTableau = $export->getData('exportListe');


        //Si l'utilisateur veut un graphe
        if ($boolGraph == true){
            $typeGraphe = $export->getData('typeGraphe');

            if($typeGraphe == 'EM5'){
                $this->grapheEffectifsParType();
            }
            else if($typeGraphe == 'EM7'){
                $this->graphNombreDeDoctorantsParEquipe();
            }
            else if($typeGraphe == 'EM9') {
                $this->graphEffectifsParEquipe();
            }
            else if($typeGraphe == 'EM15'){
                $this->graphEffectifsParNationaliteParSexe();
            }
        }


        //Si l'utilisateur veut un tableau
        if ($boolTableau == true){
            $typeListe = $export->getData('typeListe');
            if($typeListe == "EM1"){
                $encadrant = $export->getData('encadrant');
                $this->tableaulisteThesesParEncadrant($encadrant);
            }
            else if ($typeListe == "EM2"){ //OK MAIS ATTENTION YA DES PB
                $this->tableauListeMembresParEquipe();
            }
            else if($typeListe == "EM3"){
                $encadrant = $export->getData('encadrant');
                $this->tableauListeProjetMembre($encadrant);
            }
            else if($typeListe == "EM4"){
                $this->tableauListeDoctorant();
            }
            else if($typeListe == "EM6"){
                $this->tableauEffectifsParType();
            }
            else if($typeListe == "EM8"){
                $this->tableauNombreDeDoctorantsParEquipe();
            }
            else if($typeListe == "EM10"){
                $this->tableauEffectifsParEquipe();
            }
            else if($typeListe == "ET1"){
                $this->tableauListeEncadrantsAvecTaux();
            }
            else if($typeListe == "ET2"){
                $equipe = $export->getData('equipe');
                $this->tableauListeThesesParEquipe($equipe);
            }
            else if ($typeListe == "ET3"){
                $this->tableauListeSoutenances();
            }
            else if($typeListe == "ET4"){
                $this->tableauListeSoutenanceHDR();
            }
            else if ($typeListe == "ET5"){
                $annee = $export->getData('annee');
                $this->tableauListeSoutenancesParAnnee($annee['year']);
            }
            else if ($typeListe == "ET6"){
                $this->tableauListeTheseParType();
            }
            else if($typeListe == "ET7"){
                $this->tableauThesesEnCours();
            }
            else if ($typeListe == "EPr1"){
                $this->tableauInformationProjet();
            }
            else if ($typeListe == "EPr2"){
                $this->tableauListeProjetParEquipe();
            }
            else if ($typeListe == "EPr3"){
                $membre = $export->getData('membre');
                $this->tableauListeProjetMembre($membre);
            }
            else if ($typeListe == "EPr4"){//OK
                $this->tableauBudgetsParProjet();
            }

        }
        $this->set("boolGraphe", $boolGraph);
        $this->set("boolTableau", $boolTableau);
    }


    /**
     * Creer le graphique des effectifs par type
     */
    public function grapheEffectifsParType(){
        $controlInstance = new MembresController();
        $donnees = $controlInstance->effectifParType();
        foreach($donnees as $key => $value){
            $type[]= $key;
            $effectifs[] = $value;
        }

        $largeur = 1000;
        $hauteur = 600;
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' . DS . 'jpgraph.php');
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' .  DS . 'jpgraph_bar.php');
        // Initialisation du graphique
        $graphe = new Graph($largeur, $hauteur);

        // Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
        // Valeurs min et max seront determinees automatiquement
        $graphe->setScale("textlin");

        // Creation de l'histogramme



        $histo = new BarPlot($effectifs);

        // Ajout de l'histogramme au graphique

        $graphe->add($histo);
        $graphe->xaxis->title->set("Type");
        $graphe->yaxis->title->set("Effectifs");
        $graphe->xaxis->setTickLabels($type);

        // Ajout du titre du graphique
        $graphe->title->set("Histogramme");

        @unlink("img/effectifsParType.png");
        $graphe->stroke("img/effectifsParType.png");

        $this->set("nomGraphe", "effectifsParType.png");
    }


    /**
     * Creer le tableau des membres par equipe
     */
    public function tableauListeMembresParEquipe(){
        $controlInstance = new MembresController();
        $donnees = $controlInstance->listeMembreParEquipe();
        $tableau = $donnees->toArray();
        $entetes = ["id","role", "nom", "prenom", "email", "pass", "adresse_agent_1", "adresse_agent_2", "residence_admin_1",
            "residence_admin_2", "type_personnel", "intitule", "grade", "im_vehicule", "pf_vehicule", "signature_name",
            "login_cas", "carte_sncf", "matricule", "date_naissance", "actif", "lieu_travail_id", "equipe_id", "nationalite",
            "est_francais", "genre", "hdr", "permanent", "est_porteur", "date_creation", "date_sortie"];

        $fichier = "listeMembres.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }

        fputcsv($fp, $entetes, ";");

        $listeMembres = array();
        $membres = array();
        foreach($tableau as $key => $row){
            $listeMembres[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->role,
                $tableau[$key]->nom,
                $tableau[$key]->prenom,
                $tableau[$key]->email,
                $tableau[$key]->pass,
                $tableau[$key]->adresse_agent_1,
                $tableau[$key]->adresse_agent_2,
                $tableau[$key]->residence_admin_1,
                $tableau[$key]->residence_admin_2,
                $tableau[$key]->type_personnel,
                $tableau[$key]->intitule,
                $tableau[$key]->grade,
                $tableau[$key]->im_vehicule,
                $tableau[$key]->pf_vehicule,
                $tableau[$key]->signature_name,
                $tableau[$key]->login_cas,
                $tableau[$key]->carte_sncf,
                $tableau[$key]->matricule,
                $tableau[$key]->date_naissance,
                $tableau[$key]->actif,
                $tableau[$key]->lieu_travail_id,
                $tableau[$key]->equipe_id,
                $tableau[$key]->nationalite,
                $tableau[$key]->est_francais,
                $tableau[$key]->genre,
                $tableau[$key]->hdr,
                $tableau[$key]->permanent,
                $tableau[$key]->est_porteur,
                $tableau[$key]->date_creation,
                $tableau[$key]->date_sortie
            );

            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->role,
                $tableau[$key]->nom,
                $tableau[$key]->prenom,
                $tableau[$key]->email,
                $tableau[$key]->pass,
                $tableau[$key]->adresse_agent_1,
                $tableau[$key]->adresse_agent_2,
                $tableau[$key]->residence_admin_1,
                $tableau[$key]->residence_admin_2,
                $tableau[$key]->type_personnel,
                $tableau[$key]->intitule,
                $tableau[$key]->grade,
                $tableau[$key]->im_vehicule,
                $tableau[$key]->pf_vehicule,
                $tableau[$key]->signature_name,
                $tableau[$key]->login_cas,
                $tableau[$key]->carte_sncf,
                $tableau[$key]->matricule,
                $tableau[$key]->date_naissance,
                $tableau[$key]->actif,
                $tableau[$key]->lieu_travail_id,
                $tableau[$key]->equipe_id,
                $tableau[$key]->nationalite,
                $tableau[$key]->est_francais,
                $tableau[$key]->genre,
                $tableau[$key]->hdr,
                $tableau[$key]->permanent,
                $tableau[$key]->est_porteur,
                $tableau[$key]->date_creation,
                $tableau[$key]->date_sortie,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeMembres);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des doctorants
     */
    public function tableauListeDoctorant(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->listeDoctorant();
        //$tableau = $donnees;
        $entetes = ["id","role", "nom", "prenom", "email", "pass", "adresse_agent_1", "adresse_agent_2", "residence_admin_1",
            "residence_admin_2", "type_personnel", "intitule", "grade", "im_vehicule", "pf_vehicule", "signature_name",
            "login_cas", "carte_sncf", "matricule", "date_naissance", "actif", "lieu_travail_id", "equipe_id", "nationalite",
            "est_francais", "genre", "hdr", "permanent", "est_porteur", "date_creation", "date_sortie"];
        $fichier = "listeDoctorants.csv";

        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeDoctorants = array();
        foreach($tableau as $key => $row){
            $listeDoctorants[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->role,
                $tableau[$key]->nom,
                $tableau[$key]->prenom,
                $tableau[$key]->email,
                $tableau[$key]->pass,
                $tableau[$key]->adresse_agent_1,
                $tableau[$key]->adresse_agent_2,
                $tableau[$key]->residence_admin_1,
                $tableau[$key]->residence_admin_2,
                $tableau[$key]->type_personnel,
                $tableau[$key]->intitule,
                $tableau[$key]->grade,
                $tableau[$key]->im_vehicule,
                $tableau[$key]->pf_vehicule,
                $tableau[$key]->signature_name,
                $tableau[$key]->login_cas,
                $tableau[$key]->carte_sncf,
                $tableau[$key]->matricule,
                $tableau[$key]->date_naissance,
                $tableau[$key]->actif,
                $tableau[$key]->lieu_travail_id,
                $tableau[$key]->equipe_id,
                $tableau[$key]->nationalite,
                $tableau[$key]->est_francais,
                $tableau[$key]->genre,
                $tableau[$key]->hdr,
                $tableau[$key]->permanent,
                $tableau[$key]->est_porteur,
                $tableau[$key]->date_creation,
                $tableau[$key]->date_sortie
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->role,
                $tableau[$key]->nom,
                $tableau[$key]->prenom,
                $tableau[$key]->email,
                $tableau[$key]->pass,
                $tableau[$key]->adresse_agent_1,
                $tableau[$key]->adresse_agent_2,
                $tableau[$key]->residence_admin_1,
                $tableau[$key]->residence_admin_2,
                $tableau[$key]->type_personnel,
                $tableau[$key]->intitule,
                $tableau[$key]->grade,
                $tableau[$key]->im_vehicule,
                $tableau[$key]->pf_vehicule,
                $tableau[$key]->signature_name,
                $tableau[$key]->login_cas,
                $tableau[$key]->carte_sncf,
                $tableau[$key]->matricule,
                $tableau[$key]->date_naissance,
                $tableau[$key]->actif,
                $tableau[$key]->lieu_travail_id,
                $tableau[$key]->equipe_id,
                $tableau[$key]->nationalite,
                $tableau[$key]->est_francais,
                $tableau[$key]->genre,
                $tableau[$key]->hdr,
                $tableau[$key]->permanent,
                $tableau[$key]->est_porteur,
                $tableau[$key]->date_creation,
                $tableau[$key]->date_sortie,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeDoctorants);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des theses pour un encadrant
     * @param $id de l'encadrant
     */
    public function tableaulisteThesesParEncadrant($id){
        //IL FAUT L'ID DE L'ENCADRANT
        $controlInstance = new EncadrantsThesesController();
        $tableau = $controlInstance->listeThesesParEncadrant($id);
        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeThesesParEncadrant.csv";

        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");


        $listeThesesParEncadrants = array();
        foreach($tableau as $key => $row){
            $listeThesesParEncadrants[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeThesesParEncadrants);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Creer la liste des encadrants avec taux d'encadrement
     */
    public function tableauListeEncadrantsAvecTaux(){
        $controlInstance = new EncadrantsThesesController();
        $tableau = $controlInstance->listeEncadrantsAvecTaux();

        $entetes = ["id","role", "nom", "prenom", "email", "passwd", "adresse_agent_1", "adresse_agent_2", "residence_admin_1",
            "residence_admin_2", "type_personnel", "intitule", "grade", "im_vehicule", "pf_vehicule", "signature_name",
            "login_cas", "carte_sncf", "matricule", "date_naissance", "actif", "lieu_travail_id", "equipe_id", "nationalite",
            "est_francais", "genre", "hdr", "permanent", "est_porteur", "date_creation", "date_sortie","taux"];
        $fichier = "listeEncadrantsAvecTaux.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");


        $listeEncadrants = array();
        foreach($tableau as $key => $row){
            $listeEncadrants[$key] =  array(
                $tableau[$key]['Membres']['id'],
                $tableau[$key]['Membres']['role'],
                $tableau[$key]['Membres']['nom'],
                $tableau[$key]['Membres']['prenom'],
                $tableau[$key]['Membres']['email'],
                $tableau[$key]['Membres']['passwd'],
                $tableau[$key]['Membres']['adresse_agent_1'],
                $tableau[$key]['Membres']['adresse_agent_2'],
                $tableau[$key]['Membres']['residence_admin_1'],
                $tableau[$key]['Membres']['residence_admin_2'],
                $tableau[$key]['Membres']['type_personnel'],
                $tableau[$key]['Membres']['intitule'],
                $tableau[$key]['Membres']['grade'],
                $tableau[$key]['Membres']['im_vehicule'],
                $tableau[$key]['Membres']['pf_vehicule'],
                $tableau[$key]['Membres']['signature_name'],
                $tableau[$key]['Membres']['login_cas'],
                $tableau[$key]['Membres']['carte_sncf'],
                $tableau[$key]['Membres']['matricule'],
                $tableau[$key]['Membres']['date_naissance'],
                $tableau[$key]['Membres']['actif'],
                $tableau[$key]['Membres']['lieu_travail_id'],
                $tableau[$key]['Membres']['equipe_id'],
                $tableau[$key]['Membres']['nationalite'],
                $tableau[$key]['Membres']['est_francais'],
                $tableau[$key]['Membres']['genre'],
                $tableau[$key]['Membres']['hdr'],
                $tableau[$key]['Membres']['permanent'],
                $tableau[$key]['Membres']['est_porteur'],
                $tableau[$key]['Membres']['date_creation'],
                $tableau[$key]['Membres']['date_sortie'],
                $tableau[$key]['taux']
            );
            fputcsv($fp, array(
                $tableau[$key]['Membres']['id'],
                $tableau[$key]['Membres']['role'],
                $tableau[$key]['Membres']['nom'],
                $tableau[$key]['Membres']['prenom'],
                $tableau[$key]['Membres']['email'],
                $tableau[$key]['Membres']['passwd'],
                $tableau[$key]['Membres']['adresse_agent_1'],
                $tableau[$key]['Membres']['adresse_agent_2'],
                $tableau[$key]['Membres']['residence_admin_1'],
                $tableau[$key]['Membres']['residence_admin_2'],
                $tableau[$key]['Membres']['type_personnel'],
                $tableau[$key]['Membres']['intitule'],
                $tableau[$key]['Membres']['grade'],
                $tableau[$key]['Membres']['im_vehicule'],
                $tableau[$key]['Membres']['pf_vehicule'],
                $tableau[$key]['Membres']['signature_name'],
                $tableau[$key]['Membres']['login_cas'],
                $tableau[$key]['Membres']['carte_sncf'],
                $tableau[$key]['Membres']['matricule'],
                $tableau[$key]['Membres']['date_naissance'],
                $tableau[$key]['Membres']['actif'],
                $tableau[$key]['Membres']['lieu_travail_id'],
                $tableau[$key]['Membres']['equipe_id'],
                $tableau[$key]['Membres']['nationalite'],
                $tableau[$key]['Membres']['est_francais'],
                $tableau[$key]['Membres']['genre'],
                $tableau[$key]['Membres']['hdr'],
                $tableau[$key]['Membres']['permanent'],
                $tableau[$key]['Membres']['est_porteur'],
                $tableau[$key]['Membres']['date_creation'],
                $tableau[$key]['Membres']['date_sortie'],
                $tableau[$key]['taux']
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeEncadrants);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Creer la liste des projets pour un membre
     * @param $idMembre
     */
    public function tableauListeProjetMembre($idMembre){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->listeProjetMembre($idMembre);

        $entetes = ["id","titre","description","type","budget","date_debut","date_fin","financement_id"];
        $fichier = "listeProjetMembre.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeProjetMembre = array();
        foreach($tableau as $key => $row){
            $listeProjetMembre[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeProjetMembre);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des theses par type
     */
    public function tableauListeTheseParType(){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeTheseParType();
        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeTheseParType.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeThesesParType = array();
        foreach($tableau as $key => $row){
            $listeThesesParType[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeThesesParType);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la tableau des Soutenances d’Habilitation à Diriger les Recherches
     */
    public function tableauListeSoutenanceHDR(){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeSoutenancesHDR();
        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeSoutenanceHDR.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeSoutenanceHDR = array();
        foreach($tableau as $key => $row){
            $listeSoutenanceHDR[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeSoutenanceHDR);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des soutenances pour une année donnée
     * @param $annee
     */
    public function tableauListeSoutenancesParAnnee($annee){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeSoutenancesParAnnee($annee);

        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeSoutenanceParAnnee.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeSoutenanceParAnnee = array();
        foreach($tableau as $key => $row){
            $listeSoutenanceParAnnee[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeSoutenanceParAnnee);
        $this->set("nomFichier", $fichier);


    }

    /**
     * Créer la liste des soutenances
     */
    public function tableauListeSoutenances(){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeSoutenances();

        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeSoutenance.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeSoutenance = array();
        foreach($tableau as $key => $row){
            $listeSoutenance[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeSoutenance);
        $this->set("nomFichier", $fichier);


    }

    /**
     * Créer la liste des Effectifs par nationalité et par sexe
     */
    public function tableauEffectifsParNationaliteParSexe(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->effectifParNationaliteSexe();
        $entetes = ["Sexe_Nationalite","effectifs"];
        $fichier = "effectifsParNationalite.csv";

        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeEffectifsParNationaliteEtSexe = array();

        foreach($tableau as $key => $row){
            $listeEffectifsParNationaliteEtSexe[$key] =  array(
                $key,
                $row
            );

            fputcsv($fp, array(
                $key,
                $row
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeEffectifsParNationaliteEtSexe);
        $this->set("nomFichier", $fichier);
    }


    /**
     * Créer le tableau des effectifs par type
     */
    public function tableauEffectifsParType(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->effectifParType();
        /*foreach($donnees as $key => $value){
            $type[]= $key;
            $effectifs[] = $value;
        }*/
        //$tableau = $donnees->toArray();
        //debug($tableau);
        $entetes = ["type_personnel", "effectifs"];

        $fichier = "listeEffectifsParTypes.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }

        fputcsv($fp, $entetes, ";");

        $listeEffectifsParTypes = array();

        foreach($tableau as $key => $row){
            $listeEffectifsParTypes[$key] =  array(
                $key,
                $row
            );

            fputcsv($fp, array(
                $key,
                $row
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeEffectifsParTypes);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des theses en courss
     */
    public function tableauThesesEnCours(){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeThesesEnCours();
        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeTheseEnCours.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeThesesParType = array();
        foreach($tableau as $key => $row){
            $listeThesesParType[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeThesesParType);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des budgets par projet
     */
    public function tableauBudgetsParProjet(){
        $controlInstance = new ProjetsController();
        $tableau = $controlInstance->listeBudgetsAnnuels();
        $entetes = ["projet_id","annee","budget"];
        $fichier = "listeBudgetsParProjet.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeBudgetsParAnnee = array();
        foreach($tableau as $key => $row){
            $listeBudgetsParAnnee[$key] =  array(
                $tableau[$key]->projet_id,
                $tableau[$key]->annee,
                $tableau[$key]->budget
            );
            fputcsv($fp, array(
                $tableau[$key]->projet_id,
                $tableau[$key]->annee,
                $tableau[$key]->budget
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeBudgetsParAnnee);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer la liste des budgets pour un projet
     * @param $idProjet
     */
    public function tableauBudgetsProjet($idProjet){
        $controlInstance = new ProjetsController();
        $tableau = $controlInstance->listeBudgetsAnnuelsProjet($idProjet);
        debug($tableau);
        $entetes = ["projet_id","annee","budget"];
        $fichier = "listeBudgetsProjet.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeBudgetsParAnnee = array();
        foreach($tableau as $key => $row){
            $listeBudgetsParAnnee[$key] =  array(
                $tableau[$key]->projet_id,
                $tableau[$key]->annee,
                $tableau[$key]->budget
            );
            fputcsv($fp, array(
                $tableau[$key]->projet_id,
                $tableau[$key]->annee,
                $tableau[$key]->budget
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeBudgetsParAnnee);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer le graphique des effectifs par nationalité et par sexe
     */
    public function graphEffectifsParNationaliteParSexe(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->effectifParNationaliteSexe();


        ////////////////////////////////////////////////////
        foreach($tableau as $key => $value){
            $type[]= $key;
            $effectifs[] = $value;
        }

        $largeur = 1000;
        $hauteur = 600;
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' . DS . 'jpgraph.php');
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' .  DS . 'jpgraph_pie.php');
        // Initialisation du graphique
        $graphe = new PieGraph($largeur, $hauteur);

        // Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
        // Valeurs min et max seront determinees automatiquement
        $graphe->setScale("textlin");

        // Creation de l'histogramme

        $camGraph = new PiePlot($effectifs);

        // Ajout de l'histogramme au graphique
        $camGraph->SetCenter(0.4);
        //$camGraph->SetValueType($type);
        $camGraph->SetLegends($type);
        $graphe->add($camGraph);
        //$graphe->xaxis->title->set("Type");
        //$graphe->yaxis->title->set("Effectifs");
        //$graphe->xaxis->setTickLabels($type);

        // Ajout du titre du graphique
        $graphe->title->set("Diagramme effectifs par NationnaliteSexe");

        @unlink("img/effectifsParNationaliteSexe.png");
        //$graphe->Add($camGraph);
        $graphe->stroke("img/effectifsParNationaliteSexe.png");

        $this->set("nomGraphe", "effectifsParNationaliteSexe.png");

    }

    /**
     * Créer le graphique des effectifs par equipe
     */
    public function graphEffectifsParEquipe(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->nombreEffectifParEquipe();

        foreach($tableau as $key => $value){
            $equipe[]= $value[0];
            $effectifs[] = $value[1];
        }

        $largeur = 1000;
        $hauteur = 600;
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' . DS . 'jpgraph.php');
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' .  DS . 'jpgraph_pie.php');
        // Initialisation du graphique
        $graphe = new PieGraph($largeur, $hauteur);

        // Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
        // Valeurs min et max seront determinees automatiquement
        $graphe->setScale("textlin");

        // Creation de l'histogramme

        $camGraph = new PiePlot($effectifs);

        // Ajout de l'histogramme au graphique
        $camGraph->SetCenter(0.4);
        //$camGraph->SetValueType($type);
        $camGraph->SetLegends($equipe);
        $graphe->add($camGraph);
        //$graphe->xaxis->title->set("Type");
        //$graphe->yaxis->title->set("Effectifs");
        //$graphe->xaxis->setTickLabels($type);

        // Ajout du titre du graphique
        $graphe->title->set("Diagramme effectifs par Equipe");

        @unlink("img/effectifsParEquipe.png");
        //$graphe->Add($camGraph);
        $graphe->stroke("img/effectifsParEquipe.png");

        $this->set("nomGraphe", "effectifsParEquipe.png");

    }

    /**
     * Créer le tableau des theses pour une equipe
     * @param $idEquipe
     */
    public function tableauListeThesesParEquipe($idEquipe){
        $controlInstance = new ThesesController();
        $tableau = $controlInstance->listeThesesParEquipe($idEquipe);
        $entetes = ["id","sujet","type","date_debut","date_fin","autre_info","auteur_id"];
        $fichier = "listeTheseParEquipe.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeThesesParEquipe = array();
        foreach($tableau as $key => $row){
            $listeThesesParEquipe[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->sujet,
                $tableau[$key]->type,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->auteur_info,
                $tableau[$key]->auteur_id,
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeThesesParEquipe);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer le tableau des informations les projets
     */
    public function tableauInformationProjet(){
        $controlInstance = new ProjetsController();
        $tableau = $controlInstance->informationProjet();
        $entetes = ["id","titre","description","type","budget","date_debut","date_fin","financement_id","international", "nationalite_financement","financement_prive","financement"];
        $fichier = "InformationProjet.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");
        $informationProjet = array();
        foreach($tableau as $key => $row){
            $informationProjet[$key] =  array(

                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id,
                $tableau[$key]['Financements']['international'],
                $tableau[$key]['Financements']['nationalite_financement'],
                $tableau[$key]['Financements']['financement_prive'],
                $tableau[$key]['Financements']['financement']

            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id,
                $tableau[$key]['Financements']['international'],
                $tableau[$key]['Financements']['nationalite_financement'],
                $tableau[$key]['Financements']['financement_prive'],
                $tableau[$key]['Financements']['financement']
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $informationProjet);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer le tableau du nombre de doctorants par equipe
     */
    public function tableauNombreDeDoctorantsParEquipe(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->nombreDoctorantParEquipe();
        $entetes = ["Nom Equipe","Nombre Doctorants"];
        $fichier = "NombreDoctorantsParEquipe.csv";

        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $NombreDoctorantParEquipe = array();
        foreach($tableau as $key => $row){
            $NombreDoctorantParEquipe[$key] =  array(
                $row[0],
                $row[1]
            );

            fputcsv($fp, array(
                $row[0],
                $row[1]
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $NombreDoctorantParEquipe);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer le tableau des effectifs par equipe
     */
    public function tableauEffectifsParEquipe(){
        $controlInstance = new MembresController();
        $tableau = $controlInstance->nombreEffectifParEquipe();
        $entetes = ["Nom Equipe","Nombre"];
        $fichier = "EffectifsParEquipe.csv";

        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $EffectifsParEquipe = array();
        foreach($tableau as $key => $row){
            $EffectifsParEquipe[$key] =  array(
                $row[0],
                $row[1]
            );

            fputcsv($fp, array(
                $row[0],
                $row[1]
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $EffectifsParEquipe);
        $this->set("nomFichier", $fichier);
    }

    /**
     * Créer le graphique du nombre de doctorants par equipe
     */
    public function graphNombreDeDoctorantsParEquipe(){
        $controlInstance = new MembresController();
        $donnees = $controlInstance->nombreDoctorantParEquipe();
        foreach($donnees as $key => $value){
            $equipe[]= $value[0];
            $effectifs[] = $value[1];
        }

        $largeur = 1000;
        $hauteur = 600;
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' . DS . 'jpgraph.php');
        require_once(ROOT . DS . 'vendor' . DS . 'JPGraph' .  DS . 'jpgraph_bar.php');
        // Initialisation du graphique
        $graphe = new Graph($largeur, $hauteur);

        // Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
        // Valeurs min et max seront determinees automatiquement
        $graphe->setScale("textlin");

        // Creation de l'histogramme



        $histo = new BarPlot($effectifs);

        // Ajout de l'histogramme au graphique

        $graphe->add($histo);
        $graphe->xaxis->title->set("Equipe");
        $graphe->yaxis->title->set("Effectifs");
        $graphe->xaxis->setTickLabels($equipe);

        // Ajout du titre du graphique
        $graphe->title->set("Histogramme");

        @unlink("img/NombreDeDoctorantsParEquipe.png");
        $graphe->stroke("img/NombreDeDoctorantsParEquipe.png");

        $this->set("nomGraphe", "NombreDeDoctorantsParEquipe.png");
    }

    public function tableauListeProjetParEquipe(){
        $controlInstance = new EquipesProjetsController();
        $tableau = $controlInstance->listeProjetEquipe();
        $entetes = ["id","titre","description","type","budget","date_debut","date_fin","financement_id"];
        $fichier = "listeProjetParEquipe.csv";
        if (file_exists($fichier)){
            //si il existe
            unlink($fichier);
            $fp = fopen($fichier,'w');
        }else{
            $fp = fopen($fichier, 'w');
        }
        fputcsv($fp, $entetes, ";");

        $listeProjetEquipe = array();
        foreach($tableau as $key => $row){
            $listeProjetEquipe[$key] =  array(
                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id
            );
            fputcsv($fp, array(
                $tableau[$key]->id,
                $tableau[$key]->titre,
                $tableau[$key]->description,
                $tableau[$key]->type,
                $tableau[$key]->budget,
                $tableau[$key]->date_debut,
                $tableau[$key]->date_fin,
                $tableau[$key]->financement_id
            ), ";");

        }
        fclose($fp);

        $this->set("entetes", $entetes);
        $this->set("tableau", $listeProjetEquipe);
        $this->set("nomFichier", $fichier);
    }

	/**
	 * Checks the currently logged in user's rights to access a page (called when changing pages).
	 * @param $user : the user currently logged in
	 * @return bool : whether the user is allowed (or not) to access the requested page
	 */
	public function isAuthorized($user)
	{
		//	Tous les comptes actifs droit de faire des exports
		return $user['actif'] === true;
	}
}