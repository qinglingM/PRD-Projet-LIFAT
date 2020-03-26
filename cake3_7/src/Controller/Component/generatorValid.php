<?php

// require('pdfOrder.php');
require '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/src/Controller/Component/pdfValid.php';

// Modification GTHWeb 20-09-2016
//class Generator {
class MyValidGenerator
{
    // Fin modification

    //cadre admin
    public $_matricule = null;
    public $_dateCurrent = null;

    //agent informations
    public $_id = null;
    public $_name = null;
    public $_prenom = null;
    public $_email = null;
    public $_date_naissance = null;

    public $_personnel_type = null; /* PU, PE, Do */
    public $_intitule = null;
    public $_grade = null;
    public $_equipe = null;

    //mission informations
    public $_motifDeplacement = null;
    public $_complementMotif = null;
    public $_lieuMission = null;

    //depart information
    public $_dateD = null;
    public $_heureDepartD = null;
    // public $_heureArriveeD = null;
    public $_dateDepartArrive = null;
    public $_heureDepartArrive = null;

    public $_lieuTravail = null;
    public $_pays = null;

    //arrive information
    public $_dateR = null;
    public $_heureDepartR = null;
    // public $_heureArriveeR = null;
    public $_dateRetourDepart = null;
    public $_heureRetourArrive = null;

    // transport
    public $_transport = null;

    //signature
    public $_signature_path = null;
    public $_cheifSignaturePath = null;
    public $_juridiqueSignaturePath = null;
    public $_presidentSignaturePath = null;

    /**
     * Initialisation of agent part
     */
    public function setAgent($id, $name, $prenom, $email, $equipe, $dateNaissance)
    {
        $this->_id = $id;
        $this->_name = $name;
        $this->_prenom = $prenom;
        $this->_email = $email;
        $this->_equipe = $equipe;
        $this->_date_naissance = $dateNaissance;
    }

    public function MyGenerator()
    {

    }

    public function setLIFAT($matricule, $dateCurrent)
    {
        $this->_matricule = $matricule;
        $this->_dateCurrent = $dateCurrent;
    }

    /**
     * Intialisation of mission part
     */
    public function setMission($motifDeplacement, $complementMotif, $lieuMission, $personnel_type)
    {
        $this->_motifDeplacement = $motifDeplacement;
        $this->_complementMotif = $complementMotif;
        $this->_lieuMission = $lieuMission;
        $this->_personnel_type = $personnel_type;
    }

    /**
     * Intialisation of depart information
     */
//    public function setDepart($dateD, $heureDepartD, $dateDepartArrive, $heureDepartArrive, $lieuMission, $lieuTravail, $pays)
//    {
//        $this->_dateD = $dateD;
//        $this->_heureDepartD = $heureDepartD;
//        $this->_dateDepartArrive = $dateDepartArrive;
//        $this->_heureDepartArrive = $heureDepartArrive;
//        $this->_lieuMission = $lieuMission;
//        $this->_lieuTravail = $lieuTravail;
//        $this->_pays = $pays;
//    }

    public function setDepart($dateD, $heureDepartD, $lieuMission, $lieuTravail, $pays)
    {
        $this->_dateD = $dateD;
        $this->_heureDepartD = $heureDepartD;

        $this->_lieuMission = $lieuMission;
        $this->_lieuTravail = $lieuTravail;
        $this->_pays = $pays;
    }

    /**
     * Intialisation of arrive information
     */
//    public function setArrivee($dateR, $heureDepartR, $dateRetourDepart, $heureRetourArrive, $lieuMission, $lieuTravail, $pays)
//    {
//        $this->_dateR = $dateR;
//        $this->_heureDepartR = $heureDepartR;
//        $this->_dateRetourDepart = $dateRetourDepart;
//        $this->_heureRetourArrive = $heureRetourArrive;
//        $this->_lieuMission = $lieuMission;
//        $this->_lieuTravail = $lieuTravail;
//        $this->_pays = $pays;
//    }

    public function setArrivee($dateR, $heureDepartR,  $lieuMission, $lieuTravail, $pays)
    {
        $this->_dateR = $dateR;
        $this->_heureDepartR = $heureDepartR;

        $this->_lieuMission = $lieuMission;
        $this->_lieuTravail = $lieuTravail;
        $this->_pays = $pays;
    }

    /**
     * Set transport information
     **/
    public function setTransport($transport)
    {
        // print_r($this->_transport);
        $this->_transport = $transport;
    }

    /**
     * Set signature information
     **/
    public function setSignatures($signature_path, $cheifSignaturePath, $juridiqueSignaturePath, $presidentSignaturePath)
    {
        $this->_signature_path = $signature_path;
        $this->_cheifSignaturePath = $cheifSignaturePath;
        $this->_juridiqueSignaturePath = $juridiqueSignaturePath;
        $this->_presidentSignaturePath = $presidentSignaturePath;
    }

    /**
     * return pdf
     **/
    public function generate($fileName = null)
    {
        // error_reporting(0);
        ob_start();
        $pdf = new \pdfValid('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        // print_r($this->_transport);
        // $pdf->UniversiteTours();
        $pdf->LIFAT($this->_matricule, $this->_dateCurrent);
        $pdf->agent($this->_id, $this->_name, $this->_prenom, $this->_email, $this->_equipe, $this->_date_naissance);
        $pdf->mission($this->_motifDeplacement, $this->_complementMotif, $this->_lieuMission, $this->_personnel_type);
        $pdf->depart($this->_dateD, $this->_heureDepartD, $this->_lieuMission, $this->_lieuTravail, $this->_pays);
        $pdf->arrive($this->_dateR, $this->_heureDepartR, $this->_lieuMission, $this->_lieuTravail, $this->_pays);
        $pdf->transport($this->_transport);
        $pdf->signatures($this->_signature_path, $this->_cheifSignaturePath, $this->_juridiqueSignaturePath, $this->_presidentSignaturePath);
        $pdf->justificatif();
        // print_r($fileName);
        if ($fileName == null) {
            // print_r($fileName);
            $pdf->Output("VdM.pdf", "I");
            // $pdf->Output("OdM.pdf","F");
            // echo "ga";
        } else {
            // print_r($fileName);
            // $pdf->Output($fileName,"I");
            $pdf->Output($fileName, "F");
            // $pdf->Output(dirname(__DIR__).'/pdf/'.$fileName.'.pdf',"F");
        }
        ob_end_flush();
    }

    public function view($pdf)
    {
        $pdf->Output($fileName, "I");
    }

}
