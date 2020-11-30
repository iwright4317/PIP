<?php
session_start();
?>
<head>
	<link rel="shortcut icon" href="http://www.VMARchurches.com/favicon.ico?v=2" />

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Vineyard Mid-Atlantic Regional Churches</title>

	<script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
	<script src="bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>

	<!-- Bootstrap -->
	<link href="bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="bootstrap-3.3.4-dist/css/bootstrap.css" rel="stylesheet"> -->
	<!-- Bootstrap theme -->
	<!-- The link below  causes the theme from bootswatch to not work -->
	<!-- <link href="bootstrap-3.3.4-dist/css/bootstrap-theme.min.css" rel="stylesheet"> -->
	<!-- Custom styles for this template -->
	<link href="theme.css" rel="stylesheet">

	<!-- popcorn.js not doing anything for us -->
	<!-- <script src="js/popcorn-complete.min.js"></script>
	<script src="popcorn.capture-master/src/popcorn.capture.js"></script> -->
	
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
	$_SESSION['user_id'] = null;
	$_SESSION['user_name'] = null;

	?>

<div id="fb-root"></div>
	<script>
		( function(d, s, id) {
				var js,
				    fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
	</script>
	
	<div class="container">
		<h2>Vineyard Mid-Atlantic Region -
		<?php
		if (isset($_GET['cat']) or isset($_POST['cat'])) {
			if (isset($_GET['cat']))
				$cat = $_GET['cat'];
			if (isset($_POST['cat']))
				$cat = $_POST['cat'];
			echo $cat . ' items';
		} else {
			echo 'Search';
		}
		?></h2>
	</div><!-- /.container -->

	<div class="container" style="font-size : large; font-weight: bold;">
		<form   class="navbar-form"  action="search.php"  method="POST">
			<!-- <input type="hidden" name="cat" value="<?php echo $cat; ?>"> -->
			Search:
			<input type="text"  class="form-control" name="search_text"  title="Enter a keyword or phrase to be used to search content.">
			<button type="submit" class="btn btn-success"   title="Search for current and future events and annoucements.">
				search
			</button>
			<button type="submit" class="btn btn-success" value="Show historical items" name="submit_button"   title="Search for current, future events and annoucements and past events and annoucements.">
				Show historical items too
			</button>
		</form>
	</div>
	<?php
//$connection = mysql_connect("localhost", "vmarch5_ecomm", "bobcatalina66") or die('I cannot connect to the database because: ' . mysql_error());
//$dbc = mysql_select_db("vmarch5_ecommercerw") or die("<p>DB select failed ||<p>" . mysql_error());
if (isset($_GET['Id']) && trim($_GET['Id']) <> "" && !is_numeric($_GET['Id']) ) {exit;} // might be a hack
if (isset($_GET['id'])) {
	$query = "Select * from VMAR_content Where Id = " . $_GET['id'];
} else {
	$query = "SELECT * FROM `VMAR_content` ";
	$strWhere = " Where ";
	$strAnd = "";
	if (isset($_POST['search_text']) && trim($_POST['search_text']) <> '') {
		$query = $query . $strWhere . " (`Submitter` LIKE '%" . $_POST['search_text'] . "%' or 
		`Title` LIKE '%" . $_POST['search_text'] . "%' or 
		`Category` LIKE '%" . $_POST['search_text'] . "%' or 
		`Description` LIKE '%" . $_POST['search_text'] . "%' or 
		`Content1` LIKE '%" . $_POST['search_text'] . "%')  "; 
		$strWhere = "";
		$strAnd = " and ";
	} else {
		if (isset($cat)) {
		$query = $query . $strWhere . "`Category` LIKE '%" . $cat . "%'  "; 
		$strWhere = "";
		$strAnd = " and ";
		}
	}
	if (trim($_POST['submit_button']) <> "Show historical items") {
		$query = $query . $strWhere . $strAnd . " EventDate >= '" . date(Y) . "-" . date(m) . "-" .date(d) . "' ";
	}
}

$query = $query . ' order by EventDate ';

//echo "<p>" . $query . "</p>";

$result = mysql_query($query) or die("Query failed" . " " . $query . " " . mysql_error());

$title_color = "#c2c9cf";
$item_color = "AliceBlue";
$srcposter = './images/poster.jpg';

while ($row = mysql_fetch_array($result)) {
	if (isset($row['Content1']) && trim($row['Content1']) <> '') {
		$file1 = './archive/' . $row['Content1'];
		$mime1 = mime_content_type($file1);
		if (!strstr($mime1, "audio/") && !strstr($mime1, "video/") && !strstr($mime1, "image/")) {
			$file1Type = "text";
		} else { $file1Type = "media"; 	} 
	} else {$file1Type = ""; }
	
	if (isset($row['Content2']) && trim($row['Content2']) <> '') {
		$file2 = './archive/' . $row['Content2'];
		$mime2 = mime_content_type($file2);
		if (!strstr($mime2, "audio/") && !strstr($mime2, "video/") && !strstr($mime2, "image/")) {
			$file2Type = "text";
		} else { $file2Type = "media"; 	} 
	} else {$file2Type = ""; }
	
	if (isset($row['Content3']) && trim($row['Content3']) <> '') {
		$file3 = './archive/' . $row['Content3'];
		$mime3 = mime_content_type($file3);
		if (!strstr($mime3, "audio/") && !strstr($mime3, "video/") && !strstr($mime3, "image/")) {
			$file3Type = "text";
		} else { $file3Type = "media"; 	} 
	} else {$file3Type = ""; }
	
	if (isset($row['Content4']) && trim($row['Content4']) <> '') {
		$file4 = './archive/' . $row['Content4'];
		$mime4 = mime_content_type($file4);
		if (!strstr($mime4, "audio/") && !strstr($mime4, "video/") && !strstr($mime4, "image/")) {
			$file4Type = "text";
		} else { $file4Type = "media"; 	} 
	} else {$file4Type = ""; }
	
	if (isset($row['Content5']) && trim($row['Content5']) <> '') {
		$file5 = './archive/' . $row['Content5']; 
		$mime5 = mime_content_type($file5);
		if (!strstr($mime5, "audio/") && !strstr($mime5, "video/") && !strstr($mime5, "image/")) {
			$file5Type = "text";
		} else { $file5Type = "media"; 	} 
	} else {$file5Type = ""; }
	
	?>
	<div class="container" >
	<div class="col-md-12" style="height: 1; background-color:black">&nbsp;</div>
	<?php echo '<div class= "row" style="background-color:' . $title_color . ' ">'; ?>
	<div class="col-md-12" style="font-size : x-large">
	<?php echo '<b>' . $row['Title'] . ' </b>'; ?>
	</div>
	</div>

	<?php echo '<div class= "row" style="background-color:' . $item_color . '">'; ?>
	<div class="col-md-3" style="font-size : large">
	<?php
		echo '<a href=search.php?id=' . $row['Id'] . '> View Comments </a><br/>';
		echo 'From: <b>' . $row['Submitter'] . '</b><br/>';
	?>
	<br>
	<?php

	if (isset($row['webaddress']) && trim($row['webaddress']) <> '') {
		echo '<b><a href="' . $row['webaddress'] . '"  title="Click here to see a web site with more information" target=_blank>More information</a></b><br/>';
	}
	echo 'Event date: <b>' . ScrubDate($row['EventDate']) . '</b><br/>';
	echo 'Post date: <b>' . ScrubDate($row['SubmitDate']) . '</b><br/>';
	echo '<a href="newcontent.php?id=' . $row['Id'] . '"   title="Click here to edit this content item.">edit</a>';
	?>
	</div>
	<?php
	if ($file1Type == "media" or $file2Type == "media" or $file3Type == "media" or $file4Type == "media" or $file5TypeType == "media") {
		echo '<div class="col-md-6" style="font-size : large">';
	} else {
		echo '<div class="col-md-9" style="font-size : large">';
	}
 ?>
	<?php echo 'Catgeory: <b>' . $row['Category'] . '</b>'; ?>
	<p>
	<?php echo 'Description: <b>' . $row['Description'] . '</b>'; ?>
	
	<?php

	if ($file1Type == "text") {
		echo '</p><div style="font-size : large"><a href="' . $file1 . '" target=_blank  title="Click here to see a document with more information"> Please click here for more information </a></div></p>';
	}
	if ($file2Type == "text") {
		echo '</p><div style="font-size : large"><a href="' . $file2 . '" target=_blank title="Click here to see a document with more information"> Please click here for more information </a></div></p>';
	}
	if ($file3Type == "text") {
		echo '</p><div style="font-size : large"><a href="' . $file3 . '" target=_blank  title="Click here to see a document with more information"> Please click here for more information </a></div></p>';
	}
	if ($file4Type == "text") {
		echo '</p><div style="font-size : large"><a href="' . $file4 . '" target=_blank  title="Click here to see a document with more information"> Please click here for more information </a></div></p>';
	}
	if ($file5Type == "text") {
		echo '</p><div style="font-size : large"><a href="' . $file5 . '" target=_blank  title="Click here to see a document with more information"> Please click here for more information </a></div></p>';
	}
	?>
	</div>
<?php
if ($file1Type == "media" or $file2Type == "media" or $file3Type == "media" or 
	$file4Type == "media" or $file5Type == "media") {
	?>
	<div class="col-md-3">	
		
	<?php
	if (isset($mime1)) {
		if (strstr($mime1, "video/")) {
			echo '<video  poster="' . $srcposter . '" controls  width="250" height="200">
			<source src="' . $file1 . '" type="' . $mime1 . '"></video>';
			//echo '<iframe src="//player.vimeo.com/video/130378115" width="250" height="HEIGHT" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		if (strstr($mime1, "image/")) {
			echo '<a href="' . $file1 . '" target=_blank  title="Click here to see the full-sized image"><img src="' . $file1 . '" class="img-thumbnail" alt="' . $file1 . '" ></a>';
		}
	}

	if (isset($mime2)) {
		if (strstr($mime2, "video/")) {
			echo '<video  poster="' . $srcposter . '" controls  width="250" height="200">
			<source src="' . $file2 . '" type="' . $mime2 . '"></video>';
		}
		if (strstr($mime2, "image/")) {
			echo '<a href="' . $file2 . '" target=_blank><img src="' . $file2 . '" class="img-thumbnail" alt="' . $file2 . '" ></a>';
		}
	}

	if (isset($mime3)) {
		if (strstr($mime3, "video/")) {
			echo '<video  poster="' . $srcposter . '" controls  width="250" height="200">
			<source src="' . $file3 . '" type="' . $mime3 . '"></video>';
		}
		if (strstr($mime3, "image/")) {
			echo '<a href="' . $file3 . '" target=_blank><img src="' . $file3 . '" class="img-thumbnail" alt="' . $file3 . '" ></a>';
		}
	}

	if (isset($mime4)) {
		if (strstr($mime4, "video/")) {
			echo '<video  poster="' . $srcposter . '" controls  width="250" height="200">
			<source src="' . $file4 . '" type="' . $mime4 . '"></video>';
		}
		if (strstr($mime4, "image/")) {
			echo '<a href="' . $file4 . '" target=_blank><img src="' . $file4 . '" class="img-thumbnail" alt="' . $file4 . '" ></a>';
		}
	}

	if (isset($mime5)) {
		if (strstr($mime5, "video/")) {
			echo '<video  poster="' . $srcposter . '" controls  width="250" height="200">
			<source src="' . $file5 . '" type="' . $mime5 . '"></video>';
		}
		if (strstr($mime5, "image/")) {
			echo '<a href="' . $file5 . '" target=_blank><img src="' . $file5 . '" class="img-thumbnail" alt="' . $file5 . '" ></a>';
		}
	}
	$file1Type = '';
	$file2Type = '';
	$file3Type = '';
	$file4Type = '';
	$file5Type = '';
	$file1 = '';
	$file2 = '';
	$file3 = '';
	$file4 = '';
	$file5 = '';
	$mime1 = '';
	$mime2 = '';
	$mime3 = '';
	$mime4 = '';
	$mime5 = '';

	}
	?>
	</div>
	</div>
	</div>

	<?php
	if ($title_color == "#c2c9cf") {
		$title_color = "#e6d7c0";
		$item_color = "PapayaWhip";
	} else {
		$title_color = "#c2c9cf";
		$item_color = "AliceBlue";
	}
	}
	function ScrubDate($ADate) {
	//2016-05-20 -> 05/162016
	return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
	}

	if (isset($_GET['id'])) {
	$path =  "http://" . $_SERVER['SERVER_NAME']  .  $_SERVER['PHP_SELF'] . "?" .  $_SERVER['QUERY_STRING'];
		?>	
		<div class="fb-comments" data-href="<?php echo $path; ?>" data-numposts="5" data-colorscheme="light"></div>
		<?php
			}
	?>

</body>
