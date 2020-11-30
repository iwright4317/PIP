<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<head>
	<?php
	include ('./includes/js_css.inc');
	?>	
	
	<script>
	
		function makeWhite(item) {	
        	item.style.backgroundColor = "white";
		}
		
		function setLocation(item, idValue) {			
        	var idText = document.getElementById(idValue).innerHTML;
        	idText = idText.replace("<b>","");
        	idText = idText.replace("</b>","");
        	idText = idText.replace("\t","");
        	document.getElementById(item).value = idText;
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
			if (XMLHttpRequestObject) {
				var obj = document.getElementById(divID);
				dataSource = dataSource + item;
				XMLHttpRequestObject.open("GET", dataSource);
				XMLHttpRequestObject.onreadystatechange = function() {
					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
						eresp = XMLHttpRequestObject.responseText;
						obj.innerHTML = eresp;
					}
				}
				XMLHttpRequestObject.send(null);
			}
			return true;
		}

		function checkData(target, tstring) {
			var ReturnValue = true;
			var obj = document.getElementById(target);
			if (obj.innerHTML == tstring) {
				ReturnValue = true;
			}
			return ReturnValue;
		}

		function selectByAddress() {
			alert('selectByAddress');
		}
		
		function validateandsubmit(theform) {
			
			var returnval = true;
			debugger;
			var deleteExists = document.getElementById("deleteRecord");
			var CheckForInput = true;
        	if (deleteExists == null) { // no deleteRecord checkbox -> new content item
        		CheckForInput = true;        		
        	} else { // edit existing item
        		if (!document.getElementById("deleteRecord").checked) {        		
        			CheckForInput = true;       // not deleting -> edit -> check	
        		} else {
        			CheckForInput = false;		// delete record desired -> don't validate
        		}
        	}
        	$txtStatus = "";
			if (CheckForInput) {
				if (theform.utilityCompany != null) {
					if (theform.utilityCompany.value == 'select a Utility Company') {					
						$txtStatus = $txtStatus + "<br>The Utility Company is not selected. Please select a Utility Company and proceed. ";
						document.getElementById("utilityCompany").style.backgroundColor="yellow";
						returnval = false;
					} else {
						document.getElementById("utilityCompany").style.backgroundColor="white";
					} 
				}
				
				var element =  document.getElementById('auto');
				if (typeof(element) != 'undefined' && element != null)
				{
					if (isblankentry(theform.auto)) {
						$txtStatus = $txtStatus + "<br>The Contractor is blank. Please enter a Contractor name and click the Submit button again. ";
						document.getElementById("auto").style.backgroundColor="yellow";
						returnval = false;
					} else {
						document.getElementById("auto").style.backgroundColor="white";
					} 
				}
				
				if (theform.contactPerson != null) {
					if (isblankentry(theform.contactPerson)) {
						$txtStatus = $txtStatus + "<br>The Contact Person is blank. Please enter a Contact Person name and click the Submit button again. ";
						returnval = false;
					}
				}
				

				if (theform.phone != null) {
					if (isblankentry(theform.phone)) {
						$txtStatus = $txtStatus + "<br>The Phone Number is blank. Please enter a Phone Number and click the Submit button again. ";					
						document.getElementById("phone").style.backgroundColor="yellow";
						returnval = false;
					} else {
						document.getElementById("phone").style.backgroundColor="white";
					} 
				}

				if (theform.phone != null) {
					if (isblankentry(theform.datepicker)) {
						$txtStatus = $txtStatus + "<br>The Date of Work is blank. Please enter Date of Work and click the Submit button again. ";
						returnval = false;
					} 
				}
				
				

				if (theform.Atime != null) {
					if (theform.Atime.value == 'select time') {					
						$txtStatus = $txtStatus + "<br>The Arrival Time is not selected. Please select an Arrival Time and click the Save button again. ";
						document.getElementById("Atime").style.backgroundColor="yellow";
						returnval = false;
					} else {
						document.getElementById("Atime").style.backgroundColor="white";
					} 		
				}		
				
				var element =  document.getElementById('permit_number');
				if (typeof(element) != 'undefined' && element != null)
				{ // exists.
				if (theform.permit_number != null) {
					if (theform.permit_number.value == 'select permit' ||
					theform.permit_number.value == 'select permit (updated)' ||
					theform.permit_number.value == 'You must select a full street address' || 
					theform.permit_number.value == 'select a Utility Company above' || 
					theform.permit_number.value == 'select a Utility Company above -') {					
						$txtStatus = $txtStatus + "<br>The Permit Number is not selected. Please select a Permit Number and click the Save button again. ";
						document.getElementById("permit_number").style.backgroundColor="yellow";
						returnval = false;
					} else {
						document.getElementById("permit_number").style.backgroundColor="white";
					} 	
				}		
				}		

				if (theform.permit_number != null && theform.epermit != null) {
					if (theform.permit_number.value == 'New Blanket/ROW Permit' && isblankentry(theform.epermit)) {					
						$txtStatus = $txtStatus + "<br>You have selected New Blanket/ROW Permit, but no permit number has been entered into the enter permit # text box. Please enter a permit into the enter permit # text box and click the Save button again. ";
						document.getElementById("epermit").style.backgroundColor="yellow";
						returnval = false;
					}		
				}


				if (theform.periodAM != null && theform.periodPM != null) {
					if (!theform.periodAM.checked && !theform.periodPM.checked) {
						$txtStatus = $txtStatus + "<br>The Arrival Time is not marked as AM or PM. Please select AM or PM and click the Save button again. ";					
						returnval = false;
					} 
				}
				if (isblankentry(theform.Location)) {
					$txtStatus = $txtStatus + "<br>The Location is blank. Please enter the Location and click the Submit button again. ";
					document.getElementById("Location").style.backgroundColor="yellow";
					returnval = false;
				} else {
					document.getElementById("Location").style.backgroundColor="white";
				}  				

				$noneChecked = true;
				if (theform.Trench.checked) {$noneChecked = false;}
				if (theform.Bore.checked) {$noneChecked = false;}
				if (theform.Open_Cut.checked) {$noneChecked = false;}
				if (theform.Test_Hole.checked) {$noneChecked = false;}
				if (theform.Final_Patch.checked) {$noneChecked = false;}
				if (theform.Dig_in_Dirt.checked) {$noneChecked = false;}
				if (theform.Landscape_Clean_up.checked) {$noneChecked = false;}
				if (theform.Aerial.checked) {$noneChecked = false;}
				if (theform.Tree_Trimming.checked) {$noneChecked = false;}
				if (theform.Traffic_Only.checked) {$noneChecked = false;}
				if (theform.Blanket.checked) {$noneChecked = false;}

				if ($noneChecked){
					$txtStatus = $txtStatus + "<br>No Work Descriptions have been selected. Please select at least one Work Description and click the Submit button again. ";
					returnval = false;
					document.getElementById("WorkDescription").style.backgroundColor="yellow";
				}  else {
					document.getElementById("WorkDescription").style.backgroundColor="white";
				} 

				if (!returnval) {
					$txtStatus = $txtStatus + "<br>This request can not be submitted. ";
					document.getElementById("status").innerHTML = $txtStatus;
					document.getElementById("status").style.color="red";
					returnval = false;
				} else {
					document.getElementById("status").innerHTML = "";
					ReturnValue = true;
				}			
			}
			
			if (returnval) {
				var now = new Date();
  				var hour = now.getHours();
  				if (hour >= 9) {  					
				//if (current time is past today 9:00 am) {
				//	check if date of work is today return intended yes / no
				//	if no returnval = false with no message -> give user a chance to change the date of work
				}
			}
			
			return returnval;
		}

	</script>
	
	<script>
		$(function() {
			$("#datepicker").datepicker();
		});

	</script>
	
	<script>
	$(document).ready(function()
	{
    	$('#auto').autocomplete(
	    {
    	    source: "searchContractor.php",
        	minLength: 1
    	});
	});	
	</script>	
	
	<script>
	$(document).ready(function() {
    src = 'searchStreet.php';
    $("#auto2").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                    utilityCompany : $('#utilityCompany').find(":selected").text()
                },
                success: function(data) {
                    response(data);                
                }
            });
        },
        min_length: 1,
        delay: 300        
    });
    
	});
	</script>
	
	
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#permit_number").change(function() {
				if ($(this).val() != 'City Project') {
				$.get('loadLocation.php?permit_number=' + $(this).val(), function(data) {
					document.getElementById("StreetAddress").innerHTML='<b>' + data + '</b>';
					document.getElementById("StreetAddressH").value=data;
				});
				$.get('loadWorkSketch.php?permit_number=' + $(this).val(), function(data) {
					if (data.trim() != 'sketch not found') {
					var WS = document.getElementById('WorkSketch');
					var subfolder = data.trim();
					subfolder = subfolder.substring(0, 4);
 					WS.setAttribute('href', './archive/' + subfolder + '/' + data);
 					WS.style.visibility="visible";
 				}
				});
				} else {
					document.getElementById("StreetAddress").innerHTML='';
					document.getElementById("StreetAddressH").value='';					
				}
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#utilityCompany").change(function() {
				
				$.get('loadPermits.php?utilityCompany=' + $(this).val(), function(data) {
					$("#permit_number").html(data);
				});
				document.getElementById("epermit").style.visibility="hidden"; 
				document.getElementById("auto2").value = 'enter street name';
			});

			$("#selectAddress").click(function() {
				var sFilter = document.getElementById("auto2").value;
				sFilter = sFilter.trim();
				if (sFilter == 'select a utility company') {
					alert('Please select a utility company first');
				} else {
					if (sFilter == 'enter street name') {
						alert('Please enter part of a street name into the Street Filter box');
					} else {						
						var e = document.getElementById("permit_number");
						var permit_number = e.options[e.selectedIndex].value;
						permit_number = permit_number.trim();
						if (permit_number == 'select a Utility Company above') {
							alert('Please select a utility company first');
						} else {
							$.get('testAddress.php?utilityCompany=' + $('#utilityCompany').find(":selected").text() + '&sFilter=' + $('#auto2').val(), function(data) {
								data = data.trim();
								if (data == 'address found') {
									//alert('loadPermits.php?utilityCompany=' + $('#utilityCompany').find(":selected").text() + '&sFilter=' + $('#auto2').val() + '|');
									$.get('loadPermits.php?utilityCompany=' + $('#utilityCompany').find(":selected").text() + '&sFilter=' + $('#auto2').val(), function(data) {
										$("#permit_number").html(data);
									});
								} else {
									document.getElementById("auto2").value = 'invalid street name';
									$.get('loadPermits.php?utilityCompany=' + $('#utilityCompany').find(":selected").text(), function(data) {
										$("#permit_number").html(data);
									});
								}							
							});
						}
					}
				}
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#permit_number").change(function() {
				if (document.getElementById("permit_number").value == "Emergency" || document.getElementById("permit_number").value == "New Blanket/ROW Permit") {
					//alert('emergency');
					document.getElementById("epermit").style.visibility="visible"; 
				} else {
					document.getElementById("epermit").style.visibility="hidden"; 
				}
			});
		});
	</script>

	<title>PIP | DN Online Form </title>
