<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Home</title>

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
	
	<script>
		$(function() {
			$("#datepicker2").datepicker();
		});
	</script>
	
	
</head>
<body>

	<?php
	include ('./includes/banner.inc');
	
	function DisplayOptions($field,$connection) {
		
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
		
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " .
                "Group By " . $field . " Order by " . $field . "";
	$r = mysqli_query($connection, $q) or die("<br/>Query failed");

	While ($row = mysqli_fetch_array($r)) {
		echo "<option value='$row[0]'>$row[0]</option>";
	}
	return true;
	}
	
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());

				$strSQL = "";
	?>
	<form name="form1" method="post" action="UVASearchResults.php" onsubmit="javascript:return validateandsubmit(document.form1)">

		<div class="container"  style="font-size : large; font-weight: bold; background-color: white">

			<div class="row">
				<div class="col-sm-12" style="font-size: x-large; font-weight: bold;">
					Utility Verification Application Search
				</div>
					<hr>
			</div>

			<div class="row" style="border-bottom: solid 1px grey">
				<div class="col-sm-6">
					Permit Number:
					<input type="text" id="txtPermitNumber" name="txtPermitNumber" placeholder="(like 2014-02430)" class=""  style="background-color: whitesmoke; height:29px;  width:100%">
					<select class="" id="ddlPermitNumber" name="ddlPermitNumber" onchange="setPermitNumber()" style="background-color: whitesmoke; height:23px; width:100%; ">
						<option ></option>	
									
						<script>
						function setPermitNumber() {
							document.getElementById("txtPermitNumber").value = document.getElementById("ddlPermitNumber").value;
						}
						</script>			
						<?php				
						$time = strtotime("-14 months", time());
  						$date = date("Y-m-d", $time);  
 	
						$q = "SELECT PermitNumber " .
    					"FROM PIP Where PermitNumber is not null and DateReceived >= '" . $date . "' " . 
    					"Order by PermitNumber";
    					    					
						$r = mysqli_query($connection, $q) or die("<br/>Query failed");
	
						While ($row = mysqli_fetch_array($r)) {
							echo "<option value=$row[0]>$row[0]</option>";
						}
						?>	
					</select>
				</div>
				
				<div class="col-sm-6">
					Company Name:
					<select class="" name="ddlCompanyName"  style="background-color: whitesmoke; height:23px;  width:100%">
						<option ></option>							
						<?php DisplayOptions('CompanyName',$connection);	?>
					</select>
				</div>
				<hr>
			</div>

			<div class="row" style="border-bottom: solid 1px grey">
				<div class="col-sm-6">
					Techician:<br>
					<select  name="ddlTechnician" style="background-color: whitesmoke; width:100%">
						<option ></option>			
						<?php DisplayOptions('Technician',$connection);	?>						
					</select>

				</div>
				<div class="col-sm-6">
					Subcontractor:													
						<?php 
							$q = "SELECT Subcontractor, Count(Subcontractor) 
							FROM UtilityVerificationApplication 
							Where Subcontractor is not null 
                			Group By Subcontractor Order by Subcontractor";
                			
							$r = mysqli_query($connection, $q) or die("<br/>Query failed "  . mysqli_error($connection));
							echo '<select class="" name="ddlSubcontractor" style="background-color: whitesmoke; height:23px;  width:100%">';
							echo "<option ></option>";
							While ($row = mysqli_fetch_array($r)) {
								echo "<option value='$row[0]'>$row[0]</option>";
							}
						?>
					</select>

				</div>
			</div>

			<div class="row" style="border-bottom: solid 1px grey">

				<div class="col-sm-6">
					UVA Date:<br>
					<input type=text id="datepicker" name="SDStartDate" style="background-color: whitesmoke; height:23px; width:100px">
					to&nbsp;<input type=text id="datepicker2" name="SDEndDate"  style="background-color: whitesmoke; height:23px; width:100px">
				
				</div>
				
				<div class="col-sm-6">
					Location Description contains:&nbsp;<br>
					<input type="text" style="background-color: whitesmoke; height:23px; width:100%" name="txtLocationDescription">
				</div>
			</div>


			<div class="row" style="border-bottom: solid 1px grey">
				<div class="col-sm-3">
					<input type="checkbox" value="on" name="chkOpenPermit" class=""  style="background-color: whitesmoke; ">
					&nbsp;Open permits
				</div>
				<div class="col-sm-5">
					<input type="checkbox" value="on" name="ConstructionStart" class=""  style="background-color: whitesmoke; ">
					&nbsp;Start Construction Date
				</div>
				<div class="col-sm-4">
					<input type="checkbox" value="on" name="Codes" class=""  style="background-color: whitesmoke; ">
					&nbsp;PIE, PUV, or PVP
				</div>

				<hr>
			</div>
			<div class="row" style="border-bottom: solid 1px grey">
			<div class="col-sm-5">
					Foreman:&nbsp;
					<select name="ddlForeman" style="background-color: whitesmoke; height:23px; width:300px">
						<option></option>
												
						<?php 
							$q = "SELECT Foreman, Count(Foreman) 
							FROM UtilityVerificationApplication 
							Where Foreman is not null 
                			Group By Foreman Order by Foreman";
                			
							$r = mysqli_query($connection, $q) or die("<br/>Query failed");
	
							While ($row = mysqli_fetch_array($r)) {
								echo "<option value=$row[0]>$row[0]</option>";
							}
						?>
					</select>
					</div>
</div>
			<div class="row">
				<div class="col-sm-4">

					<button type="submit" class="btn btn-success" >
						Search UVA records
					</button>
				</div>
					
				<div class="col-sm-3">
					<a href="index.php">Clear the form</a>
				</div>
				
				
					<hr>
			</div>

		</div>
	</form>
</body>
