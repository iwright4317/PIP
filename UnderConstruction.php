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
		$q = "SELECT " . $field . ", Count(" . $field . ") FROM PIP Where " . $field . " is not null " . "Group By " . $field . " Order by " . $field . "";
		$r = mysql_query($q) or die("<br/>Query failed");

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
	
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	//$val = DumpTable("iwright_PIP","PIP",5);
	//$DNDate = "2015-12-02";	
	?>

	<div class="container"  style="font-size : normal; font-weight: normal; background-color: white">

		<div class="row">
			<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
				Under Construction
			</div>
		</div>
	</div>
	</body>
	</html>
	
