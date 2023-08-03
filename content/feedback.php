<div class="page-title">Feedback Form</div>

<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	
	if(isset($_POST['captcha']) && isset($_POST['captcha2']) && $_POST['captcha'] != $_POST['captcha2'] )
		echo '<div class="col-md-12 isa_error text-center">The security answer given is wrong</div>';
	
	else
		echo frontModel::submitFeedback($_POST);
		
	}



?>

<div class="col-md-12">
	<form action="" method="post">
    
    	<div class="col-md-12 full-row">        
        	<div class="col-md-6"><label>Fullname</label><input class="form-control" type="text" name="fullname" required placeholder="your full name" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>" ></div>
            <div class="col-md-6"><label>Phone</label><input class="form-control" type="tel" name="phoneno" required placeholder="your phone number" value="<?php echo isset($_POST['phoneno']) ? $_POST['phoneno'] : '' ?>" ></div>
        </div>

    	<div class="col-md-12 full-row">
        	<div class="col-md-6"><label>Email Address</label><input class="form-control" type="email" name="emailadd" required placeholder="your valid email address" value="<?php echo isset($_POST['emailadd']) ? $_POST['emailadd'] : '' ?>" ></div>
           	<div class="col-md-6"><label>Station Visited</label>
            <select class="form-control" name="station_id" required>
                <option value="">--select station--</option>
            
                <?php 
                $stations = frontModel::listStations(0);
                
                foreach($stations as $stat)
                    {
					
					$sel = isset($_POST['station_id']) && $_POST['station_id']==$stat->id ? 'selected="selected"' : '';
					
                    echo '<option value="'.$stat->id.'" '.$sel.'>'.$stat->title.'</option>';
                    }			
                ?>
            
            </select>
        
        	</div>
 
        </div>

		<div class="col-md-12 full-row">
        	<div class="col-md-6"><label>Visit's Reference Number</label><input class="form-control" type="text" name="ref_no" placeholder="the reference number of the visit" value="<?php echo isset($_POST['ref_no']) ? $_POST['ref_no'] : '' ?>" ></div>
    		<div class="col-md-6"><label>Feedback Details</label><textarea class="form-control" name="comments" required placeholder="write your comments here"><?php echo isset($_POST['comments']) ? $_POST['comments'] : '' ?></textarea></div>
        </div>
        
        
        <div class="col-md-12 full-row">
		<?php
        $x = rand(11,20);
        $y = rand(1,10);
        $z = rand(1,2);
        
        if($z==1)
            {
            $quiz = $y .' + '. $x .' = ? ';
            $answer = $x+$y;
            }
        else
            {
            $quiz = $x .' - '. $y .' = ? ';
            $answer = $x-$y;	
            }
        
        ?>
        
        <div class="col-md-6"><label>Confirm you are not a robot</label>
            <input name="captcha" type="text" id="captcha" class="form-control" placeholder="<?php echo $quiz; ?>" />
            <input name="captcha2" type="hidden"  value="<?php echo $answer; ?>" />
        </div>        
        </div>
        
    
        <div class="col-md-12 full-row text-center"><input type="submit" class="btn" name="submitThis" value="Submit"> <input class="btn" type="reset" name="cancelThis" value="Cancel"></div>

    
    </form>


</div>