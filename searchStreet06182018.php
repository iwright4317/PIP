<?php
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
//echo '<a href="' . $escaped_url . '">' . $escaped_url . '</a>';

$mysqli = new mysqli("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest");
$text = $mysqli->real_escape_string($_GET['term']);
$utilityCompany = $mysqli->real_escape_string($_GET['utilityCompany']);
//$utilityCompany = "Virginia Natural Gas";

$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;

//$text = "Dom";
 
$query = "SELECT PermitAddress FROM PIP WHERE PermitAddress LIKE '% $text%' ORDER BY PermitAddress ASC";

//$query = "SELECT distinct `PermitAddress`,`Id` FROM `PIP` 
//where `CompanyName`= '" . $utilityCompany . "' and 
//(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS') and 
//(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;

$query = "SELECT PermitAddress FROM PIP
where PermitAddress LIKE '%" . $text . "%' and `CompanyName`= '" . $utilityCompany . "' and 
(`PermitStatus` = 'APPROVED' or `PermitStatus` = 'APPROVED WITH CONDITIONS' or `PermitStatus` = 'BLANKET' or `PermitStatus` = 'EMERGENCY'  or `PermitStatus` = 'RIGHT-OF-WAY') and 
(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
//echo '<br>' . $query;
//echo '<br>' . $text;
//echo '<br>';
$result = $mysqli->query($query);
$json = '[';
$first = true;
while($row = $result->fetch_assoc())
{
    if (!$first) { $json .=  ','; } 
    else {
    	$first = false;		
		//json .= '{"value":"'.$escaped_url.'"}';
		//$json .=  ',';
	}
    $json .= '{"value":"'.$row['PermitAddress'].'"}';
}

$json .= ']';
echo $json;

?>
