
<?php
function SQLDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "Y-m-d") ; 	
}
						
function DisplayDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "m/d/Y") ; 	
}
				
include ('./includes/database.inc');
//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
if (1==1){
?>
<div class="container" style="font-size: normal; background-color: whitesmoke">
	<div class="row">
	<div class="col-sm-12" style="font-size: normal; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
<?php
}
$Id = 0;
$PreExisting = FALSE;


if (1 == 1) {
	if (trim($_GET["Id"]) == "") {		// Attempt new record
		// Check for pre-existing record
		$query = "Select * from DNDetails where 
		utilityCompany = '" . str_replace("'","''",$_POST["utilityCompany"]) . "' and 
		Contractor = '" . str_replace("'","''",$_POST["Contractor"]) . "' and 
		dateOfWork = '" . $_POST["dateOfWork"] . "' and 
		Location = '" . str_replace("'","''",$_POST["Location"]). "' and 
		Atime = '" . $_POST["Atime"] . "' ";
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$Id = $row["Id"];
			$PreExisting = TRUE;
		}
		if (!$PreExisting) { // no pre-existing -> Insert new record
			$query = "Insert into DNDetails ( 
			utilityCompany, Contractor, contactPerson, phone, dateOfWork, permit_number,
			period, Atime, Location, Trench, Bore, Open_Cut, Test_Hole, Final_Patch,
			Dig_in_Dirt, Landscape_Clean_up, Aerial, Tree_Trimming, Traffic_Only,
			Blanket, Additional, StreetAddress) values ( " . 
			"  '" . str_replace("'","''",$_POST["utilityCompany"]) . "' , " .
			"  '" . str_replace("'","''",$_POST["Contractor"]) . "' , " .
			"  '" . str_replace("'","''",$_POST["contactPerson"]) . "' , " .
			"  '" . $_POST["phone"] . "' , " .
			"  '" . SQLDate($_POST["dateOfWork"]) . "' , " .
			"  '" . $_POST["permit_number"] . "' , " .
			"  '" . $_POST["period"] . "' , " .
			"  '" . $_POST["Atime"] . "' , " .
			"  '" . $_POST["Location"] . "' , " .
			"  '" . $_POST["Trench"] . "' , " .
			"  '" . $_POST["Bore"] . "' , " .
			"  '" . $_POST["Open_Cut"] . "' , " .
			"  '" . $_POST["Test_Hole"] . "' , " .
			"  '" . $_POST["Final_Patch"] . "' , " .
			"  '" . $_POST["Dig_in_Dirt"] . "' , " .
			"  '" . $_POST["Landscape_Clean_up"] . "' , " .
			"  '" . $_POST["Aerial"] . "' , " .
			"  '" . $_POST["Tree_Trimming"] . "' , " .
			"  '" . $_POST["Traffic_Only"] . "' , " .
			"  '" . $_POST["Blanket"] . "' , " .
			"  '" . $_POST["Additional"] . "' , " .
			"  '" . $_POST["StreetAddressH"] . "')";
			//echo "|" . $query . "|";
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			
			// Get Id of new record
			$query = "Select * from DNDetails where 
			utilityCompany = '" . str_replace("'","''",$_POST["utilityCompany"]) . "' and 
			Contractor = '" . str_replace("'","''",$_POST["Contractor"]) . "' and 
			dateOfWork = '" . SQLDate($_POST["dateOfWork"]) . "' and 
			Location = '" . str_replace("'","''",$_POST["Location"]) . "' and 
			Atime = '" . $_POST["Atime"] . "' ";
			
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			if ($row = mysqli_fetch_array($result)) {
				$Id = $row["Id"];	
				//echo '<br>Id: ' . $Id;	
				$utilityCompany =  str_replace("'","''",$row["utilityCompany"]);
				$Contractor =  str_replace("'","''",$row["Contractor"]); 
				$contactPerson =  str_replace("'","''",$row["contactPerson"]); 
				$phone =  $row["phone"]; 
				$dateOfWork =  DisplayDate($row["dateOfWork"]); 
				$permit_number =  $row["permit_number"]; 
				$period =  $row["period"]; 
				$Atime =  $row["Atime"]; 
				$Location =  $row["Location"]; 
				$Trench =  $row["Trench"]; 
				$Bore =  $row["Bore"]; 
				$Open_Cut =  $row["Open_Cut"]; 
				$Test_Hole =  $row["Test_Hole"]; 
				$Final_Patch =  $row["Final_Patch"]; 
				$Dig_in_Dirt =  $row["Dig_in_Dirt"]; 
				$Landscape_Clean_up =  $row["Landscape_Clean_up"]; 
				$Aerial =  $row["Aerial"]; 
				$Tree_Trimming =  $row["Tree_Trimming"]; 
				$Traffic_Only =  $row["Traffic_Only"]; 
				$Blanket =  $row["Blanket"]; 
				$Additional =  str_replace("'","''",$row["Additional"]);		
			}
			//echo "<br>Id: " . $Id;		
			//echo '<br>Dig_in_Dirt: ' . $Dig_in_Dirt ;	
		}
	} else {
		if (trim($_GET["FA"]) <> "send") {
			$query = "Update DNDetails set 
			utilityCompany = '" . str_replace("'","''",$_POST["utilityCompany"]) . "',
			Contractor = '" . str_replace("'","''",$_POST["Contractor"]). "', 
			contactPerson = '" . str_replace("'","''",$_POST["contactPerson"]) . "', 
			phone = '" . $_POST["phone"] . "', 
			dateOfWork = '" . SQLDate($_POST["dateOfWork"]) . "', 
			permit_number = '" . $_POST["permit_number"] . "', 
			period = '" . $_POST["period"] . "', 
			Atime = '" . $_POST["Atime"] . "', 
			Location = '" . $_POST["Location"] . "', 
			Trench = '" . $_POST["Trench"] . "', 
			Bore = '" . $_POST["Bore"] . "', 
			Open_Cut = '" . $_POST["Open_Cut"] . "', 
			Test_Hole = '" . $_POST["Test_Hole"] . "', 
			Final_Patch = '" . $_POST["Final_Patch"] . "', 
			Dig_in_Dirt = '" . $_POST["Dig_in_Dirt"] . "', 
			Landscape_Clean_up = '" . $_POST["Landscape_Clean_up"] . "', 
			Aerial = '" . $_POST["Aerial"] . "', 
			Tree_Trimming = '" . $_POST["Tree_Trimming"] . "', 
			Traffic_Only = '" . $_POST["Traffic_Only"] . "', 
			Blanket = '" . $_POST["Blanket"] . "', 
			Additional = '" . str_replace("'","''",$_POST["Additional"]) . "' 
			Where Id = " . $_GET["Id"];	
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		}
		
		$query = "Select * from DNDetails Where Id = " . $_GET["Id"];
		
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {				
			$Id = $row["Id"];		
			$utilityCompany =  str_replace("'","''",$row["utilityCompany"]);
			$Contractor =  str_replace("'","''",$row["Contractor"]); 
			$contactPerson =  str_replace("'","''",$row["contactPerson"]); 
			$phone =  $row["phone"]; 
			$dateOfWork =  DisplayDate($row["dateOfWork"]); 
			$permit_number =  $row["permit_number"]; 
			$period =  $row["period"]; 
			$Atime =  $row["Atime"]; 
			$Location =  $row["Location"]; 
			$Trench =  $row["Trench"]; 
			$Bore =  $row["Bore"]; 
			$Open_Cut =  $row["Open_Cut"]; 
			$Test_Hole =  $row["Test_Hole"]; 
			$Final_Patch =  $row["Final_Patch"]; 
			$Dig_in_Dirt =  $row["Dig_in_Dirt"]; 
			$Landscape_Clean_up =  $row["Landscape_Clean_up"]; 
			$Aerial =  $row["Aerial"]; 
			$Tree_Trimming =  $row["Tree_Trimming"]; 
			$Traffic_Only =  $row["Traffic_Only"]; 
			$Blanket =  $row["Blanket"]; 
			$Additional =  str_replace("'","''",$row["Additional"]);	
			$Additional = "";
		}
		
	}
} else { // Not POST
	
}

