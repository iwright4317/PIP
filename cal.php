<?php
session_start();

if (isset($_GET['printer'])) {
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");
	$printer = True;
} else {
	$printer = False; 
}

?>

<head>
	<?php
	include ('./includes/js_css.inc');	 
	include ('./includes/database.inc');
	?>
	
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});
	</script>
	
</head>
<body>
	<?php	
	include ('./includes/calbanner.inc');

$Events = 0;
$Detail = '';

$strLastDay = '';
$strTitle = '';
$strURL = '';
$dtmPrev = '';
$DetailParam = '';
$intMonth = 0;
$intYear = 0;
$dtmNext = '';
$strFirstDay = '';
$intNumberOfDays = 0;
$strCurrentDay = '';
$intDay = 0;

$strDaysInMonths  = '';
$strDate = '';
$strMonthName  = '';
//$strStyle  = '';
$strMethod  = '';
$X; $Y; $Z;
$TempDate = '';

$intDay = 1;
$intMonth = 1;
$intYear = 2017;
$CurrentCycle = 1;
$intCycles = 20;
$ReadDays = array();
$ReadDates = array();
$CycleIndex = array();
$ReadDaysAdd = array();
$ReadDatesAdd = array();
$maxDays = 0;
$maxDays2 = 0;
$minDays = 500;
$isStartDate = false;
$startdate = "";
$startcycle = 1;
$OK = true;
$firstRun = false;

$pullDays = array();
$a=0;
$maxA=0;

$pushDays = array();
$p=0;
$maxP=0;

$monthreset = false;
$db = True;
$db = False;

if (isset($_POST['submit'])) {
	extract($_POST);  
	
	if (isset($_POST[startdate])) {
		$q = "Delete From Cal where user = '$_SESSION[user_name]' and action = 'startdate'";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);	
		
		$startdate = date('n/j/Y', strtotime($_POST[startdate]));
		$q = "Insert into Cal (Action,aValue,user) values ('startdate',
		'$startdate','$_SESSION[user_name]')";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);
	}
	
	if (isset($_POST[startcycle])) {
		$q = "Delete From Cal where user = '$_SESSION[user_name]' and action = 'startcycle'";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);	

		$startcycle = $_POST[startcycle];
		$q = "Insert into Cal (Action,aValue,user) values ('startcycle',
		'$_POST[startcycle]','$_SESSION[user_name]')";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);
	}
		
		
}
	
If (isset($_GET['action'])) {
	if (trim($_GET['action']) == "cycles" || trim($_GET['action']) == "monthreset") {
		$q = "Delete from Cal where user = '$_SESSION[user_name]' and Action = '$_GET[action]'";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);
	}
	
	if (trim($_GET['action']) == "remove") {
		$q = "Delete From Cal where user = '$_SESSION[user_name]' and  Action = '$_GET[item]' and aValue = '$_GET[value]'";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);
	}
	
	if (trim($_GET['action']) == "reset") {
		$q = "Delete From Cal where user = '$_SESSION[user_name]'";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);		
	} else {		
		$q = "Insert into Cal (Action,aValue,user) values ('$_GET[action]',
		'$_GET[value]','$_SESSION[user_name]')";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);
	}
}

$q = "Select * from Cal where user = '$_SESSION[user_name]' ";
$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);

