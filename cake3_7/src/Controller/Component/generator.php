<?php

// require('pdfOrder.php');
require '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/src/Controller/Component/pdfOrder.php';

// Modification GTHWeb 20-09-2016
//class Generator {
class MyGenerator {
// Fin modification

	//cadre admin
	var $_matricule = null;

	//agent informations
	var $_id = null;
	var $_name = null;
	var $_prenom = null;
	var $_adresseagent1 = null;
	var $_adresseagent2 = null;
	var $_residenceadmin1 = null;
	var $_residenceadmin2 = null;
	var $_date_naissance = null;

	var $_personnel_type = null; /* PU, PE, Do */
	var $_intitule = null;
	var $_grade = null;
	var $_equipe = null;
	var $_cheifSignaturePath = null;

	//mission informations
	var $_motifDeplacement = null;
	var $_complementMotif = null;
	var $_lieuMission = null;

	var $_dateD = null;
	var $_heureDepartD = null;
	var $_heureArriveeD = null;

	var $_dateR = null;
	var $_heureDepartR = null;
	var $_heureArriveeR = null;

	var $_nbRepas = null;
	var $_nbNuite = null;

	//financial mission informations
	var $_projet = null;

	// transport
	var $_transport = null;
	var $_immatriculation = null;
	var $_puissance = null;
	var $_commentaire = null;
	var $_reducSncf = null;
	var $_billetAgence = null;

	/**
	* Initialisation of agent part
	*/
	function setAgent($id, $name, $prenom, $adresseagent1, $adresseagent2, $residenceadmin1, $residenceadmin2, $equipe, $intitule, $grade, $personnel_type, $signature_path, $cheifSignaturePath, $dateNaissance) {

		$this->_id = $id;
		$this->_name = $name;
		$this->_prenom = $prenom;
		$this->_adresseagent1 = $adresseagent1;
		$this->_adresseagent2 = $adresseagent2;
		$this->_residenceadmin1 = $residenceadmin1;
		$this->_residenceadmin2 = $residenceadmin2;
		$this->_intitule =  $intitule;
		$this->_grade = $grade;
		$this->_equipe = $equipe;
		$this->_personnel_type = $personnel_type;
		$this->_signature_path = $signature_path;
		$this->_cheifSignaturePath = $cheifSignaturePath;
		$this->_date_naissance = $dateNaissance;

	}

	public function MyGenerator(){

	} 

	function setCadreAdmin($matricule) {
		$this->_matricule = $matricule;
	}


	/**
	* Intialisation of mission part
	*/
	function setMission($motifDeplacement, $complementMotif, $lieuMission, $dateD, $heureDepartD, $dateR, $heureArriveeR, $nbRepas, $nbNuite ) {
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
	function setFinance($projet) {
		$this->_projet = $projet;
	}

	/**
	* Set transport information
	**/
	function setTransport($transport) {
		// print_r($this->_transport);
		$this->_transport = $transport;
	}

	function setTransportBis($immatriculation, $puissance, $commentaire, $reducSncf, $billetAgence) {
		$this->_puissance = $puissance;
		$this->_immatriculation = $immatriculation;
		$this->_commentaire = $commentaire;
		$this->_reducSncf = $reducSncf;
		$this->_billetAgence = $billetAgence;
	}

	/**
	* return pdf
	**/
	function generate($sansFrais = false, $fileName = null) {
		// error_reporting(0);
		ob_start();
		$pdf=new \pdfOrder('P','mm','A4');
		$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();
// print_r($this->_transport);
		$pdf->LI($sansFrais);
		$pdf->cadreAdmin($this->_matricule);
		$pdf->agent($this->_id, $this->_name, $this->_prenom,$this->_adresseagent1,$this->_adresseagent2,$this->_residenceadmin1,$this->_residenceadmin2,$this->_equipe,$this->_intitule,$this->_grade,$this->_personnel_type,$this->_signature_path,$this->_date_naissance);
		$pdf->mission($this->_motifDeplacement, $this->_complementMotif, $this->_lieuMission,$this->_dateD,$this->_heureDepartD,$this->_heureArriveeD,$this->_dateR,$this->_heureDepartR,$this->_heureArriveeR, $this->_nbRepas, $this->_nbNuite);
		$pdf->budget($this->_projet);
		$pdf->transport($this->_transport);
		$pdf->transportBis($this->_immatriculation, $this->_puissance, $this->_commentaire, $this->_reducSncf, $this->_billetAgence);
		$pdf->signatures($this->_cheifSignaturePath);
		$pdf->justificatif();
		// print_r($fileName);
		if ($fileName == null) {
			// print_r($fileName);
			$pdf->Output("OdM.pdf","I");
			// $pdf->Output("OdM.pdf","F");
			// echo "ga";
		} else {
			// print_r($fileName);
			// $pdf->Output($fileName,"I");
			$pdf->Output($fileName,"F");

			// $pdf->Output(dirname(__DIR__).'/pdf/'.$fileName.'.pdf',"F");
			// $pdf->Output(dirname(__DIR__).'/Desktop/'.$fileName.'.pdf', 'F');
		}
		ob_end_flush();
	}



	function view($pdf){
		$pdf->Output($fileName,"I");
	}

}

?>
