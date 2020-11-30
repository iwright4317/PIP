<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | PU Comments </title>

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
				Public Utilities Comments
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

			<?php

			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
			//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
			$strSQL = "";
			$edit = false;

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

			If ($_GET["Id"] <> "") {
				$edit = true;

				$q = "Select * From PIP Where Id = " . $_GET["Id"] . " ";
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				If ($row = mysqli_fetch_array($r)) {
					$PermitId = $row["Id"];
					$PermitNumber = $row["PermitNumber"];
					$PermitAddress = $row["PermitAddress"];
					$Technician = $row["Technician"];
					$DateOfSignature = $row["DateOfSignature"];
				} else {
					$PermitAddress = "Permit not found";
				}
			}
			?>

			<div class="row">								
				<div class="col-sm-12" style='font-size: medium; font-weight: bold;'>
					  
					<a href="PUCommentsPF.php?Id=<?php echo $_GET["Id"]?>">Printer Friendly</a>&nbsp;&nbsp;
					<a href="archive/Condensed Guidelines January 2016.pdf">Condensed guidelines</a>&nbsp;&nbsp;
					<a href="archive/vacuum sewer.pdf">Vacuum sewer notification</a>
					
				</div>
			</div>
			
			<div class="row">
			<div class="col-sm-12" style='font-size: large; font-weight: bold;'>
			Technician: 
			<?php
			If ($edit) {echo $Technician . " ";
			}
			?>
			</div>

			</div>

			<div class="row">
			<div class="col-sm-12" style='font-size: large; font-weight: bold;'>
			Date of Signature:
			<?php
			
			
				function DisplayDate($ADate) {			
					$date = date_create($ADate);
					return date_format($date , "m/d/Y") ; 	
				}
				
			If ($edit) {echo DisplayDate($DateOfSignature) . " ";
			}
			?>
			</div>
			</div>

			<div class="row">
			<div class="col-sm-12" style='font-size: large; font-weight: bold;'>
			Permit Address:
			<?php
			If ($edit) {echo $PermitAddress . " ";
			}
			?>
			</div>
			</div>

			<div class="row">
			<div class="col-sm-12" style='font-size: large; font-weight: bold;'>
			Permit Number:
			<?php
			If ($edit) {echo $PermitNumber . " ";
			}
			?>
			</div>
			</div>
			
			
			<div class="row" style="background-color: #afeeee">
				<div class="col-sm-2" >
					Codes
				</div>
				<div class="col-sm-10" >
					Description
				</div>
			</div>

			<?php

			$q = "Select * from ConditionMessagesComments, ConditionMessages " . "where PermitID = " . $_GET["Id"] . " and " . "ConditionMessages.Id = ConditionMessagesComments.CMId ";
			$PermitId = $row["Id"];
			//echo "|" . $q . "|";

			$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
			while ($row = mysqli_fetch_array($r)) {
				If ($row["IncludeWithComments"] == "y") {
					$TestText = $row["Comment"];
					//$vbCrLf  = ControlChars.Lf;
					//$TestText = str_replace(vbCrLf, "<br />", TestText);
 					echo '<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">';                   
					echo '<div class="col-sm-1"><font size=4>' . $row["LetterCode"] . '</font></div>';
					echo '<div class="col-sm-1"><font size=4>&nbsp;&nbsp;&nbsp;' . $row["NumberCode"] . '</font></div>';
					echo '<div class="col-sm-10"><font size=4>' . $row["StandardText"];
					echo ' <b>' . nl2br($TestText) . '</b><font></div>';
					echo '</div>';
				}
			}

			$q = "Select * from PIPDiary where PermitID = " . $PermitId . " and " . "IncludeWithComments = 'y' ";

			$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
			while ($row = mysqli_fetch_array($r)) {
				If ($row["IncludeWithComments"] == "y") {
					echo '<div class="row"><div class="col-sm-1"><font size=5>&nbsp;</div>';
					echo '<div class="col-sm-1">&nbsp;&nbsp;&nbsp;<div class="col-sm-10"><b>' . $row["Entry"];
					echo '</b></div></div>';				}
			
			}
			?>
		</div>
	</div>
	</div>
</body>