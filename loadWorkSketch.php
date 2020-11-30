<?php 
$permit_number = $_GET['permit_number'];
if ($permit_number != 'Emergency' && $permit_number != 'New Blanket/ROW Permit') {
	
	include ('./includes/database.inc');
//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
$q = "Select WorkSketch from PIP Where PermitNumber Like '" . $permit_number . "%' order by DateOfSignature desc";
$r = mysqli_query($connection,$q) or die("<br/>Query failed");
if ($row = mysqli_fetch_array($r)) {
	echo $row[0];
} else {
	echo "sketch not found"; 
}
}
?>