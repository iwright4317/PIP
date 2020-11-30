<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");
?>
<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body style='margin:0; font-family:Arial;' >

	<!-- <div class="container" style="font-size: Large; background-color: white;  "> -->

		<?php
		
		function DisplayDate($ADate) {
			$date = date_create($ADate);
			return date_format($date, "m/d/Y");
		}
				
		function ScrubDate($ADate) {
			//2016-05-20 -> 05/16/2016
			if (!empty($ADate)) {
				return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
			} else {
				return null;
			}
		}
		?>
		
<table width='100%' border='0' cellspacing='0' style='font-family:Arial;'>	
		<tr>
			<td  style="text-align:left;  font-size: x-small; ">
				&nbsp;
			</td>
			<td colspan="4" style="text-align:center; color:red; font-weight:bold; font-size: x-large; ">
				ACCURACY NOT GUARANTEED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		
		<tr>
			<td  style="text-align:left;  font-size: x-small; ">
				<!-- FORM&nbsp;NO.&nbsp;PU&nbsp;134<br>
				REV&nbsp;9/06 
				-->
			</td>
			<td colspan="3" style="text-align:center; font-weight:bold; font-size: x-large; ">
				Utility Verification Application&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<?php	
	
		include ('./includes/database.inc');
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
		//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
				
		$strSQL = "";
		$edit = false;

		$FirstName = '';
		$LastName = '';
				
		if (!empty($_SESSION["user_id"] )) {
			$q = "Select * from Login Where Id = " . $_SESSION["user_id"];
			$r = mysqli_query($connection,$q) or die("<br/>Query failed - 19.5" . $q);

			if ($row = mysqli_fetch_array($r)) {
				$FirstName = $row["FirstName"];
				$LastName = $row["LastName"];
			}
		}

		// If Id -> Permit Id get Permit # and Company name
		if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
		
		If (Trim($_GET["Id"]) <> "") {
			$lnkRefresh = "UtilityVerificationApplication.php?Id=" . $_GET["Id"];
			$lnkNew = "UtilityVerificationApplication.php?Id=" . $_GET["Id"];
			$q = "Select PermitNumber,CompanyName from PIP Where Id = " . $_GET["Id"];
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 82 : " . $q);
			If ($row = mysqli_fetch_array($r)) {
				$txtPermitNumber = $row[0];
				$txtCompany = $row[1];
			}
		}

		If (Trim($_GET["UVAId"]) <> "") {
			$edit = true;
			
			
			$q = "Select PermitNumber,CompanyName from UtilityVerificationApplication, PIP 
			Where UtilityVerificationApplication.Id = " . $_GET["UVAId"] . ' and UtilityVerificationApplication.PermitId = PIP.Id';
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q);
			if ($row = mysqli_fetch_array($r)) {				
				$txtPermitNumber = $row[0];
				$txtCompany = $row[1];
			}
	
			$q = "Select * from UtilityVerificationApplication, UVACUs 
			Where UtilityVerificationApplication.Id = " . $_GET["UVAId"] . " and 
			UtilityVerificationApplication.Id = UVAid";
			//echo '<br>' . $q;
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q);
			$I = $_GET["UVACount"];
			$RCount = 0;
			$toggle = 0;
			while ($row = mysqli_fetch_array($r)) {
				if ($RCount == 0) {									
					?>
						
	<tr>
		<td style="width:65px">
			<img src='http:\\pip.vabeachpu.com\seal_just_seal_color60w.jpg' >&nbsp;
		</td>	
		<td style="text-align:left;  font-size: x-small; ">
&nbsp;&nbsp;&nbsp;City&nbsp;of&nbsp;Virginia&nbsp;Beach<br>
&nbsp;&nbsp;&nbsp;Department&nbsp;of&nbsp;Public&nbsp;Utilities<br>
&nbsp;&nbsp;&nbsp;Engineering<br>
&nbsp;&nbsp;&nbsp;(757)&nbsp;385-4171
		</td>
		<td  style="text-align:left; font-size: medium; font-weight: bold">
			&nbsp;<p>
				Install Date: <u><b><?php echo DisplayDate($row["UVADate"]); ?> </b></u><br>
				Sketch Sheet: <u><b><?php echo $row["SketchSheet"]; ?> </b></u>
		</td>
	</tr>
	</table>
	<table width='100%' border='0' cellspacing='0' style='font-family:Arial;'>	
		<tr>
			<td>
				<b>Permit #: <u><?php echo $txtPermitNumber; ?> </u></b>
			</td>
		</tr>
	
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>		
	
	<tr>
		<td  >
			<b>Location/Address: <u><?php echo $row["LocationAddress"]; ?> </u></b>
		</td>
	</tr>	
	<tr>
		<td  >
			<b>Street name of utility crossing: <u><?php echo $row["StreetName"]; ?> </u></b>
		</td>
	</tr>		
		
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>		
		
	<tr>
		<td  >
			<b>Company: <u><?php echo $row["Company"]; ?> </u></b>
		</td>
	</tr>
		
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>		
		
	<tr>
		<td  >
			<b>Subcontractor: <u><?php echo $row["Subcontractor"]; ?> </u></b>
		</td>
	</tr>
	
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>		
		
	<tr>
		<td  >
			<b>Foreman / Supervisor on-site: <u><?php echo $row["Foreman"]; ?> </u></b>
		</td>
	</tr>
		
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>		
		
	<tr>
		<td  >
			<b>Technician / Inspector: <u><?php echo $row["Technician"]; ?> </u></b>
		</td>
	</tr>
	
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>	
		</tr>	
		
	<tr>
		<td  >
			<b>PU Technician Comments: <u><?php echo $row["tComments"]; ?> </u></b>
		</td>
	</tr>
	
	
		<tr>
			<td  style="height:10px">
				&nbsp;
			</td>		
		</tr>	
		
	<tr>
		<td  >
			<b>Verified: <u><?php 
			if (isset($row["Verified"]) && trim($row["Verified"]) <> "select") {echo $row["Verified"];} ?> </u></b>
		</td>
	</tr>
</table>
<table width='100%' border='0' cellspacing='0' style='font-family:Arial;'>	
	
		<tr>
			<td colspan="5" style="border-bottom: 1px solid black; height:10px">
				&nbsp;
			</td>		
		</tr>	

		<?php
		} 
		if ($toggle == 1) { ?>
		</table>
		<!-- <br style="page-break-before: always"> -->
		<table>
		<table width='100%' border='0' cellspacing='0' style='font-family:Arial;'>
		<tr  >				
			<td colspan="5" style="background-color:whitesmoke; 
			border-left: 2px solid black; 
			border-right: 2px solid black; 
			border-top: 2px solid black; 
 			font-weight:bold; background-color: whitesmoke">
				Existing utility crossed
			</td>
		</tr>	
		<tr >
			<td  style="border-left: 2px solid black; font-weight: bold; background-color: whitesmoke">
				Owner:<br>
				<?php echo $row["EUOwner"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: whitesmoke">
				Size:<br>
				<?php echo $row["EUSize"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: whitesmoke">
				Type:<br>
				<?php echo $row["EUType"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: whitesmoke">
				Depth:<br>
				<?php echo $row["EUDepth"]; ?>
			</td>
			<td  style="border-right: 2px solid black; font-weight: bold; background-color: whitesmoke">
				Status:<br>
				<?php echo $row["EUStatus"]; ?>
			</td>
		</tr>			
		
		<tr>
			<td colspan="5"  style="border-left: 2px solid black; 
			border-right: 2px solid black; 
			border-top: 2px solid black;  
			font-weight:bold; background-color: whitesmoke">
				Newly Installed utility
			</td>
		</tr>		
		
		
		<tr  >
			<td  style="border-left: 2px solid black; font-weight: bold;  background-color: whitesmoke">
				Size:<br>
				<?php echo $row["IUSize"]; ?>
			</td>
			<td  style="font-weight: bold;background-color: whitesmoke">
				Type:<br>
				<?php echo $row["IUType"]; ?>
			</td>
			<td  style="font-weight: bold;background-color: whitesmoke">
				Depth:<br>
				<?php echo $row["IUDepth"]; ?>
			</td>
			<td  style="font-weight: bold;background-color: whitesmoke">
				Method:<br>
				<?php echo $row["IUMethod"]; ?>
			</td>
			<td  style="font-weight: bold;border-right: 2px solid black; background-color: whitesmoke">
				Quantity:<br>
				<?php echo $row["IUQuantity"]; ?>
			</td>
		</tr>		
		
		<tr>
			<td colspan="5" style="border-left: 2px solid black; 
			border-right: 2px solid black; 
			border-top: 2px solid black; 
			font-weight:bold; background-color: whitesmoke">
				Test hole / Open cut
			</td>
		</tr>						
			
		<tr  style="border-right: 2px solid black;border-bottom: 2px solid black; ">
			<td style="font-weight: bold;border-left: 2px solid black; 
			border-bottom: 2px solid black;  
			background-color: whitesmoke">
				Surface:<br>
				<?php echo $row["THSurface"]; ?>
			</td>
			<td style="font-weight: bold; border-bottom: 2px solid black; background-color: whitesmoke">
				Width:<br>
				<?php echo $row["THWidth"]; ?>
			</td>
			<td style="font-weight: bold; border-bottom: 2px solid black; background-color: whitesmoke">
				Length:<br>
				<?php echo $row["THLength"]; ?>
			</td>
			<td colspan="2" style="border-right: 2px solid black; border-bottom: 2px solid black; background-color: whitesmoke">
				&nbsp;<br>&nbsp;
			</td>
		</tr>
		
		
			
		<?php
		} else {
			?>
		<tr >				
			<td colspan="5" style="font-weight:bold; background-color: white">
				Existing utility crossed
			</td>
		</tr>		
		<tr >
			<td  style="font-weight: bold; background-color: white">
				Owner:<br>
				<?php echo $row["EUOwner"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: white">
				Size:<br>
				<?php echo $row["EUSize"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: white">
				Type:<br>
				<?php echo $row["EUType"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: white">
				Depth:<br>
				<?php echo $row["EUDepth"]; ?>
			</td>
			<td  style="font-weight: bold; background-color: white">
				Status:<br>
				<?php echo $row["EUStatus"]; ?>
			</td>
		</tr>			
		
		<tr>
			<td colspan="5" style=" border-top: 2px solid black; font-weight:bold; background-color: white">
				Newly Installed utility
			</td>
		</tr>				
		
		<tr style="font-weight:bold; ">
			<td  style="background-color: white">
				Size:<br>
				<?php echo $row["IUSize"]; ?>
			</td>
			<td  style="background-color: white">
				Type:<br>
				<?php echo $row["IUType"]; ?>
			</td>
			<td  style="background-color: white">
				Depth:<br>
				<?php echo $row["IUDepth"]; ?>
			</td>
			<td  style="background-color: white">
				Method:<br>
				<?php echo $row["IUMethod"]; ?>
			</td>
			<td  style="background-color: white">
				Quantity:<br>
				<?php echo $row["IUQuantity"]; ?>
			</td>
		</tr>		
		
		<tr>
			<td colspan="5"  style="border-top: 2px solid black;  font-weight:bold; background-color: white">
				Test hole / Open cut
			</td>
		</tr>						
			
		<tr  style="">
			<td style="font-weight: bold; background-color: white">
				Surface:<br>
				<?php echo $row["THSurface"]; ?>
			</td>
			<td style="font-weight: bold; background-color: white">
				Width:<br>
				<?php echo $row["THWidth"]; ?>
			</td>
			<td style="font-weight: bold; background-color: white">
				Length:<br>
				<?php echo $row["THLength"]; ?>
			</td>
			<td style="background-color: white">
				&nbsp;<br>&nbsp;
			</td>
		</tr>
		
		<!--
		<tr  style="border-top: 4px solid black; border-left: 0px solid black; border-right: 2px solid black;">
			<td  style="border-top: 0px solid black; height:10px">
				&nbsp;
			</td>		
		</tr>		
		-->
		
		<?php
		}
		
			$RCount = $RCount + 1;
			if ($toggle == 0) {
				$toggle = 1;
			} else {
				$toggle = 0;
			}
		
		
		}
		}
		?>
			
	</tr>	
	
	<tr>
			<td colspan="5"  style="border-top: 1px solid black;  font-weight:bold; background-color: white">
				&nbsp;
			</td>
		</tr>						
			
			
	</table>	
	
	
	<script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.

		var placeSearch,
		    autocomplete;
		var componentForm = {
			street_number : 'short_name',
			route : 'long_name',
			locality : 'long_name',
			administrative_area_level_1 : 'short_name',
			country : 'long_name',
			postal_code : 'short_name'
		};

		function initAutocomplete() {
			// Create the autocomplete object, restricting the search to geographical
			// location types.
			autocomplete = new google.maps.places.Autocomplete(
			/** @type {!HTMLInputElement} */(document.getElementById('autocomplete')), {
				types : ['geocode']
			});

			// When the user selects an address from the dropdown, populate the address
			// fields in the form.
			autocomplete.addListener('place_changed', fillInAddress);
		}

		// [START region_fillform]
		function fillInAddress() {
			// Get the place details from the autocomplete object.						
			var place = autocomplete.getPlace();			
			
			var GooMapText = document.getElementById("autocomplete").value;
			var res = GooMapText.replace(" ", "+"); 
			document.getElementById("GooMap").innerHTML = "<a href='https://maps.google.com/maps?q=" + res + "'>Google&nbsp;map</a>";	
			//"https://maps.google.com/maps?q=" . Replace($row["ST_NUM"), " ", "+")		

			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}

			// Get each component of the address from the place details
			// and fill the corresponding field on the form.
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					document.getElementById(addressType).value = val;
				}
			}
		}
		
		

		// [END region_fillform]

		// [START region_geolocation]
		// Bias the autocomplete object to the user's geographical location,
		// as supplied by the browser's 'navigator.geolocation' object.
		function geolocate() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var geolocation = {
						lat : position.coords.latitude,
						lng : position.coords.longitude
					};
					var circle = new google.maps.Circle({
						center : geolocation,
						radius : position.coords.accuracy
					});
					autocomplete.setBounds(circle.getBounds());
				});
			}
		}

		// [END region_geolocation]

	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXo25NYFjE0gvH5qZJ3z8xDwyJla1_brU&signed_in=true&libraries=places&callback=initAutocomplete"
	async defer></script>
	
	<?php
	if (1==2) {
		
		
						if ($curLW <> $row["THWidth"]) { // just a duplicate from s previous record?
							$curLW = $row["THWidth"];
							if (trim($row["THLength"]) <> "") {
								$curLW = $curLW . " x " . $row["THLength"];
							} 						
							
							if (trim($txtTestHole) <> trim($curLW)) {
								$txtTestHole = $txtTestHole . " " . $curLW;
							}							
						}
												
						if ($curTH <> $row["THSurface"]) {	
							$curTH = $row["THSurface"];						
							if ($txtTestHoleType <> $curTH) {
								$txtTestHoleType = $txtTestHoleType . " " . $curTH;
							}
						}

						if ($row["EUType"] == $row["EUDepth"] and 
							$row["EUType"] == $row["EUSize"]) { // legacy form
							$curPublicUtilityType = $row["EUType"];
						} else {
							$curPublicUtilityType = $row["EUType"] . " (Depth " . $row["EUDepth"] . ") (size " . $row["EUSize"] . ")";
						}
						
						if ($txtPublicUtilityType <> " " . $curPublicUtilityType) {
							$txtPublicUtilityType = $txtPublicUtilityType . " " . $curPublicUtilityType;
						}
						
						
						if ($row["IUType"] == $row["IUSize"]) { // legacy form
							$curBoreSize = $row["IUType"];
						} else {
							$curBoreSize = $row["IUType"] . " (size " . $row["IUSize"] . ")";
						}
						
						if ($txtBoreSize <> " " . $curBoreSize) {
							$txtBoreSize = $txtBoreSize . " " .$curBoreSize;
						}

						If ($txtBoreDepth <> " " . $row["IUDepth"]) {
							if (trim($row["IUDepth"]) <> "") {
								if (trim($txtBoreDepth) <> "") {
									$txtBoreDepth = $txtBoreDepth . ", " . $row["IUDepth"];
								} else {
									$txtBoreDepth = $row["IUDepth"];
								}								
							}							
						}
						
						If ($txtBoreMethod <> " " . $row["IUMethod"]) {
							$txtBoreMethod = $txtBoreMethod . " " . $row["IUMethod"];
						}
						
						
						
						if ($curLW <> $row["THWidth"]) { // just a duplicate from s previous record?
							$curLW = $row["THWidth"];
							if (trim($row["THLength"]) <> "") {
								$curLW = $curLW . " x " . $row["THLength"];
							} 						
							
							if (trim($txtTestHole) <> trim($curLW)) {
								$txtTestHole = $txtTestHole . " " . $curLW;
							}							
						}
												
						if ($curTH <> $row["THSurface"]) {	
							$curTH = $row["THSurface"];						
							if ($txtTestHoleType <> $curTH) {
								$txtTestHoleType = $txtTestHoleType . " " . $curTH;
							}
						}

						if ($row["EUType"] == $row["EUDepth"] and 
							$row["EUType"] == $row["EUSize"]) { // legacy form
							$curPublicUtilityType = $row["EUType"];
						} else {
							$curPublicUtilityType = $row["EUType"] . " (Depth " . $row["EUDepth"] . ") (size " . $row["EUSize"] . ")";
						}
						
						if ($txtPublicUtilityType <> " " . $curPublicUtilityType) {
							$txtPublicUtilityType = $txtPublicUtilityType . " " . $curPublicUtilityType;
						}
						
						
						if ($row["IUType"] == $row["IUSize"]) { // legacy form
							$curBoreSize = $row["IUType"];
						} else {
							$curBoreSize = $row["IUType"] . " (size " . $row["IUSize"] . ")";
						}
						
						if ($txtBoreSize <> " " . $curBoreSize) {
							$txtBoreSize = $txtBoreSize . " " .$curBoreSize;
						}

						If ($txtBoreDepth <> " " . $row["IUDepth"]) {
							if (trim($row["IUDepth"]) <> "") {
								if (trim($txtBoreDepth) <> "") {
									$txtBoreDepth = $txtBoreDepth . ", " . $row["IUDepth"];
								} else {
									$txtBoreDepth = $row["IUDepth"];
								}								
							}							
						}
						
						If ($txtBoreMethod <> " " . $row["IUMethod"]) {
							$txtBoreMethod = $txtBoreMethod . " " . $row["IUMethod"];
						}
				}		
	?>
</body>
