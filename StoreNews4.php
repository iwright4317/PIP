<?php
session_start();
?>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Vineyard Mid-Atlantic Regional Churches Store Content</title>

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
	?>

	<div class="container">
		<h2>Vineyard Mid-Atlantic Region Add Content</h2>
	</div><!-- /.container -->

	<?PHP
	set_time_limit(0);

	$connection = mysql_connect("localhost", "vmarch5_ecomm", "bobcatalina66") or die('I cannot connect to the database because: ' . mysql_error());
	$dbc = mysql_select_db("vmarch5_ecommercerw") or die("<p>DB select failed ||<p>" . mysql_error());

	// Select member info from the database

	$from_email = "";
	if ($_SESSION["user_id"] <> "") {
		$q = "Select Email   from VMAR_users Where Id = " . $_SESSION["user_id"] . "  ";
		$r = mysql_query($q) or die("<br/>Query failed");

		if ($row = mysql_fetch_array($r)) {
			$from_email = $row[0];
		}
	}

	echo "<p>Sending email:<i><u><b> " . $from_email . "</b></u></i><p>";

	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers = "Content-type: text/html\r\n";
	$headers = "Content-type: text/html";

	$headers = 'From: ' . $from_email . "\r\n" . "Content-type: text/html\r\n" . 'X-Mailer: PHP/' . phpversion();

	$ndescription = strip_tags($_REQUEST["description"], '<p><a>');
	$ndescription = str_replace("\n", "<br>", $ndescription);
	$ndescription = str_replace("\\", "", str_replace('"', '', str_replace("'", "", $ndescription)));

	$TName = $row['FirstName'] . " " . $row['LastName'];

	$today = date("Y-n-j");
	$today = date("Y-m-d H:i:s");

	mysql_close($connection);

	$connection = mysql_connect("localhost", "vmarch5_ecomm", "bobcatalina66") or die('I cannot connect to the database because: ' . mysql_error());
	$dbc = mysql_select_db("vmarch5_ecommercerw") or die("<p>DB select failed ||<p>" . mysql_error());

	$title = strip_tags($_REQUEST["title"]);
	$title = str_replace('"', '', $title);
	$title = str_replace("'", "", $title);

	$title = str_replace("\\", "", str_replace('"', '', str_replace("'", "", $_REQUEST["title"])));

	$query = "Insert Into VMAR_content (
		SubmitDate, Title, Category, Description, Submitter, Content1) values  (
		'" . $today . "',
		'" . $title . "', 
		'" . $_REQUEST["category"] . "', 
		'" . $ndescription . "',
		'" . $_REQUEST["uploadedfile"] . "',
		'" . $_REQUEST["webaddress"] . "' )";

	echo "<p>" . $query . "</p>";

	$result = mysql_query($query) or die("Query failed" . " " . $query . " " . mysql_error());

	$query = "Select * from VMAR_users ";

	mysql_close($connection);

	$connection = mysql_connect("localhost", "vmarch5_ecomm", "bobcatalina66") or die('I cannot connect to the database because: ' . mysql_error());
	$dbc = mysql_select_db("vmarch5_ecommercerw") or die("<p>DB select failed ||<p>" . mysql_error());

	$query = "Select * from VMAR_users Where email is not Null";

	$result = mysql_query($query) or die("Query failed" . " " . $query . " " . mysql_error());

	echo "<p>Processing records  ";

	while ($row = mysql_fetch_array($result)) {

		#$row = mysql_fetch_array($result);

		$Id = $row['id'];

		$description = "<html><body><br>News Category: <b>" . $CategoryText . "</b>
		<p>title: <b>" . $title . "</b>
		<p>Description: <b>" . $ndescription . "</b>
		<p>Sent by:<br>Email: 
		<a href=mailto:" . $from_email . ">" . $from_email . "</a> 
		<br>Name: " . $TName;

		echo "<p>" . $description . "</p>";

		If ($_REQUEST["uploadedfile"] != "") {
			$description = $description . "<p><b>
			<a href=\"http://vabeachpu.com/uploads/" . $_REQUEST["uploadedfile"] . "\" target=_blank>View attached file</b></a>";
		}

		If ($_REQUEST["webaddress"] != "") {
			$description = $description . "<p><b>
			<a href=\"" . $_REQUEST["webaddress"] . "\" target=_blank>Click to view web page</b></a>";
		}

		$description = $description . "</body></html>";

		$mail_to = $row['iwright_TNewsemail'];

		if ($row = mysql_fetch_array($result)) {
			$mail_to = $mail_to . "," . $row['iwright_TNewsemail'];
		}

		mail($mail_to, "VMAR - " . $title, $description, $headers);
		echo "<img src=darkgrey1x1.gif width=1 height=10>";
		ob_end_flush();
	}

	mysql_close($connection);
	?>
	</td>
	</tr>
	</table>

	</body>
	</html>
