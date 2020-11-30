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
	<script>
		$(function() {
			$("#datepicker3").datepicker();
		});
	</script>
	<script>
		$(function() {
			$("#datepicker4").datepicker();
		});
	</script>
	
</head>
<body>

	<?php
	include ('./includes/banner.inc');
	
	function DisplayOptions($field) {
		include ('./includes/database.inc');
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " .
                "Group By " . $field . " Order by " . $field . "";
				echo "<br>|" . $q . "|";
	$r = mysqli_query($connection, $q) or die("<br/>Query failed");

	While ($row = mysqli_fetch_array($r)) {
		echo "<option value='$row[0]'>$row[0]</option>";
	}
	return true;
	}
	
	include ('./includes/database.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
				$strSQL = "";
	?>
	<form name="form1" method="post" action="searchSmall.php" onsubmit="javascript:return validateandsubmit(document.form1)">

		<div class="container"  style="font-size : large; font-weight: bold; background-color: white">

			<div class="row">
				<div class="col-sm-12" style="font-size: x-large; font-weight: bold;background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
					Permit Search
				</div>
			</div>
			
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	

			<div class="row">
				<div class="col-sm-6" >
					Permit Number:
					<input type="text" id="txtPermitNumber" name="txtPermitNumber" placeholder="" class=""  style="background-color: whitesmoke; height:27px; width:150px">
					<select class="" id="ddlPermitNumber" name="ddlPermitNumber" onchange="setPermitNumber()" style="background-color: whitesmoke; height:27px; width:250px">
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
					<select class="" name="ddlCompanyName"  style="background-color: whitesmoke; height:23px; width:250px">
						<option ></option>							
						<?php DisplayOptions('CompanyName');	?>
					</select>
				</div>
				<hr>
			</div>

	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
			<div class="row">
				<div class="col-sm-5">
					Permit Status:
					<select class="" name="ddlPermitStatus" style="background-color: whitesmoke; height:23px; width:250px">
						<option ></option>							
						<?php DisplayOptions('PermitStatus');	?>
					</select>

				</div>

					
					
				<div class="col-sm-7">
					Location contains:
					<input type="text" name="txtLocationDescription" placeholder="" class=""  style="background-color: whitesmoke; height:27px; width:300px">
				</div>
				<?php
				if (1 == 2) {
					?>
					
				<div class="col-sm-7">
					Address:

					<select class="" name="ddlNumeric"  style="background-color: whitesmoke; height:23px; width:100px">
						<option ></option>
					</select>
					&nbsp;

					<select class="" name="ddlStreetName"  style="background-color: whitesmoke; height:23px; width:250px">
						<option ></option>	
						<?php DisplayOptions(ST_NAME);	?>
					</select>
					&nbsp;

					<select class="" name="ddlSuffix" style="background-color: whitesmoke; height:23px; width:100px">
						<option ></option>
					</select>

				</div>
				<hr>
				<?php
				}
				?>
			</div>

	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
			<div class="row">
				<div class="col-sm-4">
					Condition Message:
					<select class="" name="ddlConditionCodes" style="background-color: whitesmoke; height:23px; width:100px">
						<option ></option>
						                
	<?php
				
	$time = strtotime("-1 year", time());
  	$date = date("Y-m-d", $time);  
 
	$q = "SELECT NumberCode " .
    "FROM ConditionMessages  " . 
    "Order by NumberCode";
	If (isset($_GET['CM'])) {
	echo '<br>CM:' . $_GET['CM'];
	
	If (trim($_GET['CM']) <> "") {
		$q = "SELECT " . $_GET['CM'] . " FROM ConditionMessages Order by " . $_GET['CM'];
	}
	}
	
	$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);

	While ($row = mysqli_fetch_array($r)) {
		echo "<option value=$row[0]>$row[0]</option>";
	}
	?>
                
					</select>
					<?php
					If (isset($_GET['CM'])) {
					If (trim($_GET['CM']) <> "LetterCode") {
						echo "<a href=index_second.php?CM=LetterCode>Alpha</a>";
					} else {						
						echo "<a href=index_second.php?CM=NumberCode>Numeric</a>";
					}
					}
					?>
					
				</div>

				<?php if (1 ==2) { ?>
				
				
				<div class="col-sm-4" style="font-weight: normal;">
					<b>GPIN:</b> (legacy)  
					<select class="" name="ddlGPIN"  style="background-color: whitesmoke; height:23px; width:220px">
						<option ></option>
						<?php DisplayOptions(GPINNumber);	?>
					</select>
				</div>

				
			</div>

	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
			<div class="row">
				
				<?php } ?>
				<div class="col-sm-4">
					Technician:
					<select class="" name="ddlTechnician" style="background-color: whitesmoke; height:23px; width:100px">
						<option ></option>			
						<?php DisplayOptions('Technician');	?>						
					</select>
				</div>

			</div>

	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
			<div class="row">
				<div class="col-sm-4">
					<input type="radio" name="Location" class=""  style="background-color: whitesmoke; ">
					&nbsp;All permits
					<br>
					<input type="radio" name="OpenPermits" value="on" class=""  style="background-color: whitesmoke; ">
					&nbsp;Open permits
				</div>

				<div class="col-sm-8">
					Signature Date from:
					<input type="text" id="datepicker" name="SDStartDate" class=""  style="background-color: whitesmoke; height:23px; width:100px">
					&nbsp;to:&nbsp;
					<input type="text" id="datepicker2"  name="SDEndDate" class=""  style="background-color: whitesmoke; height:23px; width:100px">
					<br>
					Date Received from:&nbsp;
					<input type="text" id="datepicker3"  name="DRStartDate" class=""  style="background-color: whitesmoke; height:23px; width:100px">
					&nbsp;to:&nbsp;
					<input type="text" id="datepicker4"  name="DREndDate" class=""  style="background-color: whitesmoke; height:23px; width:100px">
				</div>
				<hr>
			</div>

	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
			<div class="row">
				<div class="col-sm-6">
					<button type="submit" class="btn btn-success" >
						Search permit records
					</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="index.php">Clear the form</a>
				</div>
				<div class="col-sm-6">
					<input type="checkbox" name="compact" value="on">&nbsp;Compact output
				</div>
			</div>
			
			
		<div class="row">
			<div class="col-md-12">
			<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=vabeachpu.com','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/vabeachpu.com" /></a>
		
			</div>
		</div>

		</div>
	</form>
</body>
