<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Condtion Messages </title>

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
	echo "<form name=form1 method=post action=ConditionMessages.php?Id=" . $_GET["Id"] . ">";
				
	?>
	<div class="container" style="font-size: normal; ">

		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Condition Messages
			</div>
		</div>

		<div class="row">
			<!-- <div class="col-sm-12"> -->

				<?php

				include ('./includes/database.inc');
				//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
				//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection2));
				$strSQL = "";
				$edit = false;
if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
				If ($_GET["Id"] <> "") { // Permit Id
					$edit = true;
					$q = "Select count(*) from UtilityVerificationApplication Where PermitId = " . $_GET["Id"];

					$q = "Select PermitAddress,Id,PermitNumber, CommentsAddress " . "From PIP Where Id = " . $_GET["Id"] . " ";

					//echo '<br> 9: ' . $q;
					$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

					If ($row = mysqli_fetch_array($r)) {
						$PermitId = $row[1];
						$txtPermitNumber = $row["PermitNumber"];

						If (!empty($row["CommentsAddress"]) and 1 == 2) {
							$PermitAddress = $row["CommentsAddress"];
						} else {
							$PermitAddress = $row["PermitAddress"];
						}
					} else {
						$PermitAddress = "Permit not found";
					}

				}
				?>

				<div class="row">
				<div class="col-sm-6" style='font-size: x-large; font-weight: bold;'>
				Permit:
				<?php
				if ($edit) {echo $txtPermitNumber . " ";
				}
				?>
				</div>

				<div class="col-sm-6" style='font-size: x-large; font-weight: bold;'>
				<?php
				if ($edit) {echo $PermitAddress . " ";
				}
				?>
				</div>
				</div>
				<?php

				//$CMIds(200)
				//$Comments(200)
				//$StandardText(200)
				$EntryDate = "2015-12-23";
				//$IncludeWithComments(200) As String
				$AI = 0;
				$I = 0;

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					echo '<br>POST';
					//If (Trim($_GET["Save"]) == "yes") {

					$q = "Select * From ConditionMessages Order By NumberCode";

