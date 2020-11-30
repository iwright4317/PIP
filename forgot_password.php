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

If (isset($_SESSION['user_id'])) {
	echo "<meta http-equiv='refresh' content='0; url=index.php' />";
}
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
				Forgot password
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
		
		$r = mysqli_query ($connection,$q);
		
		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r); 
		} else { // No database match made.
			echo '<p>The submitted email address does not match those on file!';
			$GBOK = false;
		}
		
	} else { // No valid address submitted.
		echo '<p>Please enter a valid email address!';
		$GBOK = false;
	} // End of $_POST['email'] IF.
	
	function get_password_hash($password) {
	
	// Need the database connection:
	//global $dbc;
	
	// Return the escaped password:
	return mysqli_real_escape_string ($connection, hash_hmac('sha256', $password, 'c#haRl891', true));
	
	} // End of get_password_hash() function.
	
	
	
	if ($GBOK) { // If everything's OK.

		// Create a new, random password:
		$p = substr(md5(uniqid(rand(), true)), 15, 15);
		$p = 'passcode';
		$password_hash = password_hash($p, PASSWORD_DEFAULT);
		// Update the database:
		$q = "UPDATE Login SET Passcode='" .  $password_hash . "' WHERE UserName='". $_POST['email'] . "'"; 
		
		//echo '<p>' . $q . ' (' . $p . ')</p>';
		
		$r = mysqli_query($connection, $q) or die("Query failed" . " " . $q . " " . mysql_error());
			
		if (1 == 1) { // If it ran OK.
		
			#echo "<p>'$q:'<br>email: " . mysqli_real_escape_string ($dbc, $_POST['email']) . "<br>password='$p'";
			// Send an email:
			$body = "Your password has been reset to login to PIP. Your password is now: $p . Please log in to PIP using this password and this email address. Then you may change your password to something more familiar.";
			mail ($_POST['email'], 'PIP - Your password has been reset.', $body);
			
			// Print a message and wrap up:
			echo '<h3>Your password has been reset.</h3><p>You will receive an email to login to PIP. Once you have logged in with this new password, you may change it by clicking on the "Change Password" link.</p>';
			//include ('./includes/footer.html');
			exit(); // Stop the script.
			
		} else { // If it did not run OK.
	
			trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

		}

	} // End of $uid IF.

} // End of the main Submit conditional.

// Need the form functions script, which defines create_form_input():
?>
<p><b>This page allows you to reset your PIP user password</b></p>

<?php
If (isset($_SESSION['user_id'])) {
	echo "You have already registered and logged into this web site";

} else {	
?>

<p><b>Please enter your email address below and click the Reset Password button. </p>	

<form action="forgot_password.php" method="post" accept-charset="utf-8">
	<p><label for="email"><strong>Email&nbsp;Address:</strong></label><br />
		<input type="text" id="email" name="email">
	<input type="submit" name="submit_button" value="Reset Password &rarr;" id="submit_button" class="formbutton" />
</form>

<?php
}
?>
</div>
</body>
</html>