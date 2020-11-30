<?php
session_start();
$Normal = TRUE;
if ($Normal) {
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | DN Online Form </title>
</head>
<body>
	
<?php
include ('./includes/banner.inc');
include ('./includes/database2.inc');
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
				<div class="col-md-12" style="font-size: x-large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
					Daily Notifications - Permit: <?echo $_GET["pn"];?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12" style="font-size: large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
					Edit a Daily Notification by clicking on the Notification Date&nbsp;<br>
				</div>
			</div>
			
			
	<div class="row">
	<div class="col-sm-12" style="font-size: normal; ">
<?php
}
$Id = 0;
$PreExisting = FALSE;

$db = True;
$db = False;

$query = "Select * from `DNDetails` Where permit_number = '" . $_GET["pn"] . "'";

$query = "SELECT * FROM `DailyNotifications`,`PIP`,`DNDetails` 
Where DailyNotifications.PermitId = PIP.Id and 
PermitNumber = '" . $_GET["pn"] . "' and permit_number = '" . $_GET["pn"] . "' 
order by DailyNotifications.Id desc";

$query = "SELECT DailyNotifications.Id, DNDate, CompanyName, PermitNumber 
FROM `DailyNotifications`,`PIP`  
Where DailyNotifications.PermitId = PIP.Id and 
PermitNumber = '" . $_GET["pn"] . "' 
order by DailyNotifications.Id desc";

//echo "<br>" . $query;
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
	echo "<table><tr>
	<th style='padding-left:10px; padding-right:10px;'>Notification Date</th>
	<th style='padding-left:10px; padding-right:10px; width:110px'>Permit</th>
	<th style='padding-left:10px; padding-right:10px;'>Utility Company</th>
	<th style='padding-left:10px; padding-right:10px;'>Date of Work</th>
	<th style='padding-left:10px; padding-right:10px;'>Contractor</th>
	<th style='padding-left:10px; padding-right:10px;'>Location</th>
	<th style='padding-left:10px; padding-right:10px;'>DN Email</th>
	</tr>";
	while ($row = mysqli_fetch_array($result)) {
		
		$query2 = "SELECT DNSubmissions.dateOfWork, DNSubmissions.Contractor, Location, DNSubmissions.Id, EmailFile FROM `DNSubmissions`, `DNDetails` Where `permit_number` = '" . $_GET["pn"] . "' 
		and SubmissionId = DNSubmissions.Id and DNSubmissions.dateOfWork = '" . $row["DNDate"] . "' Order by DNSubmissions.dateOfWork desc";
		$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection2));
		//echo "<br>$query2";
		$firstsubmission = True;
		while ($row2 = mysqli_fetch_array($result2)) {
			//echo "<br>record found found";
			if (!$firstsubmission) {
				echo "<tr>";
				WriteRow("&nbsp;", $firstsubmission);
				if (isset($row[3]) ) {WriteRow($row[3], $firstsubmission);}	
				WriteRow("&nbsp;", $firstsubmission);
			} else {				
				echo "<tr>";
				echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>
				<a target=_blank href=StoreSendDN2.php?SubmissionId=" . $row2[3] . "&action=edit>" . DisplayDate($row["DNDate"]) . "</td>";
				if (isset($row[3]) ) {WriteRow($row[3], $firstsubmission);}
				echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . str_replace(" ","&nbsp;",$row["CompanyName"]) . "</td>";		
			}
			if (isset($row2[0])) {WriteRow(DisplayDate($row2[0]), $firstsubmission);}
			if (isset($row2[1]) ) {WriteRow($row2[1], $firstsubmission);}
			if (isset($row2[2]) ) {WriteRow($row2[2], $firstsubmission);}	
			//echo "<br>fs: " .				$firstsubmission;
			//echo "<br>" . $row2[4];
			if (isset($row2[4]) && $firstsubmission) {
				WriteRow(
				"<a target=_blank href='" . $row2[4] . "'>email</a>", $firstsubmission);
			} else {
				WriteRow("&nbsp;", $firstsubmission);
			}
			echo "</tr>";
			$firstsubmission = false;
		}
		
		If ($firstsubmission) { // only basic daily notification
			echo "<tr>";
			if (isset($row[1])) {WriteRow(DisplayDate($row[1]), $firstsubmission);}			
			if (isset($row[3]) ) {WriteRow($row[3], $firstsubmission);}		
			if (isset($row[2]) ) {WriteRow(str_replace(" ","&nbsp;",$row[2]) , $firstsubmission);}
			WriteRow("&nbsp;", $firstsubmission);
			WriteRow("&nbsp;", $firstsubmission);
			WriteRow("&nbsp;", $firstsubmission);
			WriteRow("&nbsp;", $firstsubmission);
			echo "</tr>";
				
		}
		
		if (false) {
		$Id = $row["Id"];		
		$utilityCompany =  str_replace("'","''",$row["utilityCompany"]);
		$Contractor =  str_replace("'","''",$row["Contractor"]); 
		$contactPerson =  str_replace("'","''",$row["contactPerson"]); 
		$phone =  $row["phone"]; 
		$dateOfWork =  DisplayDate($row["dateOfWork"]); 
		$PermitNumber =  $row["permit_number"]; 
		$period =  $row["period"]; 
		$Atime =  $row["Atime"]; 
		$Location =  $row["Location"]; 
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
		$Additional =  str_replace("'","''",$row["Additional"]);	
		$PermitType = $row["PermitType"];	
		
		//echo "<br>" . $dateOfWork;
		
		}
	
	}	
	
	if (false) {
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
	}
	
function WriteRow($item, $firstsubmission) {
	
			if (isset($item) ) {
				if ($firstsubmission) {
					echo "<td style='border-top: 1px black solid;padding-left:10px; padding-right:10px;'>" . $item. "</td>";
				} else {					
					echo "<td style='padding-left:10px; padding-right:10px;'>" . $item . "</td>";
				}
			} else {
				echo "<td style='border-top: 1px black solid;' ><i>&nbsp;</i></td>";
			}
			return true;
}