</head>
<body>
	<?php
		
	function DisplayDate($ADate) {			
		$date = date_create($ADate);
		return date_format($date , "m/d/Y") ; 	
	}	
	
	include ('./includes/banner.inc');
	
	$db = True;
	$db = False;
	
	if (isset($_GET["action"]) && $_GET["action"] == "ds") { // delete current submission
		if (isset($_GET["SubmissionId"])) {
			$q = "Delete From DNSubmissions Where Id = " . $_GET["SubmissionId"];
			if ($db) { echo '<br>' . $q;}
			$r = mysqli_query($connection,$q) or die("<br/>Query failed");
			
			$q = "Delete From DNDetails Where SubmissionId = " . $_GET["SubmissionId"];
			if ($db) { echo '<br>' . $q;}
			$r = mysqli_query($connection,$q) or die("<br/>Query failed");
			unset($_GET["SubmissionId"]);
			$SubmissionId = 0;
		}
	}	
	
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error($connection));
	$Organization = '';
	$OrganizationType = '';
	$FirstName = '';
	$LastName = '';
	$MiddleInitial = '';
	$Phone = '';
	$UploadFiles = "./archive/";
	if (!empty($_SESSION["user_id"] )) {
		$q = "Select * from Login Where Id = " . $_SESSION["user_id"] ;
		$r = mysqli_query($connection,$q) or die("<br/>Query failed");
		if ($row = mysqli_fetch_array($r)) {
			$Organization = $row['Organization'];
			$OrganizationType = $row['OrganizationType'];
			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
			$MiddleInitial = str_replace(".","",$row['MiddleInitial']);
			if (trim($MiddleInitial) <> '') { $MiddleInitial = $MiddleInitial . '.';}
			$Phone = $row['Phone'];
		}
	}
	
	?>
	<form name="form1" method="post" action="StoreSendDN2.php?Id=<?php if (isset($_GET['Id'])) {echo $_GET['Id'];}?>" onsubmit="javascript:return validateandsubmit(document.form1)">

