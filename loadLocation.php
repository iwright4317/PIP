<?php 
$permit_number = $_GET['permit_number'];
if ($permit_number != 'Emergency' && $permit_number != 'New Blanket/ROW Permit') {
	
	include ('./includes/database.inc');
	
//echo '<b>1: ' . $permit_number;
//$parts[] = explode(" ",$permit_number,0);
$permits = explode(" ",$permit_number);
//$permit_number = $parts[0];
//echo '<b>2: ' . $permits[0];
//echo '<b>3: ';
//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
$q = "Select PermitAddress,LocationDescription from PIP Where PermitNumber like '" . $permits[0] . "%' order by DateOfSignature desc";
$r = mysqli_query($connection,$q) or die("<br/>Query failed");
if ($row = mysqli_fetch_array($r)) {
	echo $row[0];
} else {
	echo "permit not found"; 
}
}
?>