<?php

require('fpdf16/fpdf.php');

class pdfValid extends FPDF
{

  function _check($x,$y,$width,$checked) {
	if ($checked)
	  $this->rect($x,$y,$width,$width,'F');
	else
	  $this->rect($x,$y,$width,$width);
  }


  function LIFAT($matricule,$dateCurrent) {

	$Lifat = 'Lifat';

	$this->Image(dirname(__FILE__)  .'/universite.jpg',10,15,60); //x，上边距，下边距
	// $this->Image(dirname(__FILE__)  .'/li.jpg',10,2,20);
	$this->Image(dirname(__FILE__)  .'/lifat.jpg',155,12,40); //x,上边距，下边距
	$this->SetTextColor(33,74,123);

	$title = 'AUTORISATION DE DEPLACEMENT';
	$this->SetXY(20,40);
	$this->SetFont('Times','B',18);
	$this->SetDrawColor(33,74,123);
	$this->Line(54,46,165,46);
	$this->MultiCell(0,6,utf8_decode($title),0,'C');

	$this->SetTextColor(0,0,0);
	$text = '(à remplir pour chaque mission/déplacement - cf. procédure sur l\'Intranet)';
	$this->SetXY(20,47);
	$this->SetFont('Times','I',13);
	$this->MultiCell(0,6,utf8_decode($text),0,'C');

	// $dateCurrent = date("d-m-Y");

	// $text = 'Document créé le $dateCurrent à Tours';
	$this->SetXY(20,53);
	// $this->Ln(3);
	$details = "Document créé le $dateCurrent à Tours";
	// $this->Cell(30,0,utf8_decode("Document créé le $dateCurrent à Tours"),0,1,'L');

	$this->SetFont('Times','',13);
	$this->MultiCell(0,6,utf8_decode($details),0,'C');

  }

  function agent($id, $nom,$prenom,$email, $equipe, $date_naissance) {

	$date = date("d-m-Y",strtotime($date_naissance));

	//AGENT
	$this->SetXY(10,66);
	$this->SetFont('Times','B',16);
	$this->SetTextColor(81,130,187);
	$this->Cell(30,0,'Identification de l\'agent',0,1,'L');
	$this->SetDrawColor(81,130,187);
	$this->Line(10,70,200,70);
	$this->SetTextColor(0,0,0);

	//partie de gauche
	$this->SetXY(10,74);
	$this->SetFont('Times','',10);

	$this->Cell(30,0,utf8_decode("NOM : $nom"),0,1,'L');
	$this->Ln(6);

	$this->Cell(30,0,utf8_decode("PRENOM : $prenom"),0,1,'L');
	$this->Ln(6);

	$this->Cell(30,0,utf8_decode("Addresse mail : $email"),0,1,'L');
	$this->Ln(6);
	
	$this->Cell(30,0,utf8_decode("Date de naissance : $date"),0,1,'L');
	$this->Ln(6);
	$this->Cell(30,0,utf8_decode("Unité de recherche / Composante / Service : $equipe"),0,1,'L');
  }


  function mission($motif,$complementMotif,$lieu,$personnel_type) {
	//TITRE
	$this->SetXY(10,110);
	$this->SetFont('Times','B',16);
	$this->SetTextColor(81,130,187);
	$this->Cell(30,0,utf8_decode('Motif(s) du déplacement'),0,1,'L');
	$this->SetDrawColor(81,130,187);
	$this->Line(10,114,200,114);
	$this->SetTextColor(0,0,0);

	if($complementMotif !=null) {
		$complementMotif = " - ".$complementMotif;
	}

	$this->SetXY(15,118);
	$this->SetFont('Times','',11);
	$this->Cell(30,0,utf8_decode('Pédagogie'),0,0,'L');
	if ($personnel_type == 'PU')
	  $this->_check(12,117,2,true);
	else 
	  $this->_check(12,117,2,false);

	$this->Ln(6);
	$this->SetXY(65,118);
	$this->Cell(30,0,utf8_decode('Recherche'),0,0,'L');
	if ($personnel_type == 'PE')
	$this->_check(62,117,2,true);
	else 
	$this->_check(62,117,2,false);
	$this->Ln(6);    

	$this->SetXY(115,118);
	$this->Cell(30,0,utf8_decode('Autre(précisez) : $autre'),0,0,'L');
	if ($personnel_type == 'Do')
	$this->_check(112,117,2,true);
	else 
	$this->_check(112,117,2,false);


	//cadre motif
	$this->SetXY(10,122);
	$motif = "Motif(s) : $motif
Composante, service ou unité de recherche demandant la mission : $complementMotif";
	$this->MultiCell(0,6,utf8_decode($motif));

// Lieu de la mission : $lieu

  }


