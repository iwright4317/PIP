<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});
	</script>	
</head>
<body style='margin:0; font-family:Times;' >	
	<form action="FAFAOnlineForm.php?PermitId=<?php echo $_GET['PermitId'];?>" method="POST">
		<div class="container"  style=" font-weight: bold; background-color: white">
			<div class="row">				
				<div class="col-sm-12" >
					
<?php
	$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	$txtPermitNumber = '';
	$Technician = '';
	$CompanyName = '';
	if (!empty($_POST["Save"])) {
					
		$query = "Select * from FAFA Where PermitId = " . $_GET['PermitId'];
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
		if ($row = mysqli_fetch_array($result)) {
			$Id = $row["Id"];
			$query = 'Update FAFA set  
			FormDate = "' . DateToSQL($_POST["FormDate"]) . '", 
			ToPlanning = "' . $_POST["ToPlanning"] . '", 
			ToPermits = "' . $_POST["ToPermits"] . '", 
			ToInspections = "' . $_POST["ToInspections"] . '", 
			ToPublicUtilities = "' . $_POST["ToPublicUtilities"] . '", 
			Permittee = "' . $_POST["Permittee"] . '", 
			PermitNumber = "' . $_POST["PermitNumber"] . '", 
			Contractor = "' . $_POST["Contractor"] . '", 
			SubContractor = "' . $_POST["SubContractor"] . '", 
			Location = "' . $_POST["Location"] . '", 
			Reasons = "' . $_POST["Reasons"] . '", 
			AdditionalTestHoles = "' . $_POST["AdditionalTestHoles"] . '", 
			AdditionalOpenCuts = "' . $_POST["AdditionalOpenCuts"] . '", 
			PrintName1 = "' . $_POST["PrintName1"] . '", 
			PrintName2 = "' . $_POST["PrintName2"] . '", 
			PrintName3 = "' . $_POST["PrintName3"] . '", 
			Company1 = "' . $_POST["Company1"] . '", 
			Company2 = "' . $_POST["Company2"] . '", 
			Company3 = "' . $_POST["Company3"] . '", 
			FromName = "' . $_POST["FromName"] . '", 
			FromPlanning = "' . $_POST["FromPlanning"] . '", 
			FromPermits = "' . $_POST["FromPermits"] . '", 
			FromInspections = "' . $_POST["FromInspections"] . '", 
			FromPublicUtilities = "' . $_POST["FromPublicUtilities"] . '"  
			Where Id = ' . $Id;
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
		}		
					
	}
	if (!empty($_GET['PermitId'])) {
		$query = "Select * from PIP Where Id = " . $_GET['PermitId'] . " ";
		$query = "Select PIP.Id, PermitNumber, PermitAddress, FirstName, LastName,
				PermitStatus, MiddleInitial, CompanyName  From PIP, Login Where PIP.Id = " . $_GET["PermitId"] . " and 
				Login.FirstName = PIP.Technician ";
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {			
			$txtPermitNumber = $row["PermitNumber"];
			$Technician = $row[3] . '  ' . $row[4];
			$CompanyName = $row["CompanyName"];
		}
		$query = "Select * from FAFA Where PermitId = " . $_GET['PermitId'];
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
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: bold' >
	Date: <input style='border-bottom: 2px solid black;' type="text" id="datepicker" value="<?php echo date('m/d/Y'); ?>" name="FormDate">
</td>
</tr>
<tr>
<td  colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: bold' >
	TO: <input name="ToPlanning" value="checked" type="checkbox" style='border-bottom: 2px solid black;' <?php echo $ToPlanning;?> >Planning&nbsp;/
	<input type="checkbox" name="ToPermits" value="checked" <?php echo $ToPermits;?> >Permits&nbsp;/
	<input type="checkbox" name="ToInspections" value="checked" <?php echo $ToInspections;?> >Inspections&nbsp;/
	<input type="checkbox" name="ToPublicUtilities" value="checked" <?php echo $ToPublicUtilities;?> >Public&nbsp;Utilities
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: bold' >
	FROM: <input type="text" name="FromName" value="<?php echo $FromName;?>" style="border-bottom: 2px solid black;">&nbsp;
	<input type="checkbox" name="FromPlanning" value="checked" <?php echo $FromPlanning;?> >&nbsp;Planning&nbsp;/&nbsp;
	<input type="checkbox" name="FromPermits" value="checked" <?php echo $FromPermits;?> >Permits&nbsp;/&nbsp;
	<input type="checkbox" name="FromInspections" value="checked" <?php echo $FromInspections;?> >Inspections&nbsp;/&nbsp;
	<input type="checkbox" name="FromPublicUtilities" value="checked" <?php echo $FromPublicUtilities;?> >Public&nbsp;Utilities
</td>
</tr>
<tr>
<td style='height:28; font-family:Times;font-size: 11pt;  font-weight: bold' >
	PERMITTEE: <input type="text" name="Permittee" size="30" value="<?php echo $Permittee;?>" style="border-bottom: 2px solid black;">
</td>
<td>
	Permit #: <input type="text" name="PermitNumber" value="<?php echo $txtPermitNumber;?>" style="font-weight: bold; 2px solid black;">
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-size: 11pt;  font-weight: bold'>
	Contractor Name / Sub Contractor: 
	<input size="20" name="Contractor" value="<?php echo $Contractor;?>" type="text" style="border-bottom: 2px solid black;">/
	<input size="20" name="SubContractor" value="<?php echo $SubContractor;?>" type="text" style="border-bottom: 2px solid black;">
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times;font-size: 11pt;  font-weight: bold' >
	Location:(Be&nbsp;Specfic)&nbsp;<p>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times; font-size: 11pt; font-weight: bold' >
	<textarea name="Location" rows="3" style="width:100%" name="Location"><?php echo $Location;?></textarea>
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times; font-size: 11pt; font-weight: bold' >
	Reasons For As-Built Request:	
</td>
</tr>
<tr>
<td colspan="2" style='height:28; font-family:Times; font-size: 11pt; font-weight: bold' >
	<textarea name="Reasons" rows="3" style="width:100%" name="Reasons"><?php echo $Reasons;?></textarea>
</td>
</tr>
<tr>
<td colspan="2" style=' font-size: 11pt;  font-weight: bold'>
	Number of Additional Test Holes: 
	<input type="text"  value="<?php echo $AdditionalTestHoles;?>"  name="AdditionalTestHoles" style="border-bottom: 2px solid black;"><br>
	(Test Hole Letter Shall be Currently on File for the Permit)
</td>
</tr>
<tr>
<td colspan="2" style='font-size: 11pt;  font-weight: bold'>
	Number of Additional Open Cuts: 
	<input type="text"  value="<?php echo $AdditionalOpenCuts;?>" name="AdditionalOpenCuts" style="border-bottom: 2px solid black;"><br>
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
			<input type="text" value="<?php echo $PrintName1;?>"  name="PrintName1" style="border-bottom: 2px solid black;">
		</td>
		<td>
			<input type="text" value="<?php echo $Company1;?>" name="Company1" style="border-bottom: 2px solid black;">
		</td>
	</tr>
	<tr>
		<td style='height:28;'>
			2)_______________________
		</td>
		<td>
			<input type="text"  value="<?php echo $PrintName2;?>" name="PrintName2" style="border-bottom: 2px solid black;">
		</td>
		<td>
			<input type="text"  value="<?php echo $Company2;?>" name="Company2" style="border-bottom: 2px solid black;">
		</td>
	</tr>
	<tr>
		<td style='height:28;'>
			3)_______________________
		</td>
		<td>
			<input type="text"  value="<?php echo $PrintName3;?>" name="PrintName3" style="border-bottom: 2px solid black;">
		</td>
		<td>
			<input type="text"  value="<?php echo $Company3;?>" name="Company3" style="border-bottom: 2px solid black;">
		</td>
	</tr>
</table>

<button style="font-size:12pt" class="success" name="Save" value="on">Save FAAS-Built</button>
&nbsp;&nbsp;&nbsp;&nbsp;<b>FAAS-Built saved</b>
&nbsp;&nbsp;&nbsp;&nbsp;<b><a href=FAFA.php?PermitId=<?php echo $_GET["PermitId"];?>> Download document</a></b>
</div>
</div>
</div>
</form>

	<?php
	
		function DateToSQL($ADate) {			
			$date = date_create($ADate);
			return date_format($date , "Y-m-d") ; 	
		}
				
	?>
</body>
</html>