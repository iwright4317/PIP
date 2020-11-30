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
	
	$UploadFiles = "./archive/";	
	
	function SQLDate($ADate) {			
		$date = date_create($ADate);
		return date_format($date , "Y-m-d") ; 	
	}
				
	if (empty($_SESSION["user_id"] )) {
		echo "<meta http-equiv='refresh' content='0; url=index.php' />";
	} else {
		$db = False;
	?>
		
	<div class="container">

		<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Search
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<?php
				//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
				//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
	
				$strSQL = "";

				echo "<br>Criteria: ";
				
            If ($_POST["ddlConditionCodes"] <> "") {
                $strSQL = "Select PermitNumber,CompanyName,PermitAddress,PermitStatus,
                WorkSketch,LocationDescription,PIP.Id, 
                PermitDocuments,Latitude, Longitude, DateOfSignature, 
                ST_NAME, ST_NUM, ST_TYPE, ST_DIR, Addendum1, Addendum2 From PIP, ConditionMessages, ConditionMessagesComments ";
            } else {
                $strSQL = "Select PermitNumber,CompanyName,PermitAddress,PermitStatus,
                WorkSketch,LocationDescription,PIP.Id,
                PermitDocuments,Latitude, Longitude, DateOfSignature, 
                ST_NAME, ST_NUM, ST_TYPE, ST_DIR, Addendum1, Addendum2 From PIP ";
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

            If (isset($_POST["ddlGPIN"]) && $_POST["ddlGPIN"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " GPINNumber = '" . $_POST["ddlGPIN"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " GPIN  = " . $_POST["ddlGPIN"] . ", ";
            }

            If (isset($_POST["ddlCompanyName"]) && $_POST["ddlCompanyName"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " CompanyName = '" . $_POST["ddlCompanyName"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " CompanyName = " . $_POST["ddlCompanyName"] . ", ";
            }

            If (isset($_POST["ddlPermitStatus"]) && $_POST["ddlPermitStatus"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " PermitStatus = '" . $_POST["ddlPermitStatus"] . "'";
                $strWhere = "";
                $strAnd = " and ";                
				echo " PermitStatus = " . $_POST["ddlPermitStatus"] . ", ";
            }

            If (isset($_POST["ddlType"]) && $_POST["ddlType"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " PermitType = '" . $_POST["ddlType"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " PermitType = " . $_POST["ddlType"] . ", ";
            }

            If (isset($_POST["ddlTechnician"]) && $_POST["ddlTechnician"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " Technician like '" . $_POST["ddlTechnician"] . "%'";
                $strWhere = "";
                $strAnd = " and ";
				echo " Technician = " . $_POST["ddlTechnician"] . ", ";
            }

            If (isset($_POST["DRStartDate"]) && Trim($_POST["DRStartDate"]) <> "") {
            	if (strtotime($_POST["DRStartDate"]) !== false) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateReceived >= '" . SQLDate($_POST["DRStartDate"]) . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateReceived >= " . $_POST["DRStartDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Date Received invalid"
                    $PageOK = False;
                }
            }

            If (isset($_POST["DREndDate"]) && Trim($_POST["DREndDate"]) <> "") {
            	if (strtotime($_POST["DREndDate"]) !== false) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateReceived <= '" . SQLDate($_POST["DREndDate"]) . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateReceived <= " . $_POST["DREndDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Date Received invalid"
                    $PageOK = False;
                }
            }

            If (isset($_POST["SDStartDate"]) && Trim($_POST["SDStartDate"]) <> "") {
            	if (strtotime($_POST["SDStartDate"]) !== false) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateOfSignature >= '" . SQLDate($_POST["SDStartDate"]) . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateOfSignature >= " . $_POST["SDStartDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Signature Date invalid"
                    $PageOK = False;
                }
            }

            If (isset($_POST["SDEndDate"]) && Trim($_POST["SDEndDate"]) <> "") {
            	if (strtotime($_POST["SDEndDate"]) !== false) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " DateOfSignature <= '" . SQLDate($_POST["SDEndDate"]) . "'";
                    $strWhere = "";
                    $strAnd = " and ";
					echo " DateOfSignature <= " . $_POST["SDEndDate"] . ", ";
                } else {
                    //Status"] = Status"] . "<br>Signature Date invalid"
                    $PageOK = False;
                }
            }

            If (isset($_POST["txtLocationDescription"]) && Trim($_POST["txtLocationDescription"]) <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " (LocationDescription Like '%" . $_POST["txtLocationDescription"] . "%' or 
                PermitAddress Like '%" . $_POST["txtLocationDescription"] . "%') ";
                $strWhere = "";
                $strAnd = " and ";
				echo " LocationDescription Like " . $_POST["txtLocationDescription"] . ", ";
            }

            If (isset($_POST["ddlNumeric"]) && $_POST["ddlNumeric"] <> "" And $_POST["ddlNumeric"] <> "select #") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_NUM = '" . $_POST["ddlNumeric"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_NUM = " . $_POST["ddlNumeric"] . ", ";
            }

            If (isset($_POST["ddlStreetName"]) && $_POST["ddlStreetName"] <> "" And $_POST["ddlStreetName"] <> "select a street") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_NAME like '%" . $_POST["ddlStreetName"] . "%'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_NAME like " . $_POST["ddlStreetName"] . ", ";
            }

            If (isset($_POST["ddlSuffix"]) && $_POST["ddlSuffix"] <> "") {
                $strSQL = $strSQL . $strWhere . $strAnd . " ST_TYPE = '" . $_POST["ddlSuffix"] . "'";
                $strWhere = "";
                $strAnd = " and ";
				echo " ST_TYPE = " . $_POST["ddlSuffix"] . ", ";
            }

            If (isset($_POST["OpenPermits"]) && $_POST["OpenPermits"] == "on") {
                $strSQL = $strSQL . $strWhere . $strAnd . " (PermitClosed <> 'True') and " . 
                "(PermitExpired <> 'True') ";
                $strWhere = "";
                $strAnd = " and ";
				echo " PermitExpired is not True, ";
            }

            If (isset($_POST["ddlConditionCodes"]) && $_POST["ddlConditionCodes"] <> "") {
                If (!is_numeric($_POST["ddlConditionCodes"])) {
                    $strSQL = $strSQL . $strWhere . $strAnd . " PIP.Id = PermitId and CMId = ConditionMessages.Id and LetterCode = '" . 
                    $_POST["ddlConditionCodes"] . "'";
                } else {
                    $strSQL = $strSQL . $strWhere . $strAnd . " PIP.Id = PermitId and CMId = ConditionMessages.Id and NumberCode = '" . 
                    $_POST["ddlConditionCodes"] . "'";
                }
				echo " CondtionCode = " . $_POST["ddlConditionCodes"] . ", ";
            }					

			//PermitNumber
			$compact = False;
            if (isset($_POST["compact"]) && trim($_POST["compact"]) == "on") {
            	$strSQL = $strSQL . " order by PermitNumber ";	
				$compact = True;			
            } else {
            	$strSQL = $strSQL . " order by DateOfSignature ";
            }
				
			if ($db) {echo "<br>" . $strSQL . " ";}	
			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
	
			$strSQL .= " LIMIT 10000";
			$q = $strSQL;
			$r = mysqli_query($connection, $q) or die("<br/>Query failed: " . $q);
			?>
			</div>

			</div>

			<?php
			If (!$compact) {?>
			<div class="row" style="background-color: #afeeee">
				<div class="col-sm-4" >
					&nbsp;
				</div>
				<div class="col-sm-5" >
					Permit Address / Location Description
				</div>
				<div class="col-sm-3" >
					Links
				</div>
			</div>
			<?php 
			} else {?>
				
			<div class="row" style="background-color: #afeeee">
				<div class="col-sm-2" >
					Permit
				</div>
				<div class="col-sm-3" >
					Company
				</div>
				<div class="col-sm-4" >
					Address
				</div>
				<div class="col-sm-3" >
					Status
				</div>
			</div>
			<?php
			}
			if (1 == 1) {
			
            $RecordCount = 0;
			$CityMapPath = "http://beachmaps.vbgov.com/citymap/";
				
			While ($row = mysqli_fetch_array($r)) {
			
                $RecordCount = $RecordCount + 1;
				if (!$compact) {
					
                    echo '<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">';
                    
					
                    echo '<div class="col-sm-2" >';
                    echo 'Status:<br>Signature:<br>Permit:<br>Company:<br>Address:';
                    echo '</div>';
					
                    echo '<div class="col-sm-5" >';                  
					echo $row["PermitStatus"] . "<br>";  
					if (isset($row['DateOfSignature'])) {
						echo DisplayDate($row['DateOfSignature']) . "<br>";
					} else {
						echo "<br>";
					}
					echo '<a href=NewEdit.php?Id=' . $row["Id"] . '>' . $row[0] . '</a><br>';
					echo $row[1] . '<br>';
					echo $row[2] . '<br>';				     				
					echo '</div>';                              
					
                    echo '<div class="col-sm-2" >';                    					
					$PermitAddress = $row["PermitAddress"];						
					if (strrpos($PermitAddress, "Virginia Beach") == 0) {$PermitAddress = $PermitAddress . ", Virginia Beach, VA";}
					$PermitAddresswoc = str_replace(" ","+",$PermitAddress);
					
                    If (!empty($row["Latitude"]) And !empty($row["Longitude"])) {
                        echo '<a href=' . $CityMapPath . 
                        '?llloc=' . 
                        $row["Longitude"] . ',' . 
                        $row["Latitude"] . ' target=blank>City&nbsp;Map</a><br>';
					} else {
						echo '&nbsp;<br>';
                    }                    
					
	                echo '<a href=https://maps.google.com/maps?q=' . 
                    $PermitAddresswoc. ' target=blank>Google&nbsp;Maps</a><br>';  
					
					
                    If (!empty($row[7]) && isset($UploadFiles) && false ) {
                    	$subfolder = substr($row[7],0,4);
						if ($subfolder == "2009") {
							echo '<a href=' . $UploadFiles .  $subfolder . '/' . $row[7] . ' target=blank>Documents</a><br>';
						} else {
                        	echo '<a href=' . $UploadFiles . $row[7] . ' target=blank>Documents</a><br>';							
						}
					} else { 
						echo '&nbsp;<br>';
                    } 
					                   					
					If (isset($row[7]) && isset($UploadFiles) ) {
						echo '<a href="' . uploadFileLink($UploadFiles, $row[7]) . '" target=blank>Documents</a><br>';
						//echo '<a href=' . $UploadFiles . $row[7] . ' target=blank>Documents</a><br>';
					
					}
					
                    If (!empty($row[4]) && isset($UploadFiles)) {
                        echo '<a href="' . uploadFileLink($UploadFiles, $row[4]) . '" target=blank>Work&nbsp;Sketch</a><br>';
					} else {
						echo '&nbsp;<br>';
                    }					
					
					
                    If (!empty($row[15]) && isset($UploadFiles)) {
                        echo '<a href="' . uploadFileLink($UploadFiles, $row[15]) . '" target=blank>Addem_1</a> ';
					} else {
						echo '&nbsp;';
                    }					
					
					
                    If (!empty($row[16]) && isset($UploadFiles)) {
                        echo '<a href="' . uploadFileLink($UploadFiles, $row[16]) . '" target=blank>Addem_2</a>';
					} else {
						echo '&nbsp;';
                    }	
					echo '<br>';				
										
					echo '</div>';
					
                    echo '<div class="col-sm-3" >';					
                    echo '<a href=PermitDiary.php?Id=' . $row[6] . ' target=blank>Diary</a><br>';
                    
                    echo '<a href=ConditionMessages.php?Id=' . $row[6] . ' target=blank>Condition&nbsp;Messages</a>&nbsp;<br>';
                    echo '<a href=PUComments.php?Id=' . $row[6] . ' target=blank>PU&nbsp;Comments</a><br>';
                   
                    echo '<a href=UtilityVerificationApplication.php?PIPId=' . $row[6] . '&UVACount=1 target=blank>Utility Verification Application</a><br>';
                    echo '<a href=FAFAOnlineForm.php?PermitId=' . $row[6] . ' target=blank>FAAS-built</a>';
                   
                    echo '</div>';
                    echo '</div>';
                    
					echo '<div class="row" style="background-color: whitesmoke; ">';
                    
                    echo '<div class="col-sm-2" >';
                    echo 'Description:';
                    echo '</div>';
					
                    echo '<div class="col-sm-10" >';	                  
                    echo $row["LocationDescription"] . '<br>';					
					echo '</div>';		
					} else {
						// Compact form
						echo '<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">';
                    
                    	echo '<div class="col-sm-2" >';                    
						echo '<a href=NewEdit.php?Id=' . $row["Id"] . '>' . $row[0] . '</a>';	
                    	echo '</div>';
						
                    	echo '<div class="col-sm-3" >';                    
						echo $row[1];	
                    	echo '</div>';
						
                    	echo '<div class="col-sm-4" >';                    
						echo str_replace(", Virginia Beach, VA","",str_replace(", United States","",$row[2]));	
                    	echo '</div>';
						
                    	echo '<div class="col-sm-3" >';                    
						echo $row[3];	
                    	//echo '</div>';                    	
						
                    	echo '</div>';
                    //echo '</div>';
					}		
					//echo '</div>';
					
                    echo '</div>';
                }
                }
                
                echo '<b>Permit Count: ' . $RecordCount . '</b>';
               	echo '</div>';			
				
            ?>

			</div>
			<?php
			}

				function DisplayDate($ADate) {					
					if ($ADate != '0000-00-00') { 
					$date = date_create($ADate);
					return date_format($date , "m/d/y") ; 	
					} else {
						return '';
					}
				}
			?>
		</div>
	</div>
</body>
