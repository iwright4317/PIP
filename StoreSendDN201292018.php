<?php
session_start();
?>
	
<!DOCTYPE html><html lang="en">
	
<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | DN Online Form </title>
	
	
	<script>
		function deleteLine(Id,SubmissionId) {
			var txt;
			var location;
			location = document.getElementById("location" + Id).value;
			var r = confirm("Are you sure you want to delete location " + location + " ?");
			if (r == true) {
 			   txt = "You pressed OK!";
 			   window.location = "http://pip.vabeachpu.com/StoreSendDN2.php?action=dn&SubmissionId=" + SubmissionId + "&Id=" + Id;
			} else {
    			txt = "You pressed Cancel!";
			}	
		}
	</script>
	
	
	<script>
		function deleteSub(Id,SubmissionId) {
			var txt;
			var location;
			location = document.getElementById("location" + Id).value;
			var r = confirm("Are you sure you want to delete this entire submission?");
			if (r == true) {
 			   txt = "You pressed OK!";
 			   window.location = "http://pip.vabeachpu.com/DNOnlineForm.php?action=ds&SubmissionId=";
			} else {
    			txt = "You pressed Cancel!";
			}	
		}
	</script>
	
	<script>
		function Add2URL() {
			var location;
			location = document.getElementById("StoreSendDNroot").value;
			var newDate;
			newDate = document.getElementById("datepicker").value;
			location = location + '&newDate=' + newDate;
			var newURL;
			newURL = document.getElementById("StoreSendDN")
			newURL.href = location;
		} 
	</script>
	
	
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});

	</script>
				
	
	
</head>
<body>
<?php
include ('./includes/banner.inc');
include ('./includes/database2.inc');
//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));

function SQLDate($ADate = "") {
	if (isset($ADate) && trim($ADate) <> "") {			
		$date = date_create($ADate);
		return date_format($date , "Y-m-d") ; 
	} else {	
		return date("Y-m-d");
	}
}

function JustReturn($tr,$gtext) {	
	return $gtext ; 	
}
						
function DisplayDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "m/d/Y") ; 	
}


//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error($connection));
?>
<div class="container" style="font-size: normal; background-color: whitesmoke">
	<div class="row">	
	<div class="col-sm-12" style="font-size: large; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
<?php
$Id = 0;
$PreExisting = FALSE;
$db = True;
//$db = False;

//$SubmissionId = 0;
if (isset($_GET["SubmissionId"])) {
	$SubmissionId = $_GET["SubmissionId"];
}
if (isset($_POST["SubmissionId"])) {
	$SubmissionId = $_POST["SubmissionId"];
}	

if ($db && isset($_GET["action"])) {echo '<br>50 SubmissionId: ' . $SubmissionId;}
if ($db && isset($_GET["action"])) {echo '<br>action: ' . $_GET["action"];}

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

