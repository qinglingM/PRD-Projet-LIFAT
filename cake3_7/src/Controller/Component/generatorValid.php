<?php

// require('pdfOrder.php');
require '/Applications/MAMP/htdocs/PRD-Projet-LIFAT/cake3_7/src/Controller/Component/pdfValid.php';

// Modification GTHWeb 20-09-2016
//class Generator {
class MyValidGenerator {
	// Fin modification

	//cadre admin
	var $_matricule = null;
	var $_dateCurrent = null;

	//agent informations
	var $_id = null;
	var $_name = null;
	var $_prenom = null;
	var $_email = null;
	var $_date_naissance = null;

	var $_personnel_type = null; /* PU, PE, Do */
	var $_intitule = null;
	var $_grade = null;
	var $_equipe = null;


	//mission informations
	var $_motifDeplacement = null;
	var $_complementMotif = null;
	var $_lieuMission = null;

	//depart information
	var $_dateD = null;
	var $_heureDepartD = null;
	var $_heureArriveeD = null;
	var $_trajetD = null;

	//arrive information
	var $_dateR = null;
	var $_heureDepartR = null;
	var $_heureArriveeR = null;
	var $_trajetR = null;

	// transport
	var $_transport = null;
	
	//signature
	var $_signature_path = null;
	var $_cheifSignaturePath = null;
	var $_juridiqueSignaturePath = null;
	var $_presidentSignaturePath = null;

	/**
	* Initialisation of agent part
	*/
	function setAgent($id, $name, $prenom, $email,$equipe, $dateNaissance) {
		$this->_id = $id;
		$this->_name = $name;
		$this->_prenom = $prenom;
		$this->_email = $email;
		$this->_equipe = $equipe;
		$this->_date_naissance = $dateNaissance;
	}

	public function MyGenerator(){

	} 

	function setLIFAT($matricule,$dateCurrent) {
		$this->_matricule = $matricule;
		$this->_dateCurrent = $dateCurrent;
	}


	/**
	* Intialisation of mission part
	*/
	function setMission($motifDeplacement, $complementMotif, $lieuMission,$personnel_type) {
		$this->_motifDeplacement = $motifDeplacement;
		$this->_complementMotif = $complementMotif;
		$this->_lieuMission = $lieuMission;
		$this->_personnel_type = $personnel_type;
	}


	/**
	* Intialisation of depart information
	*/
	function setDepart($dateD, $heureDepartD, $lieuMission, $trajetD){
		$this->_dateD = $dateD;
		$this->_heureDepartD = $heureDepartD;
		$this->_lieuMission = $lieuMission;
		$this->_trajetD = $trajetD;
	}

	/**
	* Intialisation of arrive information
	*/
	function setArrivee($dateR, $heureDepartR, $lieuMission, $trajetR){
		$this->_dateR = $dateR;
		$this->_heureDepartR = $heureDepartR;
		$this->_lieuMission = $lieuMission;
		$this->_trajetR = $trajetR;
	}

	/**
	* Set transport information
	**/
	function setTransport($transport) {
		// print_r($this->_transport);
		$this->_transport = $transport;
	}

	/**
	* Set signature information
	**/
	function setSignatures($signature_path, $cheifSignaturePath, $juridiqueSignaturePath, $presidentSignaturePath){
		$this->_signature_path = $signature_path;
		$this->_cheifSignaturePath = $cheifSignaturePath;
		$this->_juridiqueSignaturePath = $juridiqueSignaturePath;
		$this->_presidentSignaturePath = $presidentSignaturePath;
	} 



	/**
	* return pdf
	**/
	function generate( $fileName = null) {
		// error_reporting(0);
		ob_start();
		$pdf=new \pdfValid('P','mm','A4');
		$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();
		// print_r($this->_transport);
		// $pdf->UniversiteTours();
		$pdf->LIFAT($this->_matricule,$this->_dateCurrent);
		$pdf->agent($this->_id, $this->_name, $this->_prenom,$this->_email,$this->_equipe,$this->_date_naissance);
		$pdf->mission($this->_motifDeplacement, $this->_complementMotif, $this->_lieuMission,$this->_personnel_type);
		$pdf->depart($this->_dateD,$this->_heureDepartD, $this->_lieuMission, $this->_trajetD);
		$pdf->arrive($this->_dateR,$this->_heureDepartR, $this->_lieuMission, $this->_trajetR);
		$pdf->transport($this->_transport);
		$pdf->signatures($this->_signature_path,$this->_cheifSignaturePath,$this->_juridiqueSignaturePath,$this->_presidentSignaturePath);
		$pdf->justificatif();
		// print_r($fileName);
		if ($fileName == null) {
			// print_r($fileName);
			$pdf->Output("VdM.pdf","I");
			// $pdf->Output("OdM.pdf","F");
			// echo "ga";
		} else {
			// print_r($fileName);
			// $pdf->Output($fileName,"I");
			$pdf->Output($fileName,"F");
			// $pdf->Output(dirname(__DIR__).'/pdf/'.$fileName.'.pdf',"F");
		}
		ob_end_flush();
	}



	function view($pdf){
		$pdf->Output($fileName,"I");
	}

}

?>
