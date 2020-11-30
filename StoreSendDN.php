<?php
session_start();
$Normal = TRUE;
if ($Normal) {
?>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | DN Online Form </title>
</head>
<body>
	
<?php
include ('./includes/banner.inc');
include ('./includes/database2.inc');
//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());

}

function SQLDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "Y-m-d") ; 	
}
						
function DisplayDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "m/d/Y") ; 	
}

//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error($connection));
if ($Normal){
?>
<div class="container" style="font-size: normal; background-color: whitesmoke">
	<div class="row">
	<div class="col-sm-12" style="font-size: normal; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
<?php
}
$Id = 0;
$PreExisting = FALSE;

$db = True;
$db = False;
$checkCode = '  &#10004;';
$checkCode = '<b>X</b>';
//$checkCode = '<pre>yes</pre>';
//$checkCode = '  yes';
//$checkCode = '<pre>&#10004;</pre>';

// Create web page / email 
$DNEmail = '';

$SubmissionId = 0;
if (isset($_GET["SubmissionId"])) {
	$SubmissionId = $_GET["SubmissionId"];
}
if (isset($_POST["SubmissionId"])) {
	$SubmissionId = $_POST["SubmissionId"];
}	

if (1 == 1) {
			
	if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
	$query = "Select * from DNDetails Where SubmissionId = " . $SubmissionId;
		
	if ($db) {echo "<br>" . $query;}
	$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	if ($row = mysqli_fetch_array($result)) {
		if ($db) {echo "<br>Record found";}			
		$Id = $row["Id"];		
		$utilityCompany =  str_replace("'","''",$row["utilityCompany"]);
		$Contractor =  str_replace("'","''",$row["Contractor"]); 
		$contactPerson =  str_replace("'","''",$row["contactPerson"]); 
		$phone =  $row["phone"]; 
		$dateOfWork =  DisplayDate($row["dateOfWork"]); 
		$PermitNumber =  $row["permit_number"]; 
		$period =  $row["period"]; 
		$Atime =  $row["Atime"]; 
		$Location =  str_replace("'","''",$row["Location"]); 
		$StreetAddress = $row["StreetAddress"];
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
		$CCTV =  $row["CCTV"]; 
		$Additional =  str_replace("'","''",$row["Additional"]);	
		$PermitType = $row["PermitType"];	
		
		$query = "Select * from DNDetails where 
		permit_number = '" . $PermitNumber . "' and 
		period = '" . $period . "' and 
		Atime = '" . $Atime . "' and 
		Location = '" . $Location . "' and 
		Trench = '" . $Trench . "' and 
		Bore = '" . $Bore . "' and 
		Open_Cut = '" . $Open_Cut . "' and 
		Test_Hole = '" . $Test_Hole . "' and 
		Final_Patch = '" . $Final_Patch . "' and 
		Dig_in_Dirt = '" . $Dig_in_Dirt . "' and 
		Landscape_Clean_up = '" . $Landscape_Clean_up . "' and 
		Aerial = '" . $Aerial . "' and 
		Tree_Trimming = '" . $Tree_Trimming . "' and 
		Traffic_Only = '" . $Traffic_Only . "' and 
		Blanket = '" . $Blanket . "' and 
		CCTV = '" . $CCTV . "' and 
		Additional = '" . $Additional . "' and 
		StreetAddress = '" . $StreetAddress . "' and 
		PermitType = '" . $PermitType . "' and 
		SubmissionId <> " . $SubmissionId;	
		
		if ($db) {echo "<br>Duplicate $query";}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		$Id = 0;
		while ($row = mysqli_fetch_array($result)) {
			$Id = $row["Id"];
			$PreExisting = TRUE;
			if ($db) {echo "<br>Duplicate record found, Id = $Id";}
			$query2 = "Delete from DNDetails Where Id = " . $Id;					
			if ($db) {echo "<br>Duplicate $query2";}
			$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection2));
		}
		if ($Id == 0) {
			if ($db) {echo "<br>No Duplicate record found";}			
		}		
	}		
}
		
