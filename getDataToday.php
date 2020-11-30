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

$Tday = date('Y-m-d', strtotime('today'));

if (isset($_GET["item"]) && $_GET["item"] == "work") {
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and 
SubmissionDateTime >='" . $Tday . "' ";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$json = array();
	$json[] = "Work";
	$json[] = (int)$row[0];
	$data2[] = $json;	
}
}


if (isset($_GET["item"]) && $_GET["item"] == "percent" || $_GET["item"] == "total") {
$query = "Select PIP.PermitNumber, DNDate From DailyNotifications, PIP 
Where DNDate >= '" . $Tday . "' and DailyNotifications.PermitId = PIP.Id "; 
            
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

if (isset($_GET["item"]) && $_GET["item"] == "percent") {
$json = array();
$json[] = "% on-line";
$json[] = (int)$per;
$data2[] = $json;
}


if (isset($_GET["item"]) && $_GET["item"] == "total") {
$json = array();
$json[] = "Permits";
$json[] = (int)$totalPermitCount;
$data2[] = $json;
}
}

echo json_encode($data2);

?>