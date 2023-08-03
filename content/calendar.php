<?php

$blocked_dates = frontModel::getBlockedDates($itemId);

//$booked_dates = frontModel::getBookedDates($itemId);

$minDays = $station->min_days_before_booking;
$maxDays = $station->max_days_after_booking;

?>

<div class="col-md-12 text-center">
	<label>To make a visit request, select month
    <br><small>Not before <?php echo $minDays ?> days, Not later than <?php echo $maxDays ?> days from now</small>
    </label>

	<form action="" method="post" onch>
    	<div class="col-md-12">
        	<select name="monthyear" class="form-control" onchange="this.form.submit()" >
            	<option value="">--select month/year--</option>
                <?php	
				
					$start = new DateTime($minDays.' days');
					$start->modify('first day of this month'); 
					$end = new DateTime($maxDays.' days');
					$interval = new DateInterval('P1M');
					$period = new DatePeriod($start, $interval, $end);
					
					foreach($period as $dt)
						{
						$date = date('M Y', strtotime($dt->format('M Y')));
						
						$sel = isset($_POST['monthyear']) && $_POST['monthyear'] == $date ? 'selected="selected"' : ''; 
						echo '<option value="'.$date.'" '.$sel.' '.$sel.'>'.$dt->format('M Y') . '</option>';
						}

                ?>
                
            </select>
        </div>



    </form>


	<?php
	if(isset($_POST['monthyear']))
		{
		
		//print_r($_POST);
		$date = $_POST['monthyear'];
		
		//echo $date;
		
		$year = date('Y', strtotime($date));
		$month = date('M', strtotime($date));
	
		$lastDay = date("t", strtotime($date));
		
		$url_cal = 'index.php?art=book-pre&stat='.baseModel::encode($itemId);
		
		$holidays = frontModel::getHolidayDates($year);
		
		// a function to return 1 if date/time is blocked
		$today = date('Y-m-d'); 
		
		$count = 0;
		
		$calendarDisplay ='';
		for($dy=1; $dy<=$lastDay; $dy++)
			{
			
			$day = sprintf('%02d', $dy); 
			
			$thisdate = $year.'-'.$month.'-'.$day;
			$thisdate_morning1 = $year.'-'.$month.'-'.$day. ' 10:00';
			$thisdate_afternoon1 = $year.'-'.$month.'-'.$day. ' 14:00';

			$thisdate = date('Y-m-d', strtotime($thisdate)); 
			
			$thisdate_morning = date('Y-m-d H:i', strtotime($thisdate_morning1));
			$thisdate_afternoon = date('Y-m-d H:i', strtotime($thisdate_afternoon1));
			
			$time_diff = strtotime($thisdate) - strtotime($today) ;
			$diff = round($time_diff / (60 * 60 * 24));
			
			$dayNum = date("w", strtotime($thisdate));
			$weekDay = date("l", strtotime($thisdate));
			
			$date_display = date("M d, D", strtotime($thisdate));
			
			$bg = $count%2 == 0 ? 'bg-grey' : 'bg-white';
			
			if( $diff >= $minDays && $diff <= $maxDays ):
				
				$morningLocked = frontModel::checkIfThisDateBooked($stationid, $thisdate, 1);
				$afternoonLocked = frontModel::checkIfThisDateBooked($stationid, $thisdate, 2);
				
				//morning
				$morning='';
				if($morningLocked ==1)
					$morning = '<span class="small">Booked</span>';					
				elseif($dayNum ==1 ) //no bookings on monday morning, friday afternoon
					$morning = '10am';
				else
					$morning = '<a href="'.$url_cal.'&dy='.strtotime($thisdate).'_1">10am</a>';			
	
				//afternooon
				$afternoon ='';			
				if($afternoonLocked ==1 )
					$afternoon = '<span class="small">Booked</span>';					
				elseif($dayNum ==5 ) //no bookings on monday morning, friday afternoon
					$afternoon = '2pm';
				else
					$afternoon = '<a href="'.$url_cal.'&dy='.strtotime($thisdate).'_2">2pm</a>';		
				
				
				if($dayNum ==0 || $dayNum ==6 )
					$dayDisplay ='<div class="col-md-8 small">Weekend</div>';
				elseif(in_array(strtotime($thisdate), $blocked_dates))
					$dayDisplay ='<div class="col-md-8 small">UnAvailable</div>';
				elseif(in_array(strtotime($thisdate), $holidays))
					$dayDisplay ='<div class="col-md-8 small">Holiday</div>';
				else				
					$dayDisplay ='<div class="col-md-4">'.$morning.'</div><div class="col-md-4">'.$afternoon.'</div>';
				
				
				$calendarDisplay .= '<div class="col-md-12 '.$bg.'">
						<div class="col-md-4 small">'.$date_display.'</div>
						'.$dayDisplay.'			
					</div>';
				
			endif;
			
			$count++;
				
			} //end for
			
			echo '<div class="col-md-12 full-row iframe-400">'.$calendarDisplay.'</div>';
			
		}
	?>


</div>