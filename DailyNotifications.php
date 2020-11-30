<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Daily Notifications </title>

	<script>
		$(function() {
			$(document).tooltip();
		});
	</script>
	
	<script>
		function AddPermit() {
			var Permit = document.getElementById("txtPermitNumber").value;
			var x = document.getElementById("PermitNumbers");
			var option = document.createElement("option");
			option.text = Permit;
			x.add(option);
		}
	</script>
	<style>
		label {
			display: inline-block;
			width: 5em;
		}
	</style>
</head>
<body>

	<?php
	include ('./includes/banner.inc');

	function DisplayOptions($field) {
		include ('./includes/database.inc');
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " . "Group By " . $field . " Order by " . $field . "";
		$r = mysqli_query($connection,$q) or die("<br/>Query failed");

		While ($row = mysql_fetch_array($r)) {
			echo "<option value='$row[0]'>$row[0]</option>";
		}
		return true;
	}
	
	function DumpTable($database,$table,$rowlimit) {
		// Connect database 
		$database="iwright_PIP"; 
		$result=mysql_query("select * from $table limit $rowlimit"); 
		if (!$result) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		echo "<pre>";
		if (mysql_num_rows($result) > 0) {
    		while ($row = mysql_fetch_assoc($result)) {
        		print_r($row);
    		}
		}		
		echo "</pre>";
	}
	
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
	//$val = DumpTable("iwright_PIP","PIP",5); 
		
	$DNDate = "";
	if (isset($_GET["DNDate"])) {
		$DNDate = $_GET["DNDate"];
	}
	if (isset($_POST['DNDate'])) {
		$DNDate = $_POST['DNDate'];
	}
	if (trim($DNDate) == "") {
		$DNDate = date('Y-m-d');
	}
	if (isset($_POST['RemoveThis']) ) {
		If (isset($_POST['PermitNumbers'])) {
			
		$values = $_POST['PermitNumbers'];			
		if (is_array($values)) {							
			foreach ($values as $selectedOption) {
    			//echo $selectedOption."\n";    			    			
							
				$strSQL = "Select DailyNotifications.Id From PIP, DailyNotifications 
Where PIP.Id = DailyNotifications.PermitId and DNDate = '" . DateToSQL($DNDate) . "' 
and PermitNumber = '" . $selectedOption . "'";		
			
				//echo "<p>" . $strSQL;
				$q = $strSQL;
				$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
				if ($row = mysqli_fetch_array($r)) {
					// Add permit ids to DailyNotifications with Notification date	
					$PId = $row[0];
					if (is_numeric($PId)) {										
						$strSQL = "Delete from DailyNotifications Where Id = " . $PId;	
						//echo "<p>" . $strSQL;		
						$q = $strSQL;
						$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
					}
				}
			}
		} else {
			echo "&nbsp;no permit selected";
		}		
		} else {
			echo "&nbsp;no permit selected";
		}		
	}		
	// Check if user clicked the Use New date button
	if (isset($_POST['UseNew']) ) {
		unset($_POST['UseNew']);
		echo "<meta http-equiv='refresh' content='0; url=DailyNotifications.php?DNDate=" . 
		date_format(date_create($_POST["DNDate"]),"Y-m-d")  . "' />";
	}
	
	// Check if user clicked the Save this Daily Notification button
	if (isset($_POST['SaveThis']) ) {
                    
		$strSQL = "Select Id From PIP Where PermitNumber = '" . 
		$_POST['txtPermitNumber'] . "' order by DateReceived Desc";
		
$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-18 months" ) );
$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;

		$strSQL = "Select Id From PIP 
		where PermitNumber = '" . 
		$_POST['txtPermitNumber'] . "'  and 
		(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by Id Desc" ;
		
		//echo "<p>" . $strSQL . "<p>";
		$q = $strSQL;
		$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
		$i=0;
		$PId = 0 ;
		if ($row = mysqli_fetch_array($r)) {
			// Add permit ids to DailyNotifications with Notification date	
			$PId = $row["Id"];
			// First check to see if this PermitNumber already is recorded for 
			// for thid DN
			
			$strSQL = "Select Id from DailyNotifications Where PermitId = " . $PId . " and  
			DNDate = '" . DateToSQL($DNDate) . "' ";
							
			//echo "<p>" . $strSQL;		
			$q = $strSQL;
			$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			if ($row = mysqli_fetch_array($r)) {
				echo "This permit is already recorded as part of this Daily Notiification.";
			} else {
				
				$TimeAdded = date('Y-m-d H:i:s', strtotime('- 4 hours'));
                $strSQL = "Insert into DailyNotifications (DNDate, PermitId, TimeAdded) values ('" .
                    DateToSQL($DNDate) . "'," . $PId . ",'" . $TimeAdded . "')";	
				//echo "<p>" . $strSQL;	
				$q = $strSQL;
				$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			}
		} else {
			echo "This Permit Number is not valid";
		}			
	}


	//$DNDate = "2015-12-02";	
	
	
	?>

	<div class="container"  style="font-size : normal; font-weight: normal; background-color: white">

		<div class="row">
			<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
				Daily Notifications
			</div>
		</div>

		<form action="DailyNotifications.php" method="POST">
		<div class="row">
			<div class="col-md-2" style="text-align: right">
				Daily Notification Date:
			</div>
			<div class="col-md-1">				
				<input type="text" value="<?php echo date_format(date_create($DNDate),"m/d/Y"); ?>" name="DNDate">
			</div>
			<div class="col-md-2">
				<input type="submit" id="UseNew" name="UseNew" value="Use new date">				
			</div>
		</div>
		<!-- </form>

		<form action="DailyNotifications.php" method="POST"> -->
		<div class="row">
			<div class="col-md-2" style="text-align: right">
				Enter Permit Number:
			</div>
			<div class="col-md-2" >
				<input type="text" name="txtPermitNumber" id="txtPermitNumber">
			</div>
			<!-- <div class="col-md-2">
				<input type="button" onclick=AddPermit(); id="SaveThis" name="SaveThis" value="Add to list">				
			</div> -->
			<div class="col-md-3">
				<input type="submit" id="SaveThis" name="SaveThis" value="Add to list">				
			</div>
		</div>
		

		<div class="row">
			<div class="col-md-2" >
			</div>
			<div class="col-md-2" style="background-color: whitesmoke">
				<?php
				$strSQL = "Select PermitNumber From PIP, DailyNotifications Where PIP.Id = DailyNotifications.PermitId and DNDate = '" . DateToSQL($DNDate) . "' order by PermitNumber  ";
				//echo $strSQL;
				?>
				<select name="PermitNumbers[]" id="PermitNumbers" multiple size=12>
				<?php
				$q = $strSQL;
				$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
				$i=0;
				While ($row = mysqli_fetch_array($r)) {
					echo '<option>'.$row[0].'<br>';
				} ?>
				</select>
				<!-- <input type="submit" value="Delete selected permits"> -->
				<input type="submit" id="RemoveThis" name="RemoveThis" value="Delete selected permits.">				
			
			</div>
			</form>
			<div class="col-md-6" >
				<div class="row">
					&nbsp;<a id="VFDNR" href="PreviewDN2.php?DNDate=<?PHP echo $DNDate;?>">View and Finalize Daily Notifications Report</a>
				</div>

				<div class="row">
					<div class="col-md-12" >
						&nbsp;
					</div>
				</div>

				<div class="row">
					<form action="PreviewDN2.php">
					<div class="col-md-4" >
						<select name="ddlDNDate" style="width:100%; height:26px;">
							<option></option>
							<?php
							$q = "Select DNDate, Count(DNDATE) From DailyNotifications Group by DNDATE Order by DNDate DESC";
							$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
							While ($row = mysqli_fetch_array($r)) {
								echo '<option>'.date_format(date_create($row[0]),"m/d/Y").'</option>';
							} ?>
						</select>
					</div>
					<div class="col-md-6" >
						<input type="submit" value="View Previous Daily Report">
					</div>
					</form>
				</div>
			
			
			
					

			<div class="row">
				<div class="col-md-5" >
					Filter by Permit Number:
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-3" >		
					Permit Number:
				</div>
				<div class="col-md-2" >		
					<input type="text" name="TextBox1" style="width:100%">
				</div>
				<div class="col-md-2" >		
					<select name="ddlPermitNumber" style="width:100%; height:26px;">
						<option></option>
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
		</div>
	</div>
	<?php
	
		function DateToSQL($ADate) {
			//echo "{{". $ADate ."}}";		
			$date = date_create($ADate);
			return date_format($date , 'Y-m-d') ; 	
			

		}
				
	?>
</body>