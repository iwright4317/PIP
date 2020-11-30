<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>	
	<script>
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

		function validateandsubmit(theform) {
			var returnval = true;
        	$txtStatus = "";		
        	if (isblankentry(theform.FirstName)) {
        		$txtStatus = $txtStatus + 
        		"<br>The <b>First Name:</b> item is blank. " +
        		"Please your first name and click the Save button again. ";
				document.getElementById("FirstName").style.backgroundColor = "yellow";
				returnval = false;
			} else {				
        		document.getElementById("FirstName").style.backgroundColor = "white";
        	}				
        	if (isblankentry(theform.LastName)) {
        		$txtStatus = $txtStatus + 
        		"<br>The <b>Last Name:</b> item is blank. " +
        		"Please your Last name and click the Save button again. ";
				document.getElementById("LastName").style.backgroundColor = "yellow";
				returnval = false;
			} else {
        			document.getElementById("LastName").style.backgroundColor = "white";
        	}					
        			
			if (isblankentry(theform.regEmail)) {
				$txtStatus = $txtStatus + "<br>The <b> Email address:</b> item is blank. Please re-enter with an email and click the Save button again. ";
				document.getElementById("regEmail").style.backgroundColor = "yellow";
				returnval = false;
			} else {				
				document.getElementById("regEmail").style.backgroundColor = "white";
				if (!testemail(theform.regEmail)) {
					$txtStatus = $txtStatus + 
					"<br>The  <b> Email address:</b> item is not valid. " +
					"Please enter a valid email and click the Save button again. ";
					document.getElementById("regEmail").style.backgroundColor="yellow";
					returnval = false; 
				}
			}				
						
        	if (isblankentry(theform.passcode)) {
        		$txtStatus = $txtStatus + 
        		"<br>The <b>Password:</b> item is blank. " +
        		"Please enter your password and click the Save button again. ";
				document.getElementById("passcode").style.backgroundColor = "yellow";
				returnval = false;
			} else {
        			document.getElementById("passcode").style.backgroundColor = "white";
        	}	
        	
        	if (isblankddl(theform.Organization,"select your company or organization ")) {
        		$txtStatus = $txtStatus + 
        		"<br>The <b>Organization:</b> item is blank. " +
        		"Please select your Organization and click the Save button again. ";
				document.getElementById("Organization").style.backgroundColor = "yellow";
				returnval = false;
			} else {
        		document.getElementById("Organization").style.backgroundColor = "white";
        	}	        	
        	
        	if (isblankradio(theform.OrganizationType)) {
        		$txtStatus = $txtStatus + 
        		"<br>The <b>organization type </b> (Utility, Contractor, or Government) item is blank. " +
        		"Please select your organization type and click the Save button again. ";
				//document.getElementById("OrganizationType").style.backgroundColor = "yellow";
				returnval = false;
			} else {
        		//document.getElementById("OrganizationType").style.backgroundColor = "white";
        	}	       	        				
			
			if (isblankentry(theform.phone)) {
				$txtStatus = $txtStatus + 
				"<br>The <b> Phone #:</b> item is blank. " +
				"Please enter your phone number and click the Save button again. ";
				document.getElementById("phone").style.backgroundColor = "yellow";
				returnval = false;
			} else {
				document.getElementById("phone").style.backgroundColor="white";
				if (!isValidPN(theform.phone)) {
					$txtStatus = $txtStatus + 
					"<br>The <b> Phone #:</b> item is not valid. " +
					"Please re-enter phone number in the format (xxx) xxx-xxxx and click the Save button again. ";
					document.getElementById("phone").style.backgroundColor = "yellow"; 
					returnval = false;
				}
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
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#permit_number").change(function() {
				$.get('loadLocation.php?permit_number=' + $(this).val(), function(data) {
					document.getElementById("StreetAddress").innerHTML='<b>' + data + '</b>';
				});
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
				
			});
		});
	</script>	
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#permit_number").change(function() {
				if (document.getElementById("permit_number").value == "Emergency") {
					document.getElementById("epermit").style.visibility="visible"; 
				} else {
					document.getElementById("epermit").style.visibility="hidden"; 
				}
			});
		});
	</script>
	<title>PUNews | Home</title>

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
//echo $_SESSION["user_id"];
if (empty($_SESSION["user_id"])) {
	echo "<meta http-equiv='refresh' content='0; url=index_second.php' />";
} else {
?>	
<!-- <div class="container"  style="font-size : large; font-weight: normal; background-color: white"> -->
<div class="container" style="background-image: linear-gradient(to right, whitesmoke 50%, #9dc9ed )">
	<div id="status" style=""></div>
	<div class="row">
		<div class="col-sm-12" style="font-size: xx-large; font-weight: bold;">
			PIP - Edit user record
		</div>
	</div>		
</div>

<div class="container" style="background-color:whitesmoke;  font-size : large; font-weight: bold;">
<form name="form1" method="post" action="new_user.php" onsubmit="javascript:return validateandsubmit(document.form1)">
	<div class= "row" style="border-bottom: 1px solid black">	
		<div class="col-sm-4">						
			Email:
			<select  class="form-control" name="Email" id="Email">
<?php										
echo '<option>select UserName  </option>';				

	$query = "Select UserName from Login order by UserName   ";
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	
	While ($row = mysqli_fetch_array($result)) {													
		echo '<option >' . $row['UserName'] . '</option>';
	}
?>
			</select>						
		</div>
	</div>
	<div class= "row">
		<div class="col-sm-12">		
			<br>
			<button type="submit" name="submit" id="submit" value="submit" class="btn btn-success" >
				Select user
			</button>
		</div>
	</div>
	<div class= "row">
		<div class="col-sm-12">	
			&nbsp;
		</div>
	</div>
	
	<div class= "row">
		<div class="col-sm-12">	
			<table border=1 width=100%>
				<tr><th style="font-size: x-Large" colspan=6>Administrators</th></tr>
			
				<tr>
					<th>User</th><th>Security</th><th>Last Login</th>
					<th>Organization</th><th>Org. Type</th><th>Authorized</th>
				</tr>
	<?php 
	$query = "Select * from Login Where SecurityLevel = 3 order by UserName   ";
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	
	While ($row = mysqli_fetch_array($result)) {													
		echo '<tr>';
			echo '<td><a href="new_user.php?Id='.$row['Id'].'">' . $row['UserName'] . '</a></td>';
			echo '<td>' . $row['SecurityLevel'] . '</td>';
			echo '<td>' . $row['LastLogin'] . '</td>';
			echo '<td>' . $row['Organization'] . '</td>';
			echo '<td>' . $row['OrganizationType'] . '</td>';
			echo '<td>' . $row['Authorized'] . '</td>';
															
		echo '</tr>';
	}
			?>
			
			<tr><th colspan=6>&nbsp;</th></tr>
				<tr><th style="font-size: x-Large"colspan=6>View all, except Diary</th></tr>
			
				<tr>
					<th>User</th><th>Security</th><th>Last Login</th>
					<th>Organization</th><th>Org. Type</th><th>Authorized</th>
				</tr>
	<?php 
	$query = "Select * from Login Where SecurityLevel = 2 order by UserName   ";
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	
	While ($row = mysqli_fetch_array($result)) {													
		echo '<tr>';
			echo '<td><a href="new_user.php?Id='.$row['Id'].'">' . $row['UserName'] . '</a></td>';
			echo '<td>' . $row['SecurityLevel'] . '</td>';
			echo '<td>' . $row['LastLogin'] . '</td>';
			echo '<td>' . $row['Organization'] . '</td>';
			echo '<td>' . $row['OrganizationType'] . '</td>';
			echo '<td>' . $row['Authorized'] . '</td>';
															
		echo '</tr>';
	}
			?>
			<tr><th colspan=6>&nbsp;</th></tr>
				<tr><th style="font-size: x-Large" colspan=6>Daily Notification only</th></tr>
			
				<tr>
					<th>User</th><th>Security</th><th>Last Login</th>
					<th>Organization</th><th>Org. Type</th><th>Authorized</th>
				</tr>
	<?php 
	$query = "Select * from Login Where SecurityLevel = 1 order by UserName   ";
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	
	While ($row = mysqli_fetch_array($result)) {													
		echo '<tr>';
			echo '<td><a href="new_user.php?Id='.$row['Id'].'">' . $row['UserName'] . '</a></td>';
			echo '<td>' . $row['SecurityLevel'] . '</td>';
			echo '<td>' . $row['LastLogin'] . '</td>';
			echo '<td>' . $row['Organization'] . '</td>';
			echo '<td>' . $row['OrganizationType'] . '</td>';
			echo '<td>' . $row['Authorized'] . '</td>';
															
		echo '</tr>';
	}
			?>
			</table>
		</div>
	</div>
</form>
</div>
</body>
<?php
} ?>
</html>