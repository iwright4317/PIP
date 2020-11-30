<?php

$mysqli = new mysqli("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP");
$text = $mysqli->real_escape_string($_GET['term']);
//$text = "Dom";
 
$query = "SELECT Foreman, count(Foreman) FROM UtilityVerificationApplication 
WHERE Foreman LIKE '$text%' 
Group by Foreman
ORDER BY Foreman ASC Limit 10";
//echo '<br>' . $query . '<br>';
$result = $mysqli->query($query);
$json = '[';
$first = true;
$preForeman = "";
while($row = $result->fetch_assoc())
{
    if (!$first) { $json .=  ','; } else { $first = false; }
	$foreman = strtolower(str_replace('"', '|',$row['Foreman']));
	$foreman = ucwords($foreman);
	if ($preForeman <> $foreman ) {
    	$json .= '{"value":"'.$foreman.'"}';
	}
	$preForeman = $foreman;
}
$json .= ']';
echo $json;

?>
