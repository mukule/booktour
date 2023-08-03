<h2 class="page-header">Regional Contacts</h2>


<?php
$regions = regionsModel::listRegions();

$contacts ='';
$count = 1;
$cols =3;
$col = 12/$cols;
foreach($regions as $region)
	{
	
	if($count==1 || $count%$cols == 1)
		$contacts .= '<div class="col-md-12">';
	
	
	$contacts .= '<div class="col-md-'.$col.'"><div class="contacts-item">
				<h4>'.$region->title.'</h4>
				<p>'.$region->contacts_address.'</p>
				<p>Tel: '.$region->contacts_phoneno.'</p>
				<p>Email: '.$region->contacts_email.'</p>				
				</div></div>';
	
	if($count%$cols==0)
		$contacts .= '</div>';
	
	$count++;
	
	}

echo $contacts;

?>