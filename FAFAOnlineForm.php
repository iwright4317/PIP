<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	
	<script>
		function isblankentry(item) {
			if (item.value == "") {
				return true;
			} else {
				return false;
			}
		}

		function testemail(item) {
			var regexp = /^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/
			var result = item.value.match(regexp);
			if (result == null) {
				return false;
			} else {
				return true;
			}
		}

		function getData(dataSource, item, divID) {
			//alert(dataSource);
			if (XMLHttpRequestObject) {
				var obj = document.getElementById(divID);

				dataSource = dataSource + item;
				//alert(dataSource);

				XMLHttpRequestObject.open("GET", dataSource);
				XMLHttpRequestObject.onreadystatechange = function() {
					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
						eresp = XMLHttpRequestObject.responseText;
						obj.innerHTML = eresp;
						//alert(eresp);
					}
				}
				XMLHttpRequestObject.send(null);
			}
			return true;
		}

		function checkData(target, tstring) {
			var ReturnValue = true;
			// alert("Checking email address");
			var obj = document.getElementById(target);

			if (obj.innerHTML == tstring) {
				ReturnValue = true;
			}

			return ReturnValue;
		}

		function validateandsubmit(theform) {
			var returnval = true;
			debugger;
			//alert('validate form');
			var deleteExists = document.getElementById("deleteRecord");
			var CheckForInput = true;
        	if (deleteExists == null) { // no deleteRecord checkbox -> new content item
        		CheckForInput = true;        		
        	} else { // edit existing item
        		if (!document.getElementById("deleteRecord").checked) {        		
        			CheckForInput = true;       // not deleting -> edit -> check	
        		} else {
        			CheckForInput = false;		// delete record desired -> don't validate
        		}
        	}
        	$txtStatus = "";
			if (CheckForInput) {
				
				if (isblankentry(theform.auto)) {
					$txtStatus = $txtStatus + "<br>The Contractor is blank. Please enter a Contractor name and click the Submit button again. ";
					returnval = false;
				}
				
				if (isblankentry(theform.contactPerson)) {
					$txtStatus = $txtStatus + "<br>The Contact Person is blank. Please enter a Contact Person name and click the Submit button again. ";
					returnval = false;
				}
				
				if (isblankentry(theform.phone)) {
					$txtStatus = $txtStatus + "<br>The Phone Number is blank. Please enter a Phone Number and click the Submit button again. ";
					returnval = false;
				} 
				
				if (isblankentry(theform.datepicker)) {
					$txtStatus = $txtStatus + "<br>The Date of Work is blank. Please enter Date of Work and click the Submit button again. ";
					returnval = false;
				} 
				
				if (theform.Atime.value == 'select time') {					
					$txtStatus = $txtStatus + "<br>The Arrival Time is not selected. Please select an Arrival Time and click the Save button again. ";
					returnval = false;
				}				
				
				if (theform.permit_number.value == 'select permit') {					
					$txtStatus = $txtStatus + "<br>The Permit Number is not selected. Please select a Permit Number and click the Save button again. ";
					returnval = false;
				}		
				
				if (theform.permit_number.value == 'Emergency' && isblankentry(theform.epermit)) {					
					$txtStatus = $txtStatus + "<br>You have selected Emergency permit, but no permit has been entered into the enter permit # text box. Please enter a permit into the enter permit # text box and click the Save button again. ";
					returnval = false;
				}		
				
				if (!theform.periodAM.checked && !theform.periodPM.checked) {
					$txtStatus = $txtStatus + "<br>The Arrival Time is not marked as AM or PM. Please select AM or PM and click the Save button again. ";
					returnval = false;
				}				
				
				if (isblankentry(theform.Location)) {
					$txtStatus = $txtStatus + "<br>The Location is blank. Please enter the Location and click the Submit button again. ";
					returnval = false;
				} 				
				
				$noneChecked = true;
				if (theform.Trench.checked) {$noneChecked = false;}
				if (theform.Bore.checked) {$noneChecked = false;}
				if (theform.Open_Cut.checked) {$noneChecked = false;}
				if (theform.Test_Hole.checked) {$noneChecked = false;}
				if (theform.Final_Patch.checked) {$noneChecked = false;}
				if (theform.Dig_in_Dirt.checked) {$noneChecked = false;}
				if (theform.Landscape_Clean_up.checked) {$noneChecked = false;}
				if (theform.Aerial.checked) {$noneChecked = false;}
				if (theform.Tree_Trimming.checked) {$noneChecked = false;}
				if (theform.Traffic_Only.checked) {$noneChecked = false;}
				if (theform.Blanket.checked) {$noneChecked = false;}
				
				if ($noneChecked){
					$txtStatus = $txtStatus + "<br>No Work Descriptions have been selected. Please select at least one Work Description and click the Submit button again. ";
					returnval = false;
				} 

				if (!returnval) {
					$txtStatus = $txtStatus + "<br>This request can not be submitted. ";
					document.getElementById("status").innerHTML = $txtStatus;
					document.getElementById("status").style.color="red";
					returnval = false;
				} else {
					//var obj = document.getElementById("divsending");
					//obj.innerHTML = "<b>Sending first batch of emails...</b>";
					document.getElementById("status").innerHTML = "";
					ReturnValue = true;
				}			
			}
			return returnval;
		}

	</script>
	
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});

	</script>
	
	<script>
	$(document).ready(function()
	{
    	$('#auto').autocomplete(
	    {
    	    source: "searchContractor.php",
        	minLength: 1
    	});
	});	
	</script>	
	