  function depart($date_a,$heure_ad,$lieu,$trajet) {
	//cadre départ 
	$this->setXY(10,142);
	$this->SetFont('Times','B',16);
	$this->SetTextColor(81,130,187);
	$this->Cell(30,0,utf8_decode('Modalités de DEPART :'),0,1,'L');
	$this->SetDrawColor(81,130,187);
	$this->Line(10,146,200,146);
	$this->SetTextColor(0,0,0);
	
	$this->SetXY(10,147);
	$depart = "Date et heure de départ : $date_a  $heure_ad
Trajet(s): $trajet
Pays: $lieu";
	$this->setFont('Times','',11);
	$this->MultiCell(0,6,utf8_decode($depart));
  }

  function arrive($date_r,$heure_rd,$lieu,$trajet) {
	//cadre arrivée
	$this->setXY(10,172);
	$this->SetFont('Times','B',16);
	$this->SetTextColor(81,130,187);
	$this->Cell(30,0,utf8_decode('Modalités de RETOUR :'),0,1,'L');
	$this->SetDrawColor(81,130,187);
	$this->Line(10,176,200,176);
	$this->SetTextColor(0,0,0);

	$this->SetXY(10,177);
	$arrivee = "Date et heure d'arrivée : $date_r $heure_rd
Trajet(s): $trajet
Pays: $lieu";
	$this->setFont('Times','',11);
	$this->MultiCell(0,6,utf8_decode($arrivee));
  }



