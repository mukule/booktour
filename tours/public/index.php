<?php

session_start();

require_once "configs.php";
//echo checkTimer( time() );

if( $_REQUEST['url'] == 'logout' ) :
	
	//update chat status
	if(isset($_SESSION[SESSIONID]))
		{		
		echo defaultModel::updateLogTable($_SESSION[SESSIONID], 'logout');
		//exit;
		}
		
	session_unset( $_SESSION[SESSIONID] );
	
	//session_destroy();
	
endif;

$include = ( isset( $_SESSION[SESSIONID] ) ) ? 'default' : 'default';

include _DEFAULT . $include . EXT;



?>
