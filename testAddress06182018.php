<?php
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

$mysqli = new mysqli("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest");
$text = $mysqli->real_escape_string($_GET['sFilter']);
//echo "<br>$text";
$utilityCompany = $mysqli->real_escape_string($_GET['utilityCompany']);
//$utilityCompany = "Virginia Natural Gas";

$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
 
$query = "SELECT PermitAddress FROM PIP
where `CompanyName`= '" . $utilityCompany . "' and PermitAddress = '$text' and 
(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS'  or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY' or `PermitStatus` = 'RIGHT-OF-WAY') and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
//echo '<br>' . $query . '<br>';
//echo '<br>' . $text;
//echo '<br>';
$result = $mysqli->query($query);
//$json = '[';
$json = '';
$first = true;
if ($row = $result->fetch_assoc())
{
	//echo $row['PermitAddress'] . '<br>';
    $json = 'address found';
} else {
	$json = 'address not found';
}

echo $json;

?>
