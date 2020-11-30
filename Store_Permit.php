<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Store Permit </title>

	
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
	$db = True;
	//$db = False;
	if ($db) {echo "<br>Start of Store_Permit";}
	?>	
	<div class="container" style="font-size: normal; background-color: whitesmoke">

	<div class="row">
	<div class="col-sm-12" style="font-size: xx-large; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
		Store Permit
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
	
	if ($db) {echo "<br>Clear data variables";}
	$txtPermitNumber = "";
	$txtCompanyName = "";
	$txtTechnician = "";
	$txtPermitAddress = "";
	$txtLocationDescription = "";
	$txtPermitStatus = "";
	$txtDateReceived = "";
	$txtDateOfSignature = "";
	$txtWorkSketch = "";
	$txtLatitude = "";
	$txtLongitude = "";
	$txtDueDate = "";
	$txtCableQ = "";
	$txtCableF = "";
	$txtInnerductQ = "";
	$txtInnerductF = "";
	$txtGasMainQ = "";
	$txtGasMainF = "";
	$txtGasServiceQ = "";
	$txtGasServiceF = "";
	$txtCabinet = "";
	$txtTransformer = "";
	$txtHandholds = "";
	$txtPedestal = "";
	$txtOpenCut = "";
	$txtTestHole = "";
	$txtPoles = "";
	$txtShortSide = "";
	$txtLongSide = "";
	$txtResubmitDate = "";
	$txtPermitDocuments = "";
	$txtDueDate = "";
	$txtEntryDate = "";
	$txtConstructionStart = "";
	$txtConstructionEnd = "";
	$txtEntryTime = "";
	$txtGPINNumber = "";
	$txtPermitClosed = "";
	$txtAddendum1 = "";
	$txtAddendum2 = "";
	$txtDriveWayCuts = "";
	$txtOverheadCable = "";
	$txtAnchor = "";
	$txtOverheadCableF = "";
	$txtSidewalkCut = "";
	$txtPermitExpired = "";
	$txtNearbyAddress = "";
	//$txtCommentsAddress = $_POST["txtCommentsAddress"];
	$txtRejection = "";
	$txtCommentsAddress = "";
	
	if ($db) {echo "<br>Load data variables";}
	
	if (isset($_POST["txtPermitNumber"])) {$txtPermitNumber = $_POST["txtPermitNumber"];}
	if (isset($_POST["ddlCompanyName"])) {$txtCompanyName = $_POST["ddlCompanyName"];}
	if (isset($_POST["ddlTechnician"])) {$txtTechnician = $_POST["ddlTechnician"];}
	if (isset($_POST["txtPermitAddress"])) {$txtPermitAddress = $_POST["txtPermitAddress"];}
	if (isset($_POST["txtLocationDescription"])) {$txtLocationDescription = $_POST["txtLocationDescription"];}
	if (isset($_POST["ddlPermitStatus"])) {$txtPermitStatus = $_POST["ddlPermitStatus"];}
	if (isset($_POST["txtDateReceived"])) {$txtDateReceived = ScrubDate($_POST["txtDateReceived"]);}
	if (isset($_POST["txtDateOfSignature"])) {$txtDateOfSignature = ScrubDate($_POST["txtDateOfSignature"]);}
	if (isset($_POST["txtWorkSketch"])) {$txtWorkSketch = $_POST["txtWorkSketch"];}
	if (isset($_POST["txtLatitude"])) {$txtLatitude = $_POST["txtLatitude"];}
	if (isset($_POST["txtLongitude"])) {$txtLongitude = $_POST["txtLongitude"];}
	if (isset($_POST["txtDueDate"])) {$txtDueDate = ScrubDate($_POST["txtDueDate"]);}
	if (isset($_POST["txtCableQ"])) {$txtCableQ = $_POST["txtCableQ"];}
	if (isset($_POST["txtCableF"])) {$txtCableF = $_POST["txtCableF"];}
	if (isset($_POST["txtInnerductQ"])) {$txtInnerductQ = $_POST["txtInnerductQ"];}
	if (isset($_POST["txtInnerductF"])) {$txtInnerductF = $_POST["txtInnerductF"];}
	if (isset($_POST["txtGasMainQ"])) {$txtGasMainQ = $_POST["txtGasMainQ"];}
	if (isset($_POST["txtGasMainF"])) {$txtGasMainF = $_POST["txtGasMainF"];}
	if (isset($_POST["txtGasServiceQ"])) {$txtGasServiceQ = $_POST["txtGasServiceQ"];}
	if (isset($_POST["txtGasServiceF"])) {$txtGasServiceF = $_POST["txtGasServiceF"];}
	if (isset($_POST["txtCabinet"])) {$txtCabinet = $_POST["txtCabinet"];}
	if (isset($_POST["txtTransformer"])) {$txtTransformer = $_POST["txtTransformer"];}
	if (isset($_POST["txtHandholds"])) {$txtHandholds = $_POST["txtHandholds"];}
	if (isset($_POST["txtPedestal"])) {$txtPedestal = $_POST["txtPedestal"];}
	if (isset($_POST["txtOpenCut"])) {$txtOpenCut = $_POST["txtOpenCut"];}
	if (isset($_POST["txtTestHole"])) {$txtTestHole = $_POST["txtTestHole"];}
	if (isset($_POST["txtPoles"])) {$txtPoles = $_POST["txtPoles"];}
	if (isset($_POST["txtShortSide"])) {$txtShortSide = $_POST["txtShortSide"];}
	if (isset($_POST["txtLongSide"])) {$txtLongSide = $_POST["txtLongSide"];}
	if (isset($_POST["txtResubmitDate"])) {$txtResubmitDate = ScrubDate($_POST["txtResubmitDate"]);}
	if (isset($_POST["txtPermitDocuments"])) {$txtPermitDocuments = $_POST["txtPermitDocuments"];}
	if (isset($_POST["txtDueDate"])) {$txtDueDate = ScrubDate($_POST["txtDueDate"]);}
	$txtEntryDate = '"' . date('Y-m-d H:i:s') . '"'; 
	$txtEntryTime = '"' . date('Y-m-d H:i:s') . '"'; 
	if (isset($_POST["txtConstructionStart"])) {$txtConstructionStart = ScrubDate($_POST["txtConstructionStart"]);}
	if (isset($_POST["txtConstructionEnd"])) {$txtConstructionEnd = ScrubDate($_POST["txtConstructionEnd"]);}
	if (isset($_POST["txtGPINNumber"])) {$txtGPINNumber = $_POST["txtGPINNumber"];}
	if (isset($_POST["chkPermitClosed"])) {$txtPermitClosed = $_POST["chkPermitClosed"];}
	if (isset($_POST["txtAddendum1"])) {$txtAddendum1 = $_POST["txtAddendum1"];}
	if (isset($_POST["txtAddendum2"])) {$txtAddendum2 = $_POST["txtAddendum2"];}
	if (isset($_POST["txtDrivewayCuts"])) {$txtDriveWayCuts = $_POST["txtDrivewayCuts"];}
	if (isset($_POST["txtOverheadCable"])) {$txtOverheadCable = $_POST["txtOverheadCable"];}
	if (isset($_POST["txtAnchor"])) {$txtAnchor = $_POST["txtAnchor"];}
	if (isset($_POST["txtOverheadCableF"])) {$txtOverheadCableF = $_POST["txtOverheadCableF"];}
	if (isset($_POST["txtSidewalkCut"])) {$txtSidewalkCut = $_POST["txtSidewalkCut"];}
	if (isset($_POST["chkPermitExpired"])) {$txtPermitExpired = $_POST["chkPermitExpired"];}
	if (isset($_POST["chkNearbyAddress"])) {$txtNearbyAddress = $_POST["chkNearbyAddress"];}
	//$txtCommentsAddress = $_POST["txtCommentsAddress"];
	if (isset($_POST["ddlRejection"])) {$txtRejection = $_POST["ddlRejection"];}
	if ($db) {echo "<br>Check for hacks";}

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

	if ($db) {echo "<br>Id OK";}