  function transport($transports) {
	//Pour les missions en France métropolitaine
	$this->setXY(10,202);
	$this->setFont('Times','B',14);
	$this->SetDrawColor(0,0,0);
	$this->SetTextColor(81,130,187);

	$this->Cell(30,0,utf8_decode('Pour les missions en France métropolitaine'),0,1,'L');
	$this->rect(10,197,95,10);
	$this->SetFillColor(133,135,138);

	//En supplément pour les missions en France hors métropole et à l’étranger**

	$coord = 'En supplément pour les missions en 
France hors métropole et à l\'étranger**';
	$this->setXY(105,198);
	$this->setFont('Times','B',14);
	$this->SetFillColor(133,135,138);

	$this->Multicell(90,4,utf8_decode($coord),0,'LT');
	$this->rect(105,197,95,10);
	$this->SetTextColor(0,0,0);

   // 4 facons de transport
   $this->setXY(10,210);
   $this->setFont('Times','B',14);
//    $this->Cell(30,0,'TRANSPORT');
   $this->rect(10,207,95,22);


   $this->SetXY(15,210);
   $this->SetFont('Times','',11);
   $this->Cell(30,0,utf8_decode('Utilisation du véhicule personnel*'),0,0,'L');
//    if ($transport->type_transport == 'vehicule_personnel')
// 	 $this->_check(12,208.5,2.5,true);
//    else 
// 	 $this->_check(12,208.5,2.5,false);

   $this->SetFont('Times','',11);
   $this->Ln(6);
   $this->SetXY(15,215);
   $this->Cell(30,0,utf8_decode('Utilisation d\'un véhicule de service'),0,0,'L');
//    if ($transport->type_transport == 'vehicule_service')
//    $this->_check(12,213.5,2.5,true);
//    else 
//    $this->_check(12,213.5,2.5,false);
//    $this->Ln(6);    

   $this->SetXY(15,220);
   $this->Cell(30,0,utf8_decode('Permis de conduire en cours de validité'),0,0,'L');
//    if ($transport->type_transport == 'autre')
//    $this->_check(12,218.5,2.5,true);
//    else 
//    $this->_check(12,218.5,2.5,false);

   $this->SetXY(15,225);
   $this->Cell(30,0,utf8_decode('Recours au marché VELOCE21(train et/ou avion)'),0,0,'L');
//    if ($transport->type_transport == 'train' || $transport->type_transport == 'avion')
//    $this->_check(12,223.5,2.5,true);
//    else 
//    $this->_check(12,223.5,2.5,false);



    $firstTime = true;
	foreach ($transports as $transport) {

		if ($transport->type_transport == 'vehicule_personnel')
		$this->_check(12,208.5,2.5,true);
	  	else 
		$this->_check(12,208.5,2.5,false);

		if ($transport->type_transport == 'vehicule_service')
		$this->_check(12,213.5,2.5,true);
		else 
		$this->_check(12,213.5,2.5,false);
		$this->Ln(6); 


		if ($transport->type_transport == 'autre')
		$this->_check(12,218.5,2.5,true);
		else 
		$this->_check(12,218.5,2.5,false);

		if ($transport->type_transport == 'train' || $transport->type_transport == 'avion')
		$this->_check(12,223.5,2.5,true);
		else 
		$this->_check(12,223.5,2.5,false);


		// switch ($transport->type_transport) {
		// 	case "train" :
		// 		$textTransport = "Train";
		// 		break;
		// 	case "avion" :
		// 		$textTransport = "Avion";
		// 		break;
		// 	case "vehicule_service" :
		// 		$textTransport = "Véhicule de service";
		// 		break;
		// 	case "vehicule_personnel":
		// 		$textTransport = "Véhicule Personnel";
		// 		break;
		// 	case "autre":
		// 		$textTransport = "Autre";
		// 		break;
		// 	default:
		// 		$textTransport = "Autre";
		// 		break;
		// }
		// if ($firstTime){
		// 	$transportDisplay = $textTransport;
		// 	$firstTime =false;
		// } else {
		// 	$transportDisplay = $transportDisplay.', '.$textTransport;
		// }
	}

    

   //2 facons de transport
   $this->setXY(10,210);
   $this->setFont('Times','B',14);
//    $this->Cell(30,0,'TRANSPORT');
   $this->rect(105,207,95,22);

   $this->SetXY(110,210);
   $this->SetFont('Times','',11);
   $this->Cell(30,0,utf8_decode('Visite Médecine de prévention'),0,0,'L');
   if ($transport->type_transport == 'vehicule_personnel')
	 $this->_check(107,208.5,2.5,true);
   else 
	 $this->_check(107,208.5,2.5,false);

   $this->SetFont('Times','',11);
   $this->Ln(6);
   $this->SetXY(110,215);
   $this->Cell(30,0,utf8_decode('Inscription sur le site ARIANE du MAE'),0,0,'L');
   if ($transport->type_transport == 'vehicule_service')
   $this->_check(107,213.5,2.5,true);
   else 
   $this->_check(107,213.5,2.5,false);
   $this->Ln(6);  




//   	$firstTime = true;
// 	foreach ($transports as $transport) {

// 		switch ($transport->type_transport) {
// 			case "train" :
// 				$textTransport = "Train";
// 				break;
// 			case "avion" :
// 				$textTransport = "Avion";
// 				break;
// 			case "vehicule_service" :
// 				$textTransport = "Véhicule de service";
// 				break;
// 			case "vehicule_personnel":
// 				$textTransport = "Véhicule Personnel";
// 				break;
// 			case "autre":
// 				$textTransport = "Autre";
// 				break;
// 			default:
// 				$textTransport = "Autre";
// 				break;
// 		}
// 		if ($firstTime){
// 			$transportDisplay = $textTransport;
// 			$firstTime =false;
// 		} else {
// 			$transportDisplay = $transportDisplay.', '.$textTransport;
// 		}
// 	}
// 	if (isset($transportDisplay)) {
//   	$transport = "Moyens de transport :
// $transportDisplay";
// 	} else {
// 		$transport = "Aucun moyen de transport";
// 	}
// 	$this->setXY(-92,145);
// 	$this->setFont('Times','B',14);
// 	$this->Cell(30,0,'TRANSPORT');
// 	$this->rect(119,148,81,28);

// 	$this->setXY(-90, 149);
// 	$this->setFont('Times','',11);
// 	$this->multiCell(80,5, utf8_decode($transport));
  }

 

