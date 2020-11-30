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

if (trim($_GET['sFilter']) <> "") {
	
	$street = str_replace(", Virginia Beach, VA, United States", "", $_GET['sFilter']);		
	$street = str_replace(", Virginia Beach, VA", "", $street);			
	$street = str_replace(", Virginia Beach, Virginia, USA", "", $street);		
	$street = str_replace(", USA", "", $street);		
		
	$q = "SELECT distinct `PermitNumber`,`Id`,`PermitAddress` FROM `PIP` 
	where `CompanyName`= '" . $utilityCompany . "' and 
	(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY' or `PermitStatus` = 'RIGHT-OF-WAY') and 
	(DateOfSignature between '" . $myDate . "' and '" . $today . "') and PermitAddress like '" . $street . "%' Order by PermitNumber" ;
	
	$r = mysqli_query($connection,$q) or die("<br/>Query failed");
	$i = 0;
	While ($row = mysqli_fetch_array($r)) {
		if ($i == 0) {echo "<option>select permit (updated)</option>";}
		$street = str_replace(", Virginia Beach, VA, United States", "", $row[2]);		
		$street = str_replace(", Virginia Beach, VA", "", $street);			
		$street = str_replace(", Virginia Beach, Virginia, USA", "", $street);		
		$street = str_replace(", USA", "", $street);	
		echo "<option value='$row[0]'>$row[0] - $street</option>";
		$i++;
	}
	if ($i == 0) {
		echo "<option>You must select a full street address</option>";
	}

} else {
	$q = "SELECT distinct `PermitNumber`,`Id`,`PermitAddress` FROM `PIP` 
	where `CompanyName`= '" . $utilityCompany . "' and 
	(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY' or `PermitStatus` = 'RIGHT-OF-WAY') and 
	(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;

	echo "<option>select permit</option>";
	echo "<option>Emergency</option>";
	echo "<option>New Blanket/ROW Permit</option>";
	echo "<option>City Project</option>";
	$r = mysqli_query($connection,$q) or die("<br/>Query failed");
	While ($row = mysqli_fetch_array($r)) {
		$street = str_replace(", Virginia Beach, VA, United States", "", $row[2]);	
		$street = str_replace(", Virginia Beach, VA", "", $street);	
		$street = str_replace(", Virginia Beach, Virginia, USA", "", $street);	
		$street = str_replace(", USA", "", $street);	
		echo "<option value='$row[0]'>$row[0] - $street</option>";
	}
}


?>