while ($row = mysqli_fetch_array($r)) {
	if ($row['Action'] == "cycles") {
		$intCycles = $row['aValue'];
	}
	if ($row['Action'] == "monthreset") {
		if ($row['aValue'] == 'false') {$monthreset = false;}
		else {$monthreset = true;}
	}
	if ($row['Action'] == "add" || $row['Action'] == "pull") {		
		$pullDays[$a] = $row["aValue"];
		$a++;
	}	
	if ($row['Action'] == "push") {		
		$pushDays[$p] = $row["aValue"];
		$p++;
	}	
	
	if ($row['Action'] == "startdate") {
		$startdate = $row["aValue"];
		$isStartDate = true;
		$OK = false;
	}
	
	if ($row['Action'] == "startcycle") {
		$startcycle = $row["aValue"];
	}

}
$maxA = $a - 1;
$maxP = $p - 1;

	?>
	
	<div class="container" style='font-size medium; font-weight: normal;'> <?php
		if (!isset($_GET['printer'])) { ?>
		<div class="row">
			<div class="col-sm-12" style='text-align:center; font-size: medium; font-weight: normal;'>
				<div style="font-size: xx-large">Read Calendar</div>
				<a href=cal.php>Refresh</a>&nbsp;&nbsp;
				<a href=cal.php?action=reset>Reset</a>&nbsp;&nbsp;
				Read cycles: <?php
				if ($intCycles == 18) { ?>
					<a href=cal.php?action=cycles&value=18><b>18</b></a>&nbsp; <?php
				} else { ?>
					<a href=cal.php?action=cycles&value=18>18</a>&nbsp; <?php	
				}		

				if ($intCycles == 19) { ?>
					<a href=cal.php?action=cycles&value=19><b>19</b></a>&nbsp; <?php
				} else { ?>
					<a href=cal.php?action=cycles&value=19>19</a>&nbsp; <?php	
				}		

				if ($intCycles == 20) { ?>
					<a href=cal.php?action=cycles&value=20><b>20</b></a>&nbsp; <?php
				} else { ?>
					<a href=cal.php?action=cycles&value=20>20</a>&nbsp; <?php	
				}		

				if ($intCycles == 21) { ?>
					<a href=cal.php?action=cycles&value=21><b>21</b></a>&nbsp; <?php
				} else { ?>
					<a href=cal.php?action=cycles&value=21>21</a>&nbsp; <?php	
				}		

				if ($monthreset) { ?>
					<a href=cal.php?action=monthreset&value=false><b>Monthly reset</b></a>&nbsp;&nbsp; <?php
				} else { ?>
					<a href=cal.php?action=monthreset&value=true>Monthly reset</a>&nbsp;&nbsp; <?php
				} ?>				
				<a href=cal.php?printer=yes>Word version</a>&nbsp;&nbsp;
				<a href=#summary>Summary</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" style='text-align:center; font-size: medium; font-weight: normal;'>
				
				<form action="" method="POST" name="login"> <?php
					if (isset($startdate) && trim($startdate) <> "") { ?>
					<input style="width: 100px" value="<?php echo $startdate;?>" id="datepicker" type="text" name="startdate" placeholder="Start date">&nbsp;
					<input style="width: 100px" value="<?php echo $startcycle;?>" type="text" name="startcycle" placeholder="Start cycle">&nbsp; <?php
					} else { ?>   
					<input style="width: 100px" id="datepicker" type="text" name="startdate" placeholder="Start date">&nbsp;
					<input style="width: 100px" type="text" name="startcycle" placeholder="Start cycle">&nbsp; <?php
					}  ?>          					                   
                	&nbsp;<button type="submit" name="submit">
                		set start
                	</button> 
				</form>
			</div>
		</div>
		<?php
		} ?>
				
		<div class="row">
			<div class="col-sm-12" style='text-align:center; font-size: xx-large; font-weight: bold;'>
				