$DNEmail = '';
//$DNEmail = $DNEmail . '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"/>';
//$DNEmail = $DNEmail . '<title>Daily Notification - ' . $permit_number . '</title></head><body style="font-family:Calibri;">';
$DNEmail = $DNEmail . '<table style="font-family:Calibri; width:100%; border:0;">';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td >';
//$DNEmail = $DNEmail . '<img src="just_seal.jpg" style="width:145;" >';
$DNEmail = $DNEmail . '</td>';	
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '<td>';
$DNEmail = $DNEmail . 'Notification to <u><b>STARTWORK</b></u> in the City of Virginia Beach Right of Way';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="text-align:right; font-size: 8pt;">';
$DNEmail = $DNEmail . 'rev: 11/7/2016';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';	
$DNEmail = $DNEmail . '<td style="width:100px;"></td>';
$DNEmail = $DNEmail . '<td></td>';	
$DNEmail = $DNEmail . '<td colspan="2" style="text-align:center;">';
$DNEmail = $DNEmail . '<u>TO BE EMAILED OR FAXED IN DAILY BEFORE 9AM</u>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td colspan="2">&nbsp;</td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '<td style="text-align:left;">';
$DNEmail = $DNEmail . 'EMAIL: <p>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td>';
$DNEmail = $DNEmail . '<i>Civil Inspections</i> at <u>piutildocuments@vbgov.com</u>, <u>mlannon@vbgov.com</u>,  ';
$DNEmail = $DNEmail . '<b><u>and</u></b><br>';
$DNEmail = $DNEmail . '<i>Public Utilities</i> at <u>PUROWTechnicians@vbgov.com</u>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '<td style="text-align:left;">';
$DNEmail = $DNEmail . 'FAX:';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td>';
$DNEmail = $DNEmail . '<i>Civil Inspections</i> at 385-1134 or 385-5777<br>  ';
$DNEmail = $DNEmail . '<i>Public Utilities</i> at 385-5778';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td colspan="2">&nbsp;</td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '</table>';

