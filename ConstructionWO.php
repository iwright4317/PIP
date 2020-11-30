<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>CMP | Construction Work Order</title>
 
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
		$(function() {
			$("#datepicker2").datepicker();
		});
		$(function() {
			$("#datepicker3").datepicker();
		});
		$(function() {
			$("#datepicker4").datepicker();
		});
		$(function() {
			$("#datepicker5").datepicker();
		});
		$(function() {
			$("#datepicker6").datepicker();
		});
		$(function() {
			$("#datepicker7").datepicker();
		});
		$(function() {
			$("#datepicker8").datepicker();
		});
		$(function() {
			$("#datepicker9").datepicker();
		});
		$(function() {
			$("#datepicker10").datepicker();
		});
	</script>
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	
	function ScrubDate($ADate) {
	//2016-05-20 -> 05/16/2016
	if (!empty($ADate)) {
		return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
	} else {
		return null;
	}
	}

	$connection = mysql_connect("localhost", "iwright_CMP", "Mr.Coffee4") or die('I cannot connect to the database because: ' . mysql_error());
	$dbc = mysql_select_db("iwright_CMP", $connection) or die("<p>DB select failed ||<p>" . mysql_error());

	$connection2 = mysql_connect("localhost", "iwright_CMP", "Mr.Coffee4") or die('I cannot connect to the database because: ' . mysql_error());
	$dbc2 = mysql_select_db("iwright_CMP", $connection2) or die("<p>DB select failed ||<p>" . mysql_error());

	$strSQL = "";
	$edit_rec = false;

	if (!empty($_GET['Id'])) {

		$strSQL = "Select * " . "From `Construction Work Order`, Construction, 
		Engineers, Contractor, Inspectors " . "
		Where `Construction Work Order`.Id = " . $_GET['Id'] . " 
		and " . "ContractId = Construction.Id and 
		" . "`Construction Work Order`.ProjectManagerId = Engineers.Id and 
		" . "`Construction Work Order`.InspectorId = Inspectors.Id and 
		" . "`Construction Work Order`.ContractorId = Contractor.Id ";
		
		$strSQL = "Select * " . "From `Construction Work Order` 
		Where `Construction Work Order`.Id = " . $_GET['Id'];
		
		echo " " . $strSQL . " ";

		$q = $strSQL;
		$r = mysql_query($q, $connection) or die("<br/>Query failed: " . $q);
		if ($row = mysql_fetch_array($r)) {
			$edit_rec = true;						
		}
	}
	?>
	<div class="container" style='font-size: normal; font-weight: normal;'>
	<div class="row">
	<div class="col-md-12" style='font-size: x-large; font-weight: bold;'>
	Construction Work Order
	</div>
	</div>

	<div class="row">

	<div class="col-md-2">
	Contract&nbsp;Number:<br />
	<input name="txtContractNumber" type="text" value="<?php
	if ($edit_rec) {echo trim($row['Contract Number']);
	}
	?>" placeholder="text" tabindex="1" class=""  style="background-color: whitesmoke; width:140px;" />
	</div>

	<div class="col-md-4">
	Work Order Name:<br />
	<textarea name="txtContractName" rows="2" cols="20"  tabindex="2" class=""   style="background-color: whitesmoke; width:300px;"><?php
	if ($edit_rec) {echo trim($row['Contract Name']);
	}
	?></textarea>
	</div>

	<div class="col-md-3">
	Contractor:<br />
	<select name="ddlContractor" id="ddlContractor" class=""  style="background-color: whitesmoke;width:250px;">
	<option value=""></option>
	<?php
	$strSQL2 = "Select Id, Contractor, `Contact First Name`, `Contact Last Name` From Contractor Group by Contractor Order By Contractor";

	$CurCon = "";
	$SelCon = "";
	$CFN = "";
	$CLN = "";
	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	While ($row2 = mysql_fetch_array($r2)) {
		if ($row2[0] == $row['ContractorId']) {
			echo '<option selected value="' . $row2[1] . '">' . $row2[1] . '</option>';
			$SelCon = $row2[1];
			$CFN = $row2[2];
			$CLN = $row2[3];
		} else {
			if ($row2[1] <> $CurCon) {
				echo '<option value="' . $row2[1] . '">' . $row2[1] . '</option>';
			}
				$CurCon = $row2[1];
		}
	}
	?>
	</select>
	</div>

	<div class="col-md-3">
	Contact:<br />
	<select name="ddlContact" id="ddlContact" class=""  style="background-color: whitesmoke;width:182px;">
	<option value=""></option>
	<?php
	$strSQL2 = "Select * From Contractor Where Contractor = '" . $SelCon . "' Order By 'Contact First Name' ";

	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	While ($row2 = mysql_fetch_array($r2)) {
		if ($row2['Contact First Name'] == $CFN and $row2['Contact Last Name'] == $CLN) {
			echo "<option selected>" . $row2['Contact First Name'] . " " . $row2['Contact Last Name'] . "</option>";
		} else {
			echo "<option>" . $row2['Contact First Name'] . " " . $row2['Contact Last Name'] . "</option>";
		}
	}
	?>
	</select>
	</div>

	</div>

	<div class="row">
	<div class="col-md-2"><hr></div>
	</div>

	<div class="row">

	<div class="col-md-2">
	Finance&nbsp;Signs:<br />
	<input name="FinanceSigns" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Finance Signs']);
	}
	?>"
	type="text" placeholder="date" id="datepicker" tabindex="3" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Contract&nbsp;Executed:<br />
	<input name="ContractExecuted" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Contract Executed']);
	}
	?>" 
	type="text" placeholder="date" id="datepicker2" tabindex="4" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	NTP:<br />
	<input name="NTP" value="<?php
	if ($edit_rec) {echo ScrubDate($row['NTP']);
	}
	?>" 
	type="text" id="NTP" placeholder="date" id="datepicker3" tabindex="5" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Original Construction:<br />
	<input name="Duration" value="<?php
	if ($edit_rec) {echo $row['Duration'];
	}
	?>"
	type="text" placeholder="days" tabindex="6" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-1">
	<a title="Click to update Total Contract Amount" >Total Amount</a>
	<br/>
	<?php 
	
    $strSQL2 = "Select Count(*), Sum(`Change Amount`) from `Contract Change` Where " .
    "Type <> 'Formal Notification' and Type <> 'Task Order' and IncludeDollars = 'y' and " .
    "`Contract Id` = " . $_GET['Id'] . " and `Contract Type` = 'Construction Work Order'";	
	
	$CC = 0;
	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	if ($row2 = mysql_fetch_array($r2)) {
		$CC = $row2[0];
	}                        

    $strSQL2 = "Select Count(*), Sum(`Change Amount`) from `Contract Change` Where " .
    "Type = 'Change Order' and IncludeDollars = 'y' and " .
    "`Contract Id` = " . $_GET['Id'] . " and `Contract Type` = 'Construction Work Order' ";
	
	$COAmount = 0;
	$COCount = 0;
	
	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	if ($row2 = mysql_fetch_array($r2)) {
		$COCount = $row2[0];		
		$COAmount = $row2[1];
	}   
	
    $strSQL2 = "Select Count(*), Sum(`Change Amount`) from `Contract Change` Where " .
    "Type = 'Task Order' and IncludeDollars = 'y' and " .
    "`Contract Id` = " . $_GET['Id'] . " and `Contract Type` = 'Construction Work Order' ";

    $TOAmount = 0;
    $TOCount = 0;
    
    $q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	if ($row2 = mysql_fetch_array($r2)) {
		$TOCount = $row2[0];		
		$TOAmount = $row2[1];
	}  
	
    $strSQL2 = "Select Count(*), Sum(`Change Amount`) from `Contract Change` Where " .
    "Type = 'Formal Notifications' and IncludeDollars = 'y' and " .
    "`Contract Id` = " . $_GET['Id'] . " and `Contract Type` = 'Construction Work Order' ";

    $FNAmount = 0;
    $FNCount = 0;
	
	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	if ($row2 = mysql_fetch_array($r2)) {
		$FNCount = $row2[0];		
		$FNAmount = $row2[1];
	}  

	echo "$" . number_format($row['Original Contract Amount'] + $CC, 0);
	
	?>
	</div>

	<div class="col-md-3">
	Section:<br />
	<select name="ddlSection" id="ddlSection" class=""  style="background-color: whitesmoke;width:240px;">
	<option value=""></option>
	<option value="SSO Reduction">SSO Reduction</option>
	<option value="Planning and Analysis">Planning and Analysis</option>
	<option <?php if ($row['Section'] == "Design and Construction") {echo "selected";}?> value="Design and Construction">Design and Construction</option>
	<option value="Water Distribution">Water Distribution</option>
	<option value="Sewer Collection">Sewer Collection</option>
	</select>
	</div>

	</div>

	<div class="row">
	<div class="col-md-2"><hr></div>
	</div>

	<div class="row">
	<div class="col-md-2">
	Final Inspection <br>Performed:
	<input name="FinalInspectionPerformed" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Final inspection performed']);
	}
	?>" type="text" placeholder="date" id="datepicker4" tabindex="7" class=""  style="background-color: whitesmoke; width:100px" title="Letter from Inspector"
	/>
	</div>

	<div class="col-md-2">
	Closeout Change <br>Order Initiated:
	<input name="CloseoutChangeOrder" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Closeout Change Order Initiated']);
	}
	?>" type="text" placeholder="date" id="datepicker5" tabindex="8" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Warranty Inspection <br>Performed:
	<input name="WarrantyInspection" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Warranty Inspection Performed']);
	}
	?>" type="text" placeholder="date"  id="datepicker6" tabindex="9" title="Letter from Inspector"
	class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	<a title="Click to update Scheduled completion" >Scheduled completion</a>
	<?php
	if ($edit_rec) {echo ScrubDate($row['Scheduled Completion']);
	}
	?>
	</div>

	<div class="col-md-4">
	Change Orders (<?php echo $COCount;?>): <?php echo "$" . number_format($COAmount, 0);?><br/>
	Task Orders: (<?php echo $TOCount;?>): <?php echo "$" . number_format($TOAmount, 0);?><br />
	Formal Notifications: (<?php echo $FNCount;?>): <?php echo "$" . number_format($FNAmount, 0);?><br />
	</div>

	</div>

	<div class="row">
	<div class="col-md-2"><hr></div>
	</div>

	<div class="row">
		
	<div class="col-md-2">
	Warranty Period Begins:<br>
	<input name="WarrantyPeriodBegins" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Warranty Begins']);
	}
	?>" type="text" placeholder="date" id="datepicker8" tabindex="11" title="Letter from Project Manager"
	class=""  style="background-color: whitesmoke;width:100px;" />
	</div>
		
	<div class="col-md-2">
	Warranty Period Expires: <br/>
	<input name="WarrantyExpires" value="<?php
	if ($edit_rec) {echo ScrubDate($row['Warranty Complete']);
	}
	?>" type="text" placeholder="date" id="datepicker7" tabindex="10" title="Letter from Project Manager"
	class=""  style="background-color: whitesmoke;width:100px;" />
	</div>
	

	<div class="col-md-3">
	Inspector:<br />
	<select name="ddlInspector" class=""  style="background-color: whitesmoke;width:200px;">
	<option value=""></option>
	<?php
	$strSQL2 = "Select * From Inspectors Order By IName ";

	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	While ($row2 = mysql_fetch_array($r2)) {
		if ($row2['Id'] == $row['InspectorId']) {
			echo "<option selected>" . $row2['IName'] . " </option>";
		} else {
			echo "<option>" . $row2['IName'] . "</option>";
		}
	}
	?>
	</select>
	</div>

	<div class="col-md-4">
	Project Manager:<br />
	<select name="ddlProjectManager"  class=""  style="background-color: whitesmoke;width:240px;">
	<option value=""></option>
	<?php
	$strSQL2 = "Select * From Engineers Order By Engineer ";

	$q2 = $strSQL2;
	$r2 = mysql_query($q2, $connection2) or die("<br/>Query failed: " . $q2);
	While ($row2 = mysql_fetch_array($r2)) {
		if ($row2['Id'] == $row['ProjectManagerId']) {
			echo "<option selected>" . $row2['Engineer'] . " </option>";
		} else {
			echo "<option>" . $row2['Engineer'] . "</option>";
		}
	}
	?>
	</select>
	</div>

	</div>

	<div class="row">
	<div class="col-md-2"><hr></div>
	</div>

	<div class="row">

	<div class="col-md-2">
	Original Contract Amount:<br>
	<input name="OrginialWorkOrderAmount" placeholder="dollars" type="text" tabindex="12"
	class="" value="<?php
	if ($edit_rec and !empty($row['Original Contract Amount'])) {
		echo "$" . number_format($row['Original Contract Amount'], 0); 
	}
	?>" style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Original Task Order Amount:<br>
	<input name="OrginialTaskOrderAmount" placeholder="dollars"  type="text" tabindex="12"
	class="" value="<?php
	if ($edit_rec and !empty($row['Original Task Order'])) {
		echo "$" . number_format($row['Original Task Order'], 0); 
	}
	?>" style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Liquidated Damages:<br />
	<input name="LiquidatedDamages" type="text" placeholder="dollars"  tabindex="12"
	class="" value="<?php
	if ($edit_rec and !empty($row['Liquidated Damages'])) {
		echo "$" . number_format($row['Liquidated Damages'], 0); 
	}
	?>" style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-1">
	CIP Water:<br />
	<input name="txtCIPWater" type="text"  value="<?php
	if ($edit_rec) {echo $row['CIPWater'];
	}
	?>"  placeholder="CIP #" tabindex="15" class=""  style="background-color: whitesmoke;width:80px;" />
	</div>

	<div class="col-md-1">
	CIP Sewer:<br />
	<input name="txtCIPSewer" type="text"  value="<?php
	if ($edit_rec) {echo $row['CIPSewer'];
	}
	?>"  placeholder="CIP #" tabindex="16" class=""  style="background-color: whitesmoke;width:80px;" />
	</div>

	<div class="col-md-2">
	Certificate of Insurance (COI):<br />
	<input name="txtCOI" type="text" value="<?php
	if ($edit_rec) {echo ScrubDate($row['COI']);
	}
	?>"  tabindex="17" id="datepicker9" placeholder="date" class=""  style="background-color: whitesmoke;width:100px;" />
	</div>

	<div class="col-md-2">
	Contractor/Consultant Perf. Eval. (CPE):<br />
	<input name="txtCPE" type="text" value="<?php
	if ($edit_rec) {echo ScrubDate($row['CPE']);
	}
	?>"  id="datepicker10" placeholder="date"  class=""  style="background-color: whitesmoke;width:88px;" />
	</div>

	</div>

	<div class="row">
	<div class="col-md-2"><hr></div>
	</div>

	<div class="row">
	<div class="col-md-5">
	Comment:<br />
	<textarea name="txtWOName" rows="2" cols="20" id="txtComment" tabindex="2" class=""  style="background-color: whitesmoke;width:410px;"><?php echo $row['Comment']; ?></textarea>
	</div>

	<div class="col-md-3">
	<a href="ContractChange.php?Type=Construction Work Order&Id=<?php echo $row['Id'];?>" style="font-weight:bold;">Contract Change</a><br />
	<a style="font-weight:bold;">Invoice Tracking</a><P>
	<input id="Inactive" type="checkbox" name="Inactive">&nbsp;Inactive<br />
	<input id="DeleteContract" type="checkbox" name="DeleteContract" />&nbsp;Delete this contract
	</div>

	<div class="col-md-4">
	<a style="font-weight:bold;">Create Final Inspection Form</a>
	<br/>
	<a style="font-weight:bold;">Create Warranty Begins  Letter</a>
	<br/>
	<a style="font-weight:bold;">Create Warranty Inspection Form</a>
	<br/>
	<a style="font-weight:bold;">Create Warranty Expires Letter</a>
	</div>
	</div>

	<div class="row">

	<div class="col-md-4">
	<input type="submit" name="Button1" value="Store this Contract Item" id="Button1"
	class=""  style="background-color: whitesmoke;width:250px;" />
	</div>

	<div class="col-md-2">
	<a id="HyperLink11" href="ConstructionContract.aspx" >Reset form</a>
	</div>

	</div>

	</div>
</body>
