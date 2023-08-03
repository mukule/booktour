<?php

/*** Defining the folders **/

define( 'EXT', '.php' );

//define( 'DS', DIRECTORY_SEPARATOR );

define( 'DS', "/" );
define( 'CURRENT_DIRECTORY', dirname( __FILE__ ) );
define( 'ROOT', dirname( dirname( __FILE__ ) ) );
define( 'APPLIC', ROOT . DS . 'applications' . DS );
define( 'SYSTEM', ROOT . DS . 'system' . DS );
define( '_DEFAULT', APPLIC . DS . 'default' . DS );
define( '_PUBLIC', ROOT . DS .'public' . DS );

if(isset($_REQUEST['act']))
	define( 'ACT',  $_REQUEST['act'] );

define( 'DASHBOARD_ICONS', 'images' .DS. 'dashboard'. DS );
define( 'ACTION_ICONS', 'images' .DS. 'icons'. DS );
define( 'REGIONS_IMAGES', 'images' .DS. 'regions'. DS );
define( 'STATIONS_IMAGES', 'images' .DS. 'slides' .DS. 'stations'. DS );
define( 'DOCUMENTS_FOLDER', 'images' .DS. 'documents'. DS );
define( 'LETTERS_FOLDER', 'public' .DS. 'letters'. DS );

// define('SITE_NAME', 'KenGen Tours Portal' );
// define('SITE_NAME_SHORT', "KenGen Tours" );
// define('SYSTEM_EMAIL', 'tours@kengen.co.ke' );
// define('NOREPLY_EMAIL', 'noreply@kengen.co.ke' );
// define('BCC', 'cnsirali@gmail.com, nathan@kenyaweb.com' );
define('SITE_NAME', 'KenGen Tours Portal' );
define('SITE_NAME_SHORT', "KenGen Tours" );
define('SYSTEM_EMAIL', 'nelsonmasibo6@gmail.com' );
define('NOREPLY_EMAIL', 'noreply@kengen.co.ke' );
define('BCC', 'nelson.masibo@kenyaweb.com' );

//defaults
define('MIN_VISITORS', 0 );
define('MAX_VISITORS', 80 );
define('MIN_DAYS_BEFORE_BOOKING', 90 );
define('MAX_DAYS_AFTER_BOOKING', 365 );
define('GUIDES_PER_SESSION', 4 );

define('DEVELOPED_BY', 'Kenyaweb Ltd' );
define('DEVELOPED_BY_URL', 'http://www.kenyaweb.com' );
define('SESSIONID', 'myid_tours' );

if(isset($_SESSION[SESSIONID]))
	define('MYID', $_SESSION[SESSIONID]);

define('ACCESS_LVL', isset($_SESSION['userlevel']) ? $_SESSION['userlevel'] : 0);

define( 'SESSION_DURATION',  30 ); //minutes

/*** Load System Libraries **/

require_once SYSTEM . 'sql' . EXT;
require_once SYSTEM . 'mysql' . EXT;
require_once SYSTEM . 'database' . EXT;
require_once SYSTEM . 'stdlib' . EXT;
require_once SYSTEM . 'pagination' . EXT;

$bg_light = "#ffffff";
$bg_dark = "#efefef";

date_default_timezone_set('Africa/Nairobi');

/*** Autoload all the model classes **/
$folders = glob( APPLIC  . "*" );

foreach( $folders as $folder ) : 	
 	if( is_dir( $folder )   ) :
		
		$filename = basename($folder);
	
		$file = $folder . DS . $filename . EXT;
		$model = $folder . DS . 'model' . EXT;

		if(is_file($model))
  			require_once $model;
		else
			echo '<div class="col-md-12 isa_error text-center">An important library is missing.</div>';
		
		if(!is_file($file))
			echo '<div class="col-md-12 isa_error text-center">An important file is missing.</div>';	
			
	endif;
	
endforeach;


/*** Database Configuration  **/
if(strpos($_SERVER['HTTP_HOST'], 'v3.kenyaweb.co') > 0 ):
	$host = 'localhost';
	$db = 'aloise_kgntour';
	$user = 'aloise_kgntour';
	$pwd = 'LF4r56d#p8c';

	define('SITE_URL', 'http://dev3.kenyaweb.com/KenGen/BookTour' );
	
elseif(strpos($_SERVER['HTTP_HOST'], 'engen.co.') > 0 ):
	$host = 'localhost';
	$db = 'kengenco_booktour';
	$user = 'kengenco_touruser';
	$pwd = 'M{HKq=jqu^56PWI?)';
	
	define('SITE_URL', 'https://kengen.co.ke/BookTour/tours' );	
	
else:	
	$host = 'localhost';
	$db = 'kengentours';
	$user = 'root';
	$pwd = '';	
	
	define('SITE_URL', 'http://localhost/KengenTours/tours' );	

	ini_set('display_errors', 1);	
	ini_set('display_startup_errors', 1);	
	error_reporting(E_ALL);	
	
endif;		

$dbconn = DBASE::dbConnect( $host, $user, $pwd, $db );

//

?>
