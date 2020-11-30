<?php
$data2 = array();
$json = array();

include ('./includes/database.inc');
include ('./includes/database2.inc');

$data2 = array();
$json = array();
$json[] = 'Label';
$json[] = 'Value';
$data2[] = $json;
   		
$TLess90 = date('Y-m-d', strtotime('today - 90 days'));
$TLess60 = date('Y-m-d', strtotime('today - 60 days'));

$query = "Select PIP.PermitNumber, DNDate From DailyNotifications, PIP 
Where DNDate > '" . $TLess90 . "' and DNDate < '" . $TLess60 . "' and DailyNotifications.PermitId = PIP.Id "; 
            
$totalPermitCount = 0;
$totalPermitCountOL = 0;
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
While ($row = mysqli_fetch_array($result)) {
	$totalPermitCount++;

	$query2 = "Select DNSubmissions.Contractor from DNSubmissions, 
		DNDetails Where DNSubmissions.Id = SubmissionId and DNDetails.permit_number = '" . $row[0] . "' and 
		DNSubmissions.dateOfWork = '" . date_format(date_create($row[1]),"Y-m-d") . "' ";
		//echo "<p>" . $query2;
	$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection));
	if ($row2 = mysqli_fetch_array($result2)) {
		$totalPermitCountOL++;
		//echo "<br>found";
	} else {
		//echo "<br><b>not found</b>";
	}
}


$per = $totalPermitCountOL / $totalPermitCount * 100;
if (isset($_GET["daily"]) && $_GET["daily"] == "yes") {
	$per = $totalPermitCount;	
}

$json = array();
$json[] = "90 - 60";
$json[] = (int)$per;
$data2[] = $json;

$TLess60 = date('Y-m-d', strtotime('today - 60 days'));
$TLess30 = date('Y-m-d', strtotime('today - 30 days'));

$query = "Select PIP.PermitNumber, DNDate From DailyNotifications, PIP 
Where DNDate > '" . $TLess60 . "' and DNDate < '" . $TLess30 . "' and DailyNotifications.PermitId = PIP.Id "; 
            
$totalPermitCount = 0;
$totalPermitCountOL = 0;
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
While ($row = mysqli_fetch_array($result)) {
	$totalPermitCount++;

	$query2 = "Select DNSubmissions.Contractor from DNSubmissions, 
		DNDetails Where DNSubmissions.Id = SubmissionId and DNDetails.permit_number = '" . $row[0] . "' and 
		DNSubmissions.dateOfWork = '" . date_format(date_create($row[1]),"Y-m-d") . "' ";
		//echo "<br>" . $query2;
	$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection));
	if ($row2 = mysqli_fetch_array($result2)) {
		$totalPermitCountOL++;
	}
}
$per = $totalPermitCountOL / $totalPermitCount * 100;
if (isset($_GET["daily"]) && $_GET["daily"] == "yes") {
	$per = $totalPermitCount;	
}
$json = array();
$json[] = "60 - 30";
$json[] = (int)$per;
$data2[] = $json;


$TLess30 = date('Y-m-d', strtotime('today - 30 days'));

$query = "Select PIP.PermitNumber, DNDate From DailyNotifications, PIP 
Where DNDate > '" . $TLess30 . "' and DailyNotifications.PermitId = PIP.Id "; 
            
//echo "$query<p>";
$totalPermitCount = 0;
$totalPermitCountOL = 0;
$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
While ($row = mysqli_fetch_array($result)) {
	$totalPermitCount++;

	$query2 = "Select DNSubmissions.Contractor from DNSubmissions, 
		DNDetails Where DNSubmissions.Id = SubmissionId and DNDetails.permit_number = '" . $row[0] . "' and 
		DNSubmissions.dateOfWork = '" . date_format(date_create($row[1]),"Y-m-d") . "' ";
		//echo "<p>" . $query2;
	$result2 = mysqli_query($connection2, $query2) or die("Query failed" . " " . $query2 . " " . mysqli_error($connection));
	if ($row2 = mysqli_fetch_array($result2)) {
		$totalPermitCountOL++;
		//echo "<br> found";
	} else {
		//echo "<br><b> not found</b>";
	}
}

//echo "<p><b>totalPermitCountOL: " . $totalPermitCountOL;
//echo "<p>totalPermitCount: " . $totalPermitCount;
//echo "<p><b>";

$per = $totalPermitCountOL / $totalPermitCount * 100;
if (isset($_GET["daily"]) && $_GET["daily"] == "yes") {
	$per = $totalPermitCount;	
}

$json = array();
$json[] = "30 - Now";
$json[] = (int)$per;
$data2[] = $json;

echo json_encode($data2);

?>