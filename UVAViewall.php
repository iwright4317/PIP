<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | UVA </title>

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
		
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	?>
	<div class="container" style="font-size: Large; background-color: white;  ">

		<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Utility Verification Application - View All
			</div>
		</div>
		
		<?php
		function ScrubDate($ADate) {
			//2016-05-20 -> 05/16/2016
			if (!empty($ADate)) {
				return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
			} else {
				return null;
			}
		}
	
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
		//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
		if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
		
        $q = "Select PermitNumber,CompanyName from PIP Where Id = " . $_GET["Id"];

		$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
		If ($row = mysqli_fetch_array($r)) {
			$PermitNumber = $row[0];
			$Company = $row[1];
		}

        $q = "Select count(*) from UtilityVerificationApplication Where PermitId = " . $_GET["Id"];

        $UVAPages  = 0;        
		$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
		If ($row = mysqli_fetch_array($r)) {			
            $UVAPages = $row[0];
		}

        $q = "Select * from UtilityVerificationApplication Where PermitId = " . $_GET["Id"];         
			
		$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q);
		
        echo "&nbsp;<br>";
       
        echo "<table width=100% border=1>";
        $I  = 0;
        While ($row = mysqli_fetch_array($r)) {
                $I = $I + 1;
                echo "<tr><td colspan=2 ><font size=4>" . $I . "/" . $UVAPages . "</font></td></tr>";
                echo "<tr><td colspan=2 >Permit #: <b>" . $PermitNumber . "</b></td></tr>";
                echo "<tr><td colspan=2 >Location/Address: <b>" . $row["LocationAddress"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >Company: <b>" . $Company . "</b></td></tr>";
                echo "<tr><td colspan=2 >Subcontractor: <b>" . $row["Subcontractor"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >Foreman/Supervisor on Site: <b>" . $row["Foreman"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >Technician/Inspector on Site: <b>" . $row["Technician"] . "<</b>/td></tr>";
                echo "<tr><td colspan=2 >Test Hole/Open Cut Size/Type: <b>" . $row["TestHole"] . ", ";
                echo $row["TestHoleType"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >Public Utility Type: <b>" . $row["PublicUtilityType"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >PublicUtilityDepth: <b>" . $row["PublicUtilityDepth"] . "</b></td></tr>";
                echo "<tr><td colspan=2 >Bore Size/Type: <b>" . $row["BoreSize"] . "</b></td></tr>";
                echo "<tr><td >Bore Depth: <b>" . $row["BoreDepth"] . "</b></td>";
                echo "<td >Method of Installation: <b>" . $row["BoreMethod"] . "</b></td></tr>";
                echo "<tr><td colspan=2><hr></td><tr>";
        }				
				
		?>
	</div>
</body>
	
				