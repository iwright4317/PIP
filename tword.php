<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "<img src='http:\\pip.vabeachpu.com\seal.jpg' height='173' width='624'>";
echo "<table width='100%'>";
echo "<tr style='font-family:Arial; font-size:6pt'>";
echo "<td>";
echo "DEPARTMENT OF PUBLIC UTILITIES<br>";
echo "ENGINEERING DIVISION<br>";
echo "(757) 385-4171<br>";
echo "FAX (757) 385-5778";
echo "TTY 711 OR (800) 828-1120<BR>";
echo "</td>";
echo "<td style='text-align:right'>";
echo "MUNUCUPAL CENTER<br>";
echo "BUILDING 2<br>";
echo "2405 COURTHOUSE DRIVE<br>";
echo "VIRGINIA BEACH, VA 23456-9041<br>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>