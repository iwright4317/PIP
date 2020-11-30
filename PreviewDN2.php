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
	
	if (!$printer) {
		include ('./includes/js_css.inc');
	}
	?>
	<title>PIP | Daily Notifications </title>

	<script>
		$(function() {
			$(document).tooltip();
		});
	</script>
	<style>
		label {
			display: inline-block;
			width: 5em;
		}
	</style>
</head>
<body>

	<?php
	
	if (!$printer) {
	include ('./includes/banner.inc');
	}
	include ('./includes/database.inc');
	include ('./includes/database2.inc');

	if (empty($_SESSION["user_id"] )) {
		echo "<meta http-equiv='refresh' content='0; url=index_second.php' />";
	}
	
	function DisplayOptions($field) {
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " . "Group By " . $field . " Order by " . $field . "";
		$r = mysql_query($q) or die("<br/>Query failed");

		While ($row = mysql_fetch_array($r)) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		return true;
	}
		
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
	
	//$DNDate = "2015-12-02";	
	$DNDate = "";
	if (isset($_GET["DNDate"])) {$DNDate = $_GET["DNDate"];}
	if (trim($DNDate) == "") {
		if (isset($_GET["ddlDNDate"]) ) {$DNDate = $_GET["ddlDNDate"];}
	}
	
	$DNDate = DateToSQL($DNDate);
	?>

	<div class="container"  style="font-size : normal; font-weight: normal; background-color: white">

		<div class="row">
			<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
				Daily Notifications for <?php echo date_format(date_create($DNDate),"m/d/Y"); ?>
			</div>
		</div>

		<div class="row" >
			<div class="col-md-12" style="text-align: right">
			<?php
            $strSQL = "";
            $strBody = ""; 
             		
			$date = date_create($DNDate);
			$txtDate = date_format($date , "m/d/y") ; 
					
            $strSQL = "Select PIP.PermitNumber, DNDate From " . 
            "DailyNotifications, PIP " . 
            "Where " . 
            "DNDate = '" . $DNDate . "' and DailyNotifications.PermitId = PIP.Id "; 

            $strSQL = "Select PIP.PermitNumber, DNDate, PIP.Id " . 
            "From DailyNotifications, PIP Where "; 

            $txtAnd  = "";
            $DNId = 0; 

            If (isset($_GET["DNDate"]) && Trim($_GET["DNDate"]) <> "") {
                $DNDate = $_GET["DNDate"];
				$date = date_create($DNDate);
				$txtDate = date_format($date , "Y-m-d") ; 
                $strSQL = $strSQL . $txtAnd . " DNDate = '" . $txtDate . "' ";
                $txtAnd = " and ";
            }
			
			
            If (isset($_GET["ddlDNDate"]) && Trim($_GET["ddlDNDate"]) <> "") {
                $DNDate = $_GET["ddlDNDate"];
				$date = date_create($DNDate);
				$txtDate = DateToSQL($_GET["ddlDNDate"], "Y-m-d") ; 
                $strSQL = $strSQL . $txtAnd . " DNDate = '" . DateToSQL($_GET["ddlDNDate"], "Y-m-d") . "' ";
                $txtAnd = " and ";
            }            

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

            If (isset($_GET["Id"]) && Trim($_GET["Id"]) <> "") {
                $DNId = $_GET["Id"];
                $strSQL = $strSQL . $txtAnd . " DailyNotifications.Id = '" . $DNId . "' ";
                $txtAnd = " and ";
            }
			
            If ($txtAnd == " and ") {
            	if ($printer && !isset($_GET['all'])) {
            		$strSQL3 = "Select FirstName from Login Where Id = " . $_SESSION["user_id"];
            		//$strSQL3 = "Select FirstName from Login Where Id = 81";
					$r2 = mysqli_query($connection2, $strSQL3) or die("<br/>Query failed 113: " . $strSQL);
                   
					If ($row3 = mysqli_fetch_array($r2)) {
						$CurrentTec = $row3[0];
						$strSQL = $strSQL . $txtAnd . " PIP.Technician = '$CurrentTec' ";
					}          		            		
            	} else {
            		if (isset($_GET['showmine'])) {
            			
            		$strSQL3 = "Select FirstName from Login Where Id = " . $_SESSION["user_id"];
            		//$strSQL3 = "Select FirstName from Login Where Id = 81";
					$r2 = mysqli_query($connection2, $strSQL3) or die("<br/>Query failed 113: " . $strSQL);
                   
					If ($row3 = mysqli_fetch_array($r2)) {
						$CurrentTec = $row3[0];
						$strSQL = $strSQL . $txtAnd . " PIP.Technician = '$CurrentTec' ";
					}          		            		
            		}
            	}
                $strSQL = $strSQL . $txtAnd . " DailyNotifications.PermitId = PIP.Id Order by PIP.Technician, PermitNumber ";
                $CurrentPermit  = ""; 

                // Record permit numbers via PermitID

                //$PermitNumbers[10000];
				if (!$printer) {
		$ddlDNDate = "";
		
		if (isset($DNDate)) { ?>
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&showmine=yes><b>Show mine</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&printer=yes&showmine=yes><b>Print mine</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&all=yes><b>Show all</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&printer=yes&all=yes><b>Print all</b></a>&nbsp;	
			<?php
		}
		
		if (isset($_GET['Id'])) { ?>
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&showmine=yes><b>Show mine</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?Id=<?=$_GET['Id']?>&printer=yes><b>Print mine</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?DNDate=<?=$DNDate?>&all=yes><b>Show all</b></a>&nbsp;&nbsp;&nbsp;
			<a title="download your permits" href=PreviewDN2.php?Id=<?=$_GET['Id']?>&printer=yes&all=yes><b>Print all</b></a>&nbsp;	
			<?php
		}
		
				//echo "&nbsp;&nbsp;&nbsp;Jump to:<select name='select-anchor'  id='select-anchor'>";
	}
				$r = mysqli_query($connection, $strSQL) or die("<br/>Query failed 90:" . $strSQL);
				$i=0;
				While ($row = mysqli_fetch_array($r)) {
                        $PermitNumbers[$i] = $row[0];
                        $DNDate = $row[1];
						$PIPids[$i] = $row[2];
                        $i = $i + 1;
                }

                $MaxI  = $i - 1; 
                
				//echo '<br>MaxI: ' . $MaxI . ' :';

                // Record Dates Received as most recent for each permit number

                //$DatesReceived[1000];
                $i = 0;

                While ($i <= $MaxI) {
                    $strSQL = "Select DateReceived, PermitNumber " . 
                   	"From PIP Where " . 
                    "PermitNumber = '" . $PermitNumbers[$i] . "' order by DateReceived DESC"; 

					//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysql_error());
	 				$r2 = mysqli_query($connection2, $strSQL) or die("<br/>Query failed 113: " . $strSQL);
                    $CurrentPermit = "";
                    
					While ($row2 = mysqli_fetch_array($r2)) {
                            If ($row2[1] <> $CurrentPermit) {
                                $DatesReceived[$i] = $row2[0];
                                $i = $i + 1;
                            }
                            $CurrentPermit = $row2[1];
                    }
					//$i = $i + 1;					
				} 

                echo "&nbsp<br>";

                //$strBody = $strBody . "<TABLE width=100% border=1 >";

                //echo "<TABLE width=""100%"" bgcolor=""#000000"" cellspacing=""1"" cellpadding=""3"">")

                //$strBody = $strBody . "<tr bgcolor=#FFFFFF><th colspan=5><h3>&nbsp;Daily Notifications for " . date_format(date_create($DNDate),"m/d/Y") . "</h2></th></tr>";

                $Codes  = "";
                $Comma  = "";
                $Para  = "";
                $Condition  = "";
                $Location  = "";
                $Company  = "";
                $Technician  = "";
                $SignatureDate  = "";
                $NewPermit  = "";
                $BGShade = "#E0E0E0"; 
                $i = 0;

                While ($i <= $MaxI) {

					$date = date_create($DatesReceived[$i]);
					$txtDatesReceived = date_format($date , "Y-m-d") ; 
			
                    $strSQL = "Select " . 
                    "PIP.PermitNumber, CompanyName, PermitAddress, LocationDescription, StandardText, Comment, LetterCode, Technician, DateOfSignature " .
                    "From " . 
                    "ConditionMessagesComments, ConditionMessages, PIP " . 
                    "Where " . 
                    "PermitNumber = '" . $PermitNumbers[$i] . "' and DateReceived = '" . $txtDatesReceived . "' and " . 
                    "ConditionMessagesComments.PermitId = PIP.Id and " . 
                    "ConditionMessagesComments.CMId = ConditionMessages.Id " . 
                    "Order By PIP.PermitNumber, DateReceived DESC";
										
					//echo "<p>" . $strSQL . "</p>";
					$r2 = mysqli_query($connection2, $strSQL) or die("<br/>Query failed 159: " . $strSQL);
                    $CurrentPermit = "";
					$First = True;
					if ($row2 = mysqli_fetch_array($r2)) {
						
						$strBody = $strBody . "<TABLE width=100% border=1 >";
	                    $Company = $row2[1];
    	                $Technician = $row2[7]; 
	
    		            If (!empty($row2[8])) {
        		           $SignatureDate = $row2[8];
            		    } 

                		$Location = $row2[2] . " <br>" . $row2[3];
	                    $Codes = $Codes . $Comma . "<b>" . $row2[6] . "</b>";
                        $Condition = $Condition . $Para . $row2[4] . "<br> <b>" . $row2[5] . "</b>";

       	                $Comma = ", ";
           	            $Para = "<p>";
						$First = False;
						while  ($row2 = mysqli_fetch_array($r2)) {
                        	$Codes = $Codes . $Comma . "<b>" . $row2[6] . "</b>";
                        	$Condition = $Condition . $Para . $row2[4] . "<br> <b>" . $row2[5] . "</b>";
						}
                                                $strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<th style='border-top: 3px black solid; padding-left: 5px; padding-right: 5px; text-align: center'>Permit</th>
<th style='border-top: 3px black solid; padding-left: 5px; padding-right: 5px; text-align: center' colspan='4'>Street Address / Location Description</th></tr>";
                        $strBody = $strBody . "
<tr bgcolor=" . $BGShade . ">";
                        $strBody = $strBody . "
<td style='padding-left: 5px; padding-right: 5px;' align=center><a href=http://pip.vabeachpu.com/NewEdit.php?Id=" . $PIPids[$i] . ">" . $PermitNumbers[$i] . "</a></td>
<td style='padding-left: 5px; padding-right: 5px;' colspan='4'>" . $Location . "</td></tr>";
                        
                        $strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<th style='padding-left: 5px; padding-right: 5px; text-align: center'>Company</th>
<th style='padding-left: 5px; padding-right: 5px; text-align: center'>Technician</th>
<th style='padding-left: 5px; padding-right: 5px; text-align: center'>Signature</th>
<th style='padding-left: 5px; padding-right: 5px; text-align: center' colspan='2' >Codes</th></tr>";

                        $strBody = $strBody . "<tr bgcolor=" . $BGShade . ">";
                        $strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' align=center>" . $Company . "</td>";
                        $strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' align=center>" . $Technician . "</td>";						
                        $strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' align=center>" . date_format(date_create($SignatureDate),"m/d/Y") . "</td>                        
<td style='padding-left: 5px; padding-right: 5px;' colspan='2' valign=top  align=center>" . $Codes . "</td></tr>";

                        $strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<th style='border-top: 2px black solid; padding-left: 5px; padding-right: 5px; text-align: center' colspan='5'>Conditions</th></tr>";

                        $strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<td style='border-bottom: 2px black solid;  padding-left: 5px; padding-right: 5px;' colspan=5>";                        
                       
                        $strBody = $strBody . "" . nl2br($Condition);
                        
			if (isset($PermitNumbers[$i+1])) {
				$strBody = $strBody . "<div id='" . $PermitNumbers[$i+1] . "'></div>";
			}
			if (isset($Technicians[$i+1])) {
				if ($CurrentTechnician <> $Technicians[$i]) {
					$strBody = $strBody . "<div id='" . $Technicians[$i+1] . "'></div>";
				}
				$CurrentTechnician = $Technicians[$i];
			}  
			
                        $strBody = $strBody . "</td></tr>";					
						
						
		$query2 = "Select DNSubmissions.Contractor, DNSubmissions.contactPerson, 
		phone, dateOfWork, period,
		Atime, Location, Trench, Bore, Open_Cut, Test_Hole, Final_Patch, 
			Dig_in_Dirt, Landscape_Clean_up, Aerial, Tree_Trimming,
			Traffic_Only, Blanket, Additional from DNSubmissions, DNDetails 
		Where DNSubmissions.Id = SubmissionId and 		
		DNDetails.permit_number = '" . $PermitNumbers[$i] . "' ";
		
		$query2 = "Select DNSubmissions.Contractor, DNSubmissions.contactPerson, 
		DNSubmissions.phone, DNSubmissions.dateOfWork, period, Atime, Location, Trench, Bore, 
		Open_Cut, Test_Hole, Final_Patch, Dig_in_Dirt, Landscape_Clean_up, 
		Aerial, Tree_Trimming, Traffic_Only, Blanket, Additional from DNSubmissions, 
		DNDetails Where DNSubmissions.Id = SubmissionId and 
		DNDetails.permit_number = '" . $PermitNumbers[$i] . "' and 
		DNSubmissions.dateOfWork = '" . date_format(date_create($DNDate),"Y-m-d") . "' "; 
		
		if ($db) {echo "<br>" . $query2;}
		$Contractor = "";
		$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection));
		While ($row2 = mysqli_fetch_array($result2)) {				
			//$DNDId = $row2["Id"];		
			$Contractor =  $row2["Contractor"]; 
			if ($db) {echo "|$row2[Contractor]|";}
			$contactPerson =  str_replace("'","''",$row2["contactPerson"]); 
			$phone =  $row2["phone"]; 
			$dateOfWork =   date_format(date_create($row2["dateOfWork"]),"m/d/Y");
			$period =  $row2["period"]; 
			$Atime =  $row2["Atime"]; 
			$Location =  $row2["Location"]; 
			$Trench =  $row2["Trench"] == "yes" ? ", Trench" : "";  
			$Bore =  $row2["Bore"] == "yes" ? ", Bore" : ""; 
			$Open_Cut =  $row2["Open_Cut"] == "yes" ? ", Open Cut" : ""; 
			$Test_Hole =  $row2["Test_Hole"] == "yes" ? ", Test Hole" : ""; 
			$Final_Patch =  $row2["Final_Patch"] == "yes" ? ", Final Patch" : ""; 
			$Dig_in_Dirt =  $row2["Dig_in_Dirt"] == "yes" ? ", Dig in Dirt" : ""; 
			$Landscape_Clean_up =  $row2["Landscape_Clean_up"] == "yes" ? ", Landscape Clean up" : ""; 
			$Aerial =  $row2["Aerial"] == "yes" ? ", Aerial" : ""; 
			$Tree_Trimming =  $row2["Tree_Trimming"] == "yes" ? ", Tree Trimming" : ""; 
			$Traffic_Only =  $row2["Traffic_Only"] == "yes" ? ", Traffic Only" : ""; 
			$Blanket =  $row2["Blanket"] == "yes" ? ", Blanket" : ""; 
			$Additional =  str_replace("'","''",$row2["Additional"]);	
			
			$Work = "$Trench $Bore $Open_Cut $Test_Hole $Final_Patch 
			$Dig_in_Dirt $Landscape_Clean_up $Aerial $Tree_Trimming 
			$Traffic_Only $Blanket"; 
			$FC = strpos($Work,",");
			$FC++;
			$Work = substr($Work, $FC); //trim($Work);
$strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<th style='padding-left: 5px; padding-right: 5px;' colspan=2>Contractor</th>
<th style='padding-left: 5px; padding-right: 5px;'>Contact Person</th>
<th style='padding-left: 5px; padding-right: 5px;'>Phone</th>
<th style='padding-left: 5px; padding-right: 5px;'>Location</th></tr>";

$strBody = $strBody . "<tr bgcolor=" . $BGShade . ">";
$strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' colspan=2>" . $Contractor . "</td>";
$strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' >" . $contactPerson . "</td>";
$strBody = $strBody . "<td style='padding-left: 5px; padding-right: 5px;' >" . $phone . "</td>		
<td style='padding-left: 5px; padding-right: 5px;' valign=top  align=left>" . $Location . "</td></tr>";


$strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<th style='padding-left: 5px; padding-right: 5px;' valign=bottom>Start</th>";
$strBody = $strBody . "<th style='padding-left: 5px; padding-right: 5px;' colspan=3 valign=bottom>Work</th>
<th style='padding-left: 5px; padding-right: 5px;' colspan=1 valign=bottom>Additional Information</th></tr>";

$strBody = $strBody . "<tr bgcolor=" . $BGShade . ">
<td style='padding-left: 5px; padding-right: 5px;' >$dateOfWork $Atime&nbsp;$period</td>
<td style='padding-left: 5px; padding-right: 5px;' colspan=3 valign=top  align=left>" . $Work . "</td>
<td style='padding-left: 5px; padding-right: 5px;' colspan=1 valign=top  align=left>" . $Additional . "</td>";
$strBody = $strBody . "</tr>";
						
		}
						
                        $Codes = "";
                        $Condition = "";
                        $Comma = "";
                        $Para = "";
                        $SignatureDate = "";
						$strBody = $strBody . "</table>";					
						if ($printer) {$strBody = $strBody . '<br style="page-break-before: always">';}
                    } 
                    If ($First) { // No open permit record for this permit number
                        $strBody = $strBody . "<tr bgcolor=" . $BGShade . "><td colspan=7><b>Error: No open permit record for permit number: " . 
                        $PermitNumbers[$i] . "</b><br>" . "Check: <br>" . 
                        "A missing permit record for permit " . $PermitNumbers[$i] . "<br>" . 
                        "A permit record was mistakenly closed </br>" . 
                        "Un-approved contractor work is being requested <br>" . 
                        "No condition code assigned to active permit record</td></tr>";
                    }
					
                    If ($BGShade == "#E0E0E0") {
                       $BGShade = "#FFFFFF";
                    } else {
                       $BGShade = "#E0E0E0";
                    }

                    $i = $i + 1;
                } 

                //$strBody = $strBody . "<table>";

                echo $strBody;

					
				if ($admin) { 	
                echo "&nbsp;<p><b><a href=PreviewDN2.php?Send=yes&DNDate=" . $DNDate . ">Send Daily Notifications </a></b>";
				}
                If (isset($_GET["Send"]) && Trim($_GET["Send"]) == "yes") {
                	echo "<p><h3>Sending Daily Notification emails... </h3>";
                    $strSQL = "Select Emails From DNEmails"; 
					$r2 = mysqli_query($connection2, $strSQL) or die("<br/>Query failed 223: " . $strSQL);
                    $CurrentPermit = "";
					If  ($row2 = mysqli_fetch_array($r2)) {
                        $strBody = "<body bgcolor=FloralWhite><html>" . $strBody . "</body></html>";
						$username = "iwright";
                        $FromAddress  = $username . "@vbgov.com";
                        $mail_to = $row2[0]; 

                        $title = "PIP Daily Notification...";
                        $strBody = "<html><body bgcolor=FloralWhite>" . $strBody . "</body></html>";		
						$headers = "";							
						
 						// Always set content-type when sending HTML email
 						$headers = "MIME-Version: 1.0" . "\r\n";
 						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

 						// More headers
 						//$headers .= 'From: <webmaster@example.com>' . "\r\n";
 						//$headers .= 'Cc: myboss@example.com' . "\r\n";
			
						// double check to make sure user is valid to send emails
						if (is_numeric($_SESSION["user_id"]) && 
							$_SESSION["user_id"] > 0 && 
							$_SESSION["user_id"] == round($_SESSION["user_id"], 0)) {
								
							$q = "Select UserName, Id, SecurityLevel,Passcode from Login Where Id = " . $_SESSION["user_id"];
							$r = mysqli_query($connection, $q) or die("<br/>Query failed");
							if ($row = mysqli_fetch_array($r)) {								
								mail($mail_to, $title, $strBody, $headers);
								echo '<br>:' . $mail_to;
                        		echo "<p><h3>Email sent to Daily Notification Group</h3>";								
							}
						}
                    } else {

                        echo "<p><font size=5>No Emails in Daily Notification Group, click PIP Administration </font>";

                    }

                }

            } else {

                echo "<p>You must save the Daily Notification before you can view it";

            }
			//Daily Notification Date:
			?>
				
			</div>
			<?php If (1 == 2) { ?>
			<div class="col-md-1">				
				<input type="text" value=<?php echo date_format(date_create($DNDate),"m/d/Y"); ?> name="DNDate">
			</div>
			<div class="col-md-2">
				<button>
					use new date
				</button>
			</div>
			<?php
			}
			?>
		</div>
