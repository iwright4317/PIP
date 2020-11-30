<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | Table Search </title>

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
	
	<script>
		function MoveCriteria(action) {
			if (action == "1tS") {
				var Aitem = document.getElementById('ddlAvailableCriteria[]').value;
				if (Aitem == '') {
					alert('No Criteria Available item has been selected. Please select an item and try again.');
				} else {				
				
	        		var opt = document.createElement("option");   
		    	    document.getElementById("ddlSelectedCriteria[]").options.add(opt);	    	    
	    		    opt.text = Aitem;
    	    		opt.value = Aitem;       	    	
	    	    
	    	    // trash?
		    	    var country = document.getElementById('ddlAvailableCriteria[]');
					country.options[country.options.selectedIndex].selected = true;
    		    //
    		    
					var i;
					for(i=document.getElementById('ddlAvailableCriteria[]').length-1;i>=0;i--)
					{
						if(document.getElementById('ddlAvailableCriteria[]').options[i].selected)
						document.getElementById('ddlAvailableCriteria[]').remove(i);
					}							
				
					var i;
					for(i=document.getElementById('ddlSelectedCriteria[]').length-1;i>=0;i--)
					{
						document.getElementById('ddlSelectedCriteria[]').options[i].selected = true;
					}				
				}
    	   }
    	   
    	   
			if (action == "1tA") {
				var Sitem = document.getElementById('ddlSelectedCriteria[]').value;
        		var opt = document.createElement("option");  
	    	    document.getElementById("ddlAvailableCriteria[]").options.add(opt);
	    	    opt.text = Sitem;
    	    	opt.value = Sitem;   
    	    	
				var i;
				for(i=document.getElementById('ddlSelectedCriteria[]').length-1;i>=0;i--)
				{
					if(document.getElementById('ddlSelectedCriteria[]').options[i].selected)
					document.getElementById('ddlSelectedCriteria[]').options[0] = null;
				}
				
    	   }
    	   
    	   if (action == "AlltS") {  
    			var Adropdown = document.getElementById('ddlAvailableCriteria[]');
    			var AlengthDropDown = Adropdown.length;
    			    	   		
    			for (var i=0; i < AlengthDropDown; i++) {  
    				var Aitem = Adropdown[i].value;
        			var opt = document.createElement("option");        
	    	    	document.getElementById("ddlSelectedCriteria[]").options.add(opt);
	    	    	opt.text = Aitem;
    	    		opt.value = Aitem;        		
    			}   		    			
    			 			
				
    	    	var Fields = document.getElementById('ddlAvailableCriteria[]').length;
				var i = 0;
				Fields = Fields - 0;
				while (i < Fields) 		
				{
					//alert(i + ' - ' + document.getElementById('ddlAvailableCriteria[]').options[0].text);
					document.getElementById('ddlAvailableCriteria[]').options[0] = null;
					i = i + 1;						
				}				
					
    		}
    		
    		
    	   if (action == "AlltA") {   
    			var Adropdown = document.getElementById('ddlSelectedCriteria[]');
    			var AlengthDropDown = Adropdown.length;
    			
    	   		
    			for (var i=0; i < AlengthDropDown; i++) {  
    				var Aitem = Adropdown[i].value;
        			var opt = document.createElement("option");        
	    	    	document.getElementById("ddlAvailableCriteria[]").options.add(opt);
	    	    	opt.text = Aitem;
    	    		opt.value = Aitem;        		
    			}   		    			
    			 			
				
    	    	var Fields = document.getElementById('ddlSelectedCriteria[]').length;
				var i = 0;
				Fields = Fields - 0;
				while (i < Fields) 		
				{
					//alert(i + ' - ' + document.getElementById('ddlSelectedCriteria[]').options[0].text);
					document.getElementById('ddlSelectedCriteria[]').options[0] = null;
					i = i + 1;						
				}				
					
    		}
    		UpdateCriteria();			
        }
    
	</script>
	
	
	<script>
		function MoveField(action) {
			//alert(action);
			if (action == "1tS") {
				var Aitem = document.getElementById('ddlAvailableFields').value;
        		var opt = document.createElement("option");   
	    	    document.getElementById("ddlSelectedFields[]").options.add(opt);
	    	    opt.text = Aitem;
    	    	opt.value = Aitem;   
    	    	    	    	
				var i;
				for(i=document.getElementById('ddlAvailableFields').length-1;i>=0;i--)
				{
					if(document.getElementById('ddlAvailableFields').options[i].selected)
					document.getElementById('ddlAvailableFields').remove(i);
				}
				
				
				var i;
				for(i=document.getElementById('ddlSelectedFields[]').length-1;i>=0;i--)
				{
					document.getElementById('ddlSelectedFields[]').options[i].selected = true;
				}	
					
    	   }
    	   
    	   
			if (action == "1tA") {
				var Sitem = document.getElementById('ddlSelectedFields[]').value;
        		var opt = document.createElement("option");   
	    	    document.getElementById("ddlAvailableFields").options.add(opt);
	    	    opt.text = Sitem;
    	    	opt.value = Sitem;   
    	    	
    	    	var Fields = document.getElementById('ddlSelectedFields[]').length;
				var i = 0;
				Fields = Fields - 1;
				while (i < Fields) 		
				{
					if(document.getElementById('ddlSelectedFields[]').options[i].selected) {
						document.getElementById('ddlSelectedFields[]').options[i] = null;						
					} else {
						i = i + 1;
					}										
				}
				
				
				var i;
				for(i=document.getElementById('ddlSelectedFields[]').length-1;i>=0;i--)
				{
					document.getElementById('ddlSelectedFields[]').options[i].selected = true;
				}	
				
    	   }
    	   
    	   if (action == "AlltS") {   
    	   		//alert('start Allts');
    			var Adropdown = document.getElementById('ddlAvailableFields');
    			var AlengthDropDown = Adropdown.length;
    			for (var i=0; i < AlengthDropDown; i++) {  
    				var Aitem = Adropdown[i].value;
        			var opt = document.createElement("option");        
	    	    	document.getElementById("ddlSelectedFields[]").options.add(opt);
	    	    	opt.text = Aitem;
    	    		opt.value = Aitem;        		
    			}   		    			
    			 	
				var i;
				for(i=document.getElementById('ddlAvailableFields').length-1;i>=0;i--)
				{					
					document.getElementById('ddlAvailableFields').remove(i);
				}	    
				
				
				var i;
				for(i=document.getElementById('ddlSelectedFields[]').length-1;i>=0;i--)
				{
					document.getElementById('ddlSelectedFields[]').options[i].selected = true;
				}	
							
    		}
    		
    		
    	   if (action == "AlltA") {   
    			var Adropdown = document.getElementById('ddlSelectedFields[]');
    			var AlengthDropDown = Adropdown.length;
    			for (var i=0; i < AlengthDropDown; i++) {  
    				var Aitem = Adropdown[i].value;
        			var opt = document.createElement("option");        
	    	    	document.getElementById("ddlAvailableFields").options.add(opt);
	    	    	opt.text = Aitem;
    	    		opt.value = Aitem;        		
    			}   		    			
    			 	
				var i;
				for(i=document.getElementById('ddlSelectedFields[]').length-1;i>=0;i--)
				{					
					document.getElementById('ddlSelectedFields[]').remove(i);
				}	    			
    		}
    		
    		UpdateFields();
       }
    
	</script>
	
	<script>
	
		var ActiveRanges = []; // global array
		
		function MakeRange(iTarget) {
			ActiveRanges[iTarget] = 1;			
			UpdateCriteria();				
		}
		
		
		function RemoveRange(iTarget) {
			ActiveRanges[iTarget] = 0;			
			UpdateCriteria();				
		}
		
	</script>
	
	<script>
		function UpdateCriteria() {
					
			var theDiv = document.getElementById("divCriteria");			
			var theDivCF = document.getElementById("divCFields");
    		var Fields = document.getElementById('ddlSelectedCriteria[]').length;
			theDiv.innerHTML = '<b>Criteria... (' + Fields + '):</b><br>';
			var i;
    		for (var i=0; i < Fields; i++) {  
				var Sfield = document.getElementById('ddlSelectedCriteria[]').options[i].value;
				
				theDiv.innerHTML = theDiv.innerHTML + '&nbsp;' + 
				Sfield.replace(/`/g,"") + ':&nbsp;<input type="text" name="criteria' + i + '">&nbsp;';
				
				//document.getElementById('ddlSelectedCriteria[]').options[i].value + '">&nbsp;';				
				
				theDivCF.innerHTML = theDivCF.innerHTML + 
				'<input type="hidden" name="hcriteria' + i + '" value="' + 
				document.getElementById('ddlSelectedCriteria[]').options[i].value + '">';
				
        		if (ActiveRanges[i] == 1) {       
		          	theDiv.innerHTML = theDiv.innerHTML + 
		          	' to <input type="text" name="' + 
		          	document.getElementById('ddlSelectedCriteria[]').options[i].value + 'High">';
          
		          	theDivCF.innerHTML = theDivCF.innerHTML + 
		          	'<input type="hidden" name="criteria' + i + '" value="' + 
		          	document.getElementById('ddlSelectedCriteria[]').options[i].value + 'High">';
          
          
		          	theDiv.innerHTML = theDiv.innerHTML + 
		          	'<button type="button" onclick="RemoveRange(' + i + ');">remove range</button>&nbsp;';                    
                            
		        } else {          
          
		          	theDiv.innerHTML = theDiv.innerHTML + 
	          		'<button type="button" onclick="MakeRange(' + i + ');">make range</button>&nbsp;';
                    
	        	}        						
			}						
		}
	</script>
	
	
	<script>
		function UpdateFields() {
			var theDiv = document.getElementById("divFields");
    		var Fields = document.getElementById('ddlSelectedFields[]').length;
			theDiv.innerHTML = '<b>Report Fields (' + Fields + '):</b><br>';

			if (1 == 1) {
			var i;
    		for (var i=0; i < Fields; i++) {  
				var Sfield = document.getElementById('ddlSelectedFields[]').options[i].value;				
				theDiv.innerHTML = theDiv.innerHTML + "&nbsp;" + Sfield + "&nbsp;|";					
			}	
			//theDiv.innerHTML = theDiv.innerHTML + ""; 
			}					
		}
	</script>
	
	<script>		
		function validateandsubmit() {
			var returnval = true;	
			var ListCount = document.getElementById('ddlSelectedFields[]').length;
			if (ListCount == 0) {				
				alert("No report fields have been selected. Please re-enter with a title and click the Save button again. ");
				returnval = false;
			}
			return returnval;	
		}
	</script>
	
</head>
<body>
	<?php
	include ('./includes/banner.inc');
	
	$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
	
	$query = "SELECT WorkSketch, Id, PermitNumber FROM `PIP` Where WorkSketch is not Null and WorkSketch <> ''  Order by WorkSketch ";
	$r = mysqli_query($connection,$query) or die("<br/>Query failed");	
	?>
	
	<div class="container" style="font-size: normal; background-color: whitesmoke">
		<div class="row" style="font-size:medium; font-weight: bold; ">
			<div class="col-sm-12" style="font-size: x-large; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
				Check for missing files
			</div>
		</div>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-12 " style="font-size:large; font-weight: bold; outline: 0px solid blue;">	
				WorkSketch files
			</div>
		</div>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				File not found
			</div>
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				Permit
			</div>
		</div>
	<?php
	$nf = 0;	
	$count = 0;				
	while ($row = mysqli_fetch_array($r)) {
									
		If (!file_exists('archive/' . $row[0])) { ?>			
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo $row[0]; ?>
			</div>
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo "<a href=http://pip.vabeachpu.com/NewEdit.php?Id=" . $row["Id"] . ">" . $row["PermitNumber"] . "</a>"; ?>	
			</div>
		</div>	<?php
			$nf++;
		}
		$count = $count + 1;
	}
	echo "<p>WorkSketch Count: " . $count . ", not found: " . $nf . "&nbsp;<p>";
	
	if (1 == 1) {
	$strSQL = "SELECT PermitDocuments, Id, PermitNumber  from `PIP` Where PermitDocuments is not Null and PermitDocuments <> ''  Order by PermitDocuments";
	$result = mysqli_query($connection,$strSQL);
	$count = 0; ?>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-12 " style="font-size:large; font-weight: bold; outline: 0px solid blue;">	
				Permit Documents files
			</div>
		</div>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				File not found
			</div>
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				Permit
			</div>
		</div>
		<?php
	$nf = 0;
	while ($row = mysqli_fetch_array($result) ){
		If (!file_exists('archive/' . $row[0])) {
			?>			
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo $row[0]; ?>
			</div>
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo "<a href=http://pip.vabeachpu.com/NewEdit.php?Id=" . $row["Id"] . ">" . $row["PermitNumber"] . "</a>"; ?>	
			</div>
		</div>	<?php
			$nf++;
		}
		$count = $count + 1;
	}
	echo "<p>PermitDocuments Count: " . $count . ", not found: " . $nf . "&nbsp;<p>";
	}
	
	
	if (1 == 1) {
	$strSQL = "SELECT Addendum1, Id, PermitNumber from `PIP` Where Addendum1 is not Null and Addendum1 <> '' Order by Addendum1 desc";
	$result = mysqli_query($connection,$strSQL);
	$count = 0;	?>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-12 " style="font-size:large; font-weight: bold; outline: 0px solid blue;">	
				Addendum1 files
			</div>
		</div>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				File not found
			</div>
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				Permit
			</div>
		</div>
		<?php
	$nf = 0;
	while ($row = mysqli_fetch_array($result) ){
		If (!file_exists('archive/' . $row[0])) {
			?>			
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo $row[0]; ?>
			</div>
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo "<a href=http://pip.vabeachpu.com/NewEdit.php?Id=" . $row["Id"] . ">" . $row["PermitNumber"] . "</a>"; ?>	
			</div>
		</div>	<?php
			$nf++;
		}
		$count = $count + 1;
	}
	echo "<p>Addendum1 Count: " . $count . ", not found: " . $nf . "&nbsp;<p>";
	}
	
	
	if (1 == 1) {
	$strSQL = "SELECT Addendum2, Id, PermitNumber from `PIP` Where Addendum2 is not Null and Addendum2 <> '' Order by Addendum2 desc";
	$result = mysqli_query($connection,$strSQL);
	$count = 0;?>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-12 " style="font-size:large; font-weight: bold; outline: 0px solid blue;">	
				Addendum2 files
			</div>
		</div>
	
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				File not found
			</div>
			<div class="col-sm-3 " style="font-size:medium; font-weight: bold; border-bottom: 1px solid blue;">
				Permit
			</div>
		</div>
		<?php
	$nf = 0;
	while ($row = mysqli_fetch_array($result) ){
		If (!file_exists('archive/' . $row[0])) {
			?>			
		<div class="row" style="outline: 0px solid red;">
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo $row[0]; ?>
			</div>
			<div class="col-sm-3 " style="outline: 1px solid blue;">
				<?php
				echo "<a href=http://pip.vabeachpu.com/NewEdit.php?Id=" . $row["Id"] . ">" . $row["PermitNumber"] . "</a>"; ?>	
			</div>
		</div>	<?php
			$nf++;
		}
		$count = $count + 1;
	}
	echo "<p>Addendum2 Count: " . $count . ", not found: " . $nf . "&nbsp;<p>";
	}
	?>
	</div>
</body>
</html>