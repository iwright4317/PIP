<?php

$mysqli = new mysqli("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP");
$text = $mysqli->real_escape_string($_GET['term']);
//$text = "Dom";
 
$query = "SELECT Contractor, count(Contractor) FROM Contractors WHERE Contractor LIKE '$text%' Group BY Contractor ORDER BY Contractor ASC";
$result = $mysqli->query($query);
$json = '[';
$first = true;
while($row = $result->fetch_assoc())
{
    if (!$first) { $json .=  ','; } else { $first = false; }
    $json .= '{"value":"'.$row['Contractor'].'"}';
}
$json .= ']';
echo $json;

?>
