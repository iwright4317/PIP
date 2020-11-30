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
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and 
SubmissionDateTime > '" . $TLess90 . "' and SubmissionDateTime < '" . $TLess60 . "'";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$L30 = $row[0];	
	$json = array();
	$json[] = "90 - 60";
	$json[] = (int)$row[0];
	$data2[] = $json;	
}


$TLess60 = date('Y-m-d', strtotime('today - 60 days'));
$TLess30 = date('Y-m-d', strtotime('today - 30 days'));
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and 
SubmissionDateTime > '" . $TLess60 . "' and SubmissionDateTime < '" . $TLess30 . "'";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$L30 = $row[0];	
	$json = array();
	$json[] = "60 - 30";
	$json[] = (int)$row[0];
	$data2[] = $json;	
}

$TLess30 = date('Y-m-d', strtotime('today - 32 days'));
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and SubmissionDateTime > '" . $TLess30 . "'";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$L30 = $row[0];	
	$json = array();
	$json[] = "30 - Now";
	$json[] = (int)$row[0];
	$data2[] = $json;	
}

if (FALSE) {
$TLess30 = date('Y-m-d', strtotime('today'));
$query = "Select count(*) From DNDetails, DNSubmissions 
Where SubmissionId = DNSubmissions.Id and SubmissionDateTime > '" . $TLess30 . "'";

$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
If ($row = mysqli_fetch_array($result)) {
	$L30 = $row[0];	
	$json = array();
	$json[] = "Today";
	$json[] = (int)$row[0];
	$data2[] = $json;	
}
}

echo json_encode($data2);

?>