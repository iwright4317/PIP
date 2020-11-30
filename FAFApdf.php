<?php
header("Content-type: application/pdf");
header("Content-Disposition: attachment;Filename=document_name.pdf");
?> 
<html>

<body style='margin:0; font-family:Times;' >
	
	
				<?php
				
	include ('./includes/database.inc');
				//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				$txtPermitNumber = '';
				$Technician = '';
				$CompanyName = '';
	if (!empty($_GET['PermitId'])) {
		$query = "Select * from FAFA Where PermitId = " . $_GET['PermitId'] . " ";
		
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$FormDate = $row["FormDate"];
			$ToPlanning = $row["ToPlanning"];
			$ToPermits = $row["ToPermits"];
			$ToInspections = $row["ToInspections"];
			$ToPublicUtilities = $row["ToPublicUtilities"];
			$Permittee = $row["Permittee"];
			$PermitNumber = $row["PermitNumber"];
			$Contractor = $row["Contractor"];
			$SubContractor = $row["SubContractor"];
			$Location = $row["Location"];
			$Reasons = $row["Reasons"];
			$AdditionalTestHoles = $row["AdditionalTestHoles"];
			$AdditionalOpenCuts = $row["AdditionalOpenCuts"];
			$PrintName1 = $row["PrintName1"];
			$PrintName2 = $row["PrintName2"];
			$PrintName3 = $row["PrintName3"];
			$Company1 = $row["Company1"];
			$Company2 = $row["Company2"];
			$Company3 = $row["Company3"];
			$FromName = $row["FromName"];
			$FromPlanning = $row["FromPlanning"];
			$FromPermits = $row["FromPermits"];
			$FromInspections = $row["FromInspections"];
			$FromPublicUtilities = $row["FromPublicUtilities"];							
		}
	}
				?>
				
<img src='http:\\pip.vabeachpu.com\sealBW.jpg' height='173' width='624'>
<table width='624' border=0 style='font-family:Times;'>
<tr style='height:50px; font-family:Times; font-size:6pt'>
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
<table width='624' border=0 style='font-family:Times;'>
<tr style='height:53px;'>
<td colspan='2' style='height:28; font-family:Times;font-size: 11pt; width: 100%; text-align: center; font-weight: bold' >
FIELD AUTHORIZATION FOR AS-BUILT
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: normal' >
	Date: <u><b><?php echo DisplayDate($FormDate);?></b></u>
</td>
</tr>
<tr>
<td  colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: normal' >
	<?php
	$slash = ' ';
	?>
	TO: <b>
	<?php
	if ($ToPlanning == 'checked') {
		echo $slash . 'Planning';
		$slash = '/';
	}
	if ($ToPermits == 'checked') {
		echo $slash . 'Permits';
		$slash = '/';
	}
	if ($ToInspections == 'checked') {
		echo $slash . 'Inspections';
		$slash = '/';
	}
	if ($ToPublicUtilities == 'checked') {
		echo $slash . 'Public&nbsp;Utilities';
		$slash = '/';
	}
	?>
	</b>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: normal' >
	FROM: <b>
	<?php
	echo '<u>' . $FromName . '</u>';
	$slash = '';
	if ($FromPlanning == 'checked') {
		echo 'Planning';
		$slash = '/';
	}
	if ($FromPermits == 'checked') {
		echo $slash . 'Permits';
		$slash = '/';
	}
	if ($FromInspections == 'checked') {
		echo $slash . 'Inspections';
		$slash = '/';
	}
	if ($FromPublicUtilities == 'checked') {
		echo $slash . 'Public&nbsp;Utilities';
		$slash = '/';
	}

	?>
	</b>
</td>
</tr>
<tr>
<td style='height:28; font-family:Times;font-size: 11pt;  font-weight: normal' >
	PERMITTEE: <?php echo '<u><b>' . $Permittee . '</b></u>';?>
</td>
<td>
	Permit #: <?php echo '<u><b>' . $PermitNumber . '</b></u>';?>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-size: 11pt;  font-weight: normal'>
	Contractor Name / Sub Contractor: <?php echo '<u><b>' . $Contractor . '&nbsp;/&nbsp;' . $SubContractor . '</b></u>';?>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: normal' >
	Location:(Be&nbsp;Specfic)&nbsp;<?php echo '<u><b>' . $Location . '</b></u><p>';?>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times; font-size: 11pt; font-weight: normal' >
	Reasons For As-Built Request:	
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times; font-size: 11pt; font-weight: normal' >
	<?php echo '<u><b>' . $Reasons . '</b></u><p>';?>
</td>
</tr>

<tr>
<td colspan="2" style=' font-size: 11pt;  font-weight: normal'>
	Number of Additional Test Holes: <?php echo '<u><b>' . $AdditionalTestHoles . '</b></u><br>';?>
	(Test Hole Letter Shall be Currently on File for the Permit)
</td>
</tr>
<tr>
<td colspan="2" style='font-size: 11pt;  font-weight: normal'>
	Number of Additional Open Cuts: <?php echo '<u><b>' . $AdditionalOpenCuts . '</b></u><br>';?>
	(Open Cut Letter Shall be Currently on File for the Permit With As-built)
</td>
</tr>
</table>
<table style='width:624;'>
	<tr>
		<td>Approved by:</td>
		<td>Print Name:</td>
		<td>Company:</td>
	</tr>
	<tr >
		<td style='height:28;'>
			1)_______________________
		</td>
		<td>
			<?php echo '<u><b>' . $PrintName1 . '</b></u><br>';?>
		</td>
		<td>
			<?php echo '<u><b>' . $Company1 . '</b></u><br>';?>
		</td>
	</tr>
	<tr>
		<td style='height:28;'>
			2)_______________________
		</td>
		<td>
			<?php echo '<u><b>' . $PrintName2 . '</b></u><br>';?>
		</td>
		<td>
			<?php echo '<u><b>' . $Company2 . '</b></u><br>';?>
		</td>
	</tr>
	<tr>
		<td style='height:28;'>
			3)_______________________
		</td>
		<td>
			<?php echo '<u><b>' . $PrintName3 . '</b></u><br>';?>
		</td>
		<td>
			<?php echo '<u><b>' . $Company3 . '</b></u><br>';?>
		</td>
	</tr>
</table>
<?php
	function DisplayDate($ADate) {			
					$date = date_create($ADate);
					return date_format($date , "m/d/Y") ; 	
				}
?>		
</body>
</html>