if (!isset($_POST["txtPermitNumber"])) {exit;} // might be a hack 
if ($db) {echo "<br>PermitNumber OK";}

if (isset($_GET["Id"]) && $db) {echo "<p>GET Id: " . $_GET["Id"];}
if (isset($_GET["Id"]) && trim($_GET["Id"]) <> "") { // update
	$deleted = FALSE;
	if (isset($_POST["chkDelete"])) {
		if ($db) {echo "<br>Delete  indicated";}
		if (trim($_POST["chkDelete"]) == 'on') {
			$query = 'Delete from PIP WHere Id = ' . $_GET["Id"] ;
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			echo "Permit deleted";
			$deleted = TRUE;
		}
	}
	if (!$deleted) {
		if ($db) {echo "<br>Update indicated";}
		$query = 'Update PIP Set 
			PermitNumber	= "' . str_replace('"','""',$txtPermitNumber) . '",
			CompanyName	= "' . 	str_replace('"','""',$txtCompanyName) . '",
			Technician	= "' . 	str_replace('"','""',$txtTechnician) . '",
			PermitAddress	= "' . 	str_replace('"','""',$txtPermitAddress) . '",
			LocationDescription	= "' . 	str_replace('"','""',$txtLocationDescription) . '",
			PermitStatus	= "' . 	str_replace('"','""',$txtPermitStatus) . '",
			DateReceived	= ' . 	$txtDateReceived	 . ',
			DateOfSignature	= ' . 	$txtDateOfSignature	 . ',
			Latitude	= "' . 	$txtLatitude	 . '",
			Longitude	= "' . 	$txtLongitude	 . '",
			DueDate	= ' . 	$txtDueDate	 . ',
			CableQ	= "' . 	$txtCableQ	 . '",
			CableF	= "' . 	$txtCableF	 . '",
			InnerductQ	= "' . 	$txtInnerductQ	 . '",
			InnerductF	= "' . 	$txtInnerductF	 . '",
			GasMainQ	= "' . 	$txtGasMainQ	 . '",
			GasMainF	= "' . 	$txtGasMainF	 . '",
			GasServiceQ	= "' . 	$txtGasServiceQ	 . '",
			GasServiceF	= "' . 	$txtGasServiceF	 . '",
			Cabinet	= "' . 	$txtCabinet	 . '",
			Transformer	= "' . 	$txtTransformer	 . '",
			Handholds	= "' . 	$txtHandholds	 . '",
			Pedestal	= "' . 	$txtPedestal	 . '",
			OpenCut	= "' . 	$txtOpenCut	 . '",
			TestHole	= "' . 	$txtTestHole	 . '",
			Poles	= "' . 	$txtPoles	 . '",
			ShortSide	= "' . 	$txtShortSide	 . '",
			LongSide	= "' . 	$txtLongSide	 . '",
			ResubmitDate	= ' . 	$txtResubmitDate	 . ',
			DueDate	= ' . 	$txtDueDate	 . ',
			EntryDate	= ' . 	$txtEntryDate	 . ',
			ConstructionStart	= ' . 	$txtConstructionStart	 . ',
			ConstructionEnd	= ' . 	$txtConstructionEnd	 . ',
			EntryTime	= ' . 	$txtEntryTime	 . ',
			GPINNumber	= "' . 	$txtGPINNumber	 . '",
			PermitClosed	= "' . 	$txtPermitClosed	 . '",
			DriveWayCuts	= "' . 	$txtDriveWayCuts	 . '",
			OverheadCable	= "' . 	$txtOverheadCable	 . '",
			Anchor	= "' . 	$txtAnchor	 . '",
			OverheadCableF	= "' . 	$txtOverheadCableF	 . '",
			SidewalkCut	= "' . 	$txtSidewalkCut	 . '",
			PermitExpired	= "' . 	$txtPermitExpired	 . '",
			NearbyAddress	= "' . 	$txtNearbyAddress	 . '",
			Rejection	= "' . 	$txtRejection	 . '" 
			Where Id = ' . $_GET["Id"];	
			
		if ($db) {echo "<p>" . $query;}
		//if ($_GET["Id"] == 2923) {$query = $query . "?";}
		$result = mysqli_query($connection, $query);
		if ($result) {
			echo "<br>Permit updated..";	
		} else {
			echo "Error:<br>";
			sendError("Query failed" . " " . $query . " " . mysqli_error($connection));
		}		

		echo "<p><a href=NewEdit.php?Id=" . $_GET["Id"] . ">View</a> ";	
	}
} else {
	if ($db) {echo "<br>Insert indicated";}
	$query = 'Insert into PIP (
		PermitNumber,CompanyName,Technician,PermitAddress,LocationDescription,PermitStatus,
		DateReceived,DateOfSignature,WorkSketch,Latitude,
		Longitude,DueDate,CableQ,CableF,InnerductQ,InnerductF,GasMainQ,GasMainF,
		GasServiceQ,GasServiceF,Cabinet,Transformer,Handholds,Pedestal,OpenCut,
		TestHole,Poles,ShortSide,LongSide,ResubmitDate,PermitDocuments,
		EntryDate,ConstructionStart,ConstructionEnd,EntryTime,GPINNumber,PermitClosed,
		Addendum1,Addendum2,DriveWayCuts,OverheadCable,Anchor,OverheadCableF,SidewalkCut,
		PermitExpired,NearbyAddress,CommentsAddress,Rejection			
		) values ("' .
		$txtPermitNumber . '","' . str_replace('"','""',$txtCompanyName) . '","' . 
		$txtTechnician . '","' . str_replace('"','""',$txtPermitAddress) . '","' . 
		str_replace('"','""',$txtLocationDescription) . '","' . $txtPermitStatus . '",' . 
		$txtDateReceived . ',' . $txtDateOfSignature . ',"' . 
		$txtWorkSketch . '","' . $txtLatitude . '","' . 
		$txtLongitude . '",' . $txtDueDate . ',"' . 
		$txtCableQ . '","' . $txtCableF . '","' . 
		$txtInnerductQ . '","' . $txtInnerductF . '","' . 
		$txtGasMainQ . '","' . $txtGasMainF . '","' . 
		$txtGasServiceQ . '","' . $txtGasServiceF . '","' . 
		$txtCabinet . '","' . $txtTransformer . '","' . 
		$txtHandholds . '","' . $txtPedestal . '","' . 
		$txtOpenCut . '","' . $txtTestHole . '","' . 
		$txtPoles . '","' . $txtShortSide . '","' . 
		$txtLongSide . '",' . $txtResubmitDate . ',"' . 
		$txtPermitDocuments . '",' . 
		$txtEntryDate . ',' . $txtConstructionStart . ',' . 
		$txtConstructionEnd . ',' . $txtEntryDate . ',"' . 
		$txtGPINNumber . '","' . $txtPermitClosed . '","' . 
		$txtAddendum1 . '","' . $txtAddendum2 . '","' . 
		$txtDriveWayCuts . '","' . $txtOverheadCable . '","' . 
		$txtAnchor . '","' . $txtOverheadCableF . '","' . 
		$txtSidewalkCut . '","' . $txtPermitExpired . '","' . 
		$txtNearbyAddress . '","' . $txtCommentsAddress . '","' . 
		$txtRejection . '")';		
		
		if ($db) {echo "<p>" . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		echo "<br>Permit record inserted";
		
		if ($db) {echo "<br>Get Id from new record";}
		$query = "Select Id From PIP 
		Where PermitNumber = '" . $txtPermitNumber . "' and 
		Technician = '" . $txtTechnician . "' and 
		DateReceived = " . $txtDateReceived;
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			echo "<p><a href=NewEdit.php?Id=" . $row[0] . ">View permit</a> ";	
		}
	}

	?>
		
	</div>
	</div>
	</div>
	</body>
	</html>