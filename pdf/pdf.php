<?php 
date_default_timezone_set('UTC');
require('fpdf.php'); // fpdf library 
session_start();
set_time_limit(0);
class PDF_result extends FPDF {
	function __construct ($orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
		$this->FPDF($orientation, $unit, $format);
		$this->SetTopMargin($margin);
		$this->SetLeftMargin($margin);
		$this->SetRightMargin($margin);
		$this->SetAutoPageBreak(true, $margin);
$user_info = $_SESSION['user_info'];
$tweet = $_SESSION['tweet'];

	}
	
	function Header () {
$user_info = $_SESSION['user_info'];
$tweet = $_SESSION['tweet'];

	     $this->Image($user_info->profile_image_url);

	//	$this->SetFont('Arial', 'B', 20);
	//	$this->SetFillColor(36, 96, 84);
	//	$this->SetTextColor(225);
	//	$this->Cell(0, 30, "YouHack MCQ Results", 0, 1, 'C', true);
	}
	
 function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Twitter',0,0,'C');
}

	
function Generate_Table($tweet, $user_info) {
$user_info = $_SESSION['user_info'];
$tweet = $_SESSION['tweet'];

	$this->SetFont('Arial', 'B', 12);
	$this->SetTextColor(0);
//	$this->SetFillColor(94, 188, z);
$this->SetFillColor(94, 188, 225);
	$this->SetLineWidth(1);
	$this->Cell(450, 25, "Tweets", 'LTR', 0, 'C', true);
	$this->Cell(100, 25, "Created At", 'LTR', 1, 'C', true);
	 
	$this->SetFont('Arial', '');
	$this->SetFillColor(238);
	$this->SetLineWidth(0.2);
	$fill = false;
	
	for ($i = 0; $i < count($tweet); $i++) {
		$this->Cell(450, 20, $tweet[$i]->text, 1, 0, 'L', $fill);
		$this->Cell(100, 20,  $tweet[$i]->created_at, 1, 1, 'R', $fill);
		$fill = !$fill;
	}
	$this->SetX(367);
	//$this->Cell(100, 20, "Total", 1);
//	$this->Cell(100, 20,  array_sum($marks), 1, 1, 'R');
}
}
$user_info = $_SESSION['user_info'];
$tweet = $_SESSION['tweet'];
if(!empty($user_info->location))
	$location = $user_info->location;
else
	$location = 'Not Available';
$pdf = new PDF_result();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY(100);

$pdf->Cell(100, 13, "Twitter Details");
$pdf->SetFont('Arial', '');

$pdf->Cell(250, 13, 'Full Name: '.$user_info->name);

$pdf->SetFont('Arial', 'B');
$pdf->Cell(50, 13, "Date:");
$pdf->SetFont('Arial', '');
$pdf->Cell(100, 13, date('F j, Y'), 0, 1);

$pdf->SetFont('Arial', 'I');
$pdf->SetX(140);
$pdf->Cell(200, 15, 'Screen Name: '.$user_info->screen_name, 0, 2);
$pdf->Cell(200, 15, 'Location: '.$location , 0, 2);
$pdf->Cell(200, 15, 'Twitter ID: '.$user_info->id, 0, 2);

$pdf->Ln(100);

$pdf->Generate_Table($tweet, $user_info);

$pdf->Ln(50);

$message = "Send feedback";

$pdf->MultiCell(0, 15, $message);

$pdf->SetFont('Arial', 'U', 12);
$pdf->SetTextColor(1, 162, 232);

$pdf->Write(13, "Contact", "mailto:mails4aniket@gmail.com");
$pdf->Output('My_Tweets.pdf', 'D');

?>