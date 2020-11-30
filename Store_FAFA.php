<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Store FAFA </title>

	
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
	$db = TRUE;
	
	$db = False;
	
	?>	
	

	<div class="container" style="font-size: normal; background-color: whitesmoke">

	<div class="row">
	<div class="col-sm-12" style="font-size: xx-large; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
		Store FAFA
	</div>
	</div>

	<div class="row">
	<div class="col-sm-12" style="font-size: large; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
		
	<?php
	
	
	function ScrubDate($inputDate) {
		// 05-16-2016
		if (isset($inputDate)) {
			if ($inputDate == "" or $inputDate == "Null") {
				return "Null";
			} else {
				//echo "<p><b>ScrubDate: " . $inputDate . "</b>";
				if(date_create($inputDate) !== false) {		
					$date=date_create($inputDate);
					return '"' . date_format($date,"Y-m-d") . '"';		
					//return "'" . substr($inputDate, 7, 4) . "-" . substr($inputDate, 0, 2) . "-" . substr($inputDate, 3, 2) . "'";
				} else {
					return "Null";
				}
			}
		} else {
			return "Null";
		}
	}
	
if(isset($_POST["ddlRejection"])) {$txtRejection = $_POST["ddlRejection"];}

$FAFAId = 0;
$FAFAFound = True;

if (trim($_GET["FAFAId"]) <> "") { // update
	$FAFAId = $_GET["FAFAId"];
	$FAFAFound = True;
} else {
	if (trim($_GET["FAFACount"]) == "") { // update
		$FAFACount = 1;
	} else {
		$FAFACount = $_GET["FAFACount"];	

		$query = "Select Id From FAFA 
		Where PermitId = '" . $_GET["PermitId"] . "' and 
		Location = '" . str_replace("'","''",$_POST["Location"]) . "' ";
		
		$query = "Select Id From FAFA 
		Where PermitId = '" . $_GET["PermitId"] . "' and 
		Location = '" . str_replace("'","''",$_POST["Location"]) . "' ";
		
		if ($db) {echo "<br>Get FAFA Id " . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			$FAFACount = $_GET["FAFACount"] + 1;
			$FAFAId = $row[0];
			$FAFAFound = True;
		} else {
			$FAFAFound = FALSE;
		}
	}
}

 $ToPlanning = ""; 
 $ToPermits = ""; 
 $ToInspections = ""; 
 $ToPublicUtilities = ""; 
 $Permittee = ""; 
 $PermitNumber = ""; 
 $Contractor = ""; 
 $SubContractor = ""; 
 $Location  = ""; 
 $Reasons = ""; 
 $AdditionalTestHoles = ""; 
 $AdditionalOpenCuts = ""; 
 $PrintName1 = ""; 
 $PrintName2 = ""; 
 $PrintName3 = ""; 
 $Company1 = ""; 
 $Company2 = ""; 
 $Company3 = ""; 
 $FromName = ""; 
 $FromPlanning = ""; 
 $FromPermits = ""; 
 $FromInspections = ""; 
 $SheetNumber = ""; 
 $FromPublicUtilities = ""; 
 
 
 if (isset($_POST["ToPlanning"])){ $ToPlanning = $_POST["ToPlanning"];}
 if (isset($_POST["ToPermits"])){ $ToPermits = $_POST["ToPermits"];}
 if (isset($_POST["ToInspections"])){ $ToInspections = $_POST["ToInspections"];}
 if (isset($_POST["ToPublicUtilities"])){ $ToPublicUtilities = $_POST["ToPublicUtilities"];}
 if (isset($_POST["Permittee"])){ $Permittee = $_POST["Permittee"];}
 if (isset($_POST["PermitNumber"])){ $PermitNumber = $_POST["PermitNumber"];}
 if (isset($_POST["Contractor"])){ $Contractor = $_POST["Contractor"];}
 if (isset($_POST["SubContractor"])){ $SubContractor = $_POST["SubContractor"];}
 if (isset($_POST["Location"])){ $Location  = $_POST["Location"];}
 if (isset($_POST["Reasons"])){ $Reasons = str_replace('"','""',$_POST["Reasons"]);}
 if (isset($_POST["AdditionalTestHoles"])){ $AdditionalTestHoles = $_POST["AdditionalTestHoles"];}
 if (isset($_POST["AdditionalOpenCuts"])){ $AdditionalOpenCuts = $_POST["AdditionalOpenCuts"];}
 if (isset($_POST["PrintName1"])){ $PrintName1 = $_POST["PrintName1"];}
 if (isset($_POST["PrintName2"])){ $PrintName2 = $_POST["PrintName2"];}
 if (isset($_POST["PrintName3"])){ $PrintName3 = $_POST["PrintName3"];}
 if (isset($_POST["Company1"])){ $Company1 = $_POST["Company1"];}
 if (isset($_POST["Company2"])){ $Company2 = $_POST["Company2"];}
 if (isset($_POST["Company3"])){ $Company3 = $_POST["Company3"];}
 if (isset($_POST["FromName"])){ $FromName = $_POST["FromName"];}
 if (isset($_POST["FromPlanning"])){ $FromPlanning = $_POST["FromPlanning"];}
 if (isset($_POST["FromPermits"])){ $FromPermits = $_POST["FromPermits"];}
 if (isset($_POST["FromInspections"])){ $FromInspections = $_POST["FromInspections"];}
 if (isset($_POST["SheetNumber"])){ $SheetNumber = $_POST["SheetNumber"];}
 if (isset($_POST["FromPublicUtilities"])){ $FromPublicUtilities = $_POST["FromPublicUtilities"];}
 			
