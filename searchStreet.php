<?php
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

include ('./includes/database.inc');
$text = $connection->real_escape_string($_GET['term']);
$utilityCompany = $connection->real_escape_string($_GET['utilityCompany']);

$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
 
$query = "SELECT PermitAddress FROM PIP
where PermitAddress LIKE '%$text%' and `CompanyName`= '" . $utilityCompany . "' and 
(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY'  or `PermitStatus` = 'RIGHT-OF-WAY') and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;

$json = '[';
$first = true;

$r = mysqli_query($connection,$query) or die("<br/>Query failed");
$i = 0;
While ($row = mysqli_fetch_array($r)) {
		
    if (!$first) { $json .=  ','; } 
    else {
    	$first = false;	
	}
    $json .= '{"value":"'.$row[0].'"}';
}
$json .= ']';
echo $json;

?>
