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
	//include ('./includes/database2.inc');
	set_time_limit(2000);
				
	?>
	<div class="container" style="font-size: normal; ">

		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Condition Messages Merge
			</div>
		</div>

		<div class="row">
			<!-- <div class="col-sm-12"> -->

				<?php

				$strSQL = "";
				$edit = false;

				?>

				<div class="row">
				<div class="col-sm-6" style='font-size: x-large; font-weight: bold;'>
				
				</div>

				<div class="col-sm-6" style='font-size: x-large; font-weight: bold;'>
				
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

				$q = "Select * from ConditionMessagesCommentsIMH ";
				echo "<br>$q";
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				While ($row = mysqli_fetch_array($r)) {
				    //echo "rf,";
					$CMIdsS[$AI] = $row["CMId"];
					$CommentsS[$AI] = $row["Comment"];
					$PermitIdsS[$AI] = $row["PermitId"];
					$IncludeWithCommentsS[$AI] = $row["IncludeWithComments"];
					$StandardTextS[$AI] = $row["StandardText"];
					$CommentsS[$AI] = $row["Comment"];
					$AI = $AI + 1;
				}
				
				$AIS = $AI - 1;
				$AI = 0;
				$I = 0;

				$q = "Select * from ConditionMessagesComments ";
				echo "<br>$q";
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

				While ($row = mysqli_fetch_array($r)) {
				    //echo "rf,";
					$CMIds[$AI] = $row["CMId"];
					$Comments[$AI] = $row["Comment"];
					$PermitIds[$AI] = $row["PermitId"];
					$IncludeWithComments[$AI] = $row["IncludeWithComments"];					
					$StandardText[$AI] = $row["StandardText"];
					$AI = $AI + 1;
				}
				

				$AI = $AI - 1; // HG
				echo "<br>$AI";
				$nfc = 0;
				$I = 0;
				While ($I < $AI) {
					//echo "$I,";
					$J = 0;
					$Found = false;
					While ($J <= $AIS && !$Found) {
					    if ($CMIds[$I] == $CMIdsS[$J] && $PermitIds[$I] == $PermitIdsS[$J]) {
					        $Found = true;
					    }
					    $J = $J + 1;
					}
					
					if(!$Found) {
					    echo "<br>Not found " . $CMIds[$I] . " " . $PermitIds[$I] . " ";
					    $nfc = $nfc + 1;
					    $q = "Insert into ConditionMessagesCommentsIMH 
					    (CMId,Comment,PermitId,IncludeWithComments,
					    StandardText) values (
					    '" . $CMIds[$I] . "','" . str_replace("'", "''",$Comments[$I]) . "','" .
					    $PermitIds[$I] . "','" . $IncludeWithComments[$I] . 
					    "','" . str_replace("'", "''",$StandardText[$I]) . "')";
				        echo "<br>$q";
				        $r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);

					}
					
					$I = $I + 1;
				} 
				echo"<p>nfc: " . $nfc;

 ?>
</body>