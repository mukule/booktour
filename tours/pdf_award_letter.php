<?php

//session_start();

require_once "inc/configs.php";

//include modules
$dir = APPLIC;

$folders = scandir($dir,1);

foreach($folders as $folder)
	{
	if (!in_array($folder,array(".","..")))
		{
		require_once APPLIC . $folder . DS . "model" . EXT;
		}
	}

$itemId = $_REQUEST['itemId'];
$booking = bookingsModel::bookingDetails($itemId);

$stationId = $booking->station_id;

$station = stationsModel::stationDetails($stationId);

$refno = $booking->ref_no;
$refno = str_replace("#", "_", $refno);
$refno = str_replace("/", "", $refno);

$dir_letters = LETTERS_FOLDER;
$filename = $station->title .'_'.$refno.'.pdf';
$file = $dir_letters . $filename;

//echo '<br>=='.$itemId.'<br>=='.$stationId;

$dateOfPrinting = date('dS F, Y');

$visitTime = $booking->visit_time==1 ? ' 10:00' : '14:00';
$visitDatetime = $booking->visit_date . $visitTime;

require_once _PUBLIC . 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once _PUBLIC . 'dompdf/autoload.inc.php';


if($booking->plant_id > 0 )
	{
	$plant = plantsModel::plantDetails($booking->plant_id);
	
	$pTitle = !empty($plant) ? $plant->title : ' [Please contact us for this] ';
	$plantTitle = '( Power plant : '.$pTitle.' )';
	
	}
else
	$plantTitle ='';
	
$station = stationsModel::stationDetails($booking->station_id);

$region = regionsModel::regionDetails($station->region_id);

$regionContacts = $region->title .' Region<br>';
$regionContacts .= !empty($region->address) ? $region->address.'<br>' : '';
$regionContacts .= !empty($region->phoneno) ? $region->phoneno.'<br>' : '';
$regionContacts .= !empty($region->emailadd) ? $region->emailadd.'<br>' : '';

if($region->acting==1):
	$acting = !empty($region->incharge) ? '<p>Signed by '.$region->incharge.', On Behalf</p>' : '';
else:
	$acting ='';
endif;

$stationContacts = $station->title.'<br>';	
$stationContacts .= $station->contacts.'<br>';	

$specialTerms = !empty($station->special_terms) ? '<h3>Special Terms:</h3>'.$station->special_terms : '';

$title = SITE_NAME.' - Visit Award Letter';

if(!empty($region->signature))
	$signature = '<p><img src="data:image/jpeg;base64,'.base64_encode( $region->signature ).'"/></p>';
else
	$signature = '';


use Dompdf\Dompdf;
// instantiate and use the dompdf class
$html = '<html>
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
            <title>'.$title.'</title>
                <style>        
        @import url("https://fonts.googleapis.com/css?family=Mr+Bedfort");
		
		@font-face {
		  font-family: "Salterio Shadow";		 
		  src: url(dompdf/lib/fonts/SalterioShadow.ttf);
		}
		
		@font-face {
		  font-family: "Certificate";		 
		  src: url(dompdf/lib/fonts/Certificate.ttf);
		}

		<link href="css/superlist.css" rel="stylesheet" type="text/css">
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

        .joti-font-1 {font-family: "Certificate", cursive !important;    }
		.joti-font-2 {font-family: "Salterio Shadow", cursive !important; text-transform:capitalize;    }
		
		body {margin-top: 3.5cm; margin-bottom: 1cm; margin-left: 1cm; margin-right: 1cm; }
		
		.watermark {    
				position: fixed;
				top: 30%;
				width: 100%;
				text-align: center;
				opacity: .6;
				transform: rotate(-45deg);
				transform-origin: 50% 50%;
				z-index: -1000;
				}
		
		.watermark img {display: block; max-width: 100%; min-width:50%; height: auto; opacity:0.1; margin:15%; position:relative;}
		 
		
		.no-watermark {
				display: inline-block;
				position: absolute;
				width: 100%;
				left: 0;				
				padding: 1em; 
				z-index: 2;
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
				top:0 !important;
			 }
		
	.disclaimer {font-size:13px; font-style:italic;}
	

	
    </style>

    </head>

    <body class="pdf">
		
		<div class="watermark" align="center">
			<img src="images/logo.png"  />
		</div>		
		
		<div class="col-md-12"><i><strong>Our Ref : </strong> '.$booking->ref_no.' &nbsp; &nbsp; <strong> </strong></i></div>


				<div class="col-md-12 text-right font-bold" align="right">	
					<img src="images/logo.png"  /><br>				
					KenGen Pension Plaza<br>
					P. O. Box 47936, 00100, Nairobi<br>
					Tel: 0711036000/0732116000/203666000<br>
					Email: pr@Kengen.co.ke
					<p>Date : '.$dateOfPrinting.'</p>
				</div>
				
				<div class="col-md-12 font-bold">
					<b>TO: </b><br>
					'.$booking->fullname.'<br>
					'.$booking->institution.'<br>
					'.$booking->phoneno.'<br>
					'.$booking->emailadd.'<br>
					'.$booking->town.'.<br>
				</div>   
							
				
				<div class="col-md-12 font-bold"><p><em>Dear Sir / Madam,</em></p></div>
				
				<div class="col-md-12 font-bold"><p><u>RE: A VISIT TO '.$station->title.'</u></p></div>
				
				<div class="col-md-12">
				<p>We wish to inform you that authority  has been granted for your party to visit:</p>
				<p><strong>'.$station->title.'</strong> Power Station '.$plantTitle.' on <strong>'.$visitDatetime.'</strong></p>
				<p><strong>(PLEASE  NOTE: BOOKING IS DONE 3 MONTHS IN ADVANCE)</strong></p>
				<p>You  are at the same time advised that on agreeing to this visit, the Kenya  Electricity Generating Co. Ltd. accepts no liability for any accident or injury  that might occur to any member of the visiting party during the tour, and you  are requested therefore to exercise caution while moving within the station. Visitors are advised <strong><em>NOT</em></strong> to wear high-heeled pointed shoes, as the floor could be slippery. <strong>For safety and operational reasons, you will be required to present a certified list of a maximum of 80 visitors who will be allowed in. Any excess visitors and children under 10(ten) years will not be allowed in.</strong> Please note that while entering our premises <strong>ID cards are mandatory for all adults</strong>, you will also be subjected to security checks and may be required to deposit certain items with security officers. Guardians are advised to co-operate with the officer leading the tour. Kindly note that there\'s no provision for visiting during Weekends and Public  Holidays.</p>
				<p>On arrival you should report to the Chief Engineer of the station who will organize on site safety briefing for the  party. We trust that you will find the tour interesting and informative. <strong>KenGen offers Educational tours free of charge.</strong></p>
				</div>
				
				'.$specialTerms.'
				
				<div class="col-md-12 text-right font-bold">
				'.$stationContacts.'
				<p>&nbsp;</p>
				Copied to :<br>
				'.$regionContacts.'				
				</div>				
				
				<div class="col-md-12">
					<p>&nbsp;</p>
					'.$acting.'					
					<p><strong><em>Yours faithfully,</em></strong></p>
					<p><strong>FOR : KENYA ELECTRICITY GENERATING CO. LTD.</strong></p>
					'.$signature.'
					<p><strong><u>OPERATIONS MANAGER - '.$region->title.' Region</u></strong></p>	
										
				</div>

    </body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

//save file
$output = $dompdf->output();
file_put_contents($file, $output);

?>

