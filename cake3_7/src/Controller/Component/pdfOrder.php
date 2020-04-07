<?php

require 'fpdf16/fpdf.php';

class pdfOrder extends FPDF
{

    public function _check($x, $y, $width, $checked)
    {
        if ($checked) {
            $this->rect($x, $y, $width, $width, 'F');
        } else {
            $this->rect($x, $y, $width, $width);
        }

    }

    public function LI($sansFrais = false)
    {
        $LI = 'LI';
        $coord = 'Laboratoire informatique
Secrétariat Christelle Grange
64, avenue Jean Portalis
37200 Tours
Tél. : 02 47 36 14 42
Fax. : 02 47 36 14 22';
        $this->Image(dirname(__FILE__) . '/li.jpg', 10, 2, 20);
        $this->SetFont('Times', 'B', 20);
        $this->SetFont('Times', '', 9);
        $this->setXY(35, 3);
        $this->Multicell(80, 4, utf8_decode($coord), 0, 'LT');

        if ($sansFrais) {
            $this->SetTextColor(255, 0, 0);
            $this->SetXY(170, 42);
            $this->setFont('Times', 'BI', 16);
            $this->Cell(80, 4, utf8_decode('SANS FRAIS'), 0, 0, 'LT');
            $this->SetTextColor(0, 0, 0);
            $this->rect(168, 41, 38, 6, 'D');
        }

    }

    public function cadreAdmin($matricule)
    {
        if ($matricule != null) {
            $text =
                "Nr AGENT : $matricule
Nr DEPLACEMENT : ..........................................................
Nr COMMANDE : ................................................................
		";
        } else {
            $text = 'Nr AGENT ............................................................................
		Nr DEPLACEMENT ............................................................
		Nr COMMANDE ..................................................................
		';
        }
        $title = 'ORDRE DE MISSION
Laboratoire d\'Informatique
EA 6300';
        $this->SetXY(-100, 8);
        $this->SetFont('Times', 'B', 9);
        $this->Cell(90, 4, utf8_decode('Cadre réservé à l\'administration'), 0, 0, 'LT');
        $this->Ln(4);
        $this->SetX(-100);
        $this->SetFont('Times', '', 9);
        $this->MultiCell(80, 4, utf8_decode($text), 0, 'LT');
        $this->SetXY(-100, 28);
        $this->SetFont('Times', 'B', 16);
        $this->MultiCell(0, 6, utf8_decode($title), 0, 'C');
        $this->rect(105, 8, 95, 17, 'D');
    }

    public function agent($id, $nom, $prenom, $add1, $add2, $res1, $res2, $equipe, $intitule, $grade, $personnel_type, $signature_path, $date_naissance)
    {
        $certifieExact = "Je soussignée, $prenom $nom m'engage à souscrire une police d'assurance garantissant d'une manière illimité ma responsabilité personnelle aux termes des articles 1382, 1383 et 1384 du Code Civile ainsi que, éventuellement, la responsabilité de l'Etat, dans les conditions définies à l'article 34 du décret num 90-437 du 28 mai 1990.

Certifié exact par l'interessé(e)                                   A Tours , le ........... Signature";

        $date = date("d-m-Y", strtotime($date_naissance));

        //AGENT
        $this->SetXY(10, 46);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(30, 0, 'AGENT', 0, 1, 'L');
        //partie de gauche
        $this->SetXY(10, 54);
        $this->SetFont('Times', '', 10);
        $this->Cell(30, 0, utf8_decode("NOM : $nom"), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode("PRENOM : $prenom"), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode("Addresse Personnelle : $add1"), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode($add2), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode("Résidence administrative : $res1"), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode($res2), 0, 1, 'L');
        $this->Ln(6);
        $this->Cell(30, 0, utf8_decode("Date de naissance : $date"), 0, 1, 'L');
        $this->rect(10, 50, 108, 43);

        //partie de droite
        $this->SetXY(-85, 60);
        $this->SetFont('Times', 'BI', 9);
        $this->Cell(30, 0, utf8_decode('Personnel Université'), 0, 0, 'L');
        if ($personnel_type == 'PU') {
            $this->_check(123, 59, 2, true);
        } else {
            $this->_check(123, 59, 2, false);
        }

        $this->SetFont('Times', '', 9);
        $this->Ln(6);
        $this->SetX(-75);
        $this->Cell(30, 0, utf8_decode("Titulaire/intitulé : $intitule"), 0, 0, 'L');
        $this->_check(133, 65, 1, false);

        $this->Ln(6);
        $this->SetX(-75);
        $this->Cell(30, 0, utf8_decode("Contractuel/Grade : $grade"), 0, 0, 'L');
        $this->_check(133, 71, 1, false);

        $this->SetFont('Times', 'BI', 9);
        $this->Ln(6);
        $this->SetX(-85);
        $this->Cell(30, 0, utf8_decode('Personnalité Extérieure'), 0, 0, 'L');
        if ($personnel_type == 'PE') {
            $this->_check(123, 77, 2, true);
        } else {
            $this->_check(123, 77, 2, false);
        }

        $this->Ln(6);
        $this->SetX(-85);
        $this->Cell(30, 0, utf8_decode('Doctorant'), 0, 0, 'L');
        if ($personnel_type == 'Do') {
            $this->_check(123, 83, 2, true);
        } else {
            $this->_check(123, 83, 2, false);
        }

        $this->Ln(6);
        $this->SetX(-88);
        $this->Cell(30, 0, utf8_decode("Equipe Interne au LI : $equipe"), 0, 0, 'L');
        $this->rect(120, 56, 80, 37);
        //cadre de bas
        $this->setXY(10, 95);
        $this->setFont('Times', 'B', 9);
        $this->MultiCell(0, 5, utf8_decode($certifieExact));
        $this->rect(10, 95, 190, 27);

        // $signature = "/Signatures/$signature_path.jpg";
        $signature = $_SERVER['DOCUMENT_ROOT'] . '/PRD-Projet-LIFAT/cake3_7/webroot' . $signature_path;

        if (file_exists($signature) && filesize($signature) != 0) {
            $this->Image($signature, 135, 111, 57, 10);
        }

    }

