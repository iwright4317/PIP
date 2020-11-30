<?php
session_start();
?>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>PIP User Manager</title>

	<link href="/video-js.css" rel="stylesheet">
	<script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
	<script src="bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>

	<!-- Bootstrap -->
	<link href="bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="theme.css" rel="stylesheet">


</head>
<body>

<?php
include ('./includes/banner.inc');

if (!isset($_POST["passcode"])) {
	echo "<meta http-equiv='refresh' content='0; url=index.php' />";
	exit;
}

?>

	<div class="container">
		<h2>PIP User Information </h2>
	</div><!-- /.container -->

	<div class="container" style="font-size : large; ">
		<div class="row">
			<div class="col-md-12">

				<?PHP
	set_time_limit(0);

	$db = True;
	$db = False;
	
	$mod = FALSE;
	$id = 0;

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
	
	if (isset($_GET["id"])) { $id = $_GET["id"];	}
	if (isset($_GET["Id"])) { $id = $_GET["Id"];	}
	if (isset($_POST["id"])) { $id = $_POST["id"];	}
	if (isset($_POST["Id"])) { $id = $_POST["Id"];	}
	if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"];	}
	if (isset($_REQUEST["Id"])) { $id = $_REQUEST["Id"];	}

	if (isset($_POST['delete']) && $_POST['delete'] == 'yes') {
		//echo "Delete record <br>";

		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
		
		if ($id > 0) {
			$query = "Delete from Login where Id = " . $id;
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
			
			echo "<p>Record deleted </p>";
			if ($db) {echo "<br>" . $query;}
		}
		
		
	} else {// not delete - Add or modify
		
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
		$admin = false;
		$SecurityLevel = 0;
		$Authorized = "no";
		
		if (!empty($_SESSION["user_id"])) {
			$query = "Select * from Login where Id = " . $_SESSION["user_id"];
			//echo "<p>Check to see if you are an admin" . $query . "</p>";
			
			if ($db) {echo "<br>" . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());

			if ($row = mysqli_fetch_array($result)) {
				if ($row["SecurityLevel"] == 3) {
					$admin = TRUE; 
				}
				$SecurityLevel = $row["SecurityLevel"];
				$Authorized = $row["Authorized"];
			} else { 
			}
		} 
		//echo "<br>: admin: " . $admin;
	
		// Select member info from the database		
		$existing = false;
		$password_string = mysqli_real_escape_string($connection, $_POST["passcode"]);
  		$password_hash = password_hash($password_string, PASSWORD_BCRYPT);
		
		$OrganizationType = "";
		If (isset($_POST["OrganizationType"])) {$OrganizationType = $_POST["OrganizationType"];}
		
		
		$Organization = "";
		If (isset($_POST["Organization"])) {$Organization = $_POST["Organization"];}
		If (isset($_POST["approve"])) {$Authorized = $_POST["approve"];}
  			
		if ($id > 0) {

			echo "<b>Update user information</b>";

			$password_string = mysqli_real_escape_string($connection, $_POST["passcode"]);
  			$password_hash = password_hash($password_string, PASSWORD_BCRYPT);

  			$USecurityLevel = 1;
			//echo "<br>sl: " . $_POST['level'];
  			if (isset($_POST['viewonly']) && $_POST['viewonly'] == 'yes') {
  				$USecurityLevel = 2;
			}
  			if (isset($_POST['administrator']) && $_POST['administrator'] == 'yes') {
  				$USecurityLevel = 3;
			}
						
  			//$USecurityLevel = 1;
  			if (isset($_POST['level']) && $_POST['level'] == 'viewonly') {
  				$USecurityLevel = 2;
			}
  			if (isset($_POST['level']) && $_POST['level'] == 'administrator') {
  				$USecurityLevel = 3;
			}
			
			
			if (isset($_POST['SecurityLevel'])) {echo "<br>sl: " . $_POST['SecurityLevel']; }
  			if (isset($_POST['SecurityLevel']) && $_POST['SecurityLevel'] == '2') {
  				$USecurityLevel = 2;
			}
  			if (isset($_POST['SecurityLevel']) && $_POST['SecurityLevel'] == '3') {
  				$USecurityLevel = 3;
			}
			
  				
			if ($admin) {
				if (trim($_POST["passcode"]) <> "") {
					$query = "Update Login set 
						email = '" . $_POST["regEmail"] . "',
						UserName = '" . $_POST["regEmail"] . "',
						FirstName = '" . $_POST["FirstName"] . "',
						LastName = '" . $_POST["LastName"] . "',
						Organization = '" . $Organization . "',
						Passcode = '" . $password_hash . "', 
						Phone = '" . $_POST["phone"] . "', 
						Authorized = '" . $Authorized . "', 
						SecurityLevel = '" . $USecurityLevel . "', 
						OrganizationType = '" . $OrganizationType . "'  
						Where Id = " . $id;
				} else {				
					$query = "Update Login set 
						email = '" . $_POST["regEmail"] . "',
						UserName = '" . $_POST["regEmail"] . "',
						FirstName = '" . $_POST["FirstName"] . "',
						LastName = '" . $_POST["LastName"] . "',
						Organization = '" . $Organization . "',
						Authorized = '" . $Authorized . "', 
						SecurityLevel = '" . $USecurityLevel . "', 
						Phone = '" . $_POST["phone"] . "', 
						OrganizationType = '" . $OrganizationType . "'  
						Where Id = " . $id;
				}
			} else {
				if (trim($_POST["passcode"]) <> "") {
					$query = "Update Login set 
						email = '" . $_POST["regEmail"] . "',
						UserName = '" . $_POST["regEmail"] . "',
						FirstName = '" . $_POST["FirstName"] . "',
						LastName = '" . $_POST["LastName"] . "',
						Organization = '" . $Organization . "',
						Passcode = '" . $password_hash . "', 
						SecurityLevel = '" . $USecurityLevel . "', 
						Phone = '" . $_POST["phone"] . "', 
						OrganizationType = '" . $OrganizationType . "'   
						Where Id = " . $id;
				} else {					
					$query = "Update Login set 
						email = '" . $_POST["regEmail"] . "',
						UserName = '" . $_POST["regEmail"] . "',
						FirstName = '" . $_POST["FirstName"] . "',
						LastName = '" . $_POST["LastName"] . "',
						Organization = '" . $Organization . "', 
						SecurityLevel = '" . $USecurityLevel . "', 
						Phone = '" . $_POST["phone"] . "', 
						OrganizationType = '" . $OrganizationType . "'    
						Where Id = " . $id;
				}
			}
				
			if ($db) {echo "<br>" . $query;}
			$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());
			echo "<p>User updated </p>";
			
			if (isset($_POST["approve"]) && $admin && $_POST["approve"] == "yes") {
										
				$description = "	You have been approved as a PIP web site user. Please go to PIP.VaBeachPU.com and login.";
				$mail_to = $_POST["regEmail"];			
				$headers = "";			
				$title = "You have been approved to use PIP";
				
				if (!isset($_POST['nosend'])) {
					mail($mail_to, "PIP - " . $title, $description, $headers);					
					echo "<p>" . $_POST["FirstName"] . " " . $_POST["LastName"] . " has been notified as an approved PIP user.  ";
					//ob_end_flush();
				}
			} else {
				
			}									

		} else {
			
			// Preparing to insert a new user, first check email does not already exist
			if (isset($_POST["regEmail"])) {
				$query = "Select Id from Login Where email = '" . $_POST["regEmail"] . "'";		
				if ($db) {echo "<br>" . $query;}
				$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
				if ($row = mysqli_fetch_array($result)) {
					echo 'You are already registered. If you want your password reset, click the Forgot password link:<p>';
					echo '<a href=forgot_password.php>Forgot password</a>';
				} else {
			
					$query = "Insert Into Login (UserName, 
						email, FirstName, LastName, Organization, Phone, 
						OrganizationType, Passcode) values  (
						'" . $_POST["regEmail"] . "',
						'" . $_POST["regEmail"] . "',
						'" . $_POST["FirstName"] . "',
						'" . $_POST["LastName"] . "',
						'" . $Organization . "',
						'" . $_POST["phone"] . "',
						'" . $OrganizationType . "',
						'" . $password_hash . "') ";

				
					if ($db) {echo "<br>" . $query;}

					$id = 0;
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysqli_error($connection));
			
					//mysqli_close($connection);

					echo "<p>Thank you for your PIP user request. Your new user information has been saved.";
		

					// run code below for both modify or add
					//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
		
					$query = "SELECT * FROM `Login` where `email` = '" . $_POST["regEmail"] . "'";

					if ($db) {echo "<br>" . $query;}
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());

					if ($row = mysqli_fetch_array($result)) {
						$id = $row['Id'];
					}
					//mysqli_close($connection);

					$description = "The following person as requested to be a PIP user: 
