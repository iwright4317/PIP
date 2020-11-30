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
						
function DisplayDate($ADate, $wTime = false) {			
	$date = date_create($ADate);
	
	if ($wTime) {
		return date_format($date , "m/d/Y H:i:s") ; 
	} else {
		return date_format($date , "m/d/Y") ; 
	}
		
}
	
$LoginId = $_SESSION["user_id"];
If (isset($_GET["LoginId"])) {
	$LoginId = $_GET["LoginId"];
}

$FirstName = "";
$LastName = "";
$Org = "";
$query = "Select * from Login Where Id = " . $LoginId;
//echo "<br>$query";
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$FirstName = $row["FirstName"];
	$LastName = $row["LastName"];
	$Org = $row["Organization"];
}

?>
<div class="container" style="font-size: normal; background-color: whitesmoke">	
	<div class="row">
		<div class="col-md-12" style="font-size: x-large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
			Daily Notifications - <?php echo $FirstName . " " . $LastName . " - " . $Org;?>
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12" style="font-size: large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
			<?php
			if ($admin) { ?>
				Edit a Daily Notification by clicking on the Notification Date&nbsp;<br>
			<?php
			} ?>
					
		</div>
	</div>			
			
	<div class="row">
		<div class="col-sm-12" style="font-size: normal; ">
<?php

$Id = 0;
$PreExisting = FALSE;

$db = True;
$db = False;

		echo "<table><tr>
		<th style='padding-left:10px; padding-right:10px;'>Notification Date</th>
		<th style='padding-left:10px; padding-right:10px; width:110px'>Permit</th>
		<th style='padding-left:10px; padding-right:10px;'>Utility Company</th>
		<th style='padding-left:10px; padding-right:10px;'>Date of Work</th>
		<th style='padding-left:10px; padding-right:10px;'>Contractor</th>
		<th style='padding-left:10px; padding-right:10px;'>DN Email</th>
		</tr>";
			
$query2 = "SELECT DNSubmissions.dateOfWork, DNSubmissions.Contractor, 
Location, DNSubmissions.Id, EmailFile, permit_number, DNSubmissions.utilityCompany,
SubmissionDateTime    
FROM `DNSubmissions`, `DNDetails` 
Where `LoginId` = " . $LoginId . " and SubmissionId = DNSubmissions.Id  
Order by DNSubmissions.dateOfWork desc, permit_number ";
		echo $query2;
		
		$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection2));
		
		$dateOfWork = "";
		$permitsList = "";
		$lastPermit = "";
		$UtilityCompany = "";
		$Contractor = "";
		$EmailFile = "";
		$SubmissionDateTime = "";
		$SubmissionId = 0;
		
		while ($row2 = mysqli_fetch_array($result2)) {
			if ($row2[0] <> $dateOfWork && $dateOfWork <> "") {
				echo "<tr>";
				if ($admin) {
					echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>
					<a target=_blank href=StoreSendDN2.php?SubmissionId=" . $SubmissionId . 
					"&action=edit>" . DisplayDate($SubmissionDateTime, true) . "</td>";
				} else {
					echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . 
					DisplayDate($SubmissionDateTime, true) . "</td>";									
				}
				if (isset($permitsList) ) {WriteRow($permitsList);}
				echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . str_replace(" ","&nbsp;",$row2["utilityCompany"]) . "</td>";		
			
				if (isset($row2[0])) {WriteRow(DisplayDate($dateOfWork));}
				if (isset($row2[1]) ) {WriteRow($Contractor);}
				//if (isset($row2[2]) ) {WriteRow($row2[2]);}	not using locations

				if (isset($EmailFile)) {
					WriteRow(
					"<a target=_blank href='" . $EmailFile. "'>email</a>");
				} else {
					WriteRow("&nbsp;");
				}
				echo "</tr>";			
			
				$permitsList = "";			
			}

			if ($lastPermit <> $row2[5] || $permitsList == "") {$permitsList .= $row2[5] . " | ";}
			$lastPermit = $row2[5];
			
			$UtilityCompany = $row2[6];
			$Contractor = $row2[1];
			$SubmissionId = $row2[3];
			$EmailFile = $row2[4];
			$SubmissionDateTime = $row2[7];
			$dateOfWork = $row2[0];
			
			
		} 
		// write-out remain submission 
		echo "<tr>";
				if ($admin) {
					echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>
					<a target=_blank href=StoreSendDN2.php?SubmissionId=" . $SubmissionId . 
					"&action=edit>" . DisplayDate($SubmissionDateTime, true) . "</td>";
				} else {
					echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . 
					DisplayDate($SubmissionDateTime, true) . "</td>";									
				}
				if (isset($permitsList) ) {WriteRow($permitsList);}
				echo "<td style='border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . str_replace(" ","&nbsp;",$row2["utilityCompany"]) . "</td>";		
			
				if (isset($dateOfWork)) {WriteRow(DisplayDate($dateOfWork));}
				if (isset($Contractor) ) {WriteRow($Contractor);}
				//if (isset($row2[2]) ) {WriteRow($row2[2]);}	not using locations

				if (isset($EmailFile)) {
					WriteRow(
					"<a target=_blank href='" . $EmailFile. "'>email</a>");
				} else {
					WriteRow("&nbsp;");
				}
				echo "</tr>";				
		?>
		</div>
	</div>
</div>
<?php	
function WriteRow($item) {
	
	if (isset($item) ) {
		echo "<td style='border-top: 1px black solid;padding-left:10px; padding-right:10px;'>" . $item. "</td>";
	} else {
		echo "<td style='border-top: 1px black solid;' ><i>&nbsp;</i></td>";
	}
	return true;
}
?>
</body>