function DateToSQL($ADate) {
	//echo "{{". $ADate ."}}";		
	$date = date_create($ADate);
	return date_format($date , 'Y-m-d') ;			
}
		
if(isset($_GET["newDate"]) ) {
	$query = "Update DNSubmissions set dateOfWork = '" . DateToSQL($_GET["newDate"]) . "' where Id = " . $SubmissionId;
	if ($db) {echo "<br>" . $query;}
	$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
}

	$query = "Select * from DNSubmissions where Id = " . $SubmissionId;
	$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	if ($row = mysqli_fetch_array($result)) {
		//$Id = $row["Id"];		// wrong Id
		$utilityCompany = $row["utilityCompany"];
		$Contractor = $row["Contractor"];
		$dateOfWork = DisplayDate($row["dateOfWork"]);
		$phone = $row["phone"];
		$contactPerson = $row["contactPerson"];
	}	
	
		if ($db) {echo "<br>" . $query;}
	
$DNEmail = '';
$DNEmail = $DNEmail . '<!DOCTYPE html><html lang="en"><head>';
$DNEmail = $DNEmail . '<title>Daily Notification</title></head><body style="font-family:Calibri;">';
$DNEmail = $DNEmail . '<table style="font-family:Calibri; width:100%; border:0;">';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td></td>';	
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '<td>';
$DNEmail = $DNEmail . 'Notification to <u><b>STARTWORK</b></u> in the City of Virginia Beach Right of Way';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="text-align:right; font-size: 8pt;">';
$DNEmail = $DNEmail . 'rev: 11/7/2016';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';	
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td></td>';	
$DNEmail = $DNEmail . '<td></td>';	
$DNEmail = $DNEmail . '<td colspan="1" style="text-align:left;">';
$DNEmail = $DNEmail . '<u>TO BE EMAILED OR FAXED IN DAILY BEFORE 9AM</u>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td colspan="5">&nbsp;</td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="width:200px;"></td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '<td style="text-align:left;">';
$DNEmail = $DNEmail . 'EMAIL: <p>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td>';
$DNEmail = $DNEmail . '<i>Civil Inspections</i> at <u>piutildocuments@vbgov.com</u>  ';
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
$DNEmail = $DNEmail . '<i>Civil Inspections</i> at 385-5777<br>  ';
$DNEmail = $DNEmail . '<i>Public Utilities</i> at 385-5778';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td></td>';
$DNEmail = $DNEmail . '</tr>';

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td colspan="5">&nbsp;</td>';
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
$DNEmail = $DNEmail . '<td style="border: 4px solid black; ">';
$DNEmail = $DNEmail . '	CCTV<br>YES/NO ';
$DNEmail = $DNEmail . '</td>'; 
$DNEmail = $DNEmail . '</tr>';
	
$query = "Select * from DNDetails Where SubmissionId = " . $SubmissionId . " order by Id";
if ($db) {echo '<br>' . $query;}
$Additional = "";
$coma = '';
$PrevPN = "";
$PNcoma = "";
$PermitNumbers = "";
	
