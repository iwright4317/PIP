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

	<?php
	
	include ('./includes/banner.inc');

	include ('./includes/database.inc');
	//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeach_PIP") or die('I cannot connect to the database because: ' . mysqli_error());
	?>

<div class="container"  style=" font-size : large; font-weight: bold; background-color: white">
	<form class="form-horizontal" action="update.php" method="POST">
		<input type="hidden" name="subject" value="<?php echo $_GET['subject'];?>">
		<div class="row" style="">
			<div class="col-sm-12" style="font-size: x-large; font-weight: bold;">
				PIP - <?php echo $_GET['subject']; ?> Manager
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-sm-6 col-xs-12" style="outline: 1px solid blue;">		
				Add a new <?php echo $_GET['subject']; ?> :<br>
				Enter a <?php echo $_GET['subject']; ?> : <input type="text" name="txtName" ID="txtName" size="10" placeholder="">
				<?php 
				if ($_GET['subject'] == "User") { ?>	
					<div style="margin-left: 1cm;">							
	  						<div class="form-group">	
		    					<input type=radio name="UserRights" value="Full Rights"> PIP Administrator&nbsp;&nbsp;
   							</div>
   							<div class="form-group">
								<input type=radio name="UserRights" valu ="Full Rights"> Full Rights&nbsp;&nbsp;
   							</div>		
   							<div class="form-group">
   								<input type=radio name="UserRights"  value="View Only"> View Only
	        				</div> 	
	        			</div>
        				<?php 
						}
						?>
						<button>Add <?php echo $_GET['subject']; ?> </button>  
						<p>&nbsp;</p>      			
       		</div>
        		
	
			<div class="col-sm-6 col-sm-6 col-xs-12" style="outline: 1px solid blue;">
				
            <div class="col-sm-6 col-sm-6 col-xs-12 hidden-sm hidden-md hidden-lg" style="font-size: medium; background-color: #003366; height:5px;"> 
            </div>
				Remove a <?php echo $_GET['subject']; ?> :<br>
				Select a <?php echo $_GET['subject']; ?> : 
				<select name="ddlNames"  ID="ddlNames" >
					<option></option>			
					<?php	
					if ($_GET['subject'] == "User") {$q = "Select UserName from Login order by UserName ";}
					if ($_GET['subject'] == "PermitStatus") {$q = "Select Status from PermitStatus order by Status ";}
					if ($_GET['subject'] == "Technician") {$q = "Select Technician from Technician order by Technician ";}
					if ($_GET['subject'] == "Company") {$q = "Select CompanyName from Company order by CompanyName ";}
					if ($_GET['subject'] == "Contractors") {$q = "Select Contractor from Contractors order by Contractor ";}
					if ($_GET['subject'] == "ConditionMessages") {$q = "Select LetterCode, Description from ConditionMessages order by LetterCode ";}
					$r = mysqli_query($connection, $q) or die("<br/>Query failed");
					While ($row = mysqli_fetch_array($r)) {
						echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
					} //Ian's True Plumb
					?>	
    			</select>
        		<p>&nbsp;</p><button>Remove <?php echo $_GET['subject']; ?> </button>         		
				<p>&nbsp;</p>      			
			</div>		
		</div>	
	</div>        
</div>
</form>
            
			<hr style="width:17cm; align:left"/>
			<hr style="width:24cm"/>
</body>