</head>
<body style='margin:0; ' >		
				
<?php
	include ('./includes/banner.inc');
	
	include ('./includes/database.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	$txtPermitNumber = '';
	$Technician = '';
	$CompanyName = '';	
	
	$db = True;
	$db = False;

	if (!empty($_GET['PermitId']) && is_numeric($_GET['PermitId'])) {
		
		// Get Permit info
		$query = "Select * from PIP Where Id = " . $_GET['PermitId'] . " ";
		$query = "Select PIP.Id, PermitNumber, PermitAddress, FirstName, LastName,
			PermitStatus, MiddleInitial, CompanyName  From PIP, Login Where PIP.Id = " . $_GET["PermitId"] . " and 
			Login.FirstName = PIP.Technician ";
			if ($db) {echo "<br>Get PIP info " . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {			
			$txtPermitNumber = $row["PermitNumber"];
			$Technician = $row[3] . '  ' . $row[4];
			$CompanyName = $row["CompanyName"];
			$Permittee = $row["CompanyName"];
			if ($db) {echo "<br>CompanyName: " . $CompanyName;}
		}
		
		$GotRecord = FALSE;
		if (isset($_GET["FAFAId"]) && trim($_GET["FAFAId"]) != "") {
			$query = "Select * from FAFA Where Id = " . $_GET["FAFAId"] . " ";
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			if ($row = mysqli_fetch_array($result) ) {
				$GotRecord = TRUE;
			}	
		} else {
			if (!isset($_GET["action"]) || trim($_GET["action"]) != "new") { 
				// Get FAFA info if FFACount
				$query = "Select * from FAFA Where PermitId = " . $_GET['PermitId'] . " order by Id ";
				$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			if ($db) {echo "<br>Get FAFA Info " . $query;}
				if (isset($_GET["FAFACount"]) && trim($_GET["FAFACount"]) <> "") {
					$FAFACount = $_GET["FAFACount"];
					while ($FAFACount >= 1 ) {
						$row = mysqli_fetch_array($result);	
						$FAFACount = $FAFACount - 1;
						$GotRecord = TRUE;
					}				
				} else {			
					if ($row = mysqli_fetch_array($result)) {
						$GotRecord = TRUE;
					}				
				}
			}
		}
		
		if ($db) {
			If ($GotRecord) {
				echo "<br>GotRecord: True";
			} else {				
				echo "<br>GotRecord: False";
			}
		}
		
			$FAFAId = "";
			$FormDate = "";
			$ToPlanning = "";
			$ToPermits = "";
			$ToInspections = "";
			$ToPublicUtilities = "";
			//$Permittee = "";
			$PermitNumber = "";
			$PermitId = "";
			$Contractor = "";
			$SubContractor = "";
			$Location = "";
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
			$FromPublicUtilities = "";	
			$SheetNumber = "";
			
		if ($GotRecord) {
			
			$FAFAId = $row["Id"];
			$FormDate = $row["FormDate"];
			$ToPlanning = $row["ToPlanning"];
			$ToPermits = $row["ToPermits"];
			$ToInspections = $row["ToInspections"];
			$ToPublicUtilities = $row["ToPublicUtilities"];
			$Permittee = $row["Permittee"];
			$PermitNumber = $row["PermitNumber"];
			$PermitId = $row["PermitId"];
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
			$SheetNumber = $row["SheetNumber"];	
		}
	}		
	
	?>				
<form action="Store_FAFA.php?FAFAId=<?php 
echo $FAFAId;?>&FAFACount=<?php 
if (isset($_GET["FAFACount"])) {echo $_GET["FAFACount"];}?>&action=<?php 
if (isset($_GET['action'])) {echo $_GET['action'];}?>&PermitId=<?php 
if (isset($_GET['PermitId'])) {echo $_GET['PermitId'];}?>" method="POST">
<div class="container"  style=" font-weight: bold; background-color: whitesmoke">
	
		<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Field Authorization for As-Built
			</div>
		</div>		

<div class="row">
	<div class="col-sm-12"  style='font-weight: bold' >
		Date:&nbsp;<input style='border-bottom: 2px solid black;' type="text" id="datepicker" value="<?php echo date('m/d/Y'); ?>" name="FormDate">
	</div>
</div>

<div class="row">
<div class="col-sm-12" style='   font-weight: bold' >
	TO: <input name="ToPlanning" value="checked" type="checkbox" style='border-bottom: 2px solid black;' <?php echo $ToPlanning;?> >Planning&nbsp;/
	<input type="checkbox" name="ToPermits" value="checked" <?php echo $ToPermits;?> >Permits&nbsp;/
	<input type="checkbox" name="ToInspections" value="checked" <?php echo $ToInspections;?> >Inspections&nbsp;/
	<input type="checkbox" name="ToPublicUtilities" value="checked" <?php echo $ToPublicUtilities;?> >Public&nbsp;Utilities
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold' >
	FROM: <input type="text" name="FromName" value="<?php echo $FromName;?>" style="border-bottom: 2px solid black;">&nbsp;
	<input type="checkbox" name="FromPlanning" value="checked" <?php echo $FromPlanning;?> >&nbsp;Planning&nbsp;/&nbsp;
	<input type="checkbox" name="FromPermits" value="checked" <?php echo $FromPermits;?> >Permits&nbsp;/&nbsp;
	<input type="checkbox" name="FromInspections" value="checked" <?php echo $FromInspections;?> >Inspections&nbsp;/&nbsp;
	<input type="checkbox" name="FromPublicUtilities" value="checked" <?php echo $FromPublicUtilities;?> >Public&nbsp;Utilities
</div>
</div>
<div class="row">
<div class="col-sm-12"  style='   font-weight: bold' >
	PERMITTEE: <input type="text" name="Permittee" size="20" value="<?php echo $Permittee;?>" style="border-bottom: 2px solid black;">
	Permit #: <input type="text" name="PermitNumber" value="<?php echo $txtPermitNumber;?>" style="font-weight: bold; 2px solid black;">
	Sheet #: <input type="text" name="SheetNumber" size="1"value="<?php echo $SheetNumber;?>" style="font-weight: bold; 2px solid black;">
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold'>
	Contractor Name / Sub Contractor: 
	<input size="20" name="Contractor" value="<?php if (isset($Contractor)) {echo $Contractor;}?>" type="text" style="border-bottom: 2px solid black;">/
	<input size="20" name="SubContractor" value="<?php if (isset($SubContractor)) {echo $SubContractor;}?>" type="text" style="border-bottom: 2px solid black;">
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold' >
	Location:(Be&nbsp;Specific)&nbsp;<p>
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold' >
	<textarea name="Location" rows="3" style="width:100%" name="Location"><?php if (isset($Location)) {echo $Location;}?></textarea>
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold' >
	Reasons For As-Built Request:	
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold' >
	<textarea name="Reasons" rows="3" style="width:100%" name="Reasons"><?php if (isset($Reasons)) {echo $Reasons;}?></textarea>
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='   font-weight: bold'>
	Number of Additional Test Holes: 
	<input type="text"  value="<?php if (isset($AdditionalTestHoles)) {echo $AdditionalTestHoles;}?>"  name="AdditionalTestHoles" style="border-bottom: 2px solid black;"><br>
	(Test Hole Letter Shall be Currently on File for the Permit)
</div>
</div>
<div class="row">
<div class="col-sm-12"   style='  font-weight: bold'>
	Number of Additional Open Cuts: 
	<input type="text"  value="<?php if (isset($AdditionalOpenCuts)) {echo $AdditionalOpenCuts;}?>" name="AdditionalOpenCuts" style="border-bottom: 2px solid black;"><br>
	(Open Cut Letter Shall be Currently on File for the Permit With As-built)
</div>
</div>

	<div class="row">
		<div class="col-sm-4" >Approved by:</div>
		<div class="col-sm-4" >Print Name:</div>
		<div class="col-sm-4" >Company:</div>
	</div>
	<div class="row" >
		<div class="col-sm-4"  style=''>
			1)_______________________
		</div>
		<div class="col-sm-4" >
			<input type="text" value="<?php if (isset($PrintName1)) {echo $PrintName1;}?>"  name="PrintName1" style="border-bottom: 2px solid black;">
		</div>
		<div class="col-sm-4" >
			<input type="text" value="<?php if (isset($Company1)) {echo $Company1;}?>" name="Company1" style="border-bottom: 2px solid black;">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4"  style=''>
			2)_______________________
		</div>
		<div class="col-sm-4" >
			<input type="text"  value="<?php if (isset($PrintName2)) {echo $PrintName2;}?>" name="PrintName2" style="border-bottom: 2px solid black;">
		</div>
		<div class="col-sm-4" >
			<input type="text"  value="<?php if (isset($Company2)) {echo $Company2;}?>" name="Company2" style="border-bottom: 2px solid black;">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4"  style=''>
			3)_______________________
		</div>
		<div class="col-sm-4" >
			<input type="text"  value="<?php if (isset($PrintName3)) {echo $PrintName3;}?>" name="PrintName3" style="border-bottom: 2px solid black;">
		</div>
		<div class="col-sm-4" >
			<input type="text"  value="<?php if (isset($Company3)) {echo $Company3;}?>" name="Company3" style="border-bottom: 2px solid black;">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12"  style=''>
