<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');	
	
	function DisplayOptions($field,$preSelect,$connection) {
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " .
                "Group By " . $field . " Order by " . $field;
	$r = mysqli_query($connection, $q) or die("<br/>Query failed");

	While ($row = mysqli_fetch_array($r)) {
		if (trim($preSelect) <> "" and trim($row[0]) == trim($preSelect)) {
			echo "<option value='$row[0]' selected >$row[0]</option>";
		} else {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		
	}
	return true;
	}
	
	?>
	<title>PIP | Permit Diary Entry</title>

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
		function isPastDate(item) {
			var datep = item.value;
			//alert(datep);
			if(Date.parse(datep)-Date.parse(new Date())>=0) {
				return false;
			} else {
				return true;
			}
			
		}
	</script>
	
	<script>
		function isblankentry(item) {
		if (item.value == "") {
		return true;
		} else {
		return false;
		}
		}
	</script>	
		
	<script>
	function isZero(item) {
		if (item.value == "") {
			return true;
		} else {
			var chkNum = item.value; 
			if (chkNum <= 0) {
				return true;
			} else {
				return false;
			}
		}
	}
	</script>	
		
	<script type="text/javascript">

/**--------------------------
//* Validate Date Field script- By JavaScriptKit.com
//* For this script and 100s more, visit http://www.javascriptkit.com
//* This notice must stay intact for usage
---------------------------**/

		function checkdate(input){
			var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
			var returnval=false
			if (!validformat.test(input.value))
				//alert("Invalid Date Format. Please correct and submit again.")
				returnval=false
			else{ //Detailed check for valid date ranges
				var monthfield=input.value.split("/")[0]
				var dayfield=input.value.split("/")[1]
				var yearfield=input.value.split("/")[2]
				var dayobj = new Date(yearfield, monthfield-1, dayfield)
				if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
					//alert("Invalid Day, Month, or Year range detected. Please correct and submit again.")
					returnval=false
				else
					returnval=true
			}
			//if (returnval==false) input.select()
			return returnval
		}

	</script>


	<script>

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
		if (XMLHttpRequestObject) {
		var obj = document.getElementById(divID);

		dataSource = dataSource + item;

		XMLHttpRequestObject.open("GET", dataSource);
		XMLHttpRequestObject.onreadystatechange = function() {
		if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
		eresp = XMLHttpRequestObject.responseText;
		obj.innerHTML = eresp;
		}
		}
		XMLHttpRequestObject.send(null);
		}
		return true;
		}

		function checkData(target, tstring) {
		var ReturnValue = true;
		var obj = document.getElementById(target);

		if (obj.innerHTML == tstring) {
		ReturnValue = true;
		}

		return ReturnValue;
		}

		function validateandsubmit(theform) {

		var returnval = true;

		if (!theform.chkDelete.checked) {			
		
		if (isblankentry(theform.datepicker2)) {
			alert("The Action Date is blank. Please enter an Action Date. ");
			returnval = false;
		} else {
			if (!checkdate(theform.datepicker2)) {
				alert("The Action Date is not in a correct format. Please enter Action Date in the correct format (mm/dd/yyyy). ");
				returnval = false;
			} else {				
				if (!isPastDate(theform.datepicker2)) {
					alert("The Action Date is in the future. Please enter an Action Date in the past or today. ");
					returnval = false;
				}
			}
		}
						
		if (isblankentry(theform.ddlTechnician)) {
			alert("The Technician is blank. Please select a Technician. If the desired technician name does not appear in the Technician drop-down list, proceed to Administration -> Technician to add the missing Technician name. ");
			returnval = false;
		}		
		
		if (theform.txtEntry.value == " " || theform.txtEntry.value == "") {
			alert('The comment field is blank. Please enter a comment.');
			returnval = false;
		}
		
		if (isZero(theform.ddlFieldHours)) {			
			alert('Please enter a number of hours greater than 0.');
			returnval = false;
		}
		
		if (!returnval) {
		//alert("This request can not be submitted. Please correct the problem and click the Store button again. ");
		returnval = false;
		} else {
		ReturnValue = true;
		}
		return returnval;
		}
		}
	</SCRIPT>


