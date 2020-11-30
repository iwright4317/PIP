<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>	
	
	<script>
		function isblankentry(item) {
			if (item.value == "") {
				return true;
			} else {
				return false;
			}
		}	
		
		function isblankradio(groupName) {
    		var radios = groupName;
    		for( i = 0; i < radios.length; i++ ) {
        		if( radios[i].checked ) {
            		return false;
        		}
    		}
    		return true;
		}	
		
		function isblankddl(item,blank) {
			// if (item.selectedIndex == 0) {}
			if (item[item.selectedIndex].value.trim() == blank.trim()) {
				return true;				
			} else {
				return false;				
			}
		}		

		function testemail(item) {
			//var regexp = /^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/
			var regexp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/
			var result = item.value.match(regexp);
			if (result == null) {
				return false;
			} else {
				return true;
			}
		}		
		
		function makeWhite(item) {			
        		document.getElementById(item).style.backgroundColor = "white";
		}
		
		function isValidPN(phoneNumber) {
  			var regExp = /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}/;
  			var phone = phoneNumber.value.match(regExp);
  			if (phone) {
    			return true;
  			}
  			return false;
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
//echo $_SESSION["user_id"];
if ($view || $admin || $company) {
	if ($view || $admin) {
		echo "<meta http-equiv='refresh' content='0; url=index_second.php' />";
	} else {		
		echo "<meta http-equiv='refresh' content='0; url=DNOnlineForm.php' />";
	}
} else {
?>	
	<!-- <div class="container"  style="font-size : large; font-weight: normal; background-color: white"> -->
	<div class="container" style="background-image: linear-gradient(to right, whitesmoke 50%, #9dc9ed )">
	<div id="status" style=""></div>
		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; font-weight: bold;">
				Permit Information Program - PIP
			</div>
		</div>
		
		<div class="row" style="border-bottom: 0px solid black">
			<div class="col-sm-12" style="font-size: large;">
				If you have used PIP before, please <b>Sign in</b><p>
			</div>
		</div>
		<form action=index.php method="POST">
		<div class="row" style="border-bottom: 0px solid black">
			<div class="col-sm-1" style="font-size: large; text-align: right;">				
				Email:
			</div>
			<div class="col-sm-3" style="font-size: large; text-align: left;">	
				<input id="email" name="email" placeholder="Email" type="email" style="width:100%">
			</div>
			<div class="col-sm-2" style="font-size: large; text-align: right;">
				Password:
			</div>
			<div class="col-sm-3" style="font-size: medium;">               
            	<input id="text2" name="text2" placeholder="Password" type="password" style="width:100%"><br>
            	<a href="forgot_password.php">Forgot&nbsp;password?</a>
            </div>			
			<div class="col-sm-2" style="font-size: large;">                       					                   
                &nbsp;<input class="btn btn-success" style="font-weight: bold; 32px; font-size: medium; color:white; " type="submit" name="commit" value="&nbsp;Sign&nbsp;In&nbsp;">
            </div>   
        </div> 
        </form>
		<div class="row" style="border-bottom: 2px solid black">
			<div class="col-sm-12" style="font-size: large;">	
				<b><u>OR</u></b> if you have never registered to use PIP, please use the form below:
			</div>
		</div>		 
	</div>	

	<form name="form1" method="post" action="store_user.php" onsubmit="javascript:return validateandsubmit(document.form1)">
		<div class="container" style="background-color:whitesmoke; font-size : large; font-weight: bold;">
			<div class= "row">
				<div class="col-sm-12">
			<?PHP
set_time_limit(0);

//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
			
$mod = FALSE;
$id = 0;

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

if (isset($_GET["id"])) {
	$mod = TRUE;
	$id = $_GET["id"];
}

if (isset($_POST["Id"])) {
	$mod = TRUE;
	$id = $_POST["Id"];
}
			
$admin = false;
if (!empty($_SESSION["user_id"])) { // already logged in
	$query = "Select * from Login where SecurityLevel = 3 and Id = " . $_SESSION["user_id"];
	//echo "<p> . $query";
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	if ($row = mysqli_fetch_array($result)) {
		$admin = TRUE;
	}  
}

//echo "<p>admin " . $admin;
//echo "<p>mod " . $mod;

If ($admin && $mod) { 
	?>
	<h2>Approve this PIP user</h2>
	To approve this user, check the box below and Save.<?php 
} else {
	if (!empty($_SESSION["user_id"])) { // already logged in
		if ($mod) {			
			?>
			<h2>Update your account information</h2>
			Please update the form below.<?php
		} else {
			If ($admin) {
				?>
				<h2>Register someone to use PIP</h2>
				Please complete the form below.<?php
			}
		}
	} else {
		if ($mod) {
			?>
		<h2>Please <b>Sign in</b></h2>
		<?php
		} else {
			?>
		<h2>Register to use PIP</h2>
		Please complete the form below.<?php
		}		
		
	}

}
?>
</div>
</div>

<div class= "row">
	<div class="col-sm-2">
		First&nbsp;name:
		<div class="form-group">
			<input type="text" placeholder="" class="form-control" name="FirstName" id="FirstName">
		</div>
	</div>
	<div class="col-sm-2">
		Last&nbsp;name:
		<div class="form-group">
			<input type="text" placeholder="" class="form-control" name="LastName" id="LastName">
		</div>
	</div>

	<div class="col-sm-4">
		Email address: 
		<div class="form-group">
			<input type="text" placeholder=""  class="form-control" name="regEmail" id="regEmail">				
		</div>
	</div>				
				
	<div class="col-sm-2">					
		<div class="form-group">
			Password:
			<input type="password" placeholder="" value="" class="form-control" name="passcode" id="passcode">						
		</div>
	</div>

</div>
</div>

<div class="container" style="background-color:whitesmoke;  font-size : large; font-weight: bold;">
	<div class="row">

		<div class="col-sm-3">					
			<div class="form-group">
				Phone&nbsp;#:
				<input type="text" placeholder="(xxx) xxx-xxxx" value="" class="form-control" name="phone" id="phone">						
			</div>
		</div>

		<div class="col-sm-6">
			<div class="form-group">						
				Company / Organization:
				<select onclick="makeWhite('Organization');" class="form-control" name="Organization" id="Organization">
					<option  <?php
					$query = "Select Name from Organizations order by Name  ";
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
					echo '<option>select your company or organization </option>';
																						
					while ($row = mysqli_fetch_array($result)) {
						echo '<option >' . $row[0] . '</option>';
					}
							
					$query = "Select CompanyName from Company order by CompanyName  ";
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
					echo '<option> </option>';							
																						
					while ($row = mysqli_fetch_array($result)) {
						echo '<option >' . $row[0] . '</option>';
					}
					
					$query = "SELECT `Contractor` FROM `Contractors` Order by `Contractor` ";
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
					echo '<option> </option>';							
																						
					while ($row = mysqli_fetch_array($result)) {
						echo '<option >' . $row[0] . '</option>';
					}
							
					echo '<option>my company is not listed</option>';
					?>
					</select>
							
				</div>
			</div>

		</div>
				
				
		<div class="row">
			<div class="col-sm-12">				
				<div class="form-group">					
					<input type="radio" name="OrganizationType" value="Utility Company">&nbsp;Utility&nbsp;Company
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
					<input type="radio" name="OrganizationType" value="Contractor">&nbsp;Contractor
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
					<input type="radio" name="OrganizationType" value="Government">&nbsp;Government
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							
				</div>		
			</div>		
		</div>
		
	</div>

	<div class="container" style="background-color:whitesmoke; font-size : large; font-weight: normal;">
		<div class= "row">
			<div class="col-sm-12">												
				Click the Register button.
				<br>
				<button type="submit" class="btn btn-success" >
					Register for PIP
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp; <a href=newcontent.php title="Clear the entire form and start over">Refresh form</a>
				<br/>
				After you click the <b>Register for PIP</b> button, the PIP administrator will be notified and grant you access to PIP
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
			<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=vabeachpu.com','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/vabeachpu.com" /></a>
		
			</div>
		</div>

	</div>
</div>
</form>
<?php
}
?>
</body>
</html>