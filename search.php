<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Search</title>

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
	?>
	<div class="container">

		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Search
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<?php
				$connection = mysqli_connect("localhost", "iwright_PIP", "Mr.Coffee4","iwright_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				$connection2 = mysqli_connect("localhost", "iwright_PIP", "Mr.Coffee4","iwright_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
				$strSQL = "";

				echo "<br>Criteria: ";
				
            If ($_POST["ddlConditionCodes"] <> "") {
                $strSQL = "Select PermitNumber,CompanyName,PermitAddress,PermitStatus,WorkSketch,LocationDescription,PIP.Id," . 
                "PermitDocuments,Latitude, Longitude, DateOfSignature, ST_NAME, ST_NUM, ST_TYPE, ST_DIR From PIP, ConditionMessages, ConditionMessagesComments ";
            } else {
                $strSQL = "Select PermitNumber,CompanyName,PermitAddress,PermitStatus,WorkSketch,LocationDescription,PIP.Id," . 
                "PermitDocuments,Latitude, Longitude, DateOfSignature, ST_NAME, ST_NUM, ST_TYPE, ST_DIR From PIP ";
            }
            $strWhere = " Where ";
            $strAnd = "";
            $PageOK = True;

            If ($_POST["txtPermitNumber"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " PermitNumber like '%" . $_POST["txtPermitNumber"] . "%'";
                $strWhere = "";
                $strAnd = " and ";
				echo " Permit Number like " . $_POST["txtPermitNumber"] . ", ";
            }

            If ($_POST["ddlGPIN"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " GPINNumber = '" . $_POST["ddlGPIN"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " GPIN  = " . $_POST["ddlGPIN"] . ", ";
            }

            If ($_POST["ddlCompanyName"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " CompanyName = '" . $_POST["ddlCompanyName"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " CompanyName = " . $_POST["ddlCompanyName"] . ", ";
            }

            If ($_POST["ddlPermitStatus"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " PermitStatus = '" . $_POST["ddlPermitStatus"] . "'";
                $strWhere = "";
                $strAnd = " and ";                
				echo " PermitStatus = " . $_POST["ddlPermitStatus"] . ", ";
            }

            If ($_POST["ddlType"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " PermitType = '" . $_POST["ddlType"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " PermitType = " . $_POST["ddlType"] . ", ";
            }

            If ($_POST["ddlTechnician"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " Technician = '" . $_POST["ddlTechnician"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " Technician = " . $_POST["ddlTechnician"] . ", ";
            }

            If (Trim($_POST["DRStartDate"]) <> "") {
                If (IsDate($_POST["DRStartDate"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateReceived >= '" . $_POST["DRStartDate"] . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateReceived >= " . $_POST["DRStartDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Date Received invalid"
                    $PageOK = False;
                }
            }

            If (Trim($_POST["DREndDate"]) <> "") {
                If (IsDate($_POST["DREndDate"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateReceived <= '" . $_POST["DREndDate"] . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateReceived <= " . $_POST["DREndDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Date Received invalid"
                    $PageOK = False;
                }
            }

            If (Trim($_POST["SDStartDate"]) <> "") {
                If (IsDate($_POST["SDStartDate"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateOfSignature >= '" . $_POST["SDStartDate"] . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateOfSignature >= " . $_POST["SDStartDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Signature Date invalid"
                    $PageOK = False;
                }
            }

            If (Trim($_POST["SDEndDate"]) <> "") {
                If (IsDate($_POST["SDEndDate"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateOfSignature <= '" . $_POST["SDEndDate"] . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateOfSignature <= " . $_POST["SDEndDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Signature Date invalid"
                    $PageOK = False;
                }
            }


            If (Trim($_POST["txtLocationDescription"]) <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " LocationDescription Like '%" . $_POST["txtLocationDescription"] . "%'";
                $strWhere = "";
                $strAnd = " and ";
				echo " LocationDescription Like " . $_POST["txtLocationDescription"] . ", ";
            }

            If ($_POST["ddlNumeric"] <> "" And $_POST["ddlNumeric"] <> "select #") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_NUM = '" . $_POST["ddlNumeric"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_NUM = " . $_POST["ddlNumeric"] . ", ";
            }

            If ($_POST["ddlStreetName"] <> "" And $_POST["ddlStreetName"] <> "select a street") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_NAME like '%" . $_POST["ddlStreetName"] . "%'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_NAME like " . $_POST["ddlStreetName"] . ", ";
            }

            If ($_POST["ddlSuffix"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_TYPE = '" . $_POST["ddlSuffix"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_TYPE = " . $_POST["ddlSuffix"] . ", ";
            }

            If ($_POST["OpenPermits"] == "on") {
                $strSQL = $strSQL . $strWhere . $strAnd . " (PermitClosed is Null or PermitClosed = 'False') and " . 
                "(PermitExpired is Null or PermitExpired = 'False') ";
                $strWhere = "";
                $strAnd = " and ";
				echo " PermitExpired is Null or PermitExpired = False, ";
            }

            If ($_POST["ddlConditionCodes"] <> "") {
                If (!is_numeric($_POST["ddlConditionCodes"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " PIP.Id = PermitId and CMId = ConditionMessages.Id and LetterCode = '" . 
                    $_POST["ddlConditionCodes"] . "'";
                } else {
                    $strSQL = $strSQL . $strWhere . $strAnd . " PIP.Id = PermitId and CMId = ConditionMessages.Id and NumberCode = '" . 
                    $_POST["ddlConditionCodes"] . "'";
                }
				echo " CondtionCode = " . $_POST["ddlConditionCodes"] . ", ";
            }

            $strSQL = $strSQL . " order by DateOfSignature ";	
			//echo "<br>" . $strSQL . " ";	
			$connection = mysqli_connect("localhost", "iwright_PIP", "Mr.Coffee4","iwright_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	
			$q = $strSQL;
			$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			?>
			</div>

			</div>

			<div class="row" style="background-color: #afeeee">
				<div class="col-sm-1" >
					Signature Date
				</div>
				<div class="col-sm-1" >
					Permit Number
				</div>
				<div class="col-sm-2" >
					Company Name
				</div>
				<div class="col-sm-4" >
					Permit Address / Location Description
				</div>
				<div class="col-sm-1" >
					Permit Status
				</div>
				<div class="col-sm-3" >
					Links
				</div>
			</div>
			<?php 
			if (1 == 1) {
			
            $RecordCount = 0;
			$CityMapPath = "http://beachmaps.vbgov.com/citymap/";
				
			While ($row = mysqli_fetch_array($r)) {
			
                    $RecordCount = $RecordCount + 1;
                    echo '<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">' . 
                    '<div class="col-sm-1" >' . DisplayDate($row["DateOfSignature"]) . '</div>' . 
                        '<div class="col-sm-1" ><a href=NewEdit.php?Id=' . 
                        $row["Id"] . '>' . $row[0] . '</a></div>' . 
                        '<div class="col-sm-2">' . $row[1] . '</div>' . 
                        '<div class="col-sm-3" >' . $row[2];
					$PermitAddress = $row["PermitAddress"];						
					if (strrpos($PermitAddress, "Virginia Beach") == 0) {$PermitAddress = $PermitAddress . ", Virginia Beach, VA";}
					$PermitAddresswoc = str_replace(" ","+",$PermitAddress);

                    echo '<br>' . $row[5];
					
	                echo '<br><a href=https://maps.google.com/maps?q=' . 
                    $PermitAddresswoc. ' target=blank>Google&nbsp;Maps</a>';
					echo '</div>';
                    echo '<div class="col-sm-2" >' . $row[3] . '</div>';
                    echo '<div class="col-sm-3" >';
                    If (!empty($row[7])) {
                        echo '<a href=archive/' . $UploadFiles . $row[7] . ' target=blank>Documents</a><br>';
					} else {
						echo '&nbsp;<br>';
                    }
                    If (!empty($row[4])) {
                        echo '<a href=archive/' . $UploadFiles . $row[4] . ' target=blank>Work&nbsp;Sketch</a><br>';
					} else {
						echo '&nbsp;<br>';
                    }
                    echo '<a href=PermitDiary.php?Id=' . $row[6] . ' target=blank>Diary</a><br>';
                    
                    If (!empty($row["Latitude"]) And !empty($row["Longitude"])) {
                        echo '<a href=' . $CityMapPath . 
                        '?llloc=' . 
                        $row["Longitude"] . ',' . 
                        $row["Latitude"] . ' target=blank>City&nbsp;Map</a><br>';
					} else {
						echo '&nbsp;<br>';
                    }
                    echo '<a href=ConditionMessages.php?Id=' . $row[6] . ' target=blank>Condition&nbsp;Messages</a>&nbsp;<br>';
                    echo '<a href=PUComments.php?Id=' . $row[6] . ' target=blank>PU&nbsp;Comments</a><br>';
                   
                    //echo '</div><div class="col-sm-1" >';
                    echo '<a href=UtilityVerificationApplication.php?Id=' . $row[6] . '&UVACount=1 target=blank>Utility Verification Application</a>';
                   
                    echo '</div></div>';
                }
                }
                echo '</div>';
                echo 'Permit Count: ' . $RecordCount;
               							
				function DisplayDate($ADate) {
					$date = date_create($ADate);
					return date_format($date , "m/d/y") ; 	
				}
				
            ?>

			</div>
		</div>
	</div>
</body>
