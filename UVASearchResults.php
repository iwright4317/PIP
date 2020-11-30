<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>CMP | Search</title>

	<script language="javascript">
		var XMLHttpRequestObject = false;

		if (window.XMLHttpRequest) {
			XMLHttpRequestObject = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
		}

		function isblankentry(item) {
			if (item.value == "") {
				return true;
			} else {
				return false;
			}
		}

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
			//alert(dataSource);
			if (XMLHttpRequestObject) {
				var obj = document.getElementById(divID);

				dataSource = dataSource + item;
				//alert(dataSource);

				XMLHttpRequestObject.open("GET", dataSource);
				XMLHttpRequestObject.onreadystatechange = function() {
					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
						eresp = XMLHttpRequestObject.responseText;
						obj.innerHTML = eresp;
						//alert(eresp);
					}
				}
				XMLHttpRequestObject.send(null);
			}
			return true;
		}

		function checkData(target, tstring) {
			var ReturnValue = true;
			// alert("Checking email address");
			var obj = document.getElementById(target);

			if (obj.innerHTML == tstring) {
				ReturnValue = true;
			}

			return ReturnValue;
		}

		function validateandsubmit(theform) {

			var returnval = true;

			if (isblankentry(theform.title)) {
				alert("The title is blank. Please re-enter with a title and click the Save button again. ");
				returnval = false;
			}

			if (isblankentry(theform.description)) {
				alert("The description is blank. Please re-enter with a description and click the Submit button again. ");
				returnval = false;
			}

			if (!returnval) {
				alert("This request can not be submitted ");
				returnval = false;
			} else {
				//var obj = document.getElementById("divsending");
				//obj.innerHTML = "<b>Sending first batch of emails...</b>";
				ReturnValue = true;
			}
			return returnval;
		}

	</SCRIPT>

	<!-- <script src="../_js/jquery-1.6.3.min.js"></script> -->
	<script>
		$(document).ready(function() {
			$('#nofiles').click(function() {
				var checked_status = this.checked;
				if (checked_status == true) {
					$('#submit').show();
					document.getElementById("submit").value = "Done";
					$('#submission').hide();
					$('#selectfiles').hide();
					$('#fileselectform').hide();
					$('#nofileselectform').show();
					var sf = document.getElementById('nofileselectform')
					sf.style.visibility = 'visible';
				} else {
					$('#submit').hide();
					document.getElementById("submit").value = "Upload file";
					$('#submission').show();
					var fileInput = document.getElementById("submission");
					if (fileInput.files.length > 0) {
						$('#submit').show();
					}
					$('#selectfiles').show();
					$('#fileselectform').show();
					$('#nofileselectform').hide();
					var sf = document.getElementById('nofileselectform')
					sf.style.visibility = 'hidden';
				}

			});
			// end click
		});
		// end ready
		function hideshowDiv(tDiv, tDiv2) {
			//alert(tDiv);
			document.getElementById(tDiv).style.display = 'none';
			document.getElementById(tDiv2).style.display = 'block';
		}

		function checkfile(tDiv, tDivBut) {
			var fileInput = document.getElementById(tDiv);
			var message = "";
			if ('files' in fileInput) {
				if (fileInput.files.length == 0) {
					message = "Please browse for one or more files.";
				} else {
					for (var i = 0; i < fileInput.files.length; i++) {
						message += "<br /><b>" + (i + 1) + ". file</b><br />";
						var file = fileInput.files[i];
						if ('name' in file) {
							message += "name: " + file.name + "<br />";
						} else {
							message += "name: " + file.fileName + "<br />";
						}
						if ('size' in file) {
							message += "size: " + file.size + " bytes <br />";
						} else {
							message += "size: " + file.fileSize + " bytes <br />";
						}
						if ('mediaType' in file) {
							message += "type: " + file.mediaType + "<br />";
						}
					}
				}
				$('#submit').show();
				document.getElementById("submit").value = "Upload file";
				document.getElementById(tDivBut).style.display = 'block';
				document.getElementById("submitDiv").style.display = 'block';
			} else {
				if (fileInput.value == "") {
					message += "Please browse for one or more files.";
					message += "<br />Use the Control or Shift key for multiple selection.";
				} else {
					message += "Your browser doesn't support the files property!";
					message += "<br />The path of the selected file: " + fileInput.value;
				}
			}

			//var info = document.getElementById ("info");
			//info.innerHTML = message;
			//alert(message);
		}

	</script>

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
	</script>
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	?>
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<h2>Utility Verification Application</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				Criteria: 

				<?php
				
				
				function SQLDate($ADate) {			
					$date = date_create($ADate);
					return date_format($date , "Y-m-d") ; 	
				}
				
				
				function DisplayDate($ADate) {			
					$date = date_create($ADate);
					return date_format($date , "m/d/Y") ; 	
				}
								
				$today = $date = date('d/m/y');
				//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysql_error());
				
				$strSQL = "Select UtilityVerificationApplication.id, 
				UVADate, PIP.Id, PermitNumber, LocationAddress, 
				UtilityVerificationApplication.Technician, SketchSheet, Subcontractor, Foreman, CompanyName  
				From PIP, UtilityVerificationApplication 
				Where PIP.Id = UtilityVerificationApplication.PermitId ";

				if (isset($_POST["txtPermitNumber"]) && $_POST["txtPermitNumber"] <> "") {
					$strSQL = $strSQL . "  and PermitNumber = '" . $_POST["txtPermitNumber"] . "'";
					echo " PermitNumber = " . $_POST["txtPermitNumber"];
				}

				if (isset($_POST["ddlCompanyName"]) && $_POST["ddlCompanyName"] <> "") {
					$strSQL = $strSQL . " and  UtilityVerificationApplication.Company = '" . $_POST["ddlCompanyName"] . "'";
					echo " Company = '" . $_POST["ddlCompanyName"] . "' ";
				}

				if (isset($_POST["ddlTechnician"]) && $_POST["ddlTechnician"] <> "") {
					$strSQL = $strSQL . " and  UtilityVerificationApplication.Technician like '" . $_POST["ddlTechnician"] . "%'";
					echo " Technician like '" . $_POST["ddlTechnician"] . "%' ";
				}

				if (ISSET($_POST["ddlSubcontractor"]) && $_POST["ddlSubcontractor"] <> "") {
					$strSQL = $strSQL . " and  UtilityVerificationApplication.Subcontractor = '" . $_POST["ddlSubcontractor"] . "'";
					echo " Subcontractor = '" . $_POST["ddlSubcontractor"] . "' ";
				}

				if (isset($_POST["ddlForeman"]) && $_POST["ddlForeman"] <> "") {
					$strSQL = $strSQL . " and  UtilityVerificationApplication.Foreman = '" . $_POST["ddlForeman"] . "'";
					echo " Foreman = '" . $_POST["ddlForeman"] . "' ";
				}

				if (isset($_POST["SDStartDate"]) && Trim($_POST["SDStartDate"]) <> "") {
					$strSQL = $strSQL . " and  UVADate >= '" . SQLDate($_POST["SDStartDate"]) . "'";
					echo " UVADate >= '" . $_POST["SDStartDate"] . "' ";
				}

				if (isset($_POST["SDEndDate"]) && Trim($_POST["SDEndDate"]) <> "") {
					$strSQL = $strSQL . " and  UVADate <= '" . SQLDate($_POST["SDEndDate"]) . " 23:59'";
					echo " UVADate <= '" . $_POST["SDEndDate"] . "' ";
				}

				if (isset($_POST["txtLocationDescription"]) && Trim($_POST["txtLocationDescription"]) <> "") {
					$strSQL = $strSQL . " and UtilityVerificationApplication.LocationAddress Like '%" . $_POST["txtLocationDescription"] . "%'";
					echo " LocationAddress Like '%" . $_POST["txtLocationDescription"] . "%' " ;
				}

				if (isset($_POST["chkOpenPermit"]) && $_POST["chkOpenPermit"] == "on") {
					$strSQL = $strSQL . " and  (PermitClosed <> 'True') ";
					echo " Open Permit";
				}

				if (isset($_POST["ConstructionStart"]) && $_POST["ConstructionStart"] == "on") {
					$strSQL = $strSQL . " and ConstructionStart is not Null ";
					echo " Construction Started";
				}

				if (isset($_POST["Codes"]) && $_POST["Codes"] == "on") {
					$strSQL = $strSQL . " and (LetterCode = 'PIE' or LetterCode = 'PUV' or LetterCode = 'PVP') ";
					
					echo " PIE, PUV, or PVP ";
				}

				$strSQL = $strSQL . " Order by PermitNumber, UVADate  ";
				$query = $strSQL;
				//echo "<br>|" . $query . "|";
				$result = mysqli_query($connection, $query) or die("Query failed 1:" . "<br> " . $query . "<br> " . mysqli_error($connection));

				$BGShade = "#E0E0E0";
				echo "<TABLE width=100% border=1 cellspacing=1 cellpadding=3>";

				$RecordCount = 0;
				$CurrentPermitId = 0;

				while ($row = mysqli_fetch_array($result)) {

					if ($CurrentPermitId <> $row[2] || 1 == 1 ) {
						$RecordCount = $RecordCount + 1;

						echo '<tr bgColor=' . $BGShade . '>
						<th style="text-align:center;">&nbsp;UVA&nbsp;Date</th>
						<th width=200 style="text-align:center;">&nbsp;Permit&nbsp;Number&nbsp;</th>
						<th style="text-align:center;">&nbsp;Sketch&nbsp;Sheet&nbsp;</th>
						<th style="text-align:center;">&nbsp;Contractor&nbsp;</th>
						<th style="text-align:center;">&nbsp;Technician&nbsp;</th></tr>';

						echo "<tr bgcolor=" . $BGShade . ">";

						echo "<td align=center valign=top >
						<a href=UtilityVerificationApplication.php?UVAId=" . $row[0] . ">" . DisplayDate($row[1]) . "</a></td>";

						echo "<td align=center valign=top>
						<a href= NewEdit.php?Id=" . $row[2] . ">" . $row[3] . "</a></td>";

						echo "<td align=center valign=top>" . $row[6] . "</td>";
						echo "<td align=center valign=top>" . $row[7] . "</td>";

						echo "<td align=center valign=top>" . $row[5] . "</td>";
						echo "</tr></tr>";

						echo "<tr bgcolor=" . $BGShade . "><th  colspan=2 align=right>&nbsp;Permit&nbsp;Address&nbsp;/&nbsp;Location&nbsp;Description&nbsp;</th>";
						echo "<td align=left valign=top colspan=3>&nbsp;" . $row[4] . "</td>";
						echo "</tr></tr>";

						echo '<tr bgcolor=' . $BGShade . '><th  colspan=2 style="text-align:right">Utility&nbsp;Company&nbsp;</th>';
						echo "<td align=left valign=top colspan=3>&nbsp;" . $row[9] . "</td>";
						echo "</tr></tr>";

						if ($BGShade == "#E0E0E0") {
							$BGShade = "#FFFFFF";
						} else {
							$BGShade = "#E0E0E0";
						}
					}
					$CurrentPermitId = $row[2];
				}
				echo "<tr bgcolor=#FFFFFF><th colspan=7>UVA Count: " . $RecordCount . "</th></tr>";
				echo "</TABLE>";
				?>
</body>