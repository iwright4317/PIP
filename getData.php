<?php
$data2 = array();
$json = array();

include ('./includes/database.inc');
include ('./includes/database2.inc');

$query2 = "SELECT LoginId, count(LoginId), FirstName, LastName, Organization 
FROM `DNSubmissions`,Login 
Where Login.Id = LoginId and SecurityLevel < 3 group by LoginId, FirstName, LastName, Organization 
order by Organization, FirstName, LastName ";

$result2 = mysqli_query($connection2, $query2) or 
die("Query failed" . " " . $query2 . " " . mysqli_error($connection2));
		
$total = 0;
$totalsubs = 0;
$notCount = 0;
$admin = True;

$data2 = array();
$json = array();

$json[] = 'Name';
$json[] = 'Work';
$data2[] = $json;
		
$others = 0;
$cOrganization = "";
$sCount = 0;
while ($row2 = mysqli_fetch_array($result2)) {
	$total++;	
	
	$query = "select count(*) from DNDetails, DNSubmissions, Login 
	Where SubmissionId = DNSubmissions.Id and Login.Id = LoginId and LoginId = " . $row2["LoginId"];
	//echo "<p>$query";
	$result = mysqli_query($connection, $query) or 
	die("Query failed" . " " . $query . " " . mysqli_error($connection));
	If ($row = mysqli_fetch_array($result)) {
		$notCount+= $row[0];
		//WriteRow($row[0]);
	}	
	
	$totalsubs += $row2[1];	
	//echo "<br>Org> " . $row2["Organization"];
	//echo "<br>cOrg> " . $cOrganization;
	//echo "<br>Count " . $row[0];
	if (trim($cOrganization) == "") {$cOrganization = $row2["Organization"]; }
	if ($cOrganization != $row2["Organization"]) {
		//echo "<br>adding";	
		if ($sCount > 20) {
			$json = array();
        	$json[] = $cOrganization;
	        $json[] = $sCount;
    	    $data2[] = $json;	
			$sCount = 0;	
		} else {
			$other+= (int)$row[0];
		}
	}
	$sCount+= (int)$row[0];
	$cOrganization = $row2["Organization"];
}

$json = array();
$json[] = $cOrganization;
$json[] = $sCount;
$data2[] = $json;	

$json = array();
$json[] = "Others";
$json[] = $other;
$data2[] = $json;	

echo json_encode($data2);


?>