$DNEmail = $DNEmail . '<table  style="font-family:Calibri; border:0;"  >';		
$DNEmail = $DNEmail . '<tr><td colspan="5"></td></tr>';
$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:150px; font-weight: bold; font-size: 10pt; vertical-align:bottom; " >';
$DNEmail = $DNEmail . 'UTILITY COMPANY: ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:300px; font-size: 14pt; border-bottom: 1px solid black;">';
$DNEmail = $DNEmail . '' . str_replace("''","'",$utilityCompany) . '';
$DNEmail = $DNEmail . '</td>';	
$DNEmail = $DNEmail . '<td style="width:80px;"></td>';	
$DNEmail = $DNEmail . '<td style="font-weight: bold; font-size: 10pt; vertical-align:bottom; ">';
$DNEmail = $DNEmail . '	<b>CONTRACTOR:</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:300px; text-align:left; font-size: 14pt; border-bottom: 1px solid black;">';
$DNEmail = $DNEmail . '	' .  str_replace("''","'",$Contractor)  . '';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';	
$DNEmail = $DNEmail . '</table>';

$DNEmail = $DNEmail . '<table  style="font-family:Calibri; width:100%; border:0; " >';
$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:150px; font-weight: bold; font-size: 10pt; vertical-align:bottom; ">';
$DNEmail = $DNEmail . '	<b>CONTACT PERSON: </b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:200px; font-size: 14pt; border-bottom: 1px solid black;">';
$DNEmail = $DNEmail . '	' .  str_replace("''","'",$contactPerson)  . '';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td >';
$DNEmail = $DNEmail . '	';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td  style="width:50px; font-weight: bold; font-size: 10pt; vertical-align:bottom; ">';
$DNEmail = $DNEmail . '	PHONE#:';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:200px; font-size: 14pt; border-bottom: 1px solid black;">';
$DNEmail = $DNEmail . '	' .  $phone . '';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td >';
$DNEmail = $DNEmail . '	';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:200px; font-weight: bold; font-size: 10pt; vertical-align:bottom; " >';
$DNEmail = $DNEmail . '	DATE OF WORK';
$DNEmail = $DNEmail . '(Current Date Only):';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="width:200px; font-size: 14pt; border-bottom: 1px solid black;">';
$DNEmail = $DNEmail . '	' .  $dateOfWork . '';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';
$DNEmail = $DNEmail . '<tr><td colspan="8">&nbsp;</td></tr>';
$DNEmail = $DNEmail . '</table>';

