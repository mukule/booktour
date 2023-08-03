<?php

//sendemail

if(isset($_POST['sendThis']) && $_POST['sendThis'] == "Send" ):
	
	if(empty($_POST['email_message']) || empty($_POST['emailadds']) || empty($_POST['subject']) ):
		echo '<div class="col-md-12 text-center isa_warning">All fields must be entered</div>';
	else:
	
		$myEmail = usersModel::userDetails(MYID)->emailadd; // cc my email address
	
		$to = NOREPLY_EMAIL;
		$from = NOREPLY_EMAIL;
		$cc = $myEmail;
		$bcc = $_POST['emailadds'];
		$subj = "KenGen Tours - ". $_POST['subject'];
		$body = '
			<p>Dear Applicant,</p>		
			
			<p><u>'. $_POST['email_message'].'</ul></p>
			
			'. $_POST['email_message'].'	
			
			<p>For more information, confirmation or enquiry, please reach us through the contacts provided on our portal or website.</p>
			<p>&nbsp;</p>		
				
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';
			
		$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subj, $body );
			
		if($sent == 1)
			echo '<script>self.location="'.$urls.'&msg_email=success"</script>';
		else
			echo '<script>self.location="'.$urls.'&msg_email=error"</script>';		
		
	endif; //not empty
		
endif; //sendthis


if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Send Email" ):

	if(empty($_POST['bookids']))
		{
		echo '<div class="col-md-12 text-center isa_warning">There are no records selected</div>';
		return;
		}
		
	$bookids = $_POST['bookids'];	
	
	$emails ='';
	foreach($bookids as $bid)
		{
		$book = bookingsModel::bookingDetails($bid);
		
		$emails .= $book->emailadd .',';
		
		}
		
	$emails = !empty($emails) ? substr(trim($emails), 0, -1) : '';
	
	
	?>
    <div class="col-md-12">
    	<div class="col-md-12"><h4>Sending Email to <?php echo count($bookids); ?> applicants</h4></div>
    	
        <form action="" method="post">
        
        <div class="col-md-12"><input name="subject" class="form-control" placeholder="subject here" required /></div>
        
        <div class="col-md-12"><textarea name="email_message" class="form-control" placeholder="write message here" rows="4" required ></textarea></div>
        
        <div class="col-md-12"><input type="submit" name="sendThis" value="Send" class="btn"></div>
        
                
        <input type="hidden" name="emailadds" value="<?php echo $emails; ?>">        
        
        </form>
    
    
    </div>   
    
    <?php
	
	
endif;







?>