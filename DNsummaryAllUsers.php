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
	
$LoginId = $_SESSION["user_id"];
If (isset($_GET["LoginId"])) {
	$LoginId = $_GET["LoginId"];
}

$FirstName = "";
$LastName = "";
$query = "Select * from Login Where Id = " . $LoginId;

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$FirstName = $row["FirstName"];
	$FirstName = $row["LastName"];
}

?>
<div class="container" style="font-size: normal; background-color: whitesmoke">	
	<div class="row">
		<div class="col-md-12" style="font-size: x-large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
			Daily Notifications - All users
		</div>
	</div>
			
	<div class="row">
		<div class="col-md-12" style="font-size: large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue ) ">
			<?php
			if ($admin) { ?>
				<!-- Edit a Daily Notification by clicking on the Notification Date&nbsp;<br> -->				
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
		<th style='padding-left:10px; padding-right:10px;'>Work<br>Count</th>
		<th style='padding-left:10px; padding-right:10px; '>Name</th>
		<th style='padding-left:10px; padding-right:10px;'>Organization</th>
		<th style='padding-left:10px; padding-right:10px;'>Email</th>
		</tr>";
			
$query2 = "SELECT DNSubmissions.dateOfWork, DNSubmissions.Contractor, 
Location, DNSubmissions.Id, EmailFile, permit_number, DNSubmissions.utilityCompany,
SubmissionDateTime    
FROM `DNSubmissions`, `DNDetails` 
Where `LoginId` = " . $LoginId . " and SubmissionId = DNSubmissions.Id  
Order by DNSubmissions.dateOfWork desc";

$query2 = "SELECT LoginId, count(LoginId), FirstName, LastName, Organization, UserName  
FROM `DNSubmissions`,Login 
Where Login.Id = LoginId and SecurityLevel < 3 group by LoginId, FirstName, LastName, Organization 
order by Organization, FirstName, LastName ";
			
$result2 = mysqli_query($connection2, $query2) or 
die("Query failed" . " " . $query2 . " " . mysqli_error($connection2));
		
$total = 0;
$totalsubs = 0;
$notCount = 0;

while ($row2 = mysqli_fetch_array($result2)) {
	$total++;
	echo "<tr>";		
	
	$query = "select count(*) from DNDetails, DNSubmissions, Login 
	Where SubmissionId = DNSubmissions.Id and Login.Id = LoginId and LoginId = " . $row2["LoginId"];
	//echo "<br>$query";
	$result = mysqli_query($connection, $query) or 
	die("Query failed" . " " . $query . " " . mysqli_error($connection));
	If ($row = mysqli_fetch_array($result)) {
		$notCount+= $row[0];
		//WriteRow($row[0]);
	}	
	
	
	if ($admin) {
		echo "<td style='text-align:right; border-top: 1px black solid; padding-left:10px; padding-right:10px;'>
		<a target=_blank href=DNsummaryByUser.php?LoginId=" . $row2["LoginId"] . 
		"&action=edit>" . $row[0] . "</td>";
	} else {
		echo "<td style='text-align:right;border-top: 1px black solid; padding-left:10px; padding-right:10px;'>" . 
		$row[0] . "</td>";									
	}
	$totalsubs += $row2[1];	
	
	if (isset($row2["FirstName"]) && isset($row2["LastName"])) {
		WriteRow($row2["FirstName"] . " " . $row2["LastName"]); }
	if (isset($row2["Organization"])) { WriteRow($row2["Organization"]);}
	if (isset($row2["UserName"])) { WriteRow($row2["UserName"]);}
			
	echo "</tr>";
}
echo "<tr><td colspan='3' style='border-top: 1px black solid;padding-left:10px; padding-right:10px;'>";
echo "Total submissions: " . $notCount;
echo "</td></tr><tr><td colspan='3' style='padding-left:10px; padding-right:10px;'>";
echo "Total submitters: " . $total;
echo "</td></tr>";

$TLess30 = date('Y-m-d', strtotime('today - 32 days'));
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and SubmissionDateTime > '" . $TLess30 . "'";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$L30 = $row[0];
}

echo "<tr><td colspan='3' style='padding-left:10px; padding-right:10px;'>";
echo "Total submissions for past 30 days: " . $L30;
echo "</td></tr>";
echo "</table>";
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