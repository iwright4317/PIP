<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>ProductsList | Home</title>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#parent_cat").change(function() {
				//$(this).after('<div id="loader"><img src="ajax-loader.gif" alt="loading subcategory" /></div>');
				$.get('loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
					$("#sub_cat").html(data);
					$('#loader').slideUp(200, function() {
						$(this).remove();
					});
				});
			});
		});
	</script>

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

	<script>
		$(function() {
			$("#datepicker").datepicker();
		});

		$(function() {
			$("#datepicker2").datepicker();
		});
	</script>
</head>
<body>

<div class="container"  style=" font-size : large; font-weight: bold; background-color: white">
	
		<div class="row" style="">
			<div class="col-sm-12" style="font-size: large; font-weight: bold;">
				Update
	<?php
	include ('./includes/banner.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
	//echo "<br>Name?" . $_POST["txtNames"] . "?";
	//echo "<br>ddlName?" . $_POST["ddlNames"] . "?";
	//echo "<br>Subject?" . $_POST['subject'] . "?";
	if (trim($_POST["ddlNames"]) <> '') {
		if (trim($_POST["subject"]) == 'User') {
			$q = "delete from Login Where UserName = '" . $_POST["ddlNames"] . "' ";	
			echo "<br>&nbsp;Action: " . $_POST["ddlNames"] . " removed.";
		}					
		if ($_POST['subject'] == "PermitStatus") {
			$q = "delete from PermitStatus Where Status = '" . $_POST["ddlNames"] . "' ";	
			echo "<br>&nbsp;Action: " . $_POST["ddlNames"] . " removed.";
		}
		if ($_POST['subject'] == "Technician") {
			$q = "delete from Technician Where Technician = '" . $_POST["ddlNames"] . "' ";	
			echo "<br>&nbsp;Action: " . $_POST["ddlNames"] . " removed.";
		}
		if ($_POST['subject'] == "Company") {
			$q = 'delete from Company Where CompanyName = "' . $_POST["ddlNames"] . '" ';
			echo "<br>&nbsp;Action: " . $_POST["ddlNames"] . " removed.";
		}	
		if ($_POST['subject'] == "Contractors") {
			$q = 'delete from Contractors Where Contractor = "' . $_POST["ddlNames"] . '" ';
			echo "<br>&nbsp;Action: " . $_POST["ddlNames"] . " removed.";
		}			
					
		//echo "<br>|" . $q . "|<br>&nbsp;Presuccess";
		$r = mysqli_query($connection, $q) or die("<br/>Query failed");
		echo "<br>&nbsp;success";
	} else {
		if (trim($_POST["txtName"]) != '') {		
			if (trim($_POST["subject"]) == 'User') {
				$q = "Insert Into Login  (UserName) values ('" . $_POST["txtName"] . "') ";
				echo "<br>&nbsp;Action: " . $_POST["txtName"] . " inserted.";
			}					
			if ($_POST['subject'] == "PermitStatus") {
				$q = "Insert Into PermitStatus (Status) values ('" . $_POST["txtName"] . "') ";
				echo "<br>&nbsp;Action: " . $_POST["txtName"] . " inserted.";
			}
			if ($_POST['subject'] == "Technician") {
				$q = "Insert Into Technician  (Technician) values ('" . $_POST["txtName"] . "') ";	
				echo "<br>&nbsp;Action: " . $_POST["txtName"] . " inserted.";
			}
			if ($_POST['subject'] == "Company") {
				$q = "Insert Into Company (CompanyName) values ('" . str_replace("'","''",$_POST["txtName"]) . "') ";
				echo "<br>&nbsp;Action: " . $_POST["txtName"] . " inserted.";
			}			
			if ($_POST['subject'] == "Contractors") {
				$q = "Insert Into Contractors (Contractor) values ('" . str_replace("'","''",$_POST["txtName"]) . "') ";
				echo "<br>&nbsp;Action: " . $_POST["txtName"] . " inserted.";
			}		
					
			//echo "<br>|" . $q . "|<br>&nbsp;Presuccess";
			$r = mysqli_query($connection, $q) or die("<br/>Query failed");
			echo "<br>Status:&nbsp;success";
		} else {
			echo "<br>None value entered";
		}
	}
echo '&nbsp;<p><b><a href="administrator.php?subject=' . $_POST['subject'] . '">Continue</a></b>';
?>

			</div>
		</div>
	</div>
</body>
</html>