<div class="container" style="background-color: whitesmoke;"> 
	<div id="status" style=""></div>
	
	<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
		<div class="col-sm-1" >
			<img src='http:\\pip.vabeachpu.com\seal_just_seal_color.jpg' style="width:60;" >
		</div>	
		<div class="col-sm-1" >
			&nbsp;
		</div>		
		<div class="col-sm-10" style="font-size: large; font-weight: bold">
			Notification to Start Work in the City of Virginia Beach Right of Way<br>
			This form must be completed daily before 9:00 am
		</div>
	</div>
	
	<?php
	$edit = FALSE;
	
	if (isset($_GET["action"])) {echo "<input type='hidden' name='action' value='" . $_GET["action"] . "'>";}
	
	$SubmissionId = 0;
	if (isset($_GET["SubmissionId"])) {
		$SubmissionId = $_GET["SubmissionId"];
	}
	//echo "<br>SubmissionId: " . $SubmissionId;
	if ($SubmissionId <> 0) {
		echo "<input type='hidden' name='SubmissionId' value='" . $SubmissionId . "'>";
		
		$query = "Select * from DNSubmissions where Id = " . $SubmissionId;
		if ($db) {echo '<br>SubmissionId: ' . $query;}
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($row = mysqli_fetch_array($result)) {
			//$Id = $row["Id"];		// wrong Id
			$utilityCompany = $row["utilityCompany"];
			$Contractor = $row["Contractor"];
			$dateOfWork = $row["dateOfWork"];
			$phone = $row["phone"];
			$contactPerson = $row["contactPerson"];
			$edit=TRUE;	
		}	
	}
	