  function signatures($signature_path,$cheifSignaturePath, $juridiqueSignaturePath, $presidentSignaturePath) {

   //Signature de l’agent
   $this->setXY(15,240);
   $this->setFont('Times','BI',11);
   $this->Cell(30,0,utf8_decode('Signature de l\'agent'),0,1,'L');
   $this->rect(10,229,47.5,24);
	// $signature = $_SERVER['DOCUMENT_ROOT'].'/PRD-Projet-LIFAT/cake3_7/webroot'.$signature_path;
	// if (file_exists($signature) && filesize($signature) != 0)
	// $this->Image($signature, 135, 111, 57, 10);

   //Signature du directeur
   $this->setXY(60,232);
	$this->setFont('Times','BI',11);
	$signature = 'Signature du directeur d\'unité, du directeur de composante ou du chef de service';
	$this->Multicell(45,4,utf8_decode($signature),0,'LT');
	$this->rect(57.5,229,47.5,24);

	
	// if ($cheifSignaturePath != null || $cheifSignaturePath != ""){
	// 	$cheifSignature = "$cheifSignaturePath.jpg";
	// 	if (file_exists($cheifSignature)) {
	// 		$this->Image($cheifSignature, 25, 246, 57, 10);
	// 	}
	// }


   //Visa du directeur des affaires juridiques
   $this->setXY(110,237);
	$this->setFont('Times','BI',11);
	$signature1 = 'Visa du directeur des affaires juridiques';
		$this->Multicell(45,4,utf8_decode($signature1),0,'LT');
	$this->rect(105,229,47.5,24);


   //Signature du Président de l’université
   $this->setXY(155,237);
	$this->setFont('Times','BI',11);
	$signature2 = 'Signature du Président de l\'université';
	$this->Multicell(45,4,utf8_decode($signature2),0,'LT');
	$this->rect(152.5,229,47.5,24);


    //Signature de l’agent
	$this->setFont('Times','B',14);
	$this->rect(10,253,47.5,25);
	// $signature = "/Signatures/$signature_path.jpg";
	$signature = $_SERVER['DOCUMENT_ROOT'].'/PRD-Projet-LIFAT/cake3_7/webroot'.$signature_path;

	if (file_exists($signature) && filesize($signature) != 0)
	  $this->Image($signature, 11,254,45,23);
		
	//Signature du directeur
	$this->setFont('Times','B',14);
	$this->rect(57.5,253,47.5,25);

	$cheifSignaturePath = $_SERVER['DOCUMENT_ROOT'].'/PRD-Projet-LIFAT/cake3_7/webroot'.$cheifSignaturePath;
	if (file_exists($cheifSignaturePath) && filesize($cheifSignaturePath) != 0)
	  $this->Image($cheifSignaturePath, 58.5,254,45,23);

	//Visa du directeur des affaires juridiques
	$this->setFont('Times','B',14);
	$this->rect(105,253,47.5,25);
	$juridiqueSignaturePath = $_SERVER['DOCUMENT_ROOT'].'/PRD-Projet-LIFAT/cake3_7/webroot'.$juridiqueSignaturePath;
	if (file_exists($juridiqueSignaturePath) && filesize($juridiqueSignaturePath) != 0)
	  $this->Image($juridiqueSignaturePath, 106,254,45,23);

	//Signature du Président de l’université
	$this->setFont('Times','B',14);
	$this->rect(152.5,253,47.5,25);
	$presidentSignaturePath = $_SERVER['DOCUMENT_ROOT'].'/PRD-Projet-LIFAT/cake3_7/webroot'.$presidentSignaturePath;
	if (file_exists($presidentSignaturePath) && filesize($presidentSignaturePath) != 0)
	  $this->Image($presidentSignaturePath, 153.5,254,45,23);


	// signature de gauche
// 	$this->setXY(12,233);
// 	$this->setFont('times','B',10);
// 	$this->Cell(40,20,utf8_decode("Signature du responsable de l'équipe LI"));
// 	$this->rect(10,240,90,17);
// 	//$this->Image('./img/sign/equipe.jpg', 140, 251, 57, 10);
	
// 	// signature de droite
// 	$this->SetXY(-100,242);
// 	$this->setFont('Times','B',10);
// 	$signLI = "Fait à Tours, le 
// Signature du Directeur de l'EPU ou du Directeur du Laboratoire";
// 	$this->multiCell(0,4,utf8_decode($signLI));

  }

