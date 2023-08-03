// JavaScript Document
function updateDetails( id, dir ) {	
	
	pos = dir.substring( 0, ( dir.length - 1 ) );	
	
	if ( id == "" ) {
		document.getElementById( pos ).innerHTML = "";
		return;
	}
					
	if ( window.XMLHttpRequest ) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
		
	else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );
	}
					
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			document.getElementById( pos ).innerHTML = xmlhttp.responseText;
		}
	}
			
	xmlhttp.open( "GET", dir+"/details.php?i="+id, true );
	xmlhttp.send();
	
}






function searchGuest() {
	
	names = document.form.names.value;	
	
	
	if( names.length < 1 ) {
		alert( "Please enter names" );
		return false;
	}	
	
	if ( names == "" ) {
		document.getElementById( "guest" ).innerHTML = "";
		return;
	}
					
	if ( window.XMLHttpRequest ) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
		
	else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );
	}
					
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			document.getElementById( "guest" ).innerHTML = xmlhttp.responseText;
		}
	}
			
	xmlhttp.open( "GET", "guests/details.php?n="+names, true );
	xmlhttp.send();
	
}

function listItemTask( id, task, page ) {
			
	if ( id == "" ) {
		document.getElementById( "txtContent" ).innerHTML = "";
		return;
	}
				
	if ( window.XMLHttpRequest ) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
			
	else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );
	}
					
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			document.getElementById( "txtContent" ).innerHTML = xmlhttp.responseText;
		}
	}
			
	xmlhttp.open( "GET", page+"_publisher.php?id="+id+"&task="+task, true );
	xmlhttp.send();			
}	