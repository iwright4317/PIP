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

		function testemail(item) {
			var regexp = /^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/
			var result = item.value.match(regexp);
			if (result == null) {
				return false;
			} else {
				return true;
			}
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
			if (isblankentry(theform.regEmail)) {
				$txtStatus = $txtStatus + "<br>The <b> Email address:</b> item is blank. Please re-enter with an email and click the Save button again. ";
				document.getElementById("regEmail").style.backgroundColor = "yellow";
				returnval = false;
			} else {
				if (!testemail(theform.regEmail)) {
					$txtStatus = $txtStatus + "<br>The  <b> Email address:</b> item is not valid. Please enter a valid email and click the Save button again. ";
					document.getElementById("regEmail").style.backgroundColor="yellow";
					returnval = false; 
				} else {
					document.getElementById("regEmail").style.backgroundColor="white";
				}
			}				
			
			if (isblankentry(theform.phone)) {
				$txtStatus = $txtStatus + "<br>The <b> Phone #:</b> item is blank. Please re-enter with an email and click the Save button again. ";
				document.getElementById("phone").style.backgroundColor = "yellow";
				returnval = false;
			} else {
				if (!isValidPN(theform.phone)) {
					$txtStatus = $txtStatus + "<br>The <b> Phone #:</b> item is not valid. Please re-enter with an email and click the Save button again. ";
					document.getElementById("phone").style.backgroundColor = "yellow";
					returnval = false;
				} else {
						document.getElementById("phone").style.backgroundColor="white";
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

?>	
	<!-- <div class="container"  style="font-size : large; font-weight: normal; background-color: white"> -->
	<div class="container" style="background-image: linear-gradient(to right, whitesmoke 50%, #9dc9ed )">
	<div id="status" style=""></div>
		<div class="row">
			<div class="col-sm-12" style="font-size: xx-large; font-weight: bold;">
				Permit Information Program - PIP
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12" style="font-size: x-large; font-weight: bold;">
				Change password
			</div>
		</div>	
		
	<?php
	
// If it's a POST request, user has already entered thier password -> need to process
$GBOK = true;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Validate the email address: 
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	
		// Check for the existence of that email address...
		$q = 'SELECT id FROM Login WHERE UserName="' . $_POST['email'] . '"'; 
		
		
		$q = "Select UserName, Id, SecurityLevel, Passcode from Login 
		Where UserName = '" . $_POST['email'] . "'  ";
			
			//echo '<br>q: ' . $q;
		$r = mysqli_query($connection,$q) or die("<br/>Query failed - 18" . $q);

		if ($row = mysqli_fetch_array($r)) {
			$password_string = $_POST['OldPW'];
			$password_hash =  $row["Passcode"];
			$Id = $row["Id"];
			if (password_verify($password_string, $password_hash)) {
				if ($_POST['NewPW1'] == $_POST['NewPW2']) {					
					$p = $_POST['NewPW1'] ;
					$password_hash = password_hash($p, PASSWORD_DEFAULT);
					$q = "UPDATE Login SET Passcode='" .  $password_hash . "' WHERE UserName='". $_POST['email'] . "'"; 		
					$r = mysqli_query($connection, $q) or die("Query failed" . " " . $q . " " . mysql_error());
					echo 'You have successfully updated your PIP password';
				} else {
					echo 'new password does not match re-entered new password';	
				}
			}
		} else {
			echo 'email address not found';
		}	
		
		
		
	} else { // No valid address submitted.
		echo '<p>Please enter a valid email address!';
		$GBOK = false;
	} // End of $_POST['email'] IF.
		
	

} // End of the main Submit conditional.

// Need the form functions script, which defines create_form_input():
?>
<p><b>This page allows you to change your PIP user password</b></p>

<p><b>Please complete the form below and click the Set Password button. </p>	

<form action="forgot_password.php" method="post" accept-charset="utf-8">
	<p><b>Email&nbsp;Address:</b><br />
		<input type="text" id="email" name="email">
	<p><b>Old password:</b><br />
		<input type="text" id="OldPW" name="OldPW">
	<p><b>New password:</b><br />
		<input type="text" id="NewPW1" name="NewPW1">
	<p><b>Re-enter new password:</b><br />
		<input type="text" id="NewPW2" name="NewPW2">
	<p>
	<input type="submit" name="submit_button" value="Set Password &rarr;" id="submit_button" class="formbutton" />
</form>

<?php
//}
?>
</div>
</body>
</html><?php

// This page is used to change an existing password.
// Users must be logged in to access this page.
// This script is created in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Include the header file:
$page_title = 'Change Your Password';
include ('./includes/header.html');

// Require the database connection:
require (MYSQL);

// For storing errors:
$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
	// Check for the existing password:
	if (!empty($_POST['current'])) {
		$current = mysqli_real_escape_string ($connection, $_POST['current']);
	} else {
		$pass_errors['current'] = 'Please enter your current password!';
	}
	
	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($connection, $_POST['pass1']);
		} else {
			$pass_errors['pass2'] = 'Your password did not match the confirmed password!';
		}
	} else {
		$pass_errors['pass1'] = 'Please enter a valid password!';
	}
	
	if (empty($pass_errors)) { // If everything's OK.
	
		// Check the current password:
		$q = "SELECT id FROM users WHERE pass='"  .  get_password_hash($current) .  "' AND id={$_SESSION['user_id']}";	
		
		$r = mysqli_query ($connection, $q);
		if (mysqli_num_rows($r) == 1) { // Correct
			
			// Define the query:
			$q = "UPDATE users SET pass='"  .  get_password_hash($p) .  "' WHERE id={$_SESSION['user_id']} LIMIT 1";	
			if ($r = mysqli_query ($connection, $q)) { // If it ran OK.

				// Send an email, if desired.

				// Let the user know the password has been changed:
				echo '<h3>Your password has been changed.</h3>';
				include ('./includes/footer.html'); // Include the HTML footer.
				exit();

			} else { // If it did not run OK.

				trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

			}

		} else {
			
			$pass_errors['current'] = 'Your current password is incorrect!';
			
		} // End of current password ELSE.   

	} // End of $p IF.
	
} // End of the form submission conditional.

// Need the form functions script, which defines create_form_input():
require ('./includes/form_functions.inc.php');
?><h3>Change Your Password</h3>
<p>Use the form below to change your password.</p>
<form action="change_password.php" method="post" accept-charset="utf-8">
	<p><label for="pass1"><strong>Current Password</strong></label><br /><?php create_form_input('current', 'password', $pass_errors); ?></p>
	<p><label for="pass1"><strong>New Password</strong></label><br /><?php create_form_input('pass1', 'password', $pass_errors); ?> <small>Must be between 6 and 20 characters long, with at least one lowercase letter, one uppercase letter, and one number.</small></p>
	<p><label for="pass2"><strong>Confirm New Password</strong></label><br /><?php create_form_input('pass2', 'password', $pass_errors); ?></p>
	<input type="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="formbutton" />
</form>

<?php // Include the HTML footer:
include ('./includes/footer.html');
?>