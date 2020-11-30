<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | UVA </title>

	<script>
		$(function() {
			$(document).tooltip();
		});
	</script>
	<style>
		label {
			display: inline-block;
			width: 5em;
		}
	</style>
		
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});
	</script>
		
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	?>
	<div class="container" style="font-size: normal; ">

		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Utility Verification Application
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<?php
				
				
	function ScrubDate($ADate) {
	//2016-05-20 -> 05/16/2016
	if (!empty($ADate)) {
		return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
	} else {
		return null;
	}
	}
	
				$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
				//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
				$strSQL = "";
				$edit = false;

				If ($_GET["Id"] <> "") {
					$edit = true;
					$q = "Select count(*) from UtilityVerificationApplication Where PermitId = " . $_GET["Id"];

					$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
					If ($row = mysqli_fetch_array($r)) {
						$UVAPages = $row[0];
					}
					$txtPages = "/" . $UVAPages;
				}

				If (Trim($_GET["Id"]) <> "") {
					$lnkRefresh = "UtilityVerificationApplication.php?Id=" . $_GET["Id"];
					$lnkNew = "UtilityVerificationApplication.php?Id=" . $_GET["Id"];

					$q = "Select PermitNumber,CompanyName from PIP Where Id = " . $_GET["Id"];
					$r = mysqli_query($connection, $q) or die("<br/>Query failed 82 : " . $q);
					If ($row = mysqli_fetch_array($r)) {
						$txtPermitNumber = $row[0];
						$txtCompany = $row[1];
					}
				}

				If (Trim($_GET["UVAId"]) <> "") {
					$edit = true;
					$q = "Select * from UtilityVerificationApplication Where Id = " . $_GET["UVAId"];
										
					$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q);
					$I = $_GET["UVACount"];
					$RCount = 0;
					If ($row = mysqli_fetch_array($r)) {
						$UVAId = $row["Id"];
						$txtPages = $RCount . "/" . $UVAPages;
						$txtUVADate = $row["UVADate"];
						$txtLocation = $row["LocationAddress"];
						$txtCompany = $row["Company"];
						$txtSubcontractor = $row["Subcontractor"];
						$txtForman = $row["Forman"];
						$txtTechnician = $row["Technician"];
						$txtTestHole = $row["TestHole"];
						$txtTestHoleType = $row["TestHoleType"];
						$txtPublicUtilityType = $row["PublicUtilityType"];
						$txtPublicUtilityDepth = $row["PublicUtilityDepth"];
						$txtBoreSize = $row["BoreSize"];
						$txtBoreDepth = $row["BoreDepth"];

						//need to do this
						//ddlMethod.SelectedItem = $row["BoreMethod"];

						$lnkPrinterVersion = "UVAPrint.php?Id=" . $_GET["Id"] . "&UVACount=" . $I;
						$lnkPrinterVersion_Visible = True;

						$lnkViewAll = "UVAViewall.php?Id=" . $_GET["Id"];
						$lnkViewAll_Visible = True;

						If ($RCount < $UVAPages) {
							$lnkNext_Visible = True;
							$IPlus = $I + 1;
							$lnkNext = "UtilityVerificationApplication.php?Id=" . $_GET["Id"] . "&UVACount=" . $IPlus;
						} else {
							$lnkNext_Visible = False;
						}

}

					$PIPId = $row["PermitId"];

					$q = "Select Id from UtilityVerificationApplication Where PermitId = " . $PIPId;

					$r = mysqli_query($connection, $q) or die("<br/>Query failed 134 : " . $q);
					$ThisPage = 0;
					While ($row = mysqli_fetch_array($r)) {
						$UVAPages = $UVAPages + 1;
						If ($_GET["UVAID"] = $row[0]) { $ThisPage = $UVAPages;
						}

						$txtPages = $ThisPage . "/" . $UVAPages;

						$lnkRefresh = "UtilityVerificationApplication.php?Id=" . $PIPId;
						$lnkNew = "UtilityVerificationApplication.php?Id=" . $PIPId;

						$q = "Select PermitNumber,CompanyName from PIP Where Id = " . $PIPId;

						$r = mysqli_query($connection, $q) or die("<br/>Query failed 148 : " . $q);
						if ($row = mysqli_fetch_array($r)) {
							$txtPermitNumber = $row[0];
						}
					}
					
				}

				If (Trim($_GET["UVACount"]) <> "") {
					$q = "Select * from UtilityVerificationApplication Where PermitId = " . $_GET["Id"];
					
					$I = $_GET["UVACount"];
					$RCount = 0;

					$r = mysqli_query($connection, $q) or die("<br/>Query failed 161 : " . $q);

					While ($RCount < $I) {
						$row = mysqli_fetch_array($r);
						$RCount = $RCount + 1;
					}
					$UVAId = $row["Id"];
					$txtPages = $RCount . "/" . $UVAPages;
					$txtUVADate = $row["UVADate"];

					$txtLocation = $row["LocationAddress"];
					$txtCompany = $row["Company"];
					$txtSubcontractor = $row["Subcontractor"];
					$txtForman = $row["Forman"];
					$txtTechnician = $row["Technician"];
					$txtTestHole = $row["TestHole"];
					$txtTestHoleType = $row["TestHoleType"];
					$txtPublicUtilityType = $row["PublicUtilityType"];
					$txtPublicUtilityDepth = $row["PublicUtilityDepth"];
					$txtBoreSize = $row["BoreSize"];
					$txtBoreDepth = $row["BoreDepth"];

					//need to do this
					//ddlMethod.SelectedItem = $row["BoreMethod"];

					$lnkPrinterVersion = "UVAPrint.php?Id=" . $_GET["Id"] . "&UVACount=" . $I;
					$lnkPrinterVersion_Visible = True;

					$lnkViewAll = "UVAViewall.php?Id=" . $_GET["Id"];
					$lnkViewAll_Visible = True;

					If ($RCount < $UVAPages) {
						$lnkNext_Visible = True;
						$IPlus = $I + 1;
						$lnkNext = "UtilityVerificationApplication.php?Id=" . $_GET["Id"] . "&UVACount=" . $IPlus;
					} else {
						$lnkNext_Visible = False;
					}
				}

				function DisplayDate($ADate) {
					$date = date_create($ADate);
					return date_format($date, "m/d/Y");
				}
				?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				Permit #
				<input type="text"  name="txtPermitNumber" style="width:157px"
				<?php
					if ($edit) {echo "value=" . $txtPermitNumber . " ";
					}
 ?> >
			</div>
			<div class="col-sm-6">
				Date:
				<input type="text"  id="datepicker" name="txtUVADate" style="width:98px"
				<?php
					if ($edit) {echo "value=" . DisplayDate($txtUVADate) . " ";
					}
 ?> >
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Location/Address:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtLocation" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtLocation . "' ";
					}
 ?> >
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Company:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtCompany" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtCompany . "' ";
					}
 ?> >
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Subcontractor:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtSubcontractor" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtSubcontractor . "' ";
					}
 ?> >
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Foreman/Supervisor on Site:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtForman" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtForman . "' ";
					}
 ?>>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Technician/Inspector on Site:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtTechnician" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtTechnician . "' ";
					}
 ?>>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Test Hole/open Cut Size/Type:
			</div>
			<div class="col-sm-3">
				<input type="text" placeholder="Size" name="txtTestHole" style="width:95%"
				<?php
					if ($edit) {echo "value='" . $txtTestHole . "' ";
					}
 ?>>
				,
			</div>
			<div class="col-sm-5">
				<input type="text" placeholder="Type (Asphalt/Concrete)" name="txtTestHoleType" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtTestHoleType . "' ";
					}
 ?>>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Public Utility Type/Size/Depth:
			</div>
			<div class="col-sm-8">
				<textarea  name="txtPublicUtilityType" style="width:100%"><?php if ($edit) {echo $txtPublicUtilityType;}?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Bore Size/Type:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtBoreSize" style="width:100%"
				<?php
					if ($edit) {echo "value='" . $txtBoreSize . "' ";
					}
 ?>>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				Bore Depth:
			</div>
			<div class="col-sm-8">
				<input type="text"  name="txtBoreDepth"
				<?php
					if ($edit) {echo "value='" . $txtBoreDepth . "' ";
					}
 ?>>
			</div>
			<div class="col-sm-4">
				Method of Installation:
			</div>
			<div class="col-sm-8">
				<select  name="ddlMethod" style="width:100%"></select>
			</div>
		</div>


		<div class="row">
			<div class="col-sm-12">				
				<button  name="Button1" style="width:86px" />
				Save</button>&nbsp;&nbsp;
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">	
				<hr>				
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">	
		
		<a  name="lnkRefresh" href="<?php echo $lnkRefresh;?>">Refresh Form</a>&nbsp;&nbsp;&nbsp;
		<a  name="lnkNew" href="<?php echo $lnkNew;?>">New</a>&nbsp;&nbsp;&nbsp;
		<a  name="lnkNext" href="<?php echo $lnkNext;?>">Next</a>&nbsp;&nbsp;&nbsp;
		<a  name="lnkPrinterVersion" href="<?php echo $lnkPrinterVersion;?>" Target="_blank">Printer Version</a>&nbsp;&nbsp;&nbsp;
		<a  name="lnkViewAll" href="<?php echo $lnkViewAll;?>" Target="_blank">View All</a>&nbsp;&nbsp;&nbsp;

			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">	
		<input type="checkbox"  name="chkDelete" >
		Delete this Utility Verification Application
		&nbsp;&nbsp;&nbsp;
		<?php echo $txtPages; ?>

			</div>
		</div>
	</div>
</body>