$AlreadySent = False;
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
while ($row = mysqli_fetch_array($result)) {				
	$Id = $row["Id"];		
	//$utilityCompany =  str_replace("'","''",$row["utilityCompany"]);
	//$Contractor =  str_replace("'","''",$row["Contractor"]); 
	//$contactPerson =  str_replace("'","''",$row["contactPerson"]); 
	//$phone =  $row["phone"]; 
	//$dateOfWork =  DisplayDate($row["dateOfWork"]); 
	$PermitNumber =  $row["permit_number"]; 
	$period =  $row["period"]; 
	$Atime =  $row["Atime"]; 
	$Location =  str_replace("'","''",$row["Location"]); 
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
	$CCTV =  $row["CCTV"]; 
	if (trim($row["Additional"]) <> "") {
		$Additional = $Additional . $coma . str_replace("'","''",$row["Additional"]) . ' (' . $PermitNumber . ')';
		$coma = ', ';
	}
	
	$PermitType =  str_replace("'","''",$row["PermitType"]);		
	
	$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-36 months" ) );
			
	$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
	
	$q = "SELECT distinct `PermitNumber`,`Id` FROM `PIP` 
	where `CompanyName`= '" . $utilityCompany . "' and 
	(DateOfSignature between '" . $myDate . "' and '" . $today . "')  and 
	PermitNumber = '" . $PermitNumber . "' and 
	(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET') order by Id desc";
	
	if ($db) {echo "<br>" . $q;}

	$r = mysqli_query($connection2,$q) or die("<br/>Query failed");
	if ($row = mysqli_fetch_array($r)) {
		$PermitId = $row[1];
		$query = "Select DNDate, PermitId, Id from DailyNotifications Where DNDate = '" . 
		date("Y-m-d") . "' and PermitId = " . $row[1];	
		$query = "Select DNDate, PermitId, Id from DailyNotifications Where DNDate = '" . 
		SQLDate($dateOfWork) . "' and PermitId = " . $row[1];
					
		if ($db) {echo "<br>" . $query;}
				
		$r = mysqli_query($connection2,$query) or die("<br/>Query failed");
		if ($row = mysqli_fetch_array($r)) {
			// $AlreadySent = True; 	
			// Already recorded, no need to double record
		} else {
			if (!isset($row[2])) {
				$query = "Insert into DailyNotifications 
				(DNDate, PermitId) values ('" . SQLDate($dateOfWork) . "',
				" . $PermitId . ")";	
				if ($db) {echo "<br>" . $query;}						
				$r = mysqli_query($connection2,$query) or die("<br/>Query failed");		
			}
		}
	}				
								
		

$DNEmail = $DNEmail . '<tr>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">';
$DNEmail = $DNEmail . '	<b>' .  $PermitNumber . '</b>';
if ($PrevPN <> $PermitNumber) {
	$PermitNumbers .= $PNcoma . $PermitNumber;
	$PrevPN = $PermitNumber;
	$PNcoma = ' | ';
}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">&nbsp;';
if ($period == "AM") {$DNEmail = $DNEmail . '<b>' . trim($Atime) . '</b>';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">&nbsp;';
if ($period == "PM") {$DNEmail = $DNEmail . '<b>' . trim($Atime) . '</b>';}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; ">';
$DNEmail = $DNEmail . '	<b>' .  str_replace("''","'",$Location) . '</b>';
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Trench == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Bore == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Open_Cut == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Test_Hole == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Final_Patch == 'yes') {$DNEmail = $DNEmail . $checkCode;} 
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Dig_in_Dirt == 'yes') {$DNEmail = $DNEmail . $checkCode;} 
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Landscape_Clean_up == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Aerial == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Tree_Trimming == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Traffic_Only == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($Blanket == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '<td style="border: 1px solid black; text-align: center;">&nbsp;';
if($CCTV == 'yes') {$DNEmail = $DNEmail . $checkCode;}
$DNEmail = $DNEmail . '</td>';
$DNEmail = $DNEmail . '</tr>';
	
	} // while line records


$DNEmail = $DNEmail . '</table>';
$DNEmail = $DNEmail . '<p></p>';

$DNEmail = $DNEmail . '<table style=" border:0;" >';
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

		If (isset($_GET["FA"]) && trim($_GET["FA"]) == "send") {
			if ($db) {echo "<br>FA = send";}
			
			if ($AlreadySent && 1 == 2)	{	// Obsolete idea since multiple premits added 
				// echo 'This daily notification has already been recorded ';		
			} else {
				$myfilename = "DailyNotifications/DailyNotification-" . $PermitNumbers . "-" . $SubmissionId . ".html";
								
				$myfile = fopen($myfilename, "w") or die("Unable to open file!");
				$txt = $DNEmail;
				fwrite($myfile, $txt);
				fclose($myfile);

				$headers = "Content-type: text/html\r\n";	
				$headers = "Content-type: text/html; charset=iso-8859-1";
				$title = 'Daily Notification';
						
				$strSQL = "Select Emails From DNOFemails"; 
				$r2 = mysqli_query($connection2, $strSQL) or die("<br/>Query failed 223: " . $strSQL);
				$CurrentPermit = "";
				If ($row2 = mysqli_fetch_array($r2)) {
					$mail_to = $row2[0]; 	
					//$mail_to = "iwright@vbgov.com";
					echo "sending to : " . $mail_to;
					//mail($mail_to, $title, $DNEmail, $headers) or die("<br/>mail failed");
					//echo '<p>mail_to: ' . $mail_to;
							
					if (1 ==1) {
					$to = 'youraddress@example.com'; //define the receiver of the email 
					$to = $mail_to;
					$subject = 'Daily Notification - ' . $PermitNumbers; //define the subject of the email 

					$random_hash = md5(date('r', time())); 
					//define the headers we want passed. Note that they are separated with \r\n 
					//$headers = "From: wrighthouse4@msn.com\r\nReply-To: wrighthouse4@msn.com";
					$headers = ''; 
					//add boundary string and mime type specification 
					$headers = "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
					$headers = "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
														
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

If (true) {
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print " Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? ". Mail sent, " : "Mail failed"; 
echo 'Virginia Beach Permits and Inspections has been notified';
}

					if (isset($_SESSION["user_email"]) && trim($_SESSION["user_email"]) <> "") {
$to = $_SESSION["user_email"];
$subject = 'Confirmation - ' . $subject;
$message = "
This email is confirmation that your Daily Notification has been recieved by the City of Virginia Beach." ;
$message = '
			<html>
			<head>
  				<title>Notification Confirmation </title>
			</head>
			<body>
  			<p>Thank you for using the Virginia Beach Daily Notification system</p>
  			<table>
    			<tr>
      			<td>This message confirms Virginia Beach has received your notice</td>
    			</tr>
    			<tr>
      				<td>Permit numbers: ' . $PermitNumbers . ' </td>
    			</tr>
    			<tr>
      				<td><a href="pip.vabeachpu.com/' . $myfilename . '">view notification as a web page</a></td>
    			</tr>
  			</table>
			</body>
			</html>
			';
			$headers = "Content-type: text/html\r\n"; 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
					echo ', confirmation: ' . $_SESSION["user_email"];

					if (isset($myfilename) && isset($SubmissionId)) {
						$query3 = "Update DNSubmissions set EmailFile = '" . $myfilename . "' 
						where Id = " . $SubmissionId;
				
						$r = mysqli_query($connection2,$query3) or die("<br/>Query failed");
					}
					}
							}

							//ob_end_flush();
						
						//$headers = "Content-type: text/html\r\n";			
						//$mail_to = 'iwright@vbgov.com';
						//$title = 'Daily Notification';									
					
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
		
		if ($Normal) {
		?>
		</div>			
		</div>
		<div class="row">
		<div class="col-sm-12" >		
		<?php
		}
		echo $DNEmail;
		if ($Normal) {
		?>
		&nbsp;<p></p><a href="DNOnlineForm.php"><b>Enter next notification...</b></a>
		<?php
		if (true) {		
			$to = "iwright@vbgov.com";
			$message = '
			<html>
			<head>
  				<title>Notification Confirmation </title>
			</head>
			<body>
  			<p>Thank you for using the Virginia Beach Daily Notification system</p>
  			<table>
    			<tr>
      			<td>This message confirms Virginia Beach has received your notice</td>
    			</tr>
    			<tr>
      				<td>Permit numbers: ' . $PermitNumbers . ' </td>
    			</tr>
    			<tr>
      				<td><a href="pip.vabeachpu.com/' . $myfilename . '">view notification as a web page</a></td>
    			</tr>
  			</table>
			</body>
			</html>
			';

			$headers = "Content-type: text/html\r\n"; 

			// Mail it
			$mail_sent = @mail($to, $subject, $message, $headers);
			
		}
		?>
		</div>
	</div>
</div>
</body>
</html>
<?php
}
?>	