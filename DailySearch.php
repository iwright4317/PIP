<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Daily Search</title>

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
	
	function DisplayOptions($field) {
		include ('./includes/database.inc');
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
				$strSQL = "";
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " .
                "Group By " . $field . " Order by " . $field . "";
		$r = mysqli_query($connection, $q) or die("<br/>Query failed");

		While ($row = mysqli_fetch_array($r)) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		return true;
	}
	
	//$connection = = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
				$strSQL = "";
	?>
	<form name="form1" method="post" action="DailySearchResults.php" onsubmit="javascript:return validateandsubmit(document.form1)">

		<div class="container"  style="font-size : large; font-weight: bold; background-color: white">

			<div class="row">
				<div class="col-sm-12" style="font-size: x-large; font-weight: bold;">
					Daily Search 
				</div>
					<hr>
			</div>

			<div class="row">
				<div class="col-sm-6">
					Permit Number:
					<input type="text" id="txtPermitNumber" name="txtPermitNumber" placeholder="(like 2014-02430)" class=""  style="background-color: whitesmoke; height:29px;  width:150px">
					<select class="" id="ddlPermitNumber" name="ddlPermitNumber" onchange="setPermitNumber()" style="background-color: whitesmoke; height:23px; width:250px; ">
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
			</div>

			<div class="row">
				<div class="col-sm-6">
					Company Name:
					<select class="" name="ddlCompanyName"  style="background-color: whitesmoke; height:23px;  width:250px">
						<option ></option>							
						<?php DisplayOptions('CompanyName');	?>
					</select>
				</div>
				<hr>
			</div>

			<div class="row">
				<div class="col-sm-5">
					Keyword:
					<input type="text" name="TextBox1" style="background-color: whitesmoke; height:23px;">

				</div>
			</div>

			<div class="row">

				<div class="col-sm-3" >
					Daily Date
					<input type=text id="datepicker" name="SDStartDate" style="background-color: whitesmoke; height:23px; width:100px">
				</div>
				
				<div class="col-sm-3">
					<br>to&nbsp;&nbsp;&nbsp;<input type=text id="datepicker2" name="SDEndDate"  style="background-color: whitesmoke; height:23px; width:100px">
				</div>
				<hr>					
			</div>

			<div class="row">
				<div class="col-sm-12">
					Location Description contains:<br>
					<input type="text" style="background-color: whitesmoke; height:23px; width:100%" name="txtLocationDescription">
				</div>
				<hr>
			</div>

			<div class="row">
				<div class="col-sm-4">

					<button type="submit" class="btn btn-success" >
						Search Daily records
					</button>
				</div>
					
				<div class="col-sm-3">
					<a href="index.php">Clear the form</a>
				</div>
				
					
			</div>

		</div>
	</form>
</body>
