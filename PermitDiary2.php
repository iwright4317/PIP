<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');	
	
	function DisplayOptions($field,$preSelect) {
		$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
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
	
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	if (!$admin) { // admin-only
		echo "<meta http-equiv='refresh' content='0; url=index_second.php' />";		
	}

	function ScrubDate($ADate) {
		//2016-05-20 -> 05/16/2016
		if (!empty($ADate)) {
			return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
		} else {
			return null;
		}
	}
	
	function validate_date_reg($input)
{
   if (preg_match('\d{1,2}/\d{1,2}/\d{4}', $input))
   {
      return true; // it matched, return true
   }
   else
   {
      return false;
   }
}
			
	function DisplayDate($ADate) {
		
		if (Trim($ADate) <> "") {
			$date = date_create($ADate);
			if (!$date) {
				return FALSE;
			} else {
				return date_format($date, "m/d/Y");
			}
		} else {
			return FALSE;
		}
		
	}

	$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
	$strSQL = "";
	$PermitId = 0;

if (isset($_GET['DiaryId']) trim($_GET['DiaryId']) <> "" && !is_numeric($_GET['DiaryId']) ) {exit;} // might be a hack
if (isset($_GET['Id']) && trim($_GET['Id']) <> "" && !is_numeric($_GET['Id']) ) {exit;} // might be a hack

		if (!empty($_GET['DiaryId'])) {
			$strSQL = "Select * From PIPDiary Where Id = " . $_GET['DiaryId'] . " ";
			$q = $strSQL;
			$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
			//echo "<br>q: " . $q;
			if ($row = mysqli_fetch_array($r)) {			
				$txtSiteVisitDate = $row["SiteVisitDate"];
				$realHours = $row["Hours"];
	    	    $txtTechnician = $row["Technician"];
    	    	$txtEntry = $row["Entry"];
				$txtEntryDate = $row["EntryDate"];
				$PermitId = $row["PermitId"];
			}
		} 
		
		
				function SQLDate($ADate) {
					if (trim($ADate) != "") {
						if (validate_date_reg($ADate)) {
							$date = date_create($ADate);
							return "'" . date_format($date , "Y-m-d") . "'"; 	
						} else {
							echo "Error: incorrect date format: " . $ADate;
							return "Null";
						}
					} else {
						return "Null";
					}
				}
				
	
	if (isset($_POST["Button1"])) {
		// Save button
		//echo "<br>DiaryId: " . $_GET['DiaryId'] , "<br>";
		if (isset($_GET['DiaryId']) and trim($_GET['DiaryId']) <> "" ) { // Update or Delete		
			if (isset($_POST['chkDelete'])) { // Delete			
				$strSQL = "Delete From PIPDiary 
				Where Id = " . $_GET['DiaryId'] . " ";
			} else {
				$strSQL = "Update PIPDiary set 
				EntryDate = " . SQLDate($_POST["txtEntryDate"]) . ",
				Technician = '" . $_POST["ddlTechnician"] . "',
				SiteVisitDate = " . SQLDate($_POST["txtSiteVisitDate"]) . ",
				Hours = '" . $_POST["ddlFieldHours"] . "',
				Entry = '" . str_replace("'","''",$_POST["txtEntry"]) . "'
				Where Id = " . $_GET['DiaryId'] . " ";
			}
			
		}
		
		if (!isset($_GET['DiaryId']) or trim($_GET['DiaryId']) == "") { // New Diary Entry
			if (isset($_GET["Id"]) and trim($_GET["Id"]) <> '') {
				$strSQL = "Insert into PIPDiary (EntryDate, Technician, SiteVisitDate, Hours, Entry, PermitId) values (
				 " . SQLDate($_POST["txtEntryDate"]) . ",
				 '" . $_POST["ddlTechnician"] . "',
				 " . SQLDate($_POST["txtSiteVisitDate"]) . ",
				 '" . $_POST["ddlFieldHours"] . "',
				 '" . str_replace("'","''",$_POST["txtEntry"]) . "',
				 " . $_GET["Id"] . ")";
			
			}
		}
		
		//echo " " . $strSQL . " ";
		$q = $strSQL;
		$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
	}

	$edit = false;

	if (!empty($_GET['Id']) or $PermitId <> 0) {
		if ($PermitId == 0 ) {$PermitId = $_GET['Id'];}
		$strSQL = "Select PermitAddress, Id, PermitNumber " . "From PIP Where Id = " . $PermitId . " Order by DateReceived";

		//echo " " . $strSQL . " ";

		$q = $strSQL;
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
		<form name="form1" method="post" action="PermitDiary2.php?Id=
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
                        
		if (!empty($_GET['DiaryId'])) {
			$strSQL = "Select * From PIPDiary Where Id = " . $_GET['DiaryId'] . " order by EntryDate desc";
			//echo " " . $strSQL . " ";
			$q = $strSQL;
			$r = mysqli_query($connection, $q ) or die("<br/>Query failed: " . $q);
			if ($row = mysqli_fetch_array($r)) {			
				$txtSiteVisitDate = $row["SiteVisitDate"];
				$realHours = $row["Hours"];
	    	    $txtTechnician = $row["Technician"];
    	    	$txtEntry = $row["Entry"];
				$txtEntryDate = $row["EntryDate"];
			}
		} ?>
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
						date("m/d/y") . '" name="txtEntryDate" style="width:96px">';
					}
					
					
					
					//$DateParts = date_parse_from_format("j.n.Y H:iP", $txtEntryDate);
					
					?>					
				</div>
				
			</div>
				
				
				
			<div class="row">
				<div class="col-sm-4">
					Technician:
					<select  name="ddlTechnician" style="background-color: whitesmoke; width:100px">
						<option ></option>			
						<?php DisplayOptions('Technician',$txtTechnician);	?>						
					</select>
				</div>
				
				
				<div class="col-sm-2" style="text-align: right">
					Site Visit Date:
				</div>
				
				<div class="col-sm-2">
					
					<?php					
					if (trim($txtSiteVisitDate) <> '') {
						echo '<input type="text" id="datepicker2" value="' . 
						DisplayDate($txtSiteVisitDate) . '" name="txtSiteVisitDate" style="width:96px">';
					} else {
						echo '<input type="text" id="datepicker2" value="' 
						. '" name="txtSiteVisitDate" style="width:96px">'; // date("m/d/y") 
					}
					?>	
				</div>				
			</div>
			
			
			<div class="row">
				<div class="col-sm-4">
					&nbsp;
				</div>			
				
				<div class="col-sm-2" style="text-align: right">
					Hours on site:
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
				<a  name="lnkNew"  Font-Bold="True" href="PermitDiary2.php?Id=
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
			$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			
			While ($row = mysqli_fetch_array($r)) { ?>				
				
			<!-- <div class="row" style="background-color: #afeeee"> -->
			<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">
				<div class="col-sm-1" >
					Date:<br>Tech:<br>Site Visit:
				</div>				
				<div class="col-sm-2" > <?php
					echo '<a href=PermitDiary2.php?Id=' . $PermitId . '&DiaryId=' . $row["Id"] .
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