if ($db) {echo "<br>FAFAId: " . $FAFAId;}
if ($FAFAFound ) {
if ($FAFAId <> 0) {
	
	$deleted = FALSE;
	if (isset($_POST["chkDelete"])) {
		if (trim($_POST["chkDelete"]) == 'on') {
			$query = 'Delete from FAFA WHere Id = ' . $FAFAId ;
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			echo "FAFA deleted "; 
			
			if ($db) {echo "<br>Delete FAFA: " . $FAFAId;}
			if ($db) {echo "<br>FAFA Deleted ";}
			$deleted = TRUE;
			$FAFAId='';
		}
	}
	if (!$deleted) {
			$query = 'Update FAFA set  
			FormDate = "' . DateToSQL($_POST["FormDate"]) . '", ToPlanning = "' . $ToPlanning . '", 
			ToPermits = "' . $ToPermits . '", ToInspections = "' . $ToInspections . '", 
			ToPublicUtilities = "' . $ToPublicUtilities . '", 
			Permittee = "' . $Permittee . '", PermitNumber = "' . $PermitNumber . '", 
			Contractor = "' . str_replace('"','""',$Contractor) . '", SubContractor = "' . str_replace('"','""',$SubContractor) . '", 
			Location = "' . str_replace('"','""',$Location) . '", Reasons = "' . str_replace('"','""',$Reasons) . '", 
			AdditionalTestHoles = "' . $AdditionalTestHoles . '", 
			AdditionalOpenCuts = "' . $AdditionalOpenCuts . '", 
			PrintName1 = "' . str_replace('"','""',$PrintName1) . '", PrintName2 = "' . str_replace('"','""',$PrintName2) . '", 
			PrintName3 = "' . str_replace('"','""',$PrintName3) . '", Company1 = "' . str_replace('"','""',$Company1) . '", 
			Company2 = "' . str_replace('"','""',$Company2) . '", Company3 = "' . str_replace('"','""',$Company3) . '", 
			FromName = "' . $FromName . '", FromPlanning = "' . $FromPlanning . '", 
			FromPermits = "' . $FromPermits . '", FromInspections = "' . $FromInspections . '", 
			SheetNumber = "' . str_replace('"','""',$SheetNumber) . '", FromPublicUtilities = "' . $FromPublicUtilities . '",
			PermitId = ' . $_GET["PermitId"] . ' Where Id = ' . $FAFAId;
			
		if ($db) {echo "<br>Not delete: " . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			echo "FAFA record updated";	

		}
} else {
	
			
	$query = 'Insert into FAFA (
			FormDate, ToPlanning, ToPermits, ToInspections, ToPublicUtilities, Permittee,
			PermitNumber, Contractor, SubContractor, Location, Reasons, AdditionalTestHoles, 
			AdditionalOpenCuts, PrintName1, PrintName2, PrintName3, Company1, Company2, 
			Company3, FromName, FromPlanning, FromPermits, FromInspections, SheetNumber, 
			FromPublicUtilities, PermitId)
			values ("' . DateToSQL($_POST["FormDate"]) . '",
 			"' . $ToPlanning . '", "' . $ToPermits . '",
 			"' . $ToInspections . '", "' . $ToPublicUtilities . '",
 			"' . str_replace('"','""',$Permittee) . '", "' . $PermitNumber . '",
 			"' . str_replace('"','""',$Contractor) . '", "' . str_replace('"','""',$SubContractor) . '",
 			"' . str_replace('"','""',$Location) . '", "' . str_replace('"','""',$Reasons) . '",
 			"' . $AdditionalTestHoles . '", "' . $AdditionalOpenCuts . '",
 			"' . str_replace('"','""',$PrintName1) . '", "' . str_replace('"','""',$PrintName2) . '",
 			"' . str_replace('"','""',$PrintName3) . '", "' . str_replace('"','""',$Company1) . '",
 			"' . str_replace('"','""',$Company2) . '", "' . str_replace('"','""',$Company3) . '",
 			"' . str_replace('"','""',$FromName) . '", "' . $FromPlanning . '",
 			"' . $FromPermits . '", "' . $FromInspections . '",
 			"' . $SheetNumber . '", "' . $FromPublicUtilities . '",
			' . $_GET["PermitId"] . ')';
		if ($db) {echo "<br>Insert " . $query;}
			
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		echo "FAFA record inserted";
			
		$query = "Select Id From FAFA 
			Where PermitId = '" . $_GET["PermitId"] . "' and 
			Location = '" . str_replace("'","''",$_POST["Location"]) . "' ";
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
				$FAFAId = $row["Id"];
		}		
	}
	
	
		if (!isset($FAFACount)) {$FAFACount = "";}
	echo "<p><a href=FAFAOnlineForm.php?FAFAId=" . $FAFAId . "&PermitId=" . $_GET["PermitId"] . "&FAFACount=". $FAFACount . ">View FAASbuilt</a> ";	
		
		
		} else {
			echo "<p>FAFA not found";
		}
		
		function DateToSQL($ADate) {			
			$date = date_create($ADate);
			return date_format($date , "Y-m-d") ; 	
		}
	?>
		
	</div>
	</div>
	</div>
</body>
</html>