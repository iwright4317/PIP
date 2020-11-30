<?php
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

include ('./includes/database.inc');
//$mysqli = new mysqli("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest");
$text = $connection->real_escape_string($_GET['sFilter']);
//echo "<br>$text";
$utilityCompany = $connection->real_escape_string($_GET['utilityCompany']);
//$utilityCompany = "Virginia Natural Gas";

$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
 
$query = "SELECT PermitAddress FROM PIP
where `CompanyName`= '" . $utilityCompany . "' and PermitAddress like '%" . $text . "%' and 
(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS'  or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY' or `PermitStatus` = 'RIGHT-OF-WAY') and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
//echo '<br>' . $query . '<br>';
//echo '<br>' . $text;
//echo '<br>';
$r = mysqli_query($connection,$query) or die("<br/>Query failed");
//$result = $mysqli->query($query);
if ($row = mysqli_fetch_array($r))
{
	//echo $row['PermitAddress'] . '<br>';
    echo 'address found';
} else {
	echo 'address not found';
}

?>