$DNEmail = $DNEmail . '<table  style="font-family:Calibri; width:100%; cellspacing:0; border-collapse: collapse;" >';
$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td rowspan="2" style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	<u>PERMIT NUMBER</u><br>';
$DNEmail = $DNEmail . '	MANDATORY ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td   colspan="2" style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Estimated Time<br>';
$DNEmail = $DNEmail . '	of Arrival';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td  rowspan="2" style="border: 4px solid black; ">';
$DNEmail = $DNEmail . 'Location&amp;Nearest Cross Street<br>Please Print Clearly  ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td  colspan="11" style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Work Description <br>(Check Only Where Applicable) ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';
$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; " >';
$DNEmail = $DNEmail . '	AM';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; " >';
$DNEmail = $DNEmail . '	PM';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Trench';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Bore';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Open<br>Cut';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Test<br>Hole';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Final<br>Patch';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Dig In<br>Dirt ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Landscape<br>Clean-up ';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Aerial';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Tree<br>Trimming';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Traffic<br>Only'; 
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	Blanket<br>YES/NO ';
$DNEmail = $DNEmail . '</td>'; 
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">';
$DNEmail = $DNEmail . '	<b>' .  $permit_number . '</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">&nbsp;';
if ($period == "AM") {$DNEmail = $DNEmail . '<b>' . trim($Atime) . '</b>';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border-top: 4px solid black; ">&nbsp;';
if ($period == "PM") {$DNEmail = $DNEmail . '<b>' . trim($Atime) . '</b>';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">';
$DNEmail = $DNEmail . '	<b>' .  str_replace("''","'",$Location) . '</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center; ">';
if($Trench == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Bore == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Open_Cut == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Test_Hole == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Final_Patch == 'yes') {$DNEmail = $DNEmail . '&#10004;';} 
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center; ">';
if($Dig_in_Dirt == 'yes') {$DNEmail = $DNEmail . '&#10004;';} 
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Landscape_Clean_up == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center; ">';
if($Aerial == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Tree_Trimming == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Traffic_Only == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">';
if($Blanket == 'yes') {$DNEmail = $DNEmail . '&#10004;';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';
	
$count = 3;
while ($count > 0) {
$DNEmail = $DNEmail . '<tr>';
$Icount = 14;
while ($Icount >= 0) {
$DNEmail = $DNEmail . '<td style="height:26px; border: 1px solid black;"></td>';
$Icount = $Icount - 1;
}
$DNEmail = $DNEmail . '</tr>';
$count = $count - 1;
}

$DNEmail = $DNEmail . '</table>';
$DNEmail = $DNEmail . '<p></p>';

$DNEmail = $DNEmail . '<table style="width:100%; border:0;" >';
$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td >';
$DNEmail = $DNEmail . '	<b>Additional Information:</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td >';
$DNEmail = $DNEmail . '<b>' .  str_replace("''","'",$Additional) . '</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';
$DNEmail = $DNEmail . '</table>';
$DNEmail = $DNEmail . '</body></html>';

If (trim($_GET["Id"]) <> "") {
	$Id = $_GET["Id"];
}
		If (trim($_GET["FA"]) == "send") {	
			$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-14 months" ) );
			
			// Temp for testing
			$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-36 months" ) );
			
			$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
			$q = "SELECT distinct `PermitNumber`,`Id` FROM `PIP` 
			where `CompanyName`= '" . $utilityCompany . "' and 
			(DateOfSignature between '" . $myDate . "' and '" . $today . "')  and 
			PermitNumber = '" . $permit_number . "' ";
			$r = mysqli_query($connection,$q) or die("<br/>Query failed");
			if ($row = mysqli_fetch_array($r)) {
				$PermitId = $row[1];
				$query = "Select DNDate, PermitId, Id from DailyNotifications Where DNDate = '" . 
				date("Y-m-d") . "' and PermitId = " . $row[1];				
				$r = mysqli_query($connection,$query) or die("<br/>Query failed");
				if ($row = mysqli_fetch_array($r)) {	
					echo 'This daily notification has already been recorded ';		
				} else {
					if (!isset($row[2])) {
						$query = "Insert into DailyNotifications 
						(DNDate, PermitId) values ('" . date("Y-m-d") . "',
						" . $PermitId . ")";	
						$r = mysqli_query($connection,$query) or die("<br/>Query failed");						
								
						$myfilename = "DailyNotification-" . $permit_number . ".html";
						$myfile = fopen($myfilename, "w") or die("Unable to open file!");
						$txt = $DNEmail;
						fwrite($myfile, $txt);
						fclose($myfile);

						$headers = "Content-type: text/html\r\n";	
						$headers = "Content-type: text/html; charset=iso-8859-1";
						$title = 'Daily Notification';
						
						$query = "SELECT email FROM `Login` Where DNNotices = 'yes' ";
						$r = mysqli_query($connection,$query) or die("<br/>Query failed");						
						while ($row = mysqli_fetch_array($r)) {									
							$mail_to = $row[0];
							//mail($mail_to, $title, $DNEmail, $headers) or die("<br/>mail failed");
							//echo '<p>mail_to: ' . $mail_to;
							
							if (1 ==1) {
							$to = 'youraddress@example.com'; //define the receiver of the email 
							$to = $mail_to;
							$subject = 'Daily Notification - ' . $permit_number; //define the subject of the email 

							$random_hash = md5(date('r', time())); 
							//define the headers we want passed. Note that they are separated with \r\n 
							$headers = "From: wrighthouse4@msn.com\r\nReply-To: wrighthouse4@msn.com"; 
							//add boundary string and mime type specification 
							$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
														
							//read the atachment file contents into a string,
							//encode it with MIME base64,
							//and split it into smaller chunks
							$attachment = chunk_split(base64_encode(file_get_contents($myfilename))); 
							//define the body of the message. 
							ob_start(); //Turn on output buffering 
							?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<?php echo $DNEmail;?> 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name=<?php echo $myfilename;?> 
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent, " : "Mail failed"; 
							}

							ob_end_flush();
						}
						//$headers = "Content-type: text/html\r\n";			
						//$mail_to = 'iwright@vbgov.com';
						//$title = 'Daily Notification';									
					}
					echo 'Virginia Beach Permits and Inspections has been notified';
				}				
			}
		} else {
			?>
			Click <b>
			<a href="StoreSendDN.php?FA=send&Id=<?php echo $Id;?>">
				Send Daily Notification</a></b> if the information below is correct or 
			<b>
			<a href="DNOnlineForm.php?Id=<?php echo $Id;?>">
				Change Daily Notification</a></b> 
			<?php
		}
		?>
		</div>			
		</div>
		<div class="row">
		<div class="col-sm-12" >		
		<?php
		echo '<p>' . $DNEmail;
		if (1==1) {
		?>
		</div>
	</div>
</div>
<?php
}
?>	
</body>
</html>