<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");
?>
<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body style='margin:0; font-family:Arial;' >
<img src='http:\\pip.vabeachpu.com\sealBW.jpg' height='173' width='624'>
<table width='624' border=0 style='font-family:Arial;'>
<tr style='height:50px; font-family:Arial; font-size:6pt'>
<td style='width=50%;'>
DEPARTMENT&nbsp;OF&nbsp;PUBLIC&nbsp;UTILITIES<br>
ENGINEERING&nbsp;DIVISION<br>
(757)&nbsp;385-4171<br>
FAX&nbsp;(757)&nbsp;385-5778<br>
TTY&nbsp;711&nbsp;OR&nbsp;(800)&nbsp;828-1120
</td>
<td style='text-align:right; width=50%'>
MUNICUPAL&nbsp;CENTER<br>
BUILDING&nbsp;2<br>
2405&nbsp;COURTHOUSE&nbsp;DRIVE<br>
VIRGINIA&nbsp;BEACH,&nbsp;VA&nbsp;23456&#8209;9041<br>
</td>
</tr>
</table>
<table width='624' border=0 style='font-family:Arial;'>
<tr style='height:53px;'>
<td colspan='2' style='font-family:Arial;font-size: 12pt; width: 100%; text-align: center; font-weight: bold' >
INTER-OFFICE MEMO
</td>
</tr>

			<?php

include ('./includes/database.inc');
			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
			//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
			$strSQL = "";
			$edit = false;

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack			

			If ($_GET["Id"] <> "") {
				$edit = true;

				$q = "Select PIP.Id, PermitNumber, PermitAddress, FirstName, LastName,
				PermitStatus, MiddleInitial, DateOfSignature  From PIP, Login Where PIP.Id = " . $_GET["Id"] . " and 
				Login.FirstName = PIP.Technician ";
				//echo "|" . $q . "|";
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				If ($row = mysqli_fetch_array($r)) {
					$PermitId = $row[0];
					$PermitNumber = $row[1];
					$PermitAddress = $row[2];
					$Technician = $row[3] . ' ' . $row[4];
					$FirstName = $row[3];
					$LastName = $row[4];
					$PermitStatus = $row[5];
					$MiddleInitial = $row[6];
					$DateOfSignature = $row[7];
				} else {
					$PermitAddress = "Permit not found";
				}
			}
			?>

<tr >
<td style='font-family:Arial;font-size: 12pt;  font-weight: bold' >
DATE:
</td>
<td style='font-family:Arial;font-size: 12pt; font-weight: normal' >
<?php 
$sdate = date_create($DateOfSignature);
echo date_format($sdate,"l") .', ' . date_format($sdate,"F") . ' ' . 
date_format($sdate,"j") . ', ' . date_format($sdate,"Y"); ?>
</td>
</tr>
<tr style='height:53px;'>
<td style='font-family:Arial;font-size: 12pt;   font-weight: bold' >
TO:
</td>
<td style='font-family:Arial;font-size: 12pt; font-weight: normal' >
Planning/Permits & Inspections
</td>
</tr>

<tr style=''>
<td style=' font-family:Arial;font-size: 12pt;  font-weight: bold' >
FROM:
</td>
<td style='font-family:Arial;font-size: 12pt; font-weight: normal' >
<?php echo $Technician . ", PU/Engineering "; ?>
</td>
</tr>
<tr style='display: block; border-bottom: 1px solid #000;  '>
<td style=' font-family:Arial;font-size: 12pt;  font-weight: bold; vertical-align: top;' >
<br>SUBJECT:&nbsp;&nbsp;
</td>
<td style='font-family:Arial;font-size: 12pt; font-weight: normal' >
<br>
<?php echo 'Utility Right-of-Way Permit ' . $PermitNumber . "<br> "; 
echo str_replace(', Virginia Beach, VA, United States','',$PermitAddress);
?>
</td>
</tr>
</table>
<hr>
<table  width='624' border=0 style='font-family:Arial;'>
<tr style='height:53px;'>
	<td colspan='3'>
		<?php
		if ($PermitStatus == 'APPROVED') {
			echo 'Public Utilities approves the subject permit.';			
		}
		if ($PermitStatus == 'APPROVED WITH CONDITIONS') {
			echo 'Public Utilities approves the subject permit with the following conditions:';			
		}
		?>
	</td>
</tr>	
			
			<tr style='font-size: 12pt; font-weight: bold;'>
				<th colspan=2>&nbsp;Codes&nbsp;</th>
				<th>&nbsp;Description&nbsp;</th>
			</tr>

			<?php

			$q = "Select * from ConditionMessagesComments, ConditionMessages " . "where PermitID = " . $_GET["Id"] . " and " . "ConditionMessages.Id = ConditionMessagesComments.CMId ";
			$PermitId = $row["Id"];

			$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
			while ($row = mysqli_fetch_array($r)) {
				If ($row["IncludeWithComments"] == "y") {
					$TestText = $row["Comment"];
					//$vbCrLf  = ControlChars.Lf;
					//TestText = TestText.Replace(vbCrLf, "<br />")
 					echo '<tr style="background-color: white; border-top-style: solid; border-width: 1px; vertical-align:top; font-size: 12pt">';                   
					echo '<td style="vertical-align:top; font-size: 12pt">&nbsp;' . $row["LetterCode"] . '&nbsp;</td>';
					echo '<td style="vertical-align:top; font-size: 12pt">&nbsp;' . $row["NumberCode"] . '&nbsp;</td>';
					echo '<td style="vertical-align:top; font-size: 12pt">' . nl2br($row["StandardText"]);
					echo ' <b>' . nl2br($TestText) . '</b></td>';
					echo '</tr>';
				}
			}

			$q = "Select * from PIPDiary where PermitID = " . $PermitId . " and " . "IncludeWithComments = 'y' ";

			$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
			while ($row = mysqli_fetch_array($r)) {
				If ($row["IncludeWithComments"] == "y") {
					echo '<tr style="font-size: 12pt"><td style="vertical-align:top;" >&nbsp;</td>';
					echo '<td style="vertical-align:top;">&nbsp;</td><td style="vertical-align:top;"><b>' . $row["Entry"];
					echo '</td></tr>';				
				}			
			}
			?>
			<tr><td colspan='3'>&nbsp;</td></tr>
			<tr><td colspan='3'><?php echo substr($FirstName,0,1) . $MiddleInitial . substr($LastName,0,1) . '/'; ?></td></tr>
			<tr><td colspan='3'>&nbsp;</td></tr>
			<tr><td colspan='3'>c:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Donald S. Piron, P.E., PU/Engineering</td></tr>
			</table>
		</div>
	</div>
</body>