    public function mission($motif, $complementMotif, $lieu, $date_a, $heure_ad, $heure_aa, $date_r, $heure_ra, $heure_rd, $nb_repas, $nb_nuite)
    {
        //TITRE
        $this->setXY(10, 127);
        $this->setFont('Times', 'B', 16);
        $this->Cell(30, 0, 'MISSION');

        if ($complementMotif != null) {
            $complementMotif = " - " . $complementMotif;
        }

        //cadre motif
        $motif = "Motif du déplacement : $motif$complementMotif
Lieu de la mission : $lieu
Nombre de repas : $nb_repas
Nombre de nuitées : $nb_nuite";
        $depart = "Date : $date_a
Heure de départ : $heure_ad";
        $arrivee = "Date : $date_r
Heure d'arrivée : $heure_rd";
        $this->setFont('Times', 'B', 10);
        $this->Ln(3);
        $this->setX(12);
        $this->MultiCell(100, 7, utf8_decode($motif));
        $this->rect(10, 130, 107, 29);

        //cadre départ
        $this->setXY(25, 162);
        $this->Cell(20, 0, 'DEPART');
        $this->Ln(4);
        $this->setX(12);
        $this->setFont('Times', '', 10);
        $this->MultiCell(50, 4, utf8_decode($depart));
        $this->rect(10, 159, 54, 17);

        //cadre arrivée
        $this->setXY(84, 162);
        $this->setFont('Times', 'B', 10);
        $this->Cell(20, 0, 'RETOUR', 0, 1);
        $this->setFont('Times', '', 10);
        $this->setXY(67, 166);
        $this->MultiCell(50, 4, utf8_decode($arrivee));
        $this->rect(64, 159, 53, 17);

    }

    public function budget($projet)
    {
        //partie budget
        $this->setXY(-92, 127);
        $this->setFont('Times', 'B', 14);
        $this->Cell(30, 0, 'BUDGET D\'IMPUTATION');
        $budget = "
Projet : $projet
";
        $this->setX(-90);
        $this->setFont('Times', '', 11);
        $this->multiCell(70, 6, utf8_decode($budget));
        $this->rect(119, 130, 81, 12);

    }

    public function transport($transports)
    {
        $firstTime = true;
        foreach ($transports as $transport) {

            switch ($transport->type_transport) {
                case "train":
                    $textTransport = "Train";
                    break;
                case "avion":
                    $textTransport = "Avion";
                    break;
                case "vehicule_service":
                    $textTransport = "Véhicule de service";
                    break;
                case "vehicule_personnel":
                    $textTransport = "Véhicule Personnel";
                    break;
                case "autre":
                    $textTransport = "Autre";
                    break;
                default:
                    $textTransport = "Autre";
                    break;
            }
            if ($firstTime) {
                $transportDisplay = $textTransport;
                $firstTime = false;
            } else {
                $transportDisplay = $transportDisplay . ', ' . $textTransport;
            }
        }
        if (isset($transportDisplay)) {
            $transport = "Moyens de transport :
$transportDisplay";
        } else {
            $transport = "Aucun moyen de transport";
        }
        $this->setXY(-92, 145);
        $this->setFont('Times', 'B', 14);
        $this->Cell(30, 0, 'TRANSPORT');
        $this->rect(119, 148, 81, 28);
        $this->setXY(-90, 149);
        $this->setFont('Times', '', 11);
        $this->multiCell(80, 5, utf8_decode($transport));
    }