New user: " . $_POST["FirstName"] . " " . $_POST["LastName"] . "
Email: " . $_POST["regEmail"]  . "
Phone: " . $_POST["phone"]  . "
Organization: " . $Organization . "
OrganizationType = " . $OrganizationType . "
Please click the link to approve or disapprove this user: http://" .	
					$_SERVER['SERVER_NAME'] . "/new_user.php?id=" . $id;	
					//http://PIP.VaBeachPU.com/new_user.php?id=" . $id;

					$description = " " . $description . "	 ";
					//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error());
		
					$query = "Select * from Login where UserManager = 'yes' ";
				
					if ($db) {echo "<br>" . $query;}
					$result = mysqli_query($connection, $query) or die("Query failed" . " " . $query . " " . mysql_error());

					if (isset($_POST["regEmail"])) {
					while ($row = mysqli_fetch_array($result)) {
						$mail_to = $row['email'];	
						echo "<p>mail_to: " . $mail_to . "</p>";
				
						$headers = 'From: ' . $_POST["regEmail"]  . "\r\n" . 
						"Content-type: text/html\r\n" . 
						'X-Mailer: PHP/' . phpversion();				
			
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers = "Content-type: text/html\r\n"; 
						$headers = "Content-type: text/html"; 
						$headers = "Content-type: text/html\r\n"; 
						$headers  = 'MIME-Version: 1.0' . "\r\n";

						$headers = "";

						$headers = "From: wrighthouse4@msn.com\r\n" . 
						"Content-type: text/html\r\n" . 
						"X-Mailer: PHP/" . phpversion();		
						$headers = "";
			
						$title = "New user request";
			
						if (!isset($_POST['nosend'])) {
							mail($mail_to, "PIP - " . $title, $description, $headers);
						}
						echo "<p>You will receive a response soon from the PIP Administrator concerning your PIP user request. 
						You will not be able to login to PIP until you receive a response from the PIP administrator but, 
						please use the PIP web site to view already posted information. .";
						//ob_end_flush();
						echo '<b>' . $description;
			
						echo '<script type="text/javascript">
 		          		window.location = "http://pip.vabeachpu.com/RegThanks.php"
			      		</script>';
			
						}
					}
				}
			}
		}
	}
	mysqli_close($connection);	
	?>
		</div>
	</div>
</div>
<?php

function ScrubDate($ADate) {
	// 05-16-2016
	return substr($ADate, 6, 4) . "-" . substr($ADate, 0, 2) . "-" . substr($ADate, 3, 2);
}
?>
</body>