<?
$Today = date('n/j/Y');
//echo "<br>Today: $Today";
while ($intMonth <= 12) {

    $strFirstDay = $intMonth . "/1/" . $intYear;
	
    $strDate = $strFirstDay;
	
    // create string of days in months 
    if(date('L', mktime(0, 0, 0, $intMonth, 1, $intYear))) { 
        $strDaysInMonths = "312931303130313130313031";
    } else {
        $strDaysInMonths = "312831303130313130313031";
    }
    
	$dateObj   = DateTime::createFromFormat('!m', $intMonth);
	$strMonthName = $dateObj->format('F'); // March

    $intNumberOfDays = intval(substr($strDaysInMonths, (($intMonth - 1) * 2), 2));
    $strLastDay = $intMonth . "/" . $intNumberOfDays . "/" . $intYear;
    // build the page title 
    $strTitle = $strMonthName . " " . $intYear;
	echo "$strTitle";
	
    echo "<table border='1' cellpadding='2' cellspacing='2' width='100%'>";
    echo "<tr>";
    // print the weekday names 
    $days = [1 => 'Sunday',  2 => 'Monday',  3 => 'Tuesday',  4 => 'Wednesday',  5 => 'Thursday',  6 => 'Friday',  7 => 'Saturday'];
    $X = 1;
    while ($X <= 7) {
        echo "<th width='14%'>" . $days[$X] . "</th>";
        $X++;
    }
    echo "</tr>";
    echo "<tr>";
	
    // print empty table cells for the beginning days not in the current month 	
    if (date('w', strtotime($strFirstDay)) > 0) {		
        For ($X = 1;  $X <= date('w', strtotime($strFirstDay)); $X++) {
			echo "<td style='padding-left: 5px; padding-right: 5px;' >&nbsp;</td>";
		}
    }	
	
    // loop through the days in the current month 
    if ($monthreset) { 
    	$CurrentCycle = 1;
    }	

    For ($X = 1; $X <= $intNumberOfDays; $X++) {
        // get the day we're working on 
        $strCurrentDay = $intMonth . "/" . $X . "/" . $intYear;
        // start the table cell for a day 

        // Set background color
        $stBackGround  = "background-color:white";
		
        if(date('w', strtotime($strCurrentDay)) > 0 And date('w', strtotime($strCurrentDay)) < 6) {
			$stBackGround = 'background-color:whitesmoke';
        }
		$holiday = IsHoliday($strCurrentDay);
        if(trim($holiday) <> "") {$stBackGround = 'background-color:lightgreen';}
		
		
        if($strCurrentDay == $Today) { $stBackGround = 'background-color:yellow'; }
		
		if (isset($startdate) && trim($startdate) <> "" 
			&& $startdate == $strCurrentDay && !$OK) {
			$firstRun = true;
			$OK = True;
			$CurrentCycle = $startcycle;
			$c = 1;
			while ($c <= $intCycles) {
				$m = 1;
				while ($m <= 14) {				
  		      		$ReadDates[$c][$m] = "";
        			$ReadDays[$c][$m] = 0; 
					$m++;	
				}
				$c++;
			}
		}			        

        // CycleIndex - The current cycle read count for the year per cycle
        // ReadDates - The read dates for each cycle for the year
        // ReadDays - The number of days between reads 

        // Array (cycle # , month)

        $rDays = 0;
		
		$pullDay = False;
		$a=0;
		while ($a <= $maxA) {
			if ($pullDays[$a] == $strCurrentDay) {
				$pullDay = True;
			}
			$a++;		
		}
		
		$pushDay = False;
		$p=0;
		while ($p <= $maxP) {
			if ($pushDays[$p] == $strCurrentDay) {
				$pushDay = True;
			}
			$p++;		
		}
		
		// Check for weekday
        if($CurrentCycle > 0 and !$pushDay and 
        (date('w', strtotime($strCurrentDay)) > 0 And 
        date('w', strtotime($strCurrentDay)) < 6) || $pullDay) {
			if(trim($holiday) == "" || $pullDay) {
				echo "<td style='padding-left: 5px; padding-right: 5px; $stBackGround' id='$X' align='left' valign='top' >";
        		echo "<a name='$X'><b>$X</b></a>&nbsp;";
        		if (!$printer && $OK) {
        		echo "<a href=cal.php?action=push&value=$strCurrentDay>push</a>&nbsp;
        		<a href=cal.php?action=pull&value=$strCurrentDay>pull</a>";
				}
        		echo "<br>$holiday";
				
				$pullCount = 1;
				$pull = false;
				if ((date('w', strtotime($strCurrentDay)) > 0 And 
		        date('w', strtotime($strCurrentDay)) < 6) && $pullDay && trim($holiday) == "") {
        			$pullCount = 2;
        			//$pull = true;
				}				
				
				while ($pullCount >= 1) {
					if (isset($CycleIndex[$CurrentCycle])) {
		    			$CycleIndex[$CurrentCycle] = $CycleIndex[$CurrentCycle] + 1;
					} else {
						$CycleIndex[$CurrentCycle] = 1;
					}
    				$ReadDates[$CurrentCycle][$CycleIndex[$CurrentCycle]] = $strCurrentDay;
    				$rDays = 0;
    				if($CycleIndex[$CurrentCycle] > 1) {
        				$date1 = new DateTime($ReadDates[$CurrentCycle][$CycleIndex[$CurrentCycle] - 1]);
						$date2 = new DateTime($ReadDates[$CurrentCycle][$CycleIndex[$CurrentCycle]]);
						$rDays = $date2->diff($date1)->format("%a");
						if ($rDays > $maxDays) {
							$maxDays2 = $maxDays;
							$maxDays = $rDays;
						}
						if ($rDays < $minDays) {$minDays = $rDays;}						
    				}
					
		    		if ($OK) {
		    			$ReadDays[$CurrentCycle][$CycleIndex[$CurrentCycle]] = $rDays;     				
    					echo "<br>Read Cycle " . $CurrentCycle . "<br>";
   						if (!$firstRun) {echo $rDays . " day billing cycle"; }
					}
					
					If ($CurrentCycle == $startcycle - 1 && $firstRun) {
						$firstRun = false;
					}						
						
    				$CurrentCycle = $CurrentCycle + 1;				
    				if($CurrentCycle > $intCycles) {
	    				if ($monthreset) {
    						$CurrentCycle = 0; 
						} else {
    	    				$CurrentCycle = 1;
						}
    				}
					$pullCount = $pullCount - 1;   								 
    			}
				if ($pullDay && $OK) {echo "<br><a href=cal.php?action=remove&item=pull&value=$strCurrentDay>remove pull</a>";}
				
			} else {
    			echo "<td style='padding-left: 5px; padding-right: 5px; $stBackGround' id='$X' align='left' valign='top' >";
        		echo "<a name='$X'><b>$X</b></a>&nbsp;";        		
        		if (!$printer && $OK) {
        			echo "<a href=cal.php?action=pull&value=$strCurrentDay>add</a>";
				}
        		echo "<br>$holiday";		
			}
		} else { // weekend day	or push		
			echo "<td style='padding-left: 5px; padding-right: 5px; $stBackGround' id='$X' align='left' valign='top' >";
        	echo "<a name='$X'><b>$X</b></a>&nbsp;";    		
        		if (!$printer && $OK) {
        			echo "<a href=cal.php?action=pull&value=$strCurrentDay>add</a>";
       			}
       			echo "<br>$holiday";
				if ($pushDay && $OK) {echo "<br>Push day
				<br>
				<a href=cal.php?action=remove&item=push&value=$strCurrentDay>remove push</a>";}
				if ($pullDay && $OK) {echo "<br><a href=cal.php?action=remove&item=pull&value=$strCurrentDay>remove pull</a>";}				
		}
        // end the table cell for a day 
        echo "</td>";
		
        // if(the current day is then end of a week then output the end of the table row   
        if(date('w', strtotime($strCurrentDay)) == 6 And $strCurrentDay <> $strLastDay) {
			echo "</tr>&nbsp;<tr>"; 
        }
    
	} // for loop
	
    // print empty table cells for the ending days not in the current month 
    if(6 - date('w', strtotime($strLastDay))) {
        For ($X = 1; $X <= 6 - date('w', strtotime($strLastDay)); $X++) {
			echo "<td style='padding-left: 5px; padding-right: 5px;' >&nbsp;</td>";
		}
    }

    echo "</tr>";
    echo "</table>";
	echo '<br style="page-break-before: always">';
    $intMonth = $intMonth + 1;
	
	
}


// Output data in tabular form
$icycle = 1;

// Array (cycle # , month)?>
<a name='summary'></a> <div style="font-size: medium; text-align: left"><a href=#Top>Return to the Top</a></div><?php
echo "&nbsp<p><div style='text-align:center; font-size:x-large;'>Tabular Form</div>";
echo "<table border='1' cellpadding='2' cellspacing='2' width='100%'>";
echo "<tr><td style='padding-left: 5px; padding-right: 5px;' >&nbsp;</td>
<td style='padding-left: 5px; padding-right: 5px;' colspan=14>Cycle Reads - Day range: $minDays - $maxDays</td></tr>";
echo "<tr><td style='padding-left: 5px; padding-right: 5px;' >cycle</td>";
$imonth = 1;
while ($imonth <= 14) {
	echo "<td style='padding-left: 5px; padding-right: 5px;' >$imonth</td>";
	$imonth++;
}
echo "</tr>";
$bValue = $maxDays2 - 1;
while ($icycle <= $intCycles) {
    $imonth = 1;
    echo "<tr>";
    echo "<td style='padding-left: 5px; padding-right: 5px;' >" . $icycle . "</td>";
    while ($imonth <= 14) {
        $bDays = '';
        $ebDays = '';
        if(isset($ReadDays[$icycle][$imonth]) && $ReadDays[$icycle][$imonth] >= $bValue) {
			$bDays = "<b>";
			$ebDays = "</b>";
        }

		if (isset($ReadDays[$icycle][$imonth]) && $ReadDays[$icycle][$imonth] > 0) {			
 	       echo "<td style='padding-left: 5px; padding-right: 5px;' >" . $bDays . 
			$ReadDays[$icycle][$imonth] . " days" . $ebDays . "<br>" . 
			$ReadDates[$icycle][$imonth];        
        	echo "</td>";
		} else {
			echo "<td>&nbsp;</td>";
		}
        $imonth = $imonth + 1;
    }
    echo "</tr>";
    $icycle = $icycle + 1;
}

echo "</table>";

function IsHoliday($TestDate) {
	$db = False;
	if ($db) {echo "<br>TestDate $TestDate";}
	
	$ThisYear = date('Y', strtotime($TestDate));
	if ($db) {echo "<br>This year $ThisYear";}
	
	$Holidays = array();
	$holidayCount = 0;
	
	$Holidays[$holidayCount][0] = "New Year's Day";
	$holiday = "1/1/" . $ThisYear;
	if(date('w', strtotime($holiday)) == 6) {$holiday = "12/31/" . $ThisYear - 1;} // on a Saturday
	if(date('w', strtotime($holiday)) == 0) {$holiday = "1/2/" . $ThisYear;} // on a Sunday
	$Holidays[$holidayCount][1] = $holiday;
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Martin Luther King Day";
	$holiday = "1/1/" . $ThisYear;
	$MondayCount = 0;
	if(date('w', strtotime($holiday)) == 1) $MondayCount = 1;
	while ($MondayCount < 3) {
		$holiday = date('n/j/Y', strtotime($holiday . ' +1 day'));
		if(date('w', strtotime($holiday)) == 1) {$MondayCount++;}		
	} 
	$Holidays[$holidayCount][1] = $holiday;
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Memorial Day";
	$holiday = "5/31/" . $ThisYear;
	While (date('w', strtotime($holiday))  <> 1) {
		$holiday = date('n/j/Y', strtotime($holiday . ' -1 day'));
	}
	$Holidays[$holidayCount][1] = $holiday;
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Independence Day";
	$holiday = "7/4/" . $ThisYear;
	if(date('w', strtotime($holiday)) == 6) {$holiday = "7/3/" . $ThisYear;} // on a Saturday
	if(date('w', strtotime($holiday)) == 0) {$holiday = "7/5/" . $ThisYear;} // on a Sunday
	$Holidays[$holidayCount][1] = $holiday;	
	
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Labor Day";
	$holiday = "9/1/" . $ThisYear;
	$MondayCount = 0;
	if(date('w', strtotime($holiday)) == 1) $MondayCount = 1;
	while ($MondayCount == 0) {
		$holiday = date('n/j/Y', strtotime($holiday . ' +1 day'));
		if(date('w', strtotime($holiday)) == 1) {$MondayCount++;}			
		if ($db) {echo "<br>MondayCount after $MondayCount";	}
	} 
	$Holidays[$holidayCount][1] = $holiday;	

	$holidayCount++;
	$Holidays[$holidayCount][0] = "Veteran's Day";
	$holiday = "11/11/" . $ThisYear;
	if(date('w', strtotime($holiday)) == 6) {$holiday = "11/10/" . $ThisYear;} // on a Saturday
	if(date('w', strtotime($holiday)) == 0) {$holiday = "11/12/" . $ThisYear;} // on a Sunday
	$Holidays[$holidayCount][1] = $holiday;
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Thanksgiving Day";
	$holiday = "11/1/" . $ThisYear;
	$ThursdayCount = 0;
	if(date('w', strtotime($holiday)) == 4) $ThursdayCount = 1;
	while ($ThursdayCount < 4) {
		$holiday = date('n/j/Y', strtotime($holiday . ' +1 day'));
		if(date('w', strtotime($holiday)) == 4) {$ThursdayCount++;}		
	} 
	$Holidays[$holidayCount][1] = $holiday;	
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Day after Thanksgiving";
	$holiday = date('n/j/Y', strtotime($holiday . ' +1 day'));
	$Holidays[$holidayCount][1] = $holiday;		
	
	$holidayCount++;
	$Holidays[$holidayCount][0] = "Christmas Day";
	$holiday = "12/25/" . $ThisYear;
	if(date('w', strtotime($holiday)) == 6) {$holiday = "12/24/" . $ThisYear - 1;} // on a Saturday
	if(date('w', strtotime($holiday)) == 0) {$holiday = "12/26" . $ThisYear;} // on a Sunday
	$Holidays[$holidayCount][1] = $holiday;
	
	$holiday = "12/24/" . $ThisYear;
	if(date('w', strtotime($holiday)) <> 5 And 
		date('w', strtotime($holiday)) <> 6 And date('w', strtotime($holiday)) <> 0 ) {		
		$holidayCount++;
		$Holidays[$holidayCount][0] = "Christmas Eve (1/2 day)";
		$Holidays[$holidayCount][1] = $holiday;
	}	
		
	$isHoliday = False;
	$h = 0;
	while ($h <= $holidayCount) {
		if ($Holidays[$h][1] == $TestDate)	{
			$isHoliday = True;
			$holiday = $Holidays[$h][0];
		}	
		$h++;		
	} 
	
	if ($isHoliday) {
		return $holiday;
	} else {
		return ;
	}
} 
        
?>		
 </div>	
 </div>	
 </div>
</body>