if ((isset($_GET["action"]) && trim($_GET["action"]) == "dn" )) { // delete notification line
	if (isset($_GET["Id"])) {
		$query = "Delete from DNDetails Where Id = " . $_GET["Id"];				
		if ($db) {echo '<br>' . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	}
}

if (!isset($_GET["action"]) || (isset($_GET["action"]) && trim($_GET["action"]) <> "recall" )) {
	$SubmissionDateTime = SQLDateTime('');
	if ($db) {echo '<br>SubmissionDate: ' . $SubmissionDateTime;}
	$utilityCompany = "";
	If (isset($_POST["utilityCompany"])) {$utilityCompany = str_replace("'","''",$_POST["utilityCompany"]);}
	$Contractor = "";
	If (isset($_POST["Contractor"])) {$Contractor = str_replace("'","''",$_POST["Contractor"]);}
	$contactPerson = "";
	If (isset($_POST["contactPerson"])) {$contactPerson = str_replace("'","''",$_POST["contactPerson"]);}
	$phone = "";
	If (isset($_POST["phone"])) {$phone = str_replace("'","''",$_POST["phone"]);}
	$dateOfWork = "";
	If (isset($_POST["dateOfWork"])) {$dateOfWork = str_replace("'","''",$_POST["dateOfWork"]);}

	if (!isset($_GET["SubmissionId"]) && !isset($_POST["SubmissionId"])) { // no current submission -> create new submission record
		// check for duplicate submission 
		$DupSub = false;
		$query = "select Id From DNSubmissions Where 
			LoginId = " . $_SESSION["user_id"] . " and 
			utilityCompany = '" . $utilityCompany . "' and 
			Contractor = '" . $Contractor . "' and 
			dateOfWork = '" . SQLDate($dateOfWork) . "' and 
			phone = '" . $phone . "' and 
			contactPerson = '" . $contactPerson. "' ";
			
		if ($db) {echo '<br>check for duplicate submission:<pre>' . $query . '</pre>';}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$DupSub = true;
			if ($db) {echo '<br>found duplicate submission: ';}
			$SubmissionId = $row["Id"];
		} else {			
			if ($db) {echo '<br>did not found duplicate submission: ';}				
			if ($db) {echo '<br>New Submission';}
			
			$query = "Insert into DNSubmissions (LoginId, SubmissionDateTime, utilityCompany,
				Contractor, dateOfWork, phone, contactPerson) values 
				(" . $_SESSION["user_id"] . ",'" . $SubmissionDateTime . "','" .
				$utilityCompany . "','" . $Contractor . "','" . SQLDate($dateOfWork) . "','" .
				$phone . "','" . $contactPerson . "')";
				
			if ($db) {echo '<br>' . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
			// Retreive back to get SubmissionId
			$query = "select Id from DNSubmissions Where LoginId = " . $_SESSION["user_id"] . " and SubmissionDateTime = '" . $SubmissionDateTime . "' ";
			if ($db) {echo "<br>Retreive back to get SubmissionId: " . $query; }
		
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			if ($row = mysqli_fetch_array($result)) {
				$SubmissionId = $row["Id"];
			}			
		}
		if ($db) {echo "<br>SubmissionId: " . $SubmissionId; }
	} else {
		
		$dateOfWork = "";
		If (isset($_POST["dateOfWork"])) {$dateOfWork = str_replace("'","''",$_POST["dateOfWork"]);}
	
function DateToSQL($ADate) {
	echo "{{". $ADate ."}}";		
	$date = date_create($ADate);
	return date_format($date , 'Y-m-d') ;			
}

		$query = "Update DNSubmissions set dateOfWork = '" . DateToSQL($dateOfWork) . "' where Id = " . $SubmissionId;
		if ($db) {echo "<br>" . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
				
		$query = "Select * from DNSubmissions where Id = " . $SubmissionId;
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$utilityCompany = $row["utilityCompany"];
			$Contractor = $row["Contractor"];
			$dateOfWork = $row["dateOfWork"];
			$phone = $row["phone"];
			$contactPerson = $row["contactPerson"];
		}
	
		// Update DNSubmission record in-cased changed via form
		if ($db) {echo '<br>Update existing Submission';}
		$query = "Update DNSubmissions set 
			utilityCompany = '" . $utilityCompany . "', 
			Contractor = '" . $Contractor . "', 
			dateOfWork = '" . SQLDate($dateOfWork). "',
			phone  = '" . $phone . "',
			contactPerson   = '" . $contactPerson . "'  
			Where Id = " . $SubmissionId ;
		//if ($db) {echo '<br>' . $query;}
		//$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	}
	
	$PermitNumber = "";
	if (isset($_POST["permit_number"])) {
		$PermitNumber = $_POST["permit_number"];
	}
	
	$PermitType = "";
	if (isset($_POST["permit_number"]) && ((trim($_POST["permit_number"]) == "Emergency") or (trim($_POST["permit_number"]) == "City Project"))) {
		$PermitType = $_POST["permit_number"];
		if (isset($_POST["epermit"])) {$PermitNumber = $_POST["epermit"];}			
	}

	if ($db) {echo "<p>epermit: " . $PermitNumber ; }

	// Gather info from form and store into DNDetails

	$period = "";
	If (isset($_POST["period"])) {$period = str_replace("'","''",$_POST["period"]);}
	$Atime = "";
	If (isset($_POST["Atime"])) {$Atime = str_replace("'","''",$_POST["Atime"]);}
	$Location = "";
	If (isset($_POST["Location"])) {$Location = str_replace("'","''",$_POST["Location"]);}
	$Trench = "";
	If (isset($_POST["Trench"])) {$Trench = str_replace("'","''",$_POST["Trench"]);}
	$Bore = "";
	If (isset($_POST["Bore"])) {$Bore = str_replace("'","''",$_POST["Bore"]);}
	$Open_Cut = "";
	If (isset($_POST["Open_Cut"])) {$Open_Cut = str_replace("'","''",$_POST["Open_Cut"]);}
	$Test_Hole = "";
	If (isset($_POST["Test_Hole"])) {$Test_Hole = str_replace("'","''",$_POST["Test_Hole"]);}
	$Final_Patch = "";
	If (isset($_POST["Final_Patch"])) {$Final_Patch = str_replace("'","''",$_POST["Final_Patch"]);}
	$Dig_in_Dirt = "";
	If (isset($_POST["Dig_in_Dirt"])) {$Dig_in_Dirt = str_replace("'","''",$_POST["Dig_in_Dirt"]);}
	$Landscape_Clean_up = "";
	If (isset($_POST["Landscape_Clean_up"])) {$Landscape_Clean_up = str_replace("'","''",$_POST["Landscape_Clean_up"]);}
	$Aerial = "";
	If (isset($_POST["Aerial"])) {$Aerial = str_replace("'","''",$_POST["Aerial"]);}
	$Tree_Trimming = "";
	If (isset($_POST["Tree_Trimming"])) {$Tree_Trimming = str_replace("'","''",$_POST["Tree_Trimming"]);}
	$Traffic_Only = "";
	If (isset($_POST["Traffic_Only"])) {$Traffic_Only = str_replace("'","''",$_POST["Traffic_Only"]);}
	$Blanket = "";
	If (isset($_POST["Blanket"])) {$Blanket = str_replace("'","''",$_POST["Blanket"]);}
	$Additional = "";
	If (isset($_POST["Additional"])) {$Additional = str_replace("'","''",$_POST["Additional"]);}
	$StreetAddressH = "";
	If (isset($_POST["StreetAddressH"])) {$StreetAddressH = trim(str_replace("'","''",$_POST["StreetAddressH"]));}
	
	$action = "";
	if (isset($_POST["action"])) {$action = $_POST["action"];}
	if ($db) {echo '<br>action: ' . $action ;}
	if (!isset($_GET["Id"]) || trim($_GET["Id"]) == "" || $action == "nl" || $action == "np") {		// Attempt new record
	//if (!isset($_GET["Id"]) || trim($_GET["Id"]) == "" ) {		// Attempt new record
		// Check for pre-existing record
		if ($db) {echo '<br>Check for pre-existing record';}
			if ($db) {echo "<br>PermitType: $PermitType";}
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
		Additional = '" . $Additional . "' and 
		StreetAddress = '" . $StreetAddressH . "' and 
		PermitType = '" . $PermitType . "' and 
		SubmissionId = " . $SubmissionId . " ";	
		
		if ($db) {echo "<br>Presexisting $query";}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$Id = $row["Id"];
			$PreExisting = TRUE;
			if ($db) {echo "<br>Presexisting record found";}
		} else {
			if ($db) {echo "<br>No Presexisting record found";}			
		}
		if (!$PreExisting) { // no pre-existing -> Insert new record
			if ($db) {echo '<br>No pre-existing record';}
			$query = "Insert into DNDetails ( 
				permit_number,
				period, Atime, Location, Trench, Bore, Open_Cut, Test_Hole, Final_Patch,
				Dig_in_Dirt, Landscape_Clean_up, Aerial, Tree_Trimming, Traffic_Only,
				Blanket, Additional, StreetAddress, PermitType, SubmissionId) values ( " . 
				"  '" . $PermitNumber . "' , " .
				"  '" . $period . "' , " .
				"  '" . $Atime . "' , " .
				"  '" . $Location . "' , " .
				"  '" . $Trench . "' , " .
				"  '" . $Bore . "' , " .
				"  '" . $Open_Cut . "' , " .
				"  '" . $Test_Hole . "' , " .
				"  '" . $Final_Patch . "' , " .
				"  '" . $Dig_in_Dirt . "' , " .
				"  '" . $Landscape_Clean_up . "' , " .
				"  '" . $Aerial . "' , " .
				"  '" . $Tree_Trimming . "' , " .
				"  '" . $Traffic_Only . "' , " .
				"  '" . $Blanket . "' , " .
				"  '" . $Additional . "' , " .
				"  '" . $StreetAddressH . "'," . 
				"  '" . $PermitType . "'," . 
				"   " . $SubmissionId . ")";
			if ($db) {echo "<br>|" . $query . "|";}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			
			// Get Id of new record
			$query = "Select * from DNDetails where 
			Location = '" . str_replace("'","''",$_POST["Location"]) . "' and 
			Atime = '" . $_POST["Atime"] . "' and SubmissionId = " . $SubmissionId;
			
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			if ($row = mysqli_fetch_array($result)) {
				$Id = $row["Id"];	
				if ($db) {echo '<br>Id: ' . $Id;}					
			}
		} else {
			if ($db) {echo '<br>Pre-existing record - do nothing';}
			// This might be confusing to users
			//echo 'A record of this location and time already exists. Please enter a new location or time';
		}
	} else { // 
		if ($db) {echo '<br>Update current record';}
		if (!isset($_GET["FA"]) || (isset($_GET["FA"]) && trim($_GET["FA"]) <> "send")) {
			$query = "Update DNDetails set 
				permit_number = '" . $PermitNumber . "', 
				period = '" . $period . "', 
				Atime = '" . $Atime . "', 
				Location = '" . $Location . "', 
				Trench = '" . $Trench . "', 
				Bore = '" . $Bore . "', 
				Open_Cut = '" . $Open_Cut . "', 
				Test_Hole = '" . $Test_Hole . "', 
				Final_Patch = '" . $Final_Patch . "', 
				Dig_in_Dirt = '" . $Dig_in_Dirt . "', 
				Landscape_Clean_up = '" . $Landscape_Clean_up . "', 
				Aerial = '" . $Aerial . "', 
				Tree_Trimming = '" . $Tree_Trimming . "', 
				Traffic_Only = '" . $Traffic_Only . "', 
				Blanket = '" . $Blanket . "', 
				Additional = '" . $Additional . "', 
				PermitType = '" . $PermitType . "' 
				Where Id = " . $_GET["Id"];
				if ($db) {echo '<br>Update: ' . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		}
	}
} else { // recall of previous daily notification submission
	// Top info not arriving via the form -> must get top info from db	
	
	$query = "Select * from DNSubmissions where Id = " . $SubmissionId;
	if ($db) {echo '<br>' . $query;}
	$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	if ($row = mysqli_fetch_array($result)) {
		//$Id = $row["Id"];		// wrong Id
		$utilityCompany = $row["utilityCompany"];
		$Contractor = $row["Contractor"];
		$dateOfWork = $row["dateOfWork"];
		$phone = $row["phone"];
		$contactPerson = $row["contactPerson"];
		$dateOfWork = date("m/d/Y");	
		
		$query = "Update DNSubmissions set dateOfWork = '" . SQLDate() . "' where Id = " . $SubmissionId;
		
		$query = "Insert into DNSubmissions (LoginId, SubmissionDateTime, utilityCompany,
			Contractor, dateOfWork, phone, contactPerson) values 
			(" . $_SESSION["user_id"] . ",'" . SQLDate() . "','" .
			$utilityCompany . "','" . $Contractor . "','" . SQLDate() . "','" .
			$phone . "','" . $contactPerson . "')";
		if ($db) {echo '<br>' . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		$OldSubmissionId = $SubmissionId;
		
		// Read back the record just written to get the Id
		$query = "Select Id from DNSubmissions where Id <> " . $SubmissionId . " and 
		LoginId = " . $_SESSION["user_id"] . " and SubmissionDateTime = '" . SQLDate() . "' and 
		utilityCompany = '" . $utilityCompany . "' and Contractor = '" . $Contractor . "' and 
		dateOfWork = '" . SQLDate() . "' and phone = '" . $phone . "' and 
		contactPerson = '" . $contactPerson . "' order by Id desc";
		if ($db) {echo '<br>' . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
		if ($row = mysqli_fetch_array($result)) {
					
			$SubmissionId = $row["Id"];
			if ($db) {echo '<br>New SubmissionId ' . $SubmissionId;}
			
			$query = "Select * from DNDetails Where SubmissionId = " . $OldSubmissionId . " order by Id";
			
			if ($db) {echo '<br>' . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			
			while ($row = mysqli_fetch_array($result)) {				
				$Id = $row["Id"];		
				$PermitNumber =  $row["permit_number"]; 
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
				$PermitType =  $row["PermitType"]; 
				$StreetAddress = $row["StreetAddress"];
				$Additional = $row["Additional"];

				$query = "Insert into DNDetails ( 
				permit_number,
				period, Atime, Location, Trench, Bore, Open_Cut, Test_Hole, Final_Patch,
				Dig_in_Dirt, Landscape_Clean_up, Aerial, Tree_Trimming, Traffic_Only,
				Blanket, Additional, StreetAddress, PermitType, SubmissionId) values ( " . 
				"  '" . $PermitNumber . "' , " .
				"  '" . $period . "' , " .
				"  '" . $Atime . "' , " .
				"  '" . $Location . "' , " .
				"  '" . $Trench . "' , " .
				"  '" . $Bore . "' , " .
				"  '" . $Open_Cut . "' , " .
				"  '" . $Test_Hole . "' , " .
				"  '" . $Final_Patch . "' , " .
				"  '" . $Dig_in_Dirt . "' , " .
				"  '" . $Landscape_Clean_up . "' , " .
				"  '" . $Aerial . "' , " .
				"  '" . $Tree_Trimming . "' , " .
				"  '" . $Traffic_Only . "' , " .
				"  '" . $Blanket . "' , " .
				"  '" . $Additional . "' , " .
				"  '" . $StreetAddress . "','" . $PermitType . "'," . $SubmissionId . ")";
				if ($db) {echo "<br>|" . $query . "|";}
				$result2 = mysqli_query($connection2, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection2));
			}
		} else {			
			if ($db) {echo '<br>No New SubmissionId ';}
		}
		
	}	
}
if (isset($_GET["Id"])) {$Id = $_GET["Id"];} // probably not needed
		
// Create web page / email 
$DN = '';
	
// Top not repeated -> enter here, before the loop
$DN = $DN . '	<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">';
$DN = $DN . '		<div class="col-sm-1" >';
$DN = $DN . '			<img src="http://pip.vabeachpu.com/seal_just_seal_color.jpg" style="width:60px;" >';
$DN = $DN . '		</div>	';
$DN = $DN . '		<div class="col-sm-1" >';
$DN = $DN . '			&nbsp;';
$DN = $DN . '		</div>';		
$DN = $DN . '		<div class="col-sm-10" style="font-size: large; font-weight: bold">';
$DN = $DN . '			Notification to Start Work in the City of Virginia Beach Right of Way<br>';
$DN = $DN . '			This form must be completed daily before 9:00 am';
$DN = $DN . '		</div>';
$DN = $DN . '	</div>';

$DN = $DN . '<table border=0 width="100%">';	
$DN = $DN . '<tr>';
$DN = $DN . '<td colspan=5 style="height:10px;">';
$DN = $DN . '&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '</tr>';	
$DN = $DN . '<tr>';
$DN = $DN . '<td style="width:5%; color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>UTILITY&nbsp;COMPANY:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border-bottom: 1px solid black; width:30%; color: black; font-family:Calibri; font-size: 14pt;">';
$DN = $DN . '	&nbsp;<b>' .  str_replace("''","'",$utilityCompany)  . '</b>&nbsp;';
$DN = $DN . '</td>';	
$DN = $DN . '<td style="width:10%">';
$DN = $DN . '	&nbsp;&nbsp;';
$DN = $DN . '</td>';	
$DN = $DN . '<td style="width:5%; color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>CONTRACTOR:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border-bottom: 1px solid black; width:40%; color: black; font-family:Calibri; font-size: 14pt;">';
$DN = $DN . '	&nbsp;<b>' .  str_replace("''","'",$Contractor)  . '</b>&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '</tr>';

$DN = $DN . '</table>';
$DN = $DN . '<table width="100%" border=0>';
$DN = $DN . '<tr>';
$DN = $DN . '<td style="vertical-align:bottom; height:33px; width:5%; color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>CONTACT&nbsp;PERSON:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="vertical-align: bottom; width:25%; border-bottom: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
$DN = $DN . '	&nbsp;<b>' .  str_replace("''","'",$contactPerson)  . '</b>&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="">';
$DN = $DN . '	&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="vertical-align:bottom; text-align:right;  color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>PHONE&nbsp;#:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="vertical-align: bottom; width:20%;border-bottom: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
$DN = $DN . '	&nbsp;<b>' .  $phone . '</b>&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="">';
$DN = $DN . '	&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="vertical-align:bottom; text-align:right;  color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>DATE&nbsp;OF WORK&nbsp;';
$DN = $DN . '<font style="font-size: 8pt;">(Current&nbsp;Date&nbsp;Only)</font>:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="vertical-align: bottom; width:10%; border-bottom: 1px solid black; color: black; font-family:Calibri; font-size: 14pt; ">';

$DoW = '';
if (isset($dateOfWork)) {$DoW = DisplayDate($dateOfWork);}
if (isset($_GET["action"]) && trim($_GET["action"]) == "recall") { 
	$DN = $DN . '	&nbsp;<input type="text" id="datepicker" style="width:100%" 
	value='. $DoW . ' name="dateOfWork" onchange="Add2URL();">';
} else {			
	$DN = $DN . '	&nbsp;<b>' .  DisplayDate($dateOfWork) . '</b>&nbsp;';
}
$DN = $DN . '</td>';
$DN = $DN . '</tr>';
$DN = $DN . '<tr>';
$DN = $DN . '<td colspan=5>';
$DN = $DN . '	&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '</tr>';
$DN = $DN . '</table>';
$DN = $DN . '<table style="width:100%" border=1>';
$DN = $DN . '<tr>';
$DN = $DN . '<td style="width:150px; border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;" rowspan="2" >';
$DN = $DN . '	&nbsp;<u>PERMIT&nbsp;NUMBER</u>&nbsp;<br>';
$DN = $DN . '	MANDATORY ';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;"  colspan="2">';
$DN = $DN . '	&nbsp;&nbsp;Estimated&nbsp;Time&nbsp;&nbsp;<br>';
$DN = $DN . '	of&nbsp;Arrival';
$DN = $DN . '</td>';
$DN = $DN . '<td style="width:289px; border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;" rowspan="2" >';
$DN = $DN . 'Location&nbsp;&amp;&nbsp;Nearest&nbsp;Cross&nbsp;Street&nbsp;<br>Please Print Clearly  ';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;" colspan="11">';
$DN = $DN . '	Work Description <br>(Check&nbsp;Only&nbsp;Where&nbsp;Applicable) ';
$DN = $DN . '</td>';
$DN = $DN . '</tr>';
$DN = $DN . '<tr>';
$DN = $DN . '<td style="width:55px; border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;"  >';
$DN = $DN . '	AM';
$DN = $DN . '</td>';
$DN = $DN . '<td style="width:55px; border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	PM';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;Trench&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;&nbsp;Bore&nbsp;&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;Open<br>Cut';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;Test&nbsp;&nbsp;<br>&nbsp;&nbsp;Hole&nbsp;&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;Final&nbsp;<br>&nbsp;&nbsp;Patch&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;Dig&nbsp;In&nbsp;&nbsp;&nbsp;<br>&nbsp;Dirt&nbsp; ';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;&nbsp;Landscape&nbsp;&nbsp;<br>Clean-up ';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;Aerial&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	Tree<br>&nbsp;&nbsp;Trimming&nbsp;&nbsp;&nbsp;';
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;Traffic&nbsp;&nbsp;<br>Only'; 
$DN = $DN . '</td>';
$DN = $DN . '<td style="border: 4px solid black; text-align:center; font-weight:bold; color: black; font-family:Calibri; font-size: 11pt;">';
$DN = $DN . '	&nbsp;&nbsp;&nbsp;Blanket&nbsp;&nbsp;&nbsp;<br>YES/NO ';
$DN = $DN . '</td>'; 
$DN = $DN . '</tr>';

//$query = "Select * from DNDetails Where Id = " . $_GET["Id"]; // archive
	
$query = "Select * from DNDetails Where SubmissionId = " . $SubmissionId . " order by Id";
if ($db) {echo '<br>' . $query;}
$Additional = "";
$coma = '';
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
	if (trim($row["Additional"]) <> "") {
		//$Additional = $Additional . $coma . str_replace("'","''",$row["Additional"]);
		$Additional = $Additional . $coma . str_replace("'","''",$row["Additional"]) . ' (' . $PermitNumber . ')';		
		$coma = ', ';
	}
	
	$PermitType =  str_replace("'","''",$row["PermitType"]);	
	
	$DN = $DN . '<tr>';
	$DN = $DN . '<td style="height:37px; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt; ">';
	//if (isset($_POST["epermit"])) {$DN = $DN . '	&nbsp;<b>Emergency</b><br>';}
	$LocationP = 'deleteLine("' . $Location . '")'; ?>
	<input type="hidden" id="location<?php echo $Id;?>" value="<?php echo $Location;?>">
	<?php
	$DN = $DN . '<a title="Delete this line" onclick="deleteLine('. $Id . ',' . $SubmissionId . ');">
	<img src="delete.jpg"></a>&nbsp;<a href="DNOnlineForm.php?SubmissionId=' . 
	$SubmissionId . '&Id=' . $Id . '" title="Edit this line"><b>' .  $PermitNumber . '</b></a>';
	if (trim($PermitType) <> "") {$DN = $DN . '<br>&nbsp;<b>' . $PermitType . '</b>';}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt; ">';
	$DN = $DN . '	<b>&nbsp;';
	if ($period == "AM") {$DN = $DN . trim($Atime) . '</b>';}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	$DN = $DN . '	<b>&nbsp;';
	if ($period == "PM") {$DN = $DN . $Atime . '</b>';}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	$DN = $DN . '	&nbsp;<b>' .  str_replace("''","'",$Location) . '</b>';
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center;  border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	$DN = $DN . '	&nbsp;';
	if($Trench == 'yes') {
		$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Bore == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Open_Cut == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Test_Hole == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Final_Patch == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Dig_in_Dirt == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Landscape_Clean_up == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Aerial == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Tree_Trimming == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Traffic_Only == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '<td style="text-align:center; border: 1px solid black; color: black; font-family:Calibri; font-size: 14pt;">';
	if($Blanket == 'yes') {$DN = $DN . '<b><img src=checkedbox.jpg></b>';
	} else {
		$DN = $DN . '<b><img src=uncheckedbox.jpg></b>';	
	}
	$DN = $DN . '</td>';
	$DN = $DN . '</tr>';
	}
			$count = 1;
	while ($count > 0) {
		$DN = $DN . '<tr>';
		$Icount = 14;
		while ($Icount >= 1) {
			if ($count == 1 and $Icount == 14) {
				$DN = $DN . 
				'<td style="height:26px; border: 1px solid black;">
				<a href="DNOnlineForm.php?SubmissionId=' . 
				$SubmissionId . '&action=np&Id=' . $Id . '">
				<img src="plus.jpg">&nbsp;<b>New Permit</b></a></td>';
			}
			if ($count == 1 and $Icount == 12) {	
				$DN = $DN . '
				<td style="height:26px; border: 1px solid black;">
				<a href="DNOnlineForm.php?SubmissionId=' . 
				$SubmissionId . '&action=nl&Id=' . $Id . '">
				<img src="plus.jpg">&nbsp;<b>Enter Next Location</b></a></td>';
			}
			$DN = $DN . '<td style="height:26px; border: 1px solid black;"></td>';
			$Icount = $Icount - 1;
		}
		$DN = $DN . '</tr>';
		$count = $count - 1;
	}


$DN = $DN . '</table>';
$DN = $DN . '<p>&nbsp;</p>';
$DN = $DN . '<table width="100%" border=0>';
$DN = $DN . '<tr>';
$DN = $DN . '<td style="vertical-align:top; height:33px; width:5%; color: black; font-family:Calibri; font-size: 11pt;" >';
$DN = $DN . '	<b>Additional&nbsp;Information:</b>';
$DN = $DN . '</td>';
$DN = $DN . '<td style="width:50%; vertical-align: top;  color: black; font-family:Calibri; font-size: 14pt;">';
$DN = $DN . '	&nbsp;<b>' .  str_replace("''","'",$Additional) . '</b>&nbsp;';
$DN = $DN . '</td>';

$DN = $DN . '<td style="vertical-align: top;  color: black; font-family:Calibri; font-size: 14pt;">';

$LocationS = 'deleteSub("' . $Location . '")'; 
if (!isset($Location)) {$Location = "";}?>
<input type="hidden" id="location<?php echo $Id;?>" value="<?php echo $Location;?>">
<?php	
$DN = $DN . '<a href="DNOnlineForm.php?action=ds&SubmissionId=';
$DN = $DN . $SubmissionId . '" title="Delete this Daily Notification submission" 
onclick="deleteSub('. $Id . ',' . $SubmissionId . ');"><img src="delete.jpg">';
$DN = $DN . 'Delete this entire Daily Notification Submission</a>';
$DN = $DN . '</td>';

$DN = $DN . '</tr>';
$DN = $DN . '</table>';
$DN = $DN . '</td>';
//$DN = $DN . '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
$DN = $DN . '	</tr>';
$DN = $DN . '</table>';
			?>
			
			Click <b>
			<input type="hidden" id="StoreSendDNroot" value="StoreSendDN.php?FA=send&SubmissionId=<?php echo $SubmissionId;?>">;
			<a id="StoreSendDN" href="StoreSendDN.php?FA=send&SubmissionId=<?php echo $SubmissionId;?>"> 
			Send Daily Notification </a>  </b> if the information below is correct or 
			select a permit number below to edit
		</div>			
		</div>
		<div class="row" style="height: 10px; background-color: white">
			<div class="col-sm-12" >		
				&nbsp;
			</div>			
		</div>
			
		<div class="row" style="background-color: white">
		<div class="col-sm-12" >		
		<?php
		echo $DN;
		?>
		</div>
	</div>
</div>
		
</body>
</html>