<?php If (1 == 2) { ?>
		<div class="row">
			<div class="col-md-2" style="text-align: right">
				Enter Permit Number:
			</div>
			<div class="col-md-2" >
				<input type="text" name="txtPermitNumber">
			</div>
			<div class="col-md-2">
				<button>
					//Add to list
				</button>
			</div>
			<div class="col-md-3">
				<button>
					//Save This Daily Notifications
				</button>
			</div>
		</div>


		<div class="row">
			<div class="col-md-2" >
			</div>
			<div class="col-md-2" style="background-color: whitesmoke"><?php		
				
				$strSQL = "Select PermitNumber From PIP, DailyNotifications Where PIP.Id = DailyNotifications.PermitId and DNDate = '" . $DNDate . "' order by PermitNumber  ";
				
				$q = $strSQL;
				//$r = mysql_query($q) or die("<br/>Query failed 292: " . $q);
				$r = mysqli_query($connection, $strSQL) or die("<br/>Query failed 223: " . $strSQL);
                    
				$i=0;
				While ($row = mysqli_fetch_array($r)) {
					//echo '<input type="checkbox" name="p'.$i.'">&nbsp;'.$row[0].'<br>';
				} ?>
				<button>Delete checked permits</button>
			</div>
			<div class="col-md-6" >
				<div class="row" >
					&nbsp;<a href="PreviewDN2.php" >View and Finalize Daily Notifications Report</a>
				</div>

				<div class="row">
					<div class="col-md-12" >
						&nbsp;
					</div>
				</div>

				<div class="row">
					<form href=PreviewDN2.php>
					<div class="col-md-4" >
					<select name="ddlDNDate" style="width:100%; height:26px;">
						<option></option>
						<?php
						$q = "Select DNDate, Count(DNDATE) From DailyNotifications Group by DNDATE Order by DNDate DESC";
						//$r = mysql_query($q) or die("<br/>Query failed 316: " . $q);
						$r = mysqli_query($connection, $q) or die("<br/>Query failed 223: " . $strSQL);
                    
						While ($row = mysqli_fetch_array($r)) {
							echo '<option>'.date_format(date_create($row[0]),"m/d/Y").'</option>';
							//echo '<option>' . $row[0] . '</option>';
						} ?>
					</select>
					</div>
					<div class="col-md-6" >
						<button>View Previous Daily Notifications Report</button> 
					</div>
					</form>
				</div>

			<div class="row">
				<div class="col-md-5" >
					Filter by Permit Number:
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-3" >		
					Permit Number:
				</div>
				<div class="col-md-2" >		
					<input type="text" name="TextBox1" style="width:100%">
				</div>
				<div class="col-md-2" >		
					<select name="ddlPermitNumber" style="width:100%; height:26px;">
						<option></option>
						<?php
						
						$time = strtotime("-14 months", time());
  						$date = date("Y-m-d", $time);  
						$q = "SELECT PermitNumber " .
    					"FROM PIP Where PermitNumber is not null and DateReceived >= '" . $date . "' " . 
    					"Order by PermitNumber";	
						echo "<br>" . $strSQL . "<br>";					

						//$r = mysqli_query($q) or die("<br/>Query failed");
						$r = mysqli_query($connection, $strSQL) or die("<br/>Query failed 223: " . $strSQL);
                    
	
						While ($row = mysqli_fetch_array($r)) {
							echo "<option value=$row[0]>$row[0]</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<?php	
		function DateToSQL($ADate) {			
			$date = date_create($ADate);
			return date_format($date , "Y-m-d") ; 	
		}				
	?>
</body>