  function justificatif() {
	$titre = "";
	$justif = "* Joindre une copie de la carte grise ; l’utilisation du véhicule personnel doit être exceptionnelle et reste soumise à l’autorisation préalable de l’ordonnateur (horaires non adaptés, absence de transports en commun, correspondances trop nombreuses, etc …)   
	** A transmettre à votre gestionnaire ou antenne financière 15 jours minimum avant le départ en mission.
	
";
	$this->setXY(10,-40);
	$this->setFont('times','BUI',10);
	$this->cell(0,5,utf8_decode($titre),0,1);
	$this->setXY(12,-15);
	$this->setFont('times','I',10);
	$this->multiCell(0,4,utf8_decode($justif));
  }

  function example() {

	$nom='Hadba';
	$prenom='Julien';
	$add1='2, chichi plouf';
	$add2='40800 creole';
	$res1='64, avenue jean portalis';
	$res2='37520 La riche';
	$equipe='OC';
	$intitule = 'prof';
	$grade = 'plop';
	$personnel_type = 'Do'; /* PU, PE, Do*/

	$motif = "CLOSER";
	$lieu = "norddd";
	$date_a = "06/05/2011";
	$heure_ad = "14h00";
	$heure_aa = "18h00";
	$date_r = "08/05/2011";
	$heure_ra = "14h00";
	$heure_rd = "18h00";

	$budget_type = "v4ec"; /* r4ec, e4aa, v4ec */
	$r4ec_equipe = "plop1";
	$r4ec_anr = "plop2";
	$e4aa_equipe = "plop3";
	$e4aa_pfe = "plop4";
	$v4ec_cifre = "mandriva";
	$v4ec_autre = "plop5";

	$moyen_transport_a = 'VP'; /*S, A, O, VS, VP*/
	$moyen_transport_r = 'S'; /*S, A, O, VS, VP*/
	$immat = "5548 QE 40";
	$puiss = "6";
	$nbkm = 1000;

	//Instanciation de la classe dérivée
	$pdf=new pdfOrder('P','mm','A4');
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	$pdf->LI();
	$pdf->cadreAdmin();
	$pdf->agent($nom,$prenom,$add1,$add2,$res1,$res2,$equipe,$intitule,$grade,$personnel_type);
	$pdf->mission($motif,$lieu,$date_a,$heure_ad,$heure_aa,$date_r,$heure_ra,$heure_rd);
	$pdf->budget($budget_type, $r4ec_equipe, $r4ec_anr, $e4aa_equipe, $e4aa_pfe, $v4ec_cifre, $v4ec_autre);
	$pdf->transport($moyen_transport_a,$moyen_transport_r,$immat,$puiss,$nbkm);
	$pdf->signatures();
	$pdf->justificatif();

	$pdf->Output();

  }

}



?>