// There should not be a GET inside of a if POST
					if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
					$PermitId = $_GET["Id"];
					$PermitAddress = $_POST["PermitAddress"];

					// Record the user-entered info

					$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
					While ($row = mysqli_fetch_array($r)) {
						$Id = $row["Id"];
						$field = "CM" . $row["Id"];
						If (isset($_POST[$field]) && $_POST[$field] == "on") {
							$CMIds[$AI] = $row["Id"];
							$StandardText[$AI] = $row["Description"];
							$field = "CMDescription" . $row["Id"];
							$Comments[$AI] = $_POST[$field];
							
							$field = "CMInclude" . $row["Id"];
							If (isset($_POST[$field]) && $_POST[$field] == "on") {
								$IncludeWithComments[$AI] = "y";
							}
							$AI = $AI + 1;
						}
					}

					// Delete all previvuos Condition Messages in preparation for the update

					$strSQL = "Delete from ConditionMessagesComments where PermitId = " . $PermitId;
					$r = mysqli_query($connection, $strSQL) or die("<br/>Query failed (55): " . $strSQL . "<br>" . mysqli_error($connection));

					//echo "<br>Now deleting D strSQL: " . $strSQL;
					
					$AI = $AI - 1;
					
					//echo '<br>AI: ' . $AI;
					
					If ($AI >= 0) {
						While ($I <= $AI) {
							
							$ThisIWC = '';
							if (isset($IncludeWithComments[$I])) {$ThisIWC = $IncludeWithComments[$I];}
							
							$strSQL = "Insert into ConditionMessagesComments " . 
							"(CMId,Comment,PermitId,EntryDate,
							IncludeWithComments,StandardText) values (" . 
							$CMIds[$I] . ",'" . str_replace("'", "''", $Comments[$I]) . 
							"'," . $PermitId . ",'" . $EntryDate . "','" . 
							$ThisIWC . "','" . 
							str_replace("'", "''", $StandardText[$I]) . "')";
							//echo "<br>strSQL: " . $strSQL;
							$r = mysqli_query($connection, $strSQL) or die("<br/>Query failed (55): <br>" . $strSQL . "<br>" . mysqli_error($connection));
							$I = $I + 1;
						}
					}

					$q = "Update PIP set CommentsAddress = '" . str_replace("'", "''", $_POST["PermitAddress"]) . "' Where Id = " . $_GET["Id"] . " ";
					$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

					echo "&nbsp;<br><b>Changes saved</b><br>";
				} else {
					echo "<b>Click the button below to save changes:</b><br>";
				}

				While ($I < $AI) {
					$CMIds[$I] = 0;
					$Comments[$I] = "";
					$StandardText[$I] = "";
					$IncludeWithComments[$I] = "";
					$I = $I + 1;
				}
				$AI = 0;

				$q = "Select * from ConditionMessagesComments where PermitId = " . $PermitId;
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				While ($row = mysqli_fetch_array($r)) {
					$CMIds[$AI] = $row["CMId"];
					$StandardText[$AI] = $row["StandardText"];
					$Comments[$AI] = $row["Comment"];
					$IncludeWithComments[$AI] = $row["IncludeWithComments"];
					$AI = $AI + 1;
				}

				$AI = $AI - 1;

				$q = "Select * From ConditionMessages Order by NumberCode ";
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				echo "<input type=hidden name=PermitId value=" . $PermitId . ">";
				echo "<b>Permit Address</b> * : <input type=textbox style='width:100%' name=PermitAddress value='" . $PermitAddress . "'>";
				echo "<br>* As will appear in the Comments report";
				echo '<div class="row"  style="background-color:#afeeee">';
				echo '<div class="col-sm-2">Include w/ Permit</div>';
				echo '<div class="col-sm-1">Number Code</div>';
				echo '<div class="col-sm-7">Description</div>';
				echo '<div class="col-sm-2">Include <br>w/ PU <br>Comments</div>';
				echo '</div>';

				While ($row = mysqli_fetch_array($r)) {
					$I = 0;
					$Found = False;
					$CheckedInclude = "";
					$Checked = "";
					while ($I <= $AI And !$Found) {
						If ($CMIds[$I] == $row["Id"]) {
							$Found = True;
							$Checked = "checked";
							If ($IncludeWithComments[$I] == "y") {
								$CheckedInclude = "checked";
							}
						} else {
							$I = $I + 1;
						}
					}
					echo '<div class="row" style="font-size:normal"><div class="col-sm-2">';
					If ($Found) { $Checked = "checked";
					}
					echo "<input type=checkbox name=CM" . $row["Id"] . " value=on " . $Checked . ">&nbsp;" . $row["LetterCode"] . "</div>";
					echo '<div class="col-sm-1">' . $row["NumberCode"] . '</div>';
					echo '<div class="col-sm-7">';
					echo $row["Description"];
					echo '<br><textarea rows="3" style=" width:100%" name=CMDescription' . $row["Id"] . '>';
					If ($Found) {echo $Comments[$I];
					}
					echo "</textarea></div>";
					echo '<div class="col-sm-2"><input type=checkbox name=CMInclude';
					echo $row["Id"] . " value=on " . $CheckedInclude . ">";
					echo "</div>";
					echo "</div>";
				}

				//echo "</table>";

				echo "<input type=hidden name=Save value=yes>";

				$Security = 0;

				// if  SecurityLevel = 2
				//echo "<input type=submit name=submit value=Save Changes>";
				?>

				<?php	
				if ($admin) {	?>
				<button type="submit" name="Save" value="yes" class="btn btn-success" title="Click this button to save this VMAR user record">
				Save Changes
				</button>
				<?php } ?>
				</form>;
</body>