</head>
<body>
	<?php
	include ('./includes/banner.inc');
	$db = True;
	$db = False;
	if (!$admin) { // admin-only
		echo "<meta http-equiv='refresh' content='0; url=index_second.php' />";	
		exit;	
	}

	function ScrubDate($ADate) {
		//2016-05-20 -> 05/16/2016
		if (!empty($ADate)) {
			return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
		} else {
			return null;
		}
	}
	
			
	function DisplayDate($ADate) {
		
		if (Trim($ADate) <> "") {
			if (Trim($ADate) <> "0000-00-00") {
				$date = date_create($ADate);
				if (!$date) {
					return FALSE;
				} else {
					return date_format($date, "m/d/Y");
				}
			} else {
				return "";
			}
		} else {
			return FALSE;
		}
		
	}

	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
	
	$strSQL = "";
	$PermitId = 0;
	
	if (isset($_GET['DiaryId']) && trim($_GET['DiaryId']) <> "" && trim($_GET['DiaryId']) <> "" && !is_numeric($_GET['DiaryId']) ) {exit;} // might be a hack
		if (!empty($_GET['DiaryId'])) {
			$strSQL = "Select * From PIPDiary Where Id = " . $_GET['DiaryId'] . " ";
			$q = $strSQL;
			$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
			if ($db) { echo "<br>q: " . $q; }
			if ($row = mysqli_fetch_array($r)) {			
				$txtSiteVisitDate = $row["SiteVisitDate"];
				$realHours = $row["Hours"];
	    	    $txtTechnician = $row["Technician"];
    	    	$txtEntry = $row["Entry"];
				$txtEntryDate = $row["EntryDate"];
				$PermitId = $row["PermitId"];
				$txtSiteVisit = $row["SiteVisit"];
			}
		} 
		
		
	function validate_date_reg($input)
{
    //If in dd/mm/yyyy format
    if (preg_match("^\d{2}/\d{2}/\d{4}^", $input))
    {
   //if (preg_match('\d{1,2}/\d{1,2}/\d{4}', $input))
   //{
      return true; // it matched, return true
   }
   else
   {
      return false;
   }
}
		
				function SQLDate($ADate) {
					if (trim($ADate) != "") {
						//if (validate_date_reg($ADate)) {
						$date = date_create($ADate);
						return "'" . date_format($date , "Y-m-d") . "'"; 	
						//} else {
						//	echo "Error: incorrect date format: " . $ADate;
						//	return "Null";
						//}
					} else {
						return "Null";
					}
				}
				
	
	if (isset($_POST["Button1"])) {
		// Save button
		if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
		if (isset($_GET["DiaryId"]) && trim($_GET['DiaryId']) <> "" && !is_numeric($_GET["DiaryId"]) ) {exit;} // might be a hack
		
		if ($db) { echo "<br>DiaryId: " . $_GET['DiaryId'] , "<br>";}
		if (isset($_GET['DiaryId']) and trim($_GET['DiaryId']) <> "" ) { // Update or Delete		
			if (isset($_POST['chkDelete'])) { // Delete			
				$strSQL = "Delete From PIPDiary 
				Where Id = " . $_GET['DiaryId'] . " ";		
				$q = $strSQL;
				if ($db) { echo "<br>q: " . $q; }		
				$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);				
			} else {
				$DataOkay = True;
				
				
				$chkSiteVisit = '';
				if (isset($_POST["chkSiteVisit"])) {
					if ($db) {echo '<br>Post chkSiteVisit' . $_POST["chkSiteVisit"];}
					if ($_POST["chkSiteVisit"] == 'yes') {
						$chkSiteVisit = 'yes';
					}
				}
				
				
				if ($DataOkay) {
					// First check for existing record
					$strSQL = "Select Id From PIPDiary Where Id = " . $_GET['DiaryId'] . " ";
					
					$q = $strSQL;
					if ($db) { echo "<br>q: " . $q; }		
					$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);					
					if ($row = mysqli_fetch_array($r)) {					
					
						$strSQL = "Update PIPDiary set 
						EntryDate = " . SQLDate(date('m/d/Y')) . ",
						Technician = '" . $_POST["ddlTechnician"] . "',
						SiteVisitDate = " . SQLDate($_POST["txtSiteVisitDate"]) . ",
						Hours = '" . $_POST["ddlFieldHours"] . "',
						SiteVisit = '" . $chkSiteVisit . "', 
						Entry = '" . str_replace("'","''",$_POST["txtEntry"]) . "'
						Where Id = " . $_GET['DiaryId'] . " ";
				
						$q = $strSQL;
						if ($db) { echo "<br>q: " . $q; }		
						$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
					} else {
						// Might be Delete -> user thinks "add" -> DiaryId no good -> Insert
						
						$strSQL = "Insert into PIPDiary (EntryDate, Technician, SiteVisitDate, Hours, Entry, PermitId, SiteVisit) values (
					 	" . SQLDate(date('m/d/Y')) . ",
					 	'" . $_POST["ddlTechnician"] . "',
					 	" . SQLDate($_POST["txtSiteVisitDate"]) . ",
					 	'" . $_POST["ddlFieldHours"] . "',
					 	'" . str_replace("'","''",$_POST["txtEntry"]) . "',
					 	" . $_GET["Id"] . ",'". $chkSiteVisit . "')";
					 	
						$q = $strSQL;
						if ($db) { echo "<br>q: " . $q; }	
						$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
					}
				
				} else {
					echo "<br>Record not stored";
				}
			}
			
		}
		
		if (!isset($_GET['DiaryId']) or trim($_GET['DiaryId']) == "") { // New Diary Entry
			if (isset($_GET["Id"]) and trim($_GET["Id"]) <> '') {
				
				$DataOkay = True;
				
				if (!validate_date_reg($_POST["txtSiteVisitDate"])) {
					//$DataOkay = False;
				}
				
				$chkSiteVisit = '';
				if (isset($_POST["chkSiteVisit"])) {
					if ($_POST["chkSiteVisit"] == 'yes') {
						$chkSiteVisit = 'yes';
					}
				}				

				if ($DataOkay && !isset($_POST['chkDelete'])) {
					$strSQL = "Insert into PIPDiary (EntryDate, Technician, SiteVisitDate, Hours, Entry, PermitId, SiteVisit) values (
					 " . SQLDate(date('m/d/Y')) . ",
					 '" . $_POST["ddlTechnician"] . "',
					 " . SQLDate($_POST["txtSiteVisitDate"]) . ",
					 '" . $_POST["ddlFieldHours"] . "',
					 '" . str_replace("'","''",$_POST["txtEntry"]) . "',
					 " . $_GET["Id"] . ",'". $chkSiteVisit . "')";
					 	
					$q = $strSQL;
					if ($db) { echo "<br>q: " . $q; }	
					$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
				} else {
					echo "<br>Record not stored";
				}
			}
		}
		
	}

	$edit = false;

	if (isset($_GET['Id']) && trim($_GET['Id']) <> "" && !is_numeric($_GET['Id']) ) {exit;} // might be a hack
	if (!empty($_GET['Id']) or $PermitId <> 0) {
		if ($PermitId == 0 ) {$PermitId = $_GET['Id'];}
		$strSQL = "Select PermitAddress, Id, PermitNumber " . "From PIP Where Id = " . $PermitId . " Order by DateReceived";

		$q = $strSQL;
		if ($db) { echo "<br>q: " . $q; }		
		$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
		if ($row = mysqli_fetch_array($r)) {
			$edit_rec = true;
			$txtPermitNumber = $row[2];
			$lblPermitAddress = $row[0];
			$PermitId = $row[1];
			$edit = true;
		} else {
			$lblPermitAddress = "Permit not found";
		}
	}
	$DiaryId = "";
	if (isset($_GET["DiaryId"])) {
		$DiaryId = $_GET["DiaryId"];
	}
	?>
	<div class="container" style='font-size normal; font-weight: normal;'>
		<form name="form1" method="post" action="PermitDiary.php?Id=
		<?php echo $PermitId . '&DiaryId=' . $DiaryId;?>" onsubmit="javascript:return validateandsubmit(document.form1)">

		<div class="row">
			<div class="col-sm-12" style='font-size: xx-large; font-weight: bold;'>
				Permit Diary Entry
			</div>
		</div>

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
				if ($edit) {echo $lblPermitAddress . " ";
				}
				?> 
			</div>
		</div>
		<?php 
		$txtSiteVisitDate = '';
		$realHours = 0;
        $txtTechnician = '';
        $txtEntry = '';
		$txtEntryDate = '';
		$txtSiteVisit = '';
                        
		if (!empty($_GET['DiaryId'])) {
			$strSQL = "Select * From PIPDiary Where Id = " . $_GET['DiaryId'] . " order by EntryDate desc";
			
			$q = $strSQL;
			if ($db) { echo "<br>q: " . $q; }		
			$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
			if ($row = mysqli_fetch_array($r)) {			
				$txtSiteVisitDate = $row["SiteVisitDate"];
				$realHours = $row["Hours"];
	    	    $txtTechnician = $row["Technician"];
    	    	$txtEntry = $row["Entry"];
				$txtEntryDate = $row["EntryDate"];
				$txtSiteVisit = $row["SiteVisit"];
				if ($db) { echo "<br>txtSiteVisitDate: " . $txtSiteVisitDate; }	
			}
		} 
		if (1 == 2) {
		?>
			<div class="row">
				<div class="col-sm-4">
					&nbsp;
				</div>
				
				<div class="col-sm-2" style="text-align: right">
					Entry Date:
				</div>
				
				<div class="col-sm-2">
					<?php					
					if (trim($txtEntryDate) <> '') {
						echo '<input type="text" id="datepicker" value="' . 
						DisplayDate($txtEntryDate) . '" name="txtEntryDate" style="width:96px">';				
					} else {
						echo '<input type="text" id="datepicker"  value="' .
						date("m/d/Y") . '" name="txtEntryDate" style="width:96px">';
					}
					?>					
				</div>
				
			</div>
		<?php
		} ?>
				
				
			<div class="row">
				<div class="col-sm-4">
					Technician:
					<select  name="ddlTechnician" style="background-color: whitesmoke; width:100px">
						<option ></option>			
						<?php DisplayOptions('Technician',$txtTechnician,$connection);	?>						
					</select>
				</div>
				
				
				<div class="col-sm-2" style="text-align: right">
					Action Date:
				</div>
				
				<div class="col-sm-3">
					
					<?php					
					if (trim($txtSiteVisitDate) <> '') {
						echo '<input type="text" id="datepicker2" value="' . 
						DisplayDate($txtSiteVisitDate) . '" name="txtSiteVisitDate" style="width:96px">';
					} else {
						echo '<input type="text" id="datepicker2" value="' .
						date("m/d/Y") . '" name="txtSiteVisitDate" style="width:96px">'; // date("m/d/y") 
					}				
					if (trim($txtSiteVisit) == 'yes') {
						echo '&nbsp;<input type="checkbox" value="yes" checked name="chkSiteVisit" >';
					} else {
						echo '&nbsp;<input type="checkbox" value="yes" name="chkSiteVisit" >'; 
					}
					?>	Site visit
				</div>			
			</div>
			
			
			<div class="row">
				<div class="col-sm-4">
					&nbsp;
				</div>			
				
				<div class="col-sm-2" style="text-align: right">
					Hours:
				</div>
				
				<div class="col-sm-2">
					<select  name="ddlFieldHours" >
						<?php
		               	$FH = 0;
                		While ($FH <= 10) {
                			if ($realHours <> 0 and $realHours == $FH) {
                				echo "<option selected>". number_format($FH,2) . "</option>";
							} else {
								echo "<option>". number_format($FH,2) . "</option>";
                			}                    		
                    		$FH = $FH + 0.25;
                		}
						?>
					</select>
				</div>					
			</div>

			<div class="row">
				<div class="col-sm-12">
				Comment:&nbsp;&nbsp;&nbsp;<br>
				<textarea rows=4 name="txtEntry" style="width:100%"><?php if ($edit) {echo $txtEntry . " ";}?></textarea><br>
								
					<button type="submit"  name="Button1" id="Button1"class="btn btn-success" >
						Store this entry
					</button>
				&nbsp;&nbsp;
				<a  name="lnkNew"  Font-Bold="True" href="PermitDiary.php?Id=
				<?php echo $PermitId;?> ">Clear form and start over </a>
				&nbsp;&nbsp;
				<input type="checkbox"  name="chkDelete" value="on">
				Delete this Diary Entry record
				</div>
			</div>	
	</form>
	<div class="row">
		<div class="col-sm-12">
		<?php 	
			$strSQL = "Select * from PIPDiary where PermitId = " . $PermitId . " Order by EntryDate";          
            ?>
            <p>&nbsp;</p>
            <div style="font-size: large; font-weight: bold">Diary Entries</div> (click&nbsp;date&nbsp;to&nbsp;edit)
				              
            <?php
			$q = $strSQL;
			if ($db) { echo "<br>q: " . $q; }		
			$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			
			While ($row = mysqli_fetch_array($r)) { ?>				
				
			<!-- <div class="row" style="background-color: #afeeee"> -->
			<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">
				<div class="col-sm-1" >
					Entry:<br>Tech:<br>Action: <?php
					if ($row["SiteVisit"] == 'yes') {
						echo '<br>Site&nbsp;visit';
					} ?>
				</div>				
				<div class="col-sm-2" > <?php
					echo '<a href=PermitDiary.php?Id=' . $PermitId . '&DiaryId=' . $row["Id"] .
                    '>' . DisplayDate($row["EntryDate"]) . '</a><br>';
					echo $row["Technician"] . '<br>';
					echo DisplayDate($row["SiteVisitDate"]) . '<br>';
                	echo 'Hours: ' . $row["Hours"];
				?>
				</div>				
				<div class="col-sm-9" >
					<?php echo $row["Entry"]; ?>
				</div>
			</div>		
			<?php
			}         
		?>		
	</div>		
</body>
