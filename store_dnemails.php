<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>ProductsList | Edit DN Emails</title>

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

	<?php
	include ('./includes/banner.inc');

	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error($connection));?>
	<div class="container"  style="font-size : large; font-weight: bold; background-color: white">

	<div class="row">
	<div class="col-md-12" style="font-size: x-large; font-weight: bold;">
	PIP - Edit Daily Notification Email list...
	</div>
	</div>

	<div class="row">
	<hr />
	</div>

	<div class="row">
		<div class="col-md-12">
			
			<?php
			$q = 'update DNEmails set EMails = "' . $_POST["demails"] . '"';
			$r = mysqli_query($connection, $q) or die("<br/>Query failed<br>" . $q . "<br>" . mysqli_error($connection));
			
        	?>
        	<p>Daily notification emails updated...
		</div>			
	</div>	
	</div>
        
</form>
            
</body>