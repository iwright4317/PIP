<?php
session_start();
?>
<head>
	<?php
	include ('./includes/js_css.inc');
	?>

	<title>MRcal | New User</title>
	
<meta name="description" content="Virginia Beach Permit Information Program New User" />


<meta name="keywords" content="Virginia Beach Permit Information Program New User" />


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
			//var regexp = /^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/
			var regexp =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/
			var result = item.value.match(regexp);
			if (result == null) {
				return false;
			} else {
				return true;
			}
		}

		function getData(dataSource, item, divID) {
			alert(dataSource);
			if (XMLHttpRequestObject) {
				var obj = document.getElementById(divID);

				dataSource = dataSource + item;
				alert(dataSource);

				XMLHttpRequestObject.open("GET", dataSource);
				XMLHttpRequestObject.onreadystatechange = function() {
					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
						eresp = XMLHttpRequestObject.responseText;
						obj.innerHTML = eresp;
						alert(eresp);
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

			if (isblankentry(theform.FirstName)) {
				alert("The First Name is blank. Please re-enter with a First Name and click the Save button again. ");
				returnval = false;
			}
			
			if (isblankentry(theform.LastName)) {
				alert("The Last Name is blank. Please re-enter with a Last Name and click the Save button again. ");
				returnval = false;
			}
			
			if (isblankentry(theform.email)) {
				alert("The email item is blank. Please re-enter with an email and click the Save button again. ");
				returnval = false;
			} else {
				if (!testemail(theform.email)) {
					alert("The email address is not valid. Please enter a valid email and click the Save button again. ");
					returnval = false; 
				}
			}		
			
			//alert(theform.Organization.options[theform.Organization.selectedIndex].value);
			if (theform.Organization.options[theform.Organization.selectedIndex].value == "select your Organization") {
				alert("Your Organization has not been selected. Please select your Organization and click the Save button again. ");
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

		});
		// end ready

		<
		script > $(function() {
			$(document).tooltip();
		});
	</script>
	<style>
		label {
			display: inline-block;
			width: 5em;
		}
	</style>

	</script>
</head>

<body >
	<?php
	include ('./includes/calbanner.inc');
	
if (isset($_POST['submit'])) {
	if (!empty($_SESSION["user_id"])) {
		extract($_POST);  		
		
		$password_string = mysqli_real_escape_string($connection, $_POST["passcode"]);
  		$password_hash = password_hash($password_string, PASSWORD_BCRYPT);  		
  		
		$query = "Update Login set 
		Passcode = '" . $password_hash . "'      
		Where Id = " . $_SESSION["user_id"];
		$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
		echo "<p>&nbsp;&nbsp;&nbsp;User updated </p>";
	}
}

	?>
	
	<form name="form1" method="post" action="" >
		<div class="container" style="font-size : large; font-weight: bold;">
			<div class= "row">
				<div class="col-sm-12">
			<?PHP
set_time_limit(0);

//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
		
include ('./includes/database2.inc');	
//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
		
if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
					
$mod = FALSE;
$id = 0;
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
	$admin = true;
}


If ($admin && $mod) { 
	echo "<h2>Update your password</h2>"; 
?>
</div>
</div>
<?php
if ($mod) {
	$query = "Select * from Login where Id = " . $id;
	$result = mysqli_query($connection,$query) or die("Query failed" . " " . $query . " " . mysql_error());
	
	if ($row = mysqli_fetch_array($result)) {
		echo '<input type="hidden" name="id" value=' . $id . '>';
	} else {
		//$mod = FALSE;
	}	
}

?>

			<div class= "row">
				<div class="col-sm-4">
					Email address: 
					<div class="form-group">
						<input type="text" placeholder=""  class="form-control" 
						<?php
						if ($mod) { echo ' value = "' . $row["UserName"] . '" ';
						} else {echo ' value = " " ';}
						?> name="regEmail">				
					</div>
				</div>

				<div class="col-sm-2">
					Password:
					<div class="form-group">
						<input type="password" placeholder="" value="" class="form-control" name="passcode">						
					</div>
				</div>
				<div class="col-sm-2">
					&nbsp;<p>
					<button type="submit" name="submit" id="submit" class="btn btn-success" >
						Save
					</button>									
				</div>
							
				</div>
				<?php
				}
				?>
	</form>
</body>