<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Daily Notifications Permit Report</title>

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
		$date = date_create($_GET["DNDate"]);
		$DNDate =  date_format($date , "Y-m-d") ;
		$day_before = date( 'Y-m-d', strtotime( $_GET["DNDate"] . ' -1 day' ) );
		$date = date_create($day_before);
	}
	if (isset($_POST['DNDate'])) {
		$DNDate = $_POST['DNDate'];
	}
	if (trim($DNDate) == "") {
		$DNDate = date('Y-m-d');
		$day_before = date( 'Y-m-d', strtotime( $DNDate . ' -1 day' ) );
		$date = date_create($day_before);
	} else {
		
	}
	$prevDay = date_format($date , "Y-m-d") ;
	echo "<a href=DNFullReport.php?DNDate=" . $prevDay . ">Previous day</a>";	
	
	?>

	<div class="container"  style="font-size : normal; font-weight: normal; background-color: white">

		<div class="row">
			<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
				Daily Notifications - Permit Report
			</div>
		</div>

		<form action="DailyNotifications.php" method="POST">
		<div class="row">
			<div class="col-md-12" style="text-align: right">
				<?php
				$strSQL = "Select PermitNumber, DNDate, PermitStatus, DateOfSignature,
				PIP.Id, DailyNotifications.Id, TimeAdded From PIP, DailyNotifications Where PIP.Id = DailyNotifications.PermitId and DNDate = '" . DateToSQL($DNDate) . "' order by DailyNotifications.Id desc  ";
				//echo $strSQL;
				$q = $strSQL;
				$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);

				echo "<p>From PIP, DailyNotifications";
				echo "<table><tr><th>Permit #</th><th>DNDate</th><th>Permit Status</th>
				<th>Signature</th><th>PIP.Id</th><th>DN.Id</th><th>Time Added</th></tr>";
				
				while ($row = mysqli_fetch_array($r)) {
					echo "<tr>";
					echo "<td>" . $row["PermitNumber"] . "&nbsp;</td>";
					echo "<td>" . $row["DNDate"] . "&nbsp;</td>";
					echo "<td>" . $row["PermitStatus"] . "&nbsp;</td>";
					echo "<td>" . $row["DateOfSignature"] . "&nbsp;</td>";
					echo "<td>&nbsp;" . $row[4] . "&nbsp;</td>";
					echo "<td>" . $row[5] . "&nbsp;</td>";			
					echo "<td>" . $row[6] . "</td>";					
					echo "</tr>";
				}
				echo "<table>";
				?>				
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