    public function transportBis($immat, $puiss, $commentaire, $reducSncf, $billetAgence)
    {
        //titre
        $this->setXY(10, 181);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(0, 0, utf8_decode('Transport : Commentaires, Réduction SNCF, Immatriculation'), 0, 1, 'C');
        $this->rect(10, 178, 190, 6);
        $this->setXY(10, 185);
        $this->setFont('Times', '', 10);

        if (strlen($commentaire) > 750) {
            $newCommentaire = substr($commentaire, 0, 750);
            $commentaire = $newCommentaire . ' (...)';
        }

        if (substr_count($commentaire, "\n") > 7) {
            $commentaireExplode = explode("\n", $commentaire);
            $commentaire = "";
            for ($i = 0; $i < 7; $i++) {
                $commentaire = $commentaire . $commentaireExplode[$i] . "\n";
            }
            $commentaire = $commentaire . '(...) [Suite du message disponible dans le mail associé]';
        }

        $this->multiCell(190, 5, utf8_decode($commentaire));

        //debug(substr_count( $commentaire, "\n" ));
        //bordures
        $this->rect(10, 184, 190, 54);
        //$this->rect(105,194,95,44);
        //$this->line(10,221,200,221);
        $this->line(10, 226, 200, 226);
        $this->line(100, 226, 100, 238);

        $vehicule = "Immatriculation du véhicule : $immat
Puissance ficale du véhicule : $puiss";
        $sncf = "Réduction SNCF : $reducSncf";
        $billet = "Billet commandé par le secrétariat";

        $this->setY(227);
        $this->multiCell(0, 5, utf8_decode($vehicule));

        $this->setXy(105, 227);
        $this->multiCell(100, 5, utf8_decode($billet));
        $this->setXy(100, 232);
        $this->multiCell(100, 5, utf8_decode($sncf));

        if ($billetAgence) {
            $this->_check(102, 228, 3, true);
        } else {
            $this->_check(102, 228, 3, false);
        }

    }

    public function signatures($cheifSignaturePath)
    {
        // signature de gauche
        $this->setXY(12, 233);
        $this->setFont('times', 'B', 10);
        $this->Cell(40, 20, utf8_decode("Signature du responsable de l'équipe LI"));
        $this->rect(10, 240, 90, 17);
        //$this->Image('./img/sign/equipe.jpg', 140, 251, 57, 10);

        // signature de droite
        $this->SetXY(-100, 242);
        $this->setFont('Times', 'B', 10);
        $signLI = "Fait à Tours, le
Signature du Directeur de l'EPU ou du Directeur du Laboratoire";
        $this->multiCell(0, 4, utf8_decode($signLI));

        if ($cheifSignaturePath != null || $cheifSignaturePath != "") {
            $cheifSignature = "$cheifSignaturePath.jpg";
            if (file_exists($cheifSignature)) {
                $this->Image($cheifSignature, 25, 246, 57, 10);
            }
        }
    }

    public function justificatif()
    {
        $titre = "JUSTIFICATIF A JOINDRE :";
        $justif = "- Paiments des indemnités forfaitaires journalières : factures acquittées (hôtel et restaurants)
- Prise en charge des frais de transport : billet (train-avion)
- Autre dépenses (Autoroute - Taxi - Métro - RER - Bus - Parking) : Tickets, reçu, abonnements...
- Si utilisation du véhicule de service (Carburant)
- Attestation de non paiement pour les Agents de la Fonction Publique
- Réçu du règlement des frais d'inscriptions payé directement par l'Agent
- En cas de demande d'avance, joindre une lettre
";
        $this->setXY(10, -40);
        $this->setFont('times', 'BUI', 10);
        $this->cell(0, 5, utf8_decode($titre), 0, 1);
        $this->setX(12);
        $this->setFont('times', '', 10);
        $this->multiCell(0, 4, utf8_decode($justif));
    }

    public function example()
    {

        $nom = 'Hadba';
        $prenom = 'Julien';
        $add1 = '2, chichi plouf';
        $add2 = '40800 creole';
        $res1 = '64, avenue jean portalis';
        $res2 = '37520 La riche';
        $equipe = 'OC';
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
        $pdf = new pdfOrder('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->LI();
        $pdf->cadreAdmin();
        $pdf->agent($nom, $prenom, $add1, $add2, $res1, $res2, $equipe, $intitule, $grade, $personnel_type);
        $pdf->mission($motif, $lieu, $date_a, $heure_ad, $heure_aa, $date_r, $heure_ra, $heure_rd);
        $pdf->budget($budget_type, $r4ec_equipe, $r4ec_anr, $e4aa_equipe, $e4aa_pfe, $v4ec_cifre, $v4ec_autre);
        $pdf->transport($moyen_transport_a, $moyen_transport_r, $immat, $puiss, $nbkm);
        $pdf->signatures();
        $pdf->justificatif();

        $pdf->Output();

    }

}
