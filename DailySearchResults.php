<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Daily Search</title>

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
				<h2>Daily Search</h2>
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
				//echo "|" . $today . "|";
				
	include ('./includes/database.inc');	
	include ('./includes/database2.inc');
	
				//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
				//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
				$strSQL = "Select DailyNotifications.id, DNDate, PIP.Id, PermitNumber,  
            	CompanyName, LocationDescription, DateOfSignature 
            	From PIP, DailyNotifications Where PIP.Id = PermitId";
            
				if ($_POST["txtPermitNumber"] <> "") {
					$strSQL = $strSQL . "  and PermitNumber = '" . $_POST["txtPermitNumber"] . "'";
					echo " PermitNumber = " . $_POST["txtPermitNumber"];
				}

				if ($_POST["ddlCompanyName"] <> "") {
					$strSQL = $strSQL . " and  CompanyName = '" . $_POST["ddlCompanyName"] . "'";
					echo " Company = " . $_POST["ddlCompanyName"];
				}

				if (Trim($_POST["SDStartDate"]) <> "") {
					$strSQL = $strSQL . " and  DNDate >= '" . SQLDate($_POST["SDStartDate"]) . "'";
					echo " DNDate >= " . $_POST["SDStartDate"];
				}

				if (Trim($_POST["SDEndDate"]) <> "") {
					$strSQL = $strSQL . " and  DNDate <= '" . SQLDate($_POST["SDEndDate"]) . " 23:59'";
					echo " DNDate <= " . $_POST["SDEndDate"];
				}

				if (isset($_POST["txtLocationDescription"]) && Trim($_POST["txtLocationDescription"]) <> "") {
					$strSQL = $strSQL . " and LocationDescription Like '%" . $_POST["txtLocationDescription"] . "%'";
					echo " LocationAddress Like " . $_POST["txtLocationDescription"];
				}

				$strSQL = $strSQL . " Order by PermitNumber, DNDate  ";
				$query = $strSQL;
				//echo "<br>" . $query;
				$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error());

				$BGShade = "#E0E0E0";
				echo "<TABLE width=100% border=1 cellspacing=1 cellpadding=3>";
                echo "<tr bgColor=#afeeee><th>Daily Date</th><th width=110>Permit Number<br>(Signature)</th>" .
                "<th>Company</th><th>Permit Address / Location Description</th></tr>";

				$RecordCount = 0;
				$CurrentPermitId = 0;

				while ($row = mysqli_fetch_array($result)) {
					$RecordCount = $RecordCount + 1;
					echo "<tr bgcolor=#FFFFFF>";
                    echo "<td align=center valign=top ><a href=PreviewDN2.php?Id="  . 
                        $row[0] . ">" . DisplayDate($row[1]) . "</a></td>";
                    $strSQL = "Select Id, LocationDescription, CompanyName, DateOfSignature From PIP "  . 
                    "Where PermitNumber = '" . $row["PermitNumber"] . "' Order by DateOfSignature Desc";

					$q2 = $strSQL;
					$r2 = mysqli_query($connection2, $q2) or die("<br/>Query failed: " . $q);
					if ($row2 = mysqli_fetch_array($r2)) {                        
                        echo "<td align=center valign=top><a href= NewEdit.php?Id=" . 
                        $row2["Id"] . ">" . $row[3] . "</a><br>(" .
                        DisplayDate($row2["DateOfSignature"]) . ")</td>";
                        echo "<td align=center valign=top>" . $row2["CompanyName"] . "</td>";
                        echo "<td align=center valign=top>" . $row2["LocationDescription"] . "</td>";
                    }

                    echo "</tr></tr>";										
					$CurrentPermitId = $row[2];
				}
				echo "<tr bgcolor=#FFFFFF><th colspan=7>DN Count: " . $RecordCount . "</th></tr>";
				echo "</TABLE>";
				?>
</body>