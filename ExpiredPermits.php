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
</head>
<body>

	<?php
	include ('./includes/banner.inc');
	
	
	//$connection = mysql_connect("localhost", "iwright_PIP", "Mr.Coffee4") or die('I cannot connect to the database because: ' . mysql_error());
	//$dbc = mysql_selectdb("iwright_PIP", $connection) or die("<p>DB select failed ||<p>" . mysql_error());
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
	$strSQL = "";
	?>
	<form name="form1" method="post" action="search.php" onsubmit="javascript:return validateandsubmit(document.form1)">

		<div class="container"  style="font-size : large; font-weight: bold; background-color: white">

			<div class="row">
				<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
					Missing Data Permits
				</div>
			</div>

			<div class="row">
				<div class="col-md-6" >
				</div>
			</div>
			<?php
			
			$PrevDate = '2015-01-01';
            $strSQL = "Select " .
            "PIP.PermitNumber, CompanyName, PermitAddress, LocationDescription, StandardText, Comment, " .
            "LetterCode, Technician, DateOfSignature, PIP.Id " .
            "From " .
            "ConditionMessagesComments, ConditionMessages, PIP " .
            "Where " .
            "ConditionMessagesComments.PermitId = PIP.Id and " .
            "ConditionMessagesComments.CMId = ConditionMessages.Id and " .
            "DateOfSignature < '" . $PrevDate . "' and " .
            "(ConstructionStart is Null or ConstructionStart <> '') and " .
            "(PermitExpired is Null or PermitExpired <> 'True') and " .
            "(PermitClosed is Null or PermitClosed <> 'True') Order by Technician, CompanyName"; 

			$r = mysqli_query($connection,$strSQL) or die("Query failed" . " " . $query . " " . mysqli_error());
		
            echo "&nbsp<p>";
            $RC  = 0;
            echo "<TABLE width=100% bgcolor=#000000 border=1>";
            //echo "<tr><th bgcolor=#FFFFFF colspan=7><font size=5>Missing Data Permits for " . $PrevDate . "</font></th></tr>";

            $Codes = "";
            $Condition = "";
            $Location = "";
            $CurrentPermit = ""; 
            $Company = "";
            $Technician = "";
            $SignitureDate = "";
            $NewPermit = "";

            $Id = 0;
			$I = 0;            

			While ($row = mysqli_fetch_array($r)) {
				if ($I == 0) {				
	                $CurrentPermit = $row[0];
    	            If (!empty($row[6])) {
        	            $Codes = $row[6];
            	    }
                	$Company = $row[1];
                	$Technician = $row[7];
                	If (!empty($row[8])) {
                    	$SignitureDate = $row[8];
                	}
                	$Location = $row[2] . " <br>" . $row[3];
                	$Condition = $row[4] . "<br> <b>" . $row[5] . "</b>";
                	$FirstTime = True;
                	$BGShade = "#E0E0E0"; 	
				}
				$I = $I + 1;                

                $NewPermit = $row[0];
                If (CurrentPermit <> $row[0]) {
                        $RC = $RC + 1;
                        echo "<tr bgcolor=" . $BGShade . "><th>Permit<br>Number</th><th>Company</th><th>Technician</th><th>Signiture<br> Date</th><th>Codes</th></tr>";
                        echo "<tr bgcolor=" . $BGShade . ">";
                        echo "<td valign=top><a href= NewEdit.php?Id=" . $Id . ">" . $CurrentPermit . "</a></td>";
                        echo "<td valign=top>" . $Company . "</td>";
                        echo "<td valign=top>" . $Technician . "</td>";
                        echo "<td valign=top>" . DisplayDate($SignitureDate) . "</td>";
                        echo "<td valign=top>" . $Codes . "</td></tr>";
                        echo "<tr bgcolor=" . $BGShade . "><th valign=top>Condition</th><td valign=top colspan=4>" . $Condition . "</td></tr>";
                        echo "<tr bgcolor=" . $BGShade . "><th valign=top>Location</th><td valign=top colspan=4>" . $Location . "</td></tr>"; 

                        If ($BGShade == "#E0E0E0") {
                            $BGShade = "#FFFFFF";
                        } else {
                            $BGShade = "#E0E0E0";
                        } 

                        $Codes = ""; 
                        $Condition = "";
                        $CurrentPermit = $row[0];

                        If (!empty($row[6])) {
                            $Codes = $row[6];
                        }

                        $Company = $row[1];
                        $Technician = $row[7];
                        If (!empty($row[8])) {
                            $SignitureDate = $row[8];
                        } else {
                            $SignitureDate = "";
                        }

                        $Location = $row[2] . " <br>" . $row[3];
                        $Condition = $row[4] . "<br> <b>" . $row[5] . "</b>";
                        $Id = $row[9];

                    } else {

                        $Codes = $Codes . ", " . $row[6];
                        $Condition = $Condition . " <br>" . $row[4] . "<br> <b>" . $row[5] . "</b>";

                    }
                }

                echo "<tr>";
                echo "<td valign=top>" . $CurrentPermit . "</td>";
                echo "<td valign=top>" . $Company . "</td>";
                echo "<td valign=top>" . $Technician . "</td>";
                echo "<td valign=top>" . DisplayDate($SignitureDate) . "</td>";
                echo "<td valign=top>" . $Codes . "</td></tr>";

                echo "<tr><td valign=top>Condition</td><td valign=top colspan=4>" . $Condition . "</td></tr>";
                echo "<tr><td valign=top>Location</td><td valign=top colspan=4>" . $Location . "</td></tr>";
                echo "<table>";
                echo "<br>Record count: " . $RC;

					
				function DisplayDate($ADate) {
					$date = date_create($ADate);
					return date_format($date , "m/d/Y") ; 	
				}
            ?>

		</div>
	</form>
	</body>
	</html>