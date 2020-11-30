<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | UVA </title>

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
	</script>
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	?>
	<div class="container" style="font-size: normal; ">
		<div class="row">
			<div class="col-sm-12" style="font-size: x-large; ">
				Edit Condition Message
			</div>
		</div>				
		<div class="row">
			<div class="col-sm-12" style="font-size: large; ">
				<a href="EditConditionMessages.php?Id=new">New Condition Message</a>
			</div>
		</div>				
		<div class="row">
			<?php
			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIPtest") or die('I cannot connect to the database because: ' . mysqli_error($connection));
			
			$NewStore = FALSE;

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack
			
			if (isset($_POST["btnStore"])) {
				if (isset($_POST["Delete"])) {
					$q = "Delete From ConditionMessages Where Id = " . $_GET["Id"];
				} else {
				if ($_GET["Id"] <> "new") {
					$q = "Update ConditionMessages set LetterCode = '" . $_POST['LetterCode'] 
					. "', NumberCode = '" . $_POST['NumberCode'] . "', Description = '" .
					$_POST['Description'] . "' Where Id = " . $_GET["Id"];
				} else {					
					$q = "Insert into ConditionMessages (LetterCode, NumberCode, Description) 
					values ('" . $_POST['LetterCode'] . "', '" . $_POST['NumberCode'] . 
					"', '" . $_POST['Description'] . "') ";
				}
				}
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q . ": " . mysqli_error($connection));
				$NewStore = TRUE;
			}
			$q = "SELECT * FROM `ConditionMessages` order by `NumberCode`";			
			
			if (isset($_GET["Id"]) and !$NewStore) {
				if ($_GET["Id"] <> "new") {$q = "SELECT * FROM `ConditionMessages` Where Id = " . $_GET["Id"];}
				echo '<form action="EditConditionMessages.php?Id=' . $_GET["Id"] . '" method="POST">';
				echo 'Make changes and click the Save button';
			} else {
				echo 'To edit, click on a letter code';
			}
			
			?>			
			
			<div class="row" style="background-color: #afeeee">
				<div class="col-sm-1" >
					Letter Code
				</div>
				<div class="col-sm-1" >
					Number Code
				</div>
				<div class="col-sm-10" >
					Description
				</div>
			</div>
			<?php
			
			//if ($_GET["Id"] <> "new" or $NewStore) {
				
			if ((isset($_GET["Id"]) && $_GET["Id"] <> "new") || 
			(!isset($_GET["Id"])) || 
			(isset($NewStore) && $NewStore)) {			
						
				$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q . ": " . mysqli_error($connection));
				while ($row = mysqli_fetch_array($r)) { ?>

					<div class="row" style="background-color: whitesmoke; border-top-style: solid; border-width: 1px">
    	            <?php 
    	            if (!isset($_GET["Id"]) or $NewStore) { ?>
	    	            <div class="col-sm-1" >
    	    	        	<a href="EditConditionMessages.php?Id=<?php echo $row["Id"] . '">' . $row["LetterCode"] . '</a>';?>
            		    </div>
                		<div class="col-sm-1" >
                			<?php echo $row["NumberCode"];?>
		                </div>
    		            <div class="col-sm-10" >
        		        	<?php echo $row["Description"];?>
            		    </div>  
                	<?php
					} else { ?>					
		                <div class="col-sm-1" >
    		            	<input type="text" style="width:100%" name="LetterCode" 
    		            	value="<?php echo $row["LetterCode"] . '">';?>
            		    </div>
                		<div class="col-sm-1" >                	
                			<input type="text" style="width:100%" name="NumberCode" 
                			value="<?php echo $row["NumberCode"] . '">';?>
	    	            </div>
    	    	        <div class="col-sm-10" >
        	    	    	<textarea rows="3" style="width:100%" name="Description"><?php echo $row["Description"];?></textarea>
	            	    </div> 
						<?php
					}          				                             
                	echo '</div>';                         
				}            
			} else {
				?>					
	            <div class="col-sm-1" >
   	            	<input type="text" style="width:100%" name="LetterCode" 
   	            	value="<?php echo $row["LetterCode"] . '">';?>
           	    </div>
               	<div class="col-sm-1" >                	
               		<input type="text" style="width:100%" name="NumberCode" 
               		value="<?php echo $row["NumberCode"] . '">';?>
   	            </div>
       	        <div class="col-sm-10" >
           	    	<textarea rows="3" style="width:100%" name="Description"><?php echo $row["Description"];?></textarea>
	            	   
                </div> 
			<?php
			}
            if (isset($_GET["Id"])) { 
            	if ($_GET["Id"] <> "new") {echo '<input type="checkbox" name="Delete" value="on"> Delete this Condition Message<br>';} ?>
            	<button type="submit" class="btn btn-success" name="btnStore" id="submit" >
					Store
				</button>
            	</form>
            	<?php
			}
			?>
   		</div>
	</div>
</body>
</html>