<button style="font-size:12pt" class="success" name="Save" value="on">Save FAAS-Built</button>
<!-- <a href=FAFA.php?PermitId=<?php echo $_GET["PermitId"];?>&doct=word>Word doc</a> -->
			
		</b>
		</div>		
	</div>
	
	
	<div class="row">
		<div class="col-sm-8"  style=''>
		<a href=FAFAOnlineForm.php?action=new&PermitId=<?php echo $_GET["PermitId"];?>> New</a></b>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php
		If (isset($_GET['PermitId']) && is_numeric($_GET['PermitId'] ) ) {
		$FAFACount = "";
		if (isset($_GET["FAFACount"])) {
		$FAFACount = $_GET["FAFACount"]; // Target FAFA Count 
		If (trim($FAFACount) == "" or trim($FAFACount) == "0") {
			$FAFACount = 1; // no FAFACount -> assume showing first FAFA
		}}
		
		$query = "Select Id from FAFA Where PermitId = " . $_GET['PermitId'] . " order by Id ";
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		
		$CountFAFAs = 0; // # FAFAs in DB
		while ($row = mysqli_fetch_array($result)) {			
			$CountFAFAs = $CountFAFAs + 1;
			//echo '<p>411: FAFAId: ' . $_GET["FAFAId"];
			//echo '<br>row[0]: ' . $row[0]; 
			if (isset($_GET["FAFAId"]) && $row[0] == $_GET["FAFAId"]) {$FAFACount = $CountFAFAs;}
		}
		
		//echo '<br>CountFAFAs: ' . $CountFAFAs;
		//echo '<br>FAFACount: ' . $FAFACount . '<br>';
		
		if ($FAFACount > 1) {
			$TempFAFA = $FAFACount - 1;
			echo '<a href="FAFAOnlineForm.php?FAFACount=' . $TempFAFA . '&PermitId=' . $_GET["PermitId"] . '">Previous</a></b>&nbsp;&nbsp;&nbsp;&nbsp';		
		} 	
		
		if ($CountFAFAs > $FAFACount and $CountFAFAs > 1) {
			$TempFAFA = $FAFACount + 1;
			echo '<a href=FAFAOnlineForm.php?FAFACount='. $TempFAFA . '&PermitId=' . $_GET["PermitId"] . '> Next</a></b>&nbsp;&nbsp;&nbsp;&nbsp;';
		}	
		echo '<a href=FAFA.php?PermitId=' . $_GET["PermitId"] . '> Printer Version</a></b>&nbsp;&nbsp;&nbsp;&nbsp;';
		if (trim($FAFACount) == "") {$FAFACount = 1;}		
		echo '<b>' . $FAFACount . ' / ' . $CountFAFAs . '</b>';	
		}
		?>
		
		<!--
		<a href=FAFA.php?PermitId=<?php echo $_GET["PermitId"];?>> View All</a></b>&nbsp;&nbsp;&nbsp;&nbsp;1/1
		-->
		</div>		
		<div class="col-sm-4"  style=''>
			<input type="checkbox" value="on" name="chkDelete">&nbsp;Delete this FAAS Built form
		</div>
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