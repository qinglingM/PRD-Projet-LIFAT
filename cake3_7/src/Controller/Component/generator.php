<?php

// require('pdfOrder.php');
require '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/src/Controller/Component/pdfOrder.php';

// Modification GTHWeb 20-09-2016
//class Generator {
class MyGenerator
{
    //cadre admin
    public $_matricule = null;

    //agent informations
    public $_id = null;
    public $_name = null;
    public $_prenom = null;
    public $_adresseagent1 = null;
    public $_adresseagent2 = null;
    public $_residenceadmin1 = null;
    public $_residenceadmin2 = null;
    public $_date_naissance = null;

    public $_personnel_type = null; /* PU, PE, Do */
    public $_intitule = null;
    public $_grade = null;
    public $_equipe = null;
    public $_cheifSignaturePath = null;

    //mission informations
    public $_motifDeplacement = null;
    public $_complementMotif = null;
    public $_lieuMission = null;

    public $_dateD = null;
    public $_heureDepartD = null;
    public $_heureArriveeD = null;

    public $_dateR = null;
    public $_heureDepartR = null;
    public $_heureArriveeR = null;

    public $_nbRepas = null;
    public $_nbNuite = null;

    //financial mission informations
    public $_projet = null;

    // transport
    public $_transport = null;
    public $_immatriculation = null;
    public $_puissance = null;
    public $_commentaire = null;
    public $_reducSncf = null;
    public $_billetAgence = null;

    /**
     * Initialisation of agent part
     */
    public function setAgent($id, $name, $prenom, $adresseagent1, $adresseagent2, $residenceadmin1, $residenceadmin2, $equipe, $intitule, $grade, $personnel_type, $signature_path, $cheifSignaturePath, $dateNaissance)
    {

        $this->_id = $id;
        $this->_name = $name;
        $this->_prenom = $prenom;
        $this->_adresseagent1 = $adresseagent1;
        $this->_adresseagent2 = $adresseagent2;
        $this->_residenceadmin1 = $residenceadmin1;
        $this->_residenceadmin2 = $residenceadmin2;
        $this->_intitule = $intitule;
        $this->_grade = $grade;
        $this->_equipe = $equipe;
        $this->_personnel_type = $personnel_type;
        $this->_signature_path = $signature_path;
        $this->_cheifSignaturePath = $cheifSignaturePath;
        $this->_date_naissance = $dateNaissance;

    }

    public function MyGenerator()
    {

    }

    public function setCadreAdmin($matricule)
    {
        $this->_matricule = $matricule;
    }

    /**
     * Intialisation of mission part
     */
    public function setMission($motifDeplacement, $complementMotif, $lieuMission, $dateD, $heureDepartD, $dateR, $heureArriveeR, $nbRepas, $nbNuite)
    {
        $this->_motifDeplacement = $motifDeplacement;
        $this->_complementMotif = $complementMotif;
        $this->_lieuMission = $lieuMission;
        $this->_dateD = $dateD;
        $this->_heureDepartD = $heureDepartD;
        $this->_dateR = $dateR;
        $this->_heureArriveeR = $heureArriveeR;
        $this->_nbRepas = $nbRepas;
        $this->_nbNuite = $nbNuite;
    }

    /**
     * Set financial information
     */
    public function setFinance($projet)
    {
        $this->_projet = $projet;
    }

    /**
     * Set transport information
     **/
    public function setTransport($transport)
    {
        // print_r($this->_transport);
        $this->_transport = $transport;
    }

    public function setTransportBis($immatriculation, $puissance, $commentaire, $reducSncf, $billetAgence)
    {
        $this->_puissance = $puissance;
        $this->_immatriculation = $immatriculation;
        $this->_commentaire = $commentaire;
        $this->_reducSncf = $reducSncf;
        $this->_billetAgence = $billetAgence;
    }

    /**
     * return pdf
     **/
    public function generate($sansFrais = false, $fileName = null)
    {
        // error_reporting(0);
        ob_start();
        $pdf = new \pdfOrder('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        $pdf->LI($sansFrais);
        $pdf->cadreAdmin($this->_matricule);
        $pdf->agent($this->_id, $this->_name, $this->_prenom, $this->_adresseagent1, $this->_adresseagent2, $this->_residenceadmin1, $this->_residenceadmin2, $this->_equipe, $this->_intitule, $this->_grade, $this->_personnel_type, $this->_signature_path, $this->_date_naissance);
        $pdf->mission($this->_motifDeplacement, $this->_complementMotif, $this->_lieuMission, $this->_dateD, $this->_heureDepartD, $this->_heureArriveeD, $this->_dateR, $this->_heureDepartR, $this->_heureArriveeR, $this->_nbRepas, $this->_nbNuite);
        $pdf->budget($this->_projet);
        $pdf->transport($this->_transport);
        $pdf->transportBis($this->_immatriculation, $this->_puissance, $this->_commentaire, $this->_reducSncf, $this->_billetAgence);
        $pdf->signatures($this->_cheifSignaturePath);
        $pdf->justificatif();
        if ($fileName == null) {
            $pdf->Output("OdM.pdf", "I");
        } else {
            $pdf->Output($fileName, "F");
        }
        ob_end_flush();
    }

    public function view($pdf)
    {
        $pdf->Output($fileName, "I");
    }

}