if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
	if (isset($_GET["Id"]) && trim($_GET["Id"] <> "")) { // edit / view existing record		
		$query = "Select * from DNDetails Where Id = " . $_GET["Id"];		
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
		if ($db) {echo '<br>Existing record: ' . $query;}
		if ($row = mysqli_fetch_array($result)) {
			if ($db) {echo '<br>Found record: ';}
			$edit=TRUE;				
			$Id = $row["Id"];		
			$permit_number =  $row["permit_number"]; 
			$StreetAddress =  $row["StreetAddress"];
			$Plocation =  $row["Location"];
			$period =  $row["period"]; 
			$Atime =  $row["Atime"]; 
			if ($db) {echo '<br>Atime: '. $Atime;}
			
			if (!isset($_GET["action"]) || (isset($_GET["action"]) && trim($_GET["action"]) <> "nl" && trim($_GET["action"]) <> "np")) {
				if ($db) {echo '<br>Not New location: ';}
				$Location =  $row["Location"]; 
				$Trench =  $row["Trench"]; 
				$Bore =  $row["Bore"]; 
				$Open_Cut =  $row["Open_Cut"]; 
				$Test_Hole =  $row["Test_Hole"]; 
				$Final_Patch =  $row["Final_Patch"]; 
				$Dig_in_Dirt =  $row["Dig_in_Dirt"]; 
				$Landscape_Clean_up =  $row["Landscape_Clean_up"]; 
				$Aerial =  $row["Aerial"]; 
				$Tree_Trimming =  $row["Tree_Trimming"]; 
				$Traffic_Only =  $row["Traffic_Only"]; 
				$Blanket =  $row["Blanket"]; 
				$Additional =  $row["Additional"];		
			}
		}
	}
	?>
		
	<div class="row">
		<div class="col-sm-6" >
			<?php
			if ($OrganizationType == 'Utility Company') {
				echo 'Utility  Company: <br>';
				echo '<select onclick="makeWhite(this);" id="utilityCompany" name="utilityCompany" style="height:26px">';
				echo '<option>' . $Organization . '</option></select>';
			} else {
				echo 'Utility  Company: <br>';				
				
				if (!isset($_GET["SubmissionId"]) || True) {
				$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-24 months" ) );
				$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
					
				$q = "SELECT Distinct Company.`CompanyName` FROM Company,PIP Where 
				PIP.CompanyName = Company.CompanyName and 
				(DateOfSignature between '" . $myDate . "' and '" . $today . "') 		
				Order by `CompanyName`";
				
				$q = "SELECT Distinct Company.`CompanyName` FROM Company		
				Order by `CompanyName`";
				
				$r = mysqli_query($connection,$q) or die("<br/>Query failed");
				if ($db && isset($utilityCompany)) {echo '<br>utilityCompany: ' . $utilityCompany;}
				if ($db) {echo '<br>edit: ' . $edit;}
				echo '<select onclick="makeWhite(this);" id="utilityCompany" name="utilityCompany" style="height:26px">';
				echo '<option>select a Utility Company</option>';
				$found = FALSE;
				while ($row = mysqli_fetch_array($r)) {
					if ($edit) {
						if ($utilityCompany == $row[0]) {
							$found = TRUE;
							echo '<option selected value="' . $row[0] . '">' . $row[0] . '</option>';
						} else {
							echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
						}
					} else {
						if ($Organization == $row[0]) {
							$found = TRUE;
							echo '<option selected value="' . $row[0] . '">' . $row[0] . '</option>';
						} else {
							echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
						}
					}
				}
				if ($edit and !$found) {
					echo '<option selected value="' . $row[0] . '">' . $utilityCompany . '</option>';
				}
				echo '</select>';
				} else {
					if (isset($utilityCompany)) {
						echo '<select onclick="makeWhite(this);" id="utilityCompany" name="utilityCompany" style="height:26px">';
						echo '<option>' . $utilityCompany . '</option></select>';
						//echo '<b>' . $utilityCompany . '</b>';
					}
				}
			}			
			?>
		</div>
		<div class="col-sm-6" >
			Contractor:<br>
			<?php
			if (!isset($_GET["SubmissionId"])) {						
				if ($OrganizationType == 'Contractor') {			
					echo '<b>' . $Organization . '</b>';
					echo '<input type="hidden" id="Contractor" name="Contractor" value="' . $Organization . '">';
				} else {
					if ($edit) {				
						echo '<input name="Contractor" style="width:100%" type="text" onclick="makeWhite(this);" id="auto" '; 
						echo 'value="' . $Contractor . '" />';
					} else {	
						echo '<input name="Contractor" style="width:100%" type="text" onclick="makeWhite(this);" id="auto" />';	
					}
				}
			} else {
				if (isset($OrganizationType) && $OrganizationType == 'Contractor') {
					if (isset($Organization )) {echo '<b>' . $Organization . '</b>';}
				} else {
					if (isset($Contractor)) {echo '<b>' . $Contractor . '</b>';}
				}	
			}
			?>
			
		</div>		
	</div>	
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
		
	<div class="row">
		<div class="col-sm-4" >
			<?php
			if (!$edit ) {
				$contactPerson = $FirstName . ' ' . $MiddleInitial . ' ' . $LastName;
			} 
			?>
			Contact&nbsp;Person:<br>
			<?php
			if (!isset($_GET["SubmissionId"])) { ?>
				<input type="text"  
				style='width:100%' name="contactPerson" id="contactPerson"
				value='<?php echo $contactPerson; ?>'> 
			<?php
			} else {
				echo '<b>' . $contactPerson . '</b>'; 
			}
			?>
		</div>
		<div class="col-sm-4" >
			<?php
			if (!$edit) {
				$phone = $Phone;
			} 
			echo 'Phone&nbsp;Number:<br>';
			if (!isset($_GET["SubmissionId"])) { ?>
			<input style='width:100%' type="text" name="phone"
			id="phone" onclick="makeWhite(this);"
			value='<?php echo $phone; ?>'>
			<?php
			} else {
				echo '<b>' . $phone . '</b>'; 
			}
			?>
		</div>
		<div class="col-sm-4" >
			<?php
			if (!$edit) {
				$dateOfWork = date('m/d/Y');
			} 
			?>
			Date&nbsp;of&nbsp;Work:<br>
			<?php			
			if (!isset($_GET["SubmissionId"]) || 1 == 1) { ?>
				<input type="text" id="datepicker"  
				value='<?php echo DisplayDate($dateOfWork); ?>' name="dateOfWork">
			<?php
			} else {
				echo '<b>' . DisplayDate($dateOfWork) . '</b>'; 
			}
			?>
		</div>
	</div>
		
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
		
	<div class="row">
		<div class="col-sm-4" style="">
			<?php			
				$myDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-24 months" ) );
				$today = date( "Y-m-d", strtotime( date("Y-m-d")  . "+1 day" )) ;
				if ($db) {echo '<br>Get permit numbers, edit: '. $edit;}
				If ($edit) {
					$q = "Select PermitNumber, Id, PermitAddress from PIP Where CompanyName = '" . $utilityCompany . "' and 
					(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
					
					//$q = "Select PermitNumber, Id from PIP Where CompanyName = '" . $utilityCompany . "' Order by PermitNumber" ;
				
				} else {
					$q = "Select PermitNumber, Id, PermitAddress from PIP Where CompanyName = '" . $Organization . "' and 
					(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
				}			
				if ($db) {echo '<br>Get permit numbers, edit: '. $q;}
			?>
			Permit&nbsp;Number:							
			<input type="text" id="epermit" name="epermit" placeholder="enter permit #" style="visibility: hidden; width:100px"><br>
			<?php	
			If (isset($_GET["action"]) && trim($_GET["action"]) == "nl") {
				if (!isset($permit_number )) {$permit_number = "";}
				echo "<b>" . $permit_number . "</b>";
				echo '<input type="hidden" name="permit_number" value="' . $permit_number . '">';
			} else { 
				?>
				<select name="permit_number" id="permit_number" 
			 	onclick="makeWhite(this);" style="width:100%; height: 26">
			 	<?php
				if ($OrganizationType == 'Utility Company' || $edit ) {	
					echo "<option>select permit</option>";			
					echo "<option>Emergency</option>";		
					echo "<option>New Blanket/ROW Permit</option>";		
					echo "<option>City Project</option>";
					$found = FALSE;
					$r = mysqli_query($connection,$q) or die("<br/>Query failed");
					while ($row = mysqli_fetch_array($r)) {
						if ($edit) {
							if (isset($permit_number)) {				
								$permits = explode(" ",$permit_number);	
							}
							if (isset($permit_number) && 
							$permits[0] == $row['PermitNumber'] &&
							(!isset($_GET["action"]) || (isset($_GET["action"]) && $_GET["action"] <> "np"))) {										
							
								echo "<option selected >" . $row['PermitNumber'] . " - " . $row['PermitAddress'] . "</option>";
								$found = TRUE;
							} else {
								echo "<option  >" . $row['PermitNumber'] . " - " . $row['PermitAddress'] . "</option>";
							}
						} else {
							echo "<option  >" . $row['PermitNumber'] . " - " . $row['PermitAddress'] . "</option>";
						}					
					}			
					if (!$found || True) {
						if (isset($permit_number)) {
						echo "<option >" . $permit_number . " - " . $StreetAddress . "</option>";
						}
					}
				} else {
					echo "<option>select a Utility Company above</option>";
				}	
				?>				
				</select> 
			<?php
			} ?>
		</div>
		
		<div class="col-sm-2" style="">
			<?php
				if ($db && isset($Atime)) {echo '<br>Atime: ' . $Atime;}
			if (!$edit || ($edit && 
			(!isset($_GET["action"]) || isset($_GET["action"]) && $_GET["action"] != "nl"))) {				
			
			?>
			Street&nbsp;Filter:&nbsp;(optional)<br>
			<?php
			if (!$edit) {
			?>
				<input name="auto2" onclick="this.value='';" value=" select a utility company"  style="width:100%; height:26px" type="text"  id="auto2" /><br>
				<?php
			} else {
				?>
				<input name="auto2" onclick="this.value='';" value=" enter a street name"  style="width:100%; height:26px" type="text"  id="auto2" /><br>
				<?php
			}
			?>
			<a id="selectAddress" style="visibility: visible;">Update&nbsp;Permit Number list</a>
			<?php
			if (False) { ?>
			<select name="sFilter" id="sFilter" onclick="makeWhite(this);" 
			style="width:100%; height: 26">
				<option>select name</option>
				<?php
				
				$q = "SELECT Distinct Company.`CompanyName` FROM Company		
				Order by `CompanyName`";
				
				$q = "Select PermitAddress, Id from PIP Where CompanyName = '" . $Organization . "' and 
				(DateOfSignature between '" . $myDate . "' and '" . $today . "')  Order by PermitNumber" ;
					
				$r = mysqli_query($connection,$q) or die("<br/>Query failed");
				
				$found = FALSE;
				while ($row = mysqli_fetch_array($r)) {					
					echo '<option';
					//if (isset($Atime) && $Atime == $strHR) {echo " selected ";}
					echo '>' . $row[0] . '</option>';
				}
			}
				?>
			</select>
			<?php
			} ?>
		</div>	
		<div class="col-sm-2" style="">
			<?php
				if ($db && isset($Atime)) {echo '<br>Atime: ' . $Atime;}
			?>
			Arrival&nbsp;Time:<br>			
			<select name="Atime" id="Atime" onclick="makeWhite(this);" 
			style="width:100%; height: 26">
				<option>select time</option>
				<?php
				$HR = 1;
				while ($HR <= 12) {
					if ($HR > 13) {
						$DHR = $HR - 12;
					} else {
						$DHR = $HR;
					}
					if ($DHR < 10) {$strHR = '0' . $DHR . ':00';
					} else {$strHR = $DHR . ':00';}
					echo '<option';
					if (isset($Atime) && $Atime == $strHR) {echo " selected ";}
					echo '>' . $strHR . '</option>';
					$HR++;
				}
				?>
			</select>
		</div>		
		<div class="col-sm-4" style="vertical-align: bottom">
			&nbsp;<br>
			<input type="radio" name="period" id="periodAM" value="AM"
			<?php if (isset($period) && $period == 'AM') {echo ' checked ';}?> >&nbsp;AM&nbsp;&nbsp;&nbsp;
			<input type="radio" name="period" id="periodPM" value="PM"
			<?php if (isset($period) && $period == 'PM') {echo ' checked ';}?> >&nbsp;PM
		</div>		
	</div>
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
		
	<div class="row" >
		<div class="col-sm-6" style="">
			Permit&nbsp;Address:<br>
			<div name="StreetAddress" id="StreetAddress" ><b><?php  
			if (!$edit || ($edit && (isset($_GET["action"]) && $_GET["action"] == "np"))) {
				if (isset($StreetAddress)) {$PstreetAddress = $StreetAddress;}				
				$StreetAddress = "";				
			}
			if(isset($StreetAddress)) {						
				echo $StreetAddress;
			}
			?>
			
			</b></div>	
			<input type="hidden" name="StreetAddressH" id="StreetAddressH" value="<?php if(isset($StreetAddress)) {echo $StreetAddress;}?>">	
		</div>		
		<div class="col-sm-6" style="">
			<?php
			if(isset($Plocation) && isset($permit_number)) {	?>
				Previous&nbsp;location&nbsp;entered&nbsp;today&nbsp;for&nbsp;this&nbsp;submission:<br>
				<div name="Plocation" id="Plocation" ><b>	
				<?php							
				echo $permit_number . " - " . $Plocation . "</div>";
			}
			?>			
		</div>		
	</div>	
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>				
	
	<div class="row" >
		<div class="col-sm-12" style="">
			Location&nbsp;and&nbsp;nearest&nbsp;cross&nbsp;street:&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="usePA" onchange="setLocation('Location','StreetAddress');">&nbsp;Use Permit Address<br>
			
			<textarea name="Location" id="Location" type="text" 
			onclick="makeWhite(this);" style="width:100%" rows="2"><?php if (isset($Location)) {echo $Location;}?></textarea>
		</div>		
	</div>	
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
		
	<div class="row" >
		<div class="col-sm-12" style="">
			Additional&nbsp;information&nbsp;(optional):&nbsp;<br>
			<input name="Additional" type="text" 
			value="<?php if(isset($Additional)) {echo $Additional;}?>" style="width:100%">
		</div>		
	</div>	
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
	
	<div class="row" id="WorkDescription">
		<div class="col-sm-12" style="border-top: 1px solid blue; border-left: 1px solid blue;border-right: 1px solid blue;">
			Work Description 
			(Select only where applicable)
		</div>
	</div>	
	
	<div class="row" >
		<div class="col-sm-2" style="border-left: 1px solid blue;">
			<input type="checkbox" oncheck="makeWhite('WorkDescription');" 
			name="Trench" id="Trench" value="yes" 
			<?php if (isset($Trench) && $Trench == "yes") {echo ' checked ';}?>>&nbsp;Trench
		</div>
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Bore" id="Bore" value="yes" 
			<?php if (isset($Bore) && $Bore == "yes") {echo ' checked ';}?>>&nbsp;Bore
		</div>
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Open_Cut" id="Open_Cut" value="yes" 
			<?php if (isset($Open_Cut) && $Open_Cut == "yes") {echo ' checked ';}?>>&nbsp;Open&nbsp;Cut
		</div>
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Test_Hole" id="Test_Hole" value="yes" 
			<?php if (isset($Test_Hole) && $Test_Hole == "yes") {echo ' checked ';}?>>&nbsp;Test&nbsp;Hole
		</div>		
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Final_Patch" id="Final_Patch" value="yes" 
			<?php if (isset($Final_Patch) && $Final_Patch == "yes") {echo ' checked ';}?>>&nbsp;Final&nbsp;Patch
		</div>
		<div class="col-sm-2" style="border-right: 1px solid blue;">
			<input type="checkbox" name="Dig_in_Dirt" id="Dig_In_Dirt" value="yes" 
			<?php if (isset($Dig_in_Dirt) && $Dig_in_Dirt == "yes") {echo ' checked ';}?>>&nbsp;Dig&nbsp;in&nbsp;Dirt
		</div>
	</div>
	<div class="row" style="border-bottom: 1px solid blue;">
		<div class="col-sm-3" style="border-left: 1px solid blue;">
			<input type="checkbox" name="Landscape_Clean_up" id="Landscape_Clean_up" value="yes" 
			<?php if (isset($Landscape_Clean_up) && $Landscape_Clean_up == "yes") {echo ' checked ';}?>>&nbsp;Landscape&nbsp;Clean&#8209;up
		</div>
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Aerial" id="Aerial" value="yes" 
			<?php if (isset($Aerial) && $Aerial == "yes") {echo ' checked ';}?>>&nbsp;Aerial
		</div>
		<div class="col-sm-3" style="">
			<input type="checkbox" name="Tree_Trimming" id="Tree_Trimming" value="yes" 
			<?php if (isset($Tree_Trimming) && $Tree_Trimming == "yes") {echo ' checked ';}?>>&nbsp;Tree&nbsp;Trimming
		</div>
		<div class="col-sm-2" style="">
			<input type="checkbox" name="Traffic_Only" id="Traffic_Only"  value="yes" 
			<?php if (isset($Traffic_Only) && $Traffic_Only == "yes") {echo ' checked ';}?>>&nbsp;Traffic&nbsp;Only
		</div>
		<div class="col-sm-2" style="border-right: 1px solid blue;">
			<input type="checkbox" name="Blanket" id="Blanket" value="yes" 
			<?php if (isset($Blanket) && $Blanket == "yes") {echo ' checked ';}?>>&nbsp;Blanket
		</div>
	</div>	
	
	<div class="row">
		<div class="col-sm-12" style="height:10px">
			&nbsp;
		</div>		
	</div>		
	
	<div class="row">
		<div class="col-sm-6" style="">
			
			<?php	
			if ($admin || $view || $company) {	?>
			<button class="success">
				&nbsp; Save notification
			</button>
			<?php } ?>
		</div>
		
		<div class="col-sm-6" style="">
			<?php
				if (!isset($_GET["SubmissionId"]) || trim($_GET["SubmissionId"]) == "") {								
					if (isset($_SESSION["user_id"])) {
					$q = "SELECT * FROM DNSubmissions Where LoginId = " . $_SESSION["user_id"] .
					" Order by SubmissionDateTime desc";				
					$r = mysqli_query($connection,$q) or die("<br/>Query failed");					
					if ($row = mysqli_fetch_array($r)) {
						echo '<a href="StoreSendDN2.php?SubmissionId=' . $row["Id"] . '&action=recall">Recall Previous Notification</a>';
						echo '<a href="" target="_blank" id="WorkSketch" style="visibility: hidden">-</a>';
					}		
					}							
				}
			?>
		</div>
			
	</div>
</div>
</form>
</body>
</html>