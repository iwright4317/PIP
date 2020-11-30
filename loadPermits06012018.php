<?php 
$utilityCompany = $_GET['utilityCompany'];
$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
	
	include ('./includes/database.inc');
//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
		
$q = "SELECT distinct `PermitNumber`,`Id` FROM `PIP` 
where `CompanyName`= '" . $utilityCompany . "' and 
`PermitClosed` <> 'True' and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;

$q = "SELECT distinct `PermitNumber`,`Id` FROM `PIP` 
where `CompanyName`= '" . $utilityCompany . "' and 
(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET') and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;

$r = mysqli_query($connection,$q) or die("<br/>Query failed");
echo "<option>select permit</option>";
echo "<option>Emergency</option>";
echo "<option>New permit</option>";
echo "<option>City Project</option>";
While ($row = mysqli_fetch_array($r)) {
	echo "<option value='$row[0]'>$row[0]</option>";
}

?>
