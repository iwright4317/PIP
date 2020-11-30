<?php
session_start();
?>

<head>
	<?php
	include ('./includes/js_css.inc');
	?>
	<title>PIP | UVA </title>

	<script>
		function deleteLine(Id,location,PIPId) {
			var txt;
			//var location;
			//location = document.getElementById("location" + Id).value;
			var r = confirm("Are you sure you want to this utility crossing " + location + " ?");
			if (r == true) {
 			   txt = "You pressed OK!";
 			   window.location = "http://PIP.vabeachpu.com/UtilityVerificationApplication.php?PIPId=" + PIPId + "&chkDeleteUVA=on&UVAId=" + Id;
			} else {
    			txt = "You pressed Cancel!";
			}	
		}
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
	</script>	
	
	<script>
	$(document).ready(function()
	{
    	$('#auto').autocomplete(
	    {
    	    source: "searchCompany.php",
    	   	minLength: 1
    	});
	});	
	</script>	
	
	<script>
	$(document).ready(function()
	{
    	$('#auto2').autocomplete(
	    {
    	    source: "searchSupervisor.php",
        	minLength: 1
    	});
	});	
	</script>		
		
</head>
<body>
<?php
include ('./includes/banner.inc');	
	
function SQLDate($ADate) {			
	$date = date_create($ADate);
	return date_format($date , "Y-m-d") ; 	
}
								
$db = True;	
$db = FALSE;	
//$NewUtility = False;
			
if ($db) {echo "checking for PIPId (arrive via permit search)";}
// PIPId
$PIPId = 0;
if (isset($_GET["PIPId"])) {
if (trim($_GET["PIPId"]) <> "") {
	$PIPId = $_GET["PIPId"];
}
}

if (isset($_POST["PIPId"])) {
if (trim($_POST["PIPId"]) <> "") {
	$PIPId = $_POST["PIPId"];
}
}

if ($db) {echo "<br>PIPId: " . $PIPId . "?";}


// Find UVAId
if ($db) {echo "<br>Checking for UVAId (arrive via UVA search?)";}
$UVAId = 0;
if (isset($_GET["UVAId"])) {
if (trim($_GET["UVAId"]) <> "") {
	$UVAId = $_GET["UVAId"];
}
}

if (isset($_POST["UVAId"])) {
if (trim($_POST["UVAId"]) <> "") {
	$UVAId = $_POST["UVAId"];
}
}

if ($db) {echo "<br>UVAId: " . $UVAId . "?";}

if (isset($_GET["Id"]) && trim($_GET['Id']) <> "" && !is_numeric($_GET["Id"]) ) {exit;} // might be a hack

If ($PIPId <> 0) { 
	if ($db) {echo "<br>just have Permit Id to work with";}
	$q = "Select Id from UtilityVerificationApplication 
	Where PermitId = " . $PIPId . ' order by LocationAddress';
		if ($db) {echo '<br>' . $q;}	
	
	$r = mysqli_query($connection, $q) or die("<br/>Query failed (5445): " . $q . mysqli_error($connection));
	If ($row = mysqli_fetch_array($r)) {
		if ($UVAId == 0) {$UVAId = $row[0];}
		if (isset($_GET["Id"])) {
			$lnkViewAll = "UVAViewall.php?UVAId=" . $_GET["Id"];
		} else {
			$lnkViewAll = "UVAViewall.php";
		}
		
	}
	if ($db) {echo "<br>Now we might have a UVAId if there is already a UVA for this permit: " . $UVAId;}
	
	if ($PIPId <> 0) {
		if ($db) {echo "<br>Retreive permit info";}
		$q = "Select * from  PIP  
		Where Id = " . $PIPId;

		if ($db) {echo '<br>' . $q;}
		$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q . "<br>" . mysqli_error($connection));
		
		If ($row = mysqli_fetch_array($r)) {
			if ($db) {echo "<br>Found permit record";}
			//$txtLocation = $row["LocationDescription"];
			$txtLocation = "";
			$txtPermitAddress = $row["PermitAddress"];
			$txtCompany = $row["CompanyName"];		
			$txtTechnician = $row["Technician"];
			$PIPId = $row["Id"];		
			$txtPermitNumber = $row["PermitNumber"];
		}	
	}	
	
}

if ($UVAId <> 0) {
	$lnkPrinterVersion = "UVAPrint2.php?UVAId=" . $UVAId;
}


// Find UVACUsId
if ($db) {echo "<br>Check for UVACUsId (a particular crossing)";}
$UVACUsId = 0;
if (isset($_GET["UVACUsId"])) {
if (trim($_GET["UVACUsId"]) <> "") {
	$UVACUsId = $_GET["UVACUsId"];
}
}

if (isset($_POST["UVACUsId"])) {
if (trim($_POST["UVACUsId"]) <> "") {
	$UVACUsId = $_POST["UVACUsId"];
}
}

if ($db) {echo "<br>UVACUsId: " . $UVACUsId;}

if ($db) {echo "<br>Check for action: ";}
if (isset($_GET["action"])) {
	if ($db) {echo "<br>action: " . $_GET["action"];}
if (trim($_GET["action"]) == "NewUVA") {
	$UVAId = 0;
	$UVACUsId = 0;
}
}

if ($db) {echo "<br>If no UVACUsId yet, attempt to get value via UVAId : " .  $UVAId;}
if ($UVACUsId == 0) {
	if ($UVAId <> 0) {
		$q = "Select Id from UVACUs  
		Where UVAId = " . $UVAId . " order by Id ";
		if ($db) {echo '<br>' . $q;}
		$r = mysqli_query($connection, $q) or die("<br/>Query failed 3842 : " . $q . "<br>" . mysqli_error($connection));		
		If ($row = mysqli_fetch_array($r)) {
			$UVACUsId = $row["Id"];
		}
		if ($db) {echo "<br>UVACUsId: " . $UVACUsId;}
	}
}
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	if ($db) {echo "<br>Method is POST";}
	if ($db) {echo "<br>Check for deleteUVA";}
	if (isset($_POST["chkDeleteUVA"]) && trim($_POST["chkDeleteUVA"]) == "on") {
		if ($UVAId<> 0) {
				
			// Delete this main UVA record
			$q = "Delete from UtilityVerificationApplication  Where Id = " . $UVAId ;
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 3842 : " . $q . "<br>" . mysqli_error($connection));			
			if ($db) {echo '<br>chkDeleteUVA:  ' . $q; }
			
			// Delete any utility crossings associated with this UVA  
			$q = "Delete from UVACUs Where UVAId = " . $UVAId . " "; 
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 82 : " . $q . "<br>" . mysqli_error($connection));		
	
			$q = "Select Id from UtilityVerificationApplication 
			Where PermitId = " . $PIPId . ' order by LocationAddress';
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed (5445): " . $q . mysqli_error($connection));
			If ($row = mysqli_fetch_array($r)) {
				if ($UVAId == 0) {$UVAId = $row[0];}
				$lnkViewAll = "UVAViewall.php?UVAId=" . $UVAId;
				//$UVAId = $_GET["Id"];
			}		
		}
	} 
	
	if ($db) {echo "<br>Check for Delete";}
	if (isset($_POST["chkDelete"]) && trim($_POST["chkDelete"]) == "on") {
		if ($UVACUsId <> 0) {
			$q = "Delete from UVACUs Where Id = " . $UVACUsId ;
		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 3842 : " . $q . "<br>" . mysqli_error($connection));		
		}
	} else {
		
		if ($db) {echo "<br>Check for Insert";
			if (isset($UVAId)) {
				echo "<br>UVAId: " . $UVAId;
			} else {
				echo "<br>UVAId not set";
			}
			if (isset($_POST["UVAId"])) {
				echo "<br>Post UVAId: " . $_POST["UVAId"];
			} else {
				echo "<br>Post UVAId not set";
			}
			if (isset($_POST["chkDeleteUVA"])) {
				echo "<br>chkDeleteUVA: " . $_POST["chkDeleteUVA"];
			} else {
				echo "<br>chkDeleteUVA not set";
			}
		}	
		//if ((!isset($UVAId) || $UVAId == 0) and 
		//(!isset($_POST["chkDeleteUVA"]) || trim($_POST["chkDeleteUVA"]) <> "on")) {
		
		if ($db) {echo "<p>Check for update vs insert";}
		if ($db) {
		    if (isset($_POST["UVAId"])) {
		        echo "<br>UVAId is set UVAId: " . $_POST["UVAId"];
		    } else {
		        echo "<br>UVAId is not set";
		    }
		    if (isset($_POST["chkDeleteUVA"])) {
		        echo "<br>chkDeleteUVA (on) : " . $_POST["chkDeleteUVA"];
		    } else {
		        echo "<br>chkDeleteUVA is not set";
		    }
		    
		
		}
		if ((isset($_POST["UVAId"]) && $_POST["UVAId"] == 0) and 
		(!isset($_POST["chkDeleteUVA"]) || trim($_POST["chkDeleteUVA"]) <> "on")) {
			
		$txtPermitAddress = "";
		if (isset($_POST['txtPermitAddress']) ) {
			$txtPermitAddress = str_replace("'","''",$_POST['txtPermitAddress']);
		} 
		
			if ($db) {echo "<br>Insert indicated";}	
			$q = "insert into UtilityVerificationApplication  
			(PermitId, Verified, Technician, LocationAddress, UVADate, 
			SketchSheet, Subcontractor, Foreman, 
			StreetName, tComments, Company) values (" . $PIPId . ",	
			'" . $_POST['Verified'] . "', 
			'" . str_replace("'","''",$_POST['Technician']) . "', 
			'" . $txtPermitAddress . "', 
			'" . SQLDate($_POST['UVADate'])  . "', 
			'" . str_replace("'","''",$_POST['SketchSheet']) . "',
			'" . str_replace("'","''",$_POST['Subcontractor'])  . "',
			'" . str_replace("'","''",$_POST['Foreman']) . "', 
			'" . str_replace("'","''",$_POST['StreetName']) . "',
			'" . str_replace("'","''",$_POST['tComments']) . "',
			'" . str_replace("'","''",$_POST['Company']) . "')";

			if ($db || true) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 51282 : " . $q . "<br>" . mysqli_error($connection));
				
			if ($db) {echo "<br>Perform a UVA retreive to get the Id of the record just stored";}	
			$q = "SELECT Id FROM `UtilityVerificationApplication` where `PermitId` = " . $PIPId . " and
			UVADate = '" . SQLDate($_POST['UVADate']) . "' and 
			LocationAddress = '" . $txtPermitAddress . "' and 
			StreetName = '" . str_replace("'","''",$_POST['StreetName']) . "'";
		
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 51282 : " . $q . "<br>" . mysqli_error($connection));
			If ($row = mysqli_fetch_array($r)) {
				$UVAId = $row["Id"];
			}	
			if ($db) {echo "<br>Set NewUtility, UVAId: " . $UVAId;}
			$NewUtility = True;
		}	
		if ($UVAId <> 0 ) {
			
		if (!isset($txtPermitAddress)) {$txtPermitAddress = "";}
		if (isset($_POST['txtPermitAddress']) ) {
			$txtPermitAddress = str_replace("'","''",$_POST['txtPermitAddress']);
		} 
		
			if ($db) {echo "<br>Update indicated";}	
			$q = "Update UtilityVerificationApplication set 
			Verified = '" . $_POST['Verified'] . "', 
			Technician = '" . $_POST['Technician'] . "', 
			LocationAddress = '" . $txtPermitAddress . "', 
			UVADate = '" . SQLDate($_POST['UVADate'])  . "', 
			SketchSheet = '" . str_replace("'","''",$_POST['SketchSheet']) . "',
			Subcontractor  = '" . str_replace("'","''",$_POST['Subcontractor'])  . "',
			Foreman  = '" . str_replace("'","''",$_POST['Foreman']) . "', 
			tComments  = '" . str_replace("'","''",$_POST['tComments']) . "', 
			StreetName = '" . str_replace("'","''",$_POST['StreetName']) . "' 
			Where Id = " . $UVAId;
			
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 582 : " . $q . "<br>" . mysqli_error($connection));
			
			if ($db) {
			    echo "<p>Checking for NewUtility";
			    echo "<br>NewUtility" . $NewUtility;
			    if (isset($_GET["action"])) {
			        echo "<br>action : " . $_GET["action"];
			    } else {
			        echo "<br>action not set";
			    }
			    
			}
			if (isset($NewUtility) || (isset($_GET["action"]) && trim($_GET["action"]) == "NewUtility")) {
				
				if ($db) {echo '<br>Inserting new crossing';}
				$q = "Insert into UVACUs (UVAId) values (" . $UVAId . ")";
				
				if ($db) {echo '<br>' . $q;}
				$r = mysqli_query($connection, $q) or die("<br/>Query failed 182 : " . $q . "<br>" . mysqli_error($connection));		
			
				if ($db) {echo '<br>Retrieve Id';}
				$q = "Select Id from UVACUs  
				Where UVAId = " . $UVAId . " order by Id desc";
		
				if ($db) {echo '<br>' . $q;}
				$r = mysqli_query($connection, $q) or die("<br/>Query failed 382 : " . $q . "<br>" . mysqli_error($connection));		
				If ($row = mysqli_fetch_array($r)) {
					$UVACUsId = $row["Id"];
				}			
				if ($db) {echo '<br>UVACUsId' . $UVACUsId;}
			}
			$q = "Update UVACUs set ";
		
			if (trim($_POST['IUSize']) <> "select" ) {$q = $q . "IUSize = '" . str_replace("'","''",$_POST['IUSize']) . "',";} 
			if (trim($_POST['IUType']) <> "select" ) {$q = $q . "IUType = '" . str_replace("'","''",$_POST['IUType']) . "',";} 
			if (trim($_POST['IUDepth']) <> "select" ) {$q = $q . "IUDepth = '" . str_replace("'","''",$_POST['IUDepth']) . "',";} 
			if (trim($_POST['IUMethod']) <> "select" ) {$q = $q . "IUMethod = '" . str_replace("'","''",$_POST['IUMethod']) . "',";} 
			if (trim($_POST['IUQuantity']) <> "select" ) {$q = $q . "IUQuantity = '" . str_replace("'","''",$_POST['IUQuantity']) . "',";} 
			if (trim($_POST['THSurface']) <> "select" ) {$q = $q . "THSurface = '" . str_replace("'","''",$_POST['THSurface']) . "',";} 
			
			if (trim($_POST['THWidth']) <> "select" ) {$q = $q . "THWidth = '" . str_replace("'" , "''", $_POST['THWidth']) . "',";} 
			if (trim($_POST['THLength']) <> "select" ) {$q = $q . "THLength = '" . str_replace("'" , "''", $_POST['THLength']) . "',";} 
			if (trim($_POST['EUOwner']) <> "select" ) {$q = $q . "EUOwner = '" . str_replace("'","''",$_POST['EUOwner']) . "',";} 
			if (trim($_POST['EUSize']) <> "select" ) {$q = $q . "EUSize = '" . str_replace("'","''",$_POST['EUSize']) . "',";} 
			if (trim($_POST['EUType']) <> "select" ) {$q = $q . "EUType = '" . str_replace("'","''",$_POST['EUType']) . "',";} 
			if (trim($_POST['EUDepth']) <> "select" ) {$q = $q . "EUDepth = '" . str_replace("'","''",$_POST['EUDepth']) . "',";} 
			if (trim($_POST['EUStatus']) <> "select" ) {$q = $q . "EUStatus = '" . str_replace("'","''",$_POST['EUStatus']) . "' ";} 
			if (substr($q, -1) == ',') {$q = substr($q, 0, -1);}
		
			if ($q <> "Update UVACUs set ") { // means at least one item set
				$q = $q . " Where Id = " . $UVACUsId;	
			
				if ($db) {echo '<br>' . $q;}	
				$r = mysqli_query($connection, $q) or die("<br/>Query failed 182 : " . $q . "<br>" . mysqli_error($connection));								
			}
		}		
	}
}


	if ($db) {echo "<br>Check for deleteUVA (GET)";}
	if (isset($_GET["chkDeleteUVA"]) && trim($_GET["chkDeleteUVA"]) == "on") {
		if ($UVAId<> 0) {
				
			// Delete this main UVA record
			$q = "Delete from UtilityVerificationApplication  Where Id = " . $UVAId ;
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 3842 : " . $q . "<br>" . mysqli_error($connection));			
			if ($db) {echo '<br>chkDeleteUVA:  ' . $q; }
			
			// Delete any utility crossings associated with this UVA  
			$q = "Delete from UVACUs Where UVAId = " . $UVAId . " "; 
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 82 : " . $q . "<br>" . mysqli_error($connection));		
	
			$q = "Select Id from UtilityVerificationApplication 
			Where PermitId = " . $PIPId . ' order by LocationAddress';
			if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed (5445): " . $q . mysqli_error($connection));
			If ($row = mysqli_fetch_array($r)) {
				if ($UVAId == 0) {$UVAId = $row[0];}
				$lnkViewAll = "UVAViewall.php?UVAId=" . $UVAId;
				//$UVAId = $_GET["Id"];
			}		
		}	
	}


if (isset($_GET["action"])) {
if (trim($_GET["action"]) == "NewUtility") {
	// Delete and started but not complete new utility crossing
	$q = "Delete from UVACUs Where EUType is Null and UVAId = " . $UVAId . " "; 
		if ($db) {echo '<br>' . $q;}
	$r = mysqli_query($connection, $q) or die("<br/>Query failed 282 : " . $q . "<br>" . mysqli_error($connection));		
	
	$q = "Insert into UVACUs (UVAId) values (" . $UVAId . ")";
		if ($db) {echo '<br>' . $q;}
	$r = mysqli_query($connection, $q) or die("<br/>Query failed 382 : " . $q . "<br>" . mysqli_error($connection));		
	$q = "Select Id from UVACUs  
	Where UVAId = " . $UVAId . " order by Id desc";
		if ($db) {echo '<br>' . $q;}
	$r = mysqli_query($connection, $q) or die("<br/>Query failed 482 : " . $q . "<br>" . mysqli_error($connection));		
	If ($row = mysqli_fetch_array($r)) {
		$UVACUsId = $row["Id"];
	}		
}
}
	?>
	
<form action="UtilityVerificationApplication.php?UVAId=<?php echo $UVAId;?>&UVACUsId=<?php echo $UVACUsId;?>" method="post">
	<input type="hidden" name="PIPId" value="<?php echo $PIPId;?>">	
	<input type="hidden" name="UVAId" value="<?php echo $UVAId;?>">
	<input type="hidden" name="UVACUsId" value="<?php echo $UVACUsId;?>">
	<div class="container" style="font-size: normal; background-color: whitesmoke;  ">

		<div class="row" style="background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="font-size: xx-large; ">
				Utility Verification Application
			</div>
		</div>
		<?php
		function ScrubDate($ADate) {
			//2016-05-20 -> 05/16/2016
			if (!empty($ADate)) {
				return substr($ADate, 5, 2) . "/" . substr($ADate, 8, 2) . "/" . substr($ADate, 0, 4);
			} else {
				return null;
			}
		}
	
		//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
		
include ('./includes/database2.inc');
		//$connection2 = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
				
		$strSQL = "";
		$edit = false;
		
		if (1 == 2) {
		$UVAId = 0;
		$txtUVADate = "";
		$txtLocation = "";
		$txtPermitAddress = "";
		$txtCompany = "";
		$txtSubcontractor = "";
		$txtForeman = "";						
		$txtTechnician = "";
		$PIPId = "";						
		$txtVerified = "";
		$txtSketchSheet = "";	
		$txtStreetName = "";
		$txtPermitNumber = "";
		$tComments = "";
		}
				
		If ($PIPId <> 0) {
			$edit = true;
			$q = "Select count(*) from UtilityVerificationApplication Where PermitId = " . $PIPId;

		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed (55): " . $q . mysqli_error($connection));
			If ($row = mysqli_fetch_array($r)) {
				$UVAPages = $row[0];
			}
			$txtPages = "/" . $UVAPages;
		}

		If ($PIPId <> 0) {
			$lnkRefresh = "UtilityVerificationApplication.php?PIPId=" . $PIPId;
			$lnkNew = "UtilityVerificationApplication.php?PIPId=" . $PIPId;

			$q = "Select PermitNumber,CompanyName from PIP Where Id = " . $PIPId;
		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 482 : " . $q . "<br>" . mysqli_error($connection));
			If ($row = mysqli_fetch_array($r)) {
				$txtPermitNumber = $row[0];
				$txtCompany = $row[1];
			}
		}
		If ($UVAId <> 0) {
					
			$edit = true;
			$q = "Select UtilityVerificationApplication.Id,
			UVADate, LocationAddress, PermitAddress, 
		 	Company, Subcontractor, Foreman, 
			UtilityVerificationApplication.Technician, PIP.Id, Verified, 
			SketchSheet, StreetName, PermitNumber,tComments from UtilityVerificationApplication, PIP  
			Where PermitId = PIP.Id and 
			UtilityVerificationApplication.Id = " . $UVAId;

		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q . "<br>" . mysqli_error($connection));
			if (isset($_GET["UVACount"])) {
				$I = $_GET["UVACount"];
			} else {
				$I = "";
			}
			
			$RCount = 0;
			If ($row = mysqli_fetch_array($r)) {
				$UVAId = $row[0];
				$txtUVADate = $row[1];
				$txtLocation = $row[2];
				//$PermitAddress = $row[2]; // nearest address
				$txtPermitAddress = $row[3];
				
				$txtCompany = $row[4];
				$txtSubcontractor = $row[5];
				$txtForeman = $row[6];						
				$txtTechnician = $row[7];
				$PIPId = $row[8];						
				$txtVerified = $row[9];
				$txtSketchSheet = $row[10];	
				$txtStreetName = $row[11];
				$txtPermitNumber = $row[12];
				$tComments = $row[13];
			}
			if ($UVACUsId <> 0) {	
				$q = "Select Id,
				THWidth, THSurface, EUType, IUSize,
				IUDepth, IUType, IUQuantity, EUDepth, EUOwner,
				EUStatus, THLength, EUSize, IUMethod 
				from UVACUs  
				Where UVAId = " . $UVAId . " and 
				Id = " . $UVACUsId . " Order by Id";
			} else {
				$q = "Select Id,
				THWidth, THSurface, EUType, IUSize,
				IUDepth, IUType, IUQuantity, EUDepth, EUOwner,
				EUStatus, THLength, EUSize, IUMethod 
				from UVACUs  
				Where UVAId = " . $UVAId . ' Order by Id';
			}
			//echo '<br>' . $q;
		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection, $q) or die("<br/>Query failed 92 : " . $q . "<br>" . mysqli_error($connection));
					
			If ($row = mysqli_fetch_array($r)) {
				$UVACUsId = $row[0];
				$txtTHWidth = $row[1];
				$txtTHSurface = $row[2];
				$txtEUType = $row[3];
				$txtIUSize = $row[4];
				$txtIUDepth = $row[5];
				$txtIUType = $row[6];
				$txtIUQuantity = $row[7];
				$txtEUDepth = $row[8];
				$txtEUOwner = $row[9];
				$txtEUStatus = $row[10];
				$txtTHLength = $row[11];
				$txtEUSize = $row[12];
				$txtIUMethod = $row[13];
			}
					
		}
		function DisplayDate($ADate) {
			$date = date_create($ADate);
			return date_format($date, "m/d/Y");
		}
				
		$FirstName = '';
		$LastName = '';
				
		if (!empty($_SESSION["user_id"] )) {
			$q = "Select * from Login Where Id = " . $_SESSION["user_id"];
		if ($db) {echo '<br>' . $q;}
			$r = mysqli_query($connection,$q) or die("<br/>Query failed - 19.5" . $q . "<br>" . mysqli_error($connection));

			if ($row = mysqli_fetch_array($r)) {
				$FirstName = $row["FirstName"];
				$LastName = $row["LastName"];
			}
		}
		?>

		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row">
			
			<div class="col-sm-2">
				Technician:<br>
				<?php If (!isset($txtTechnician) || !$edit) {$txtTechnician="";} 
				DisplayOptions('Technician', $txtTechnician,$connection);?>
			</div>		
			
			<div class="col-sm-3">
				Verified:<br>
				<?php If (!isset($txtVerified) || !$edit) {$txtVerified="";}
				DisplayOptions('Verified', $txtVerified,$connection);?>
			</div>					
			
			<div class="col-sm-2">
				Install Date:<br>				
				<input type="text"  id="datepicker" name="UVADate" style="width:98px"
				<?php
					if ($edit) {if (isset($txtUVADate)) {echo "value=" . DisplayDate($txtUVADate) . " ";}
					}
 				?> >
 			</div>			
			
			<div class="col-sm-2">
				Permit&nbsp;number: <br>
				<?php
				if (1 == 2){ ?>	
					<select  name="txtPermitNumber" style="height:26px; width:115px">
					<?php
						if ($edit) {echo "<option>" . $txtPermitNumber . "</option>";
						}
 					?> 
 					</select>
	 				<?php
 				} else {
 					if (isset($txtPermitNumber)) {
 					echo "<b>" . $txtPermitNumber . "</b>"; 
 					echo '<input type="hidden" name="txtPermitNumber" value="' . $txtPermitNumber . '">';
					} 					
 				} ?>
			</div>			
			
			<div class="col-sm-2 " style="outline: 0px solid orange;">
				Sketch&nbsp;Sheet&nbsp;#:<br>
				<input style="width:100%" name="SketchSheet" value="<?php if (isset($txtSketchSheet)) {echo $txtSketchSheet;}?>"> 		
			</div>		 			
									
		</div>

		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row">
			<div class="col-sm-2">
				Permit&nbsp;Address: 
			</div>
			<div class="col-sm-10">
				<?php
					if (isset($txtPermitAddress)) {echo $txtPermitAddress;}
					//echo $txtLocation;					
 				?>
			</div>
		</div>		
		
		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row">
			<div class="col-sm-4">
				Utility Company:<br> 
				<b><?php 
				if (isset($txtCompany)) {
					echo $txtCompany; 
					echo '<input type=hidden name="Company" value="'. $txtCompany . '">';
				}?></b>
			</div>
			<div class="col-sm-4">
				Contractor:<br>
				<input type="text" id="auto" name="Subcontractor" style="width:100%"
				<?php
					if ($edit) {if (isset($txtSubcontractor)) {echo "value='" . $txtSubcontractor . "' ";}
					}
 				?>>
			</div>
			<div class="col-sm-4">
				Site Supervisor:<br>
				<input type="text" id="auto2" name="Foreman" style="width:100%"
				<?php
					if ($edit) {if (isset($txtForeman)) {echo "value='" . $txtForeman . "' ";}
					}
 				?>>
			</div>
		</div>		
				
		
		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		
		<div class="row">
			<div class="col-sm-6" style="border-top: 1px solid grey; font-size: large; font-weight:bold; background-color: whitesmoke; ">
				Utility crossing location
			</div>
		</div>		
		
		<div class="row" style="background-color: whitesmoke">
			<div class="col-sm-4 " style="outline: 0px solid orange;">				
				Nearest&nbsp;address&nbsp;to&nbsp;utility&nbsp;crossing:		
			</div>
				
			<div class="col-sm-8">
				<div id="locationField">
					<?php
					if (!isset($PermitAddress)) {$PermitAddress = ""; } 
					//if (strrpos($PermitAddress, "Virginia Beach") == 0) {$PermitAddress = $PermitAddress . ", Virginia Beach, VA";}
					if ($PermitAddress <> "" && strrpos($PermitAddress, "Virginia Beach") == 0) {
						$PermitAddress = $PermitAddress . ", Virginia Beach, VA";
					} else {
						if (isset($txtLocation)) {$PermitAddress = $txtLocation; }
					}
					if (isset($_GET["action"]) && $_GET["action"] == "NewUVA") {$PermitAddress = "";}
						?>
						<input id="autocomplete" name="txtPermitAddress" placeholder="Enter UVA address"
						onFocus="geolocate()" type="text" value="<?php echo $PermitAddress;?>" style="width:100%">
						</input>
						<?php
						if (strrpos($PermitAddress, "Virginia Beach") == 0) {$PermitAddress = $PermitAddress . ", Virginia Beach, VA";}
							$PermitAddresswoc = str_replace(" ","+",$PermitAddress);
							//echo '<script> PutGooMap("' . $PermitAddresswoc . '"); </script>';
						?>
				</div>
			</div>
		</div>		
		<div class="row" style="border-bottom: 1px solid black; background-color: whitesmoke">
			<div class="col-sm-12" style="outline: 0px solid orange;">
				Street name of utility crossing - <i>change if different than shown here:</i>&nbsp;&nbsp;
				<?php
				if (!isset($txtStreetName)) {$txtStreetName=""; } ?>			
				<input placeholder="First enter nearest address above" id="StreetName" 
				name="StreetName" value="<?php if (isset($txtStreetName)) {echo $txtStreetName; }?>" style="width:250px">
			</div>		
		</div>		
		
		<div class="row" style="">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row">
			<div class="col-sm-12" style="border-bottom: 1px black solid">
				&nbsp;Technician&nbsp;comments:<br>
				<textarea rows=2 name="tComments" style="width:100%"><?php if ($edit && isset($tComments)) {echo $tComments . " ";}?></textarea>
				
			</div>		
		</div>		
			
		<div class="row" style="border-top: 0px solid grey">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>	
				
		<div class="row">
			<div class=" col-sm-12" style="font-size: x-large; ">
				Utility Crossing Information
			</div>
			
		</div>		
		
		
		<div class="row">
			<div class="col-sm-12" style="font-size: large; font-weight:bold; background-color: lightblue">
				Newly Installed utility
			</div>
		</div>		
		
		<div class="row" style="font-weight: bold;  border-bottom: 1px solid black; ">
			<div class="col-sm-2" style="background-color: lightblue">
				Size: 
				<br>
				<?php if (!isset($txtIUSize) || !$edit) {$txtIUSize = ""; } 
				DisplayOptionsI('IUSize',$txtIUSize,$connection); ?>
			</div>
			<div class="col-sm-3" style="background-color: lightblue">
				Type:<br>
				<?php if (!isset($txtIUType) || !$edit) {$txtIUType = ""; } 
				DisplayOptionsI('IUType',$txtIUType,$connection); ?>
			</div>
			<div class="col-sm-2" style="background-color: lightblue">
				Depth:<br>
				<?php if (!isset($txtIUDepth) || !$edit) {$txtIUDepth = ""; } 
				DisplayOptionsI('IUDepth',$txtIUDepth,$connection); ?>
			</div>
			<div class="col-sm-3" style="background-color: lightblue">
				Method:<br>
				<?php if (!isset($txtIUMethod) || !$edit) {$txtIUMethod = ""; } 
				DisplayOptionsI('IUMethod',$txtIUMethod,$connection); ?>
			</div>
			<div class="col-sm-2" style="background-color: lightblue">
				Quantity:<br>
				<?php if (!isset($txtIUQuantity) || !$edit) {$txtIUQuantity = ""; } 
				DisplayOptionsI('IUQuantity',$txtIUQuantity,$connection); ?>
			</div>
		</div>		
		
		<div class="row">
			<div class="col-sm-12" style="font-size: large; font-weight:bold; background-color: lightblue">
				Depth Determination
			</div>
		</div>						
			
		<div class="row" style="border-bottom: 1px solid black; ">
			<div class="col-sm-3"style="font-weight: bold; background-color: lightblue">
				Method / Surface:<br>
				<?php if (!isset($txtTHSurface) || !$edit) {$txtTHSurface = ""; } 
				DisplayOptionsI('THSurface',$txtTHSurface,$connection); ?>
			</div>
			<div class="col-sm-4"style="font-weight: bold; background-color: lightblue">
				Test hole / Open cut Width:<br>
				<?php if (!isset($txtTHWidth) || !$edit) {$txtTHWidth = ""; } 
				DisplayOptionsI('THWidth',$txtTHWidth,$connection); ?>
			</div>
			<div class="col-sm-4"style="font-weight: bold; background-color: lightblue">
				Test hole / Open cut Length:<br>
				<?php if (!isset($txtTHLength) || !$edit) {$txtTHLength = ""; } 
				DisplayOptionsI('THLength',$txtTHLength,$connection); ?>
			</div>
			<div class="col-sm-1"style="background-color: lightblue">
				&nbsp;<br>&nbsp;
			</div> 
		</div>
		
		
		<div class="row" style=" background-color: lightblue">
			<div class="col-sm-12" style="font-size: large; font-weight:bold; background-color: lightblue">
				Existing utility crossed
			</div>
		</div>		
		
		<div class="row" style="border-bottom: 1px solid grey; ">
			<div class="col-sm-4" style="font-weight: bold; background-color: lightblue">
				Owner:<br>
				<?php if (!isset($txtEUOwner) || !$edit) {$txtEUOwner = ""; } 
				DisplayOptionsI('EUOwner',$txtEUOwner,$connection); ?>
			</div>
			<div class="col-sm-1" style="font-weight: bold; border: 0px solid yellow; background-color: lightblue">
				Size:<br>
				<?php if (!isset($txtEUSize) || !$edit) {$txtEUSize = ""; } 
				DisplayOptionsI('EUSize',$txtEUSize,$connection); ?>
			</div>
			<div class="col-sm-3" style="font-weight: bold; background-color: lightblue">
				Type:<br>
				<?php if (!isset($txtEUType) || !$edit) {$txtEUType = ""; } 
				DisplayOptionsI('EUType',$txtEUType,$connection); ?>
			</div>
			<div class="col-sm-1" style="font-weight: bold; background-color: lightblue">
				Depth:<br>
				<?php if (!isset($txtEUDepth) || !$edit) {$txtEUDepth = ""; } 
				DisplayOptionsI('EUDepth',$txtEUDepth,$connection); ?>
			</div>
			<div class="col-sm-2" style="font-weight: bold; background-color: lightblue">
				Status:<br>
				<?php if (!isset($txtEUStatus) || !$edit) {$txtEUStatus = ""; } 
				DisplayOptionsI('EUStatus',$txtEUStatus,$connection); ?>
			</div>
			<div class="col-sm-1" style="height:40px; border: 0px solid green; background-color: lightblue">				
				&nbsp;
			</div>
		</div>		
		
		<?php
		
		function stringCheck ($string, $substring) {
  			return (strpos(strtoupper($string), strtoupper($substring)) !== false);
		}		
		
		function DisplayOptions($field,$selection,$connection) {
			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
			
			if (trim($field) <> 'Technician') {
				$q = "SELECT " . $field . "  FROM " . $field . "s Where " . $field . " is not null Order by " . $field . "";
			} else {
				$q = "SELECT " . $field . "  FROM " . $field . " Where " . $field . " is not null Order by " . $field . "";			
			}
			if (isset($db)) {if ($db) {echo '<br>' . $q;} }
				$r = mysqli_query($connection, $q) or die("<br/>Query failed" . "<br>" . mysqli_error($connection));
			
				echo '<select style="width: 100%;" name="' . $field . '" id="' . $field . '">';
				echo '<option>select</otion>';
				While ($row = mysqli_fetch_array($r)) {
					echo '<option ';
					if (stringCheck($selection,$row[0])) {echo " selected ";}
					echo ">$row[0]</option>";
				}
				echo '</select>';
				return true;
			}
		
		function DisplayOptionsI($field,$selection,$connection) {
			//$connection = mysqli_connect("localhost", "puvabeac_PIP", "Mr.Coffee4","puvabeac_PIP") or die('I cannot connect to the database because: ' . mysqli_error($connection));
			
			if (trim($field) <> 'Technician') {
				$q = "SELECT " . $field . "  FROM " . $field . "s Where " . $field . " is not null Order by " . $field . "";
			} else {
				$q = "SELECT " . $field . "  FROM " . $field . " Where " . $field . " is not null Order by " . $field . "";			
			}
			if (isset($db)) {if ($db) {echo '<br>' . $q;} }
				$r = mysqli_query($connection, $q) or die("<br/>Query failed" . "<br>" . mysqli_error($connection));
			
				echo '<select style="width: 100%;" name="' . $field . '" id="' . $field . '">';
				echo '<option>select</otion>';
				While ($row = mysqli_fetch_array($r)) {
					echo "<option  ";
					if (trim($selection) == trim($row[0])) {echo " selected ";}
					echo ">$row[0]</option>";
				}
				echo '</select>';
				return true;
			}
		
		
		?>				

		<div class="row" style="border-top: 1px solid black; ">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row">
			<div class="col-sm-4">
				<?php	
				if ($admin) {	?>
				<button type="submit" style="font-weight: bold;  color:white;"  name="button1" id="button1" class="btn btn-success" >
					Save
				</button>
				<?php } ?>
			</div>
			<?php 			
				if ($UVAId <> 0) { ?>
					<div class="col-sm-4"> <?php
					echo '<a href="UtilityVerificationApplication.php?action=NewUtility&UVAId=' . $UVAId . '"><b>New&nbsp;utility&nbsp;crossing</b></a>';			
					?>
					</div>
			
					<div class="col-sm-4">	
						<input type="checkbox" value="on" name="chkDelete" >
							Delete&nbsp;this&nbsp;Utility&nbsp;Crossing
					</div>
				<?php
				} ?>			
		</div>
		
		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		
		<div class="row" style="font-size: large; font-weight:bold; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="">
				Current existing utilities crossed for this UVA
			</div>
		</div>		
		
		<div class="row" style="font-weight:bold; ">
			<div class="col-sm-4" style="text-align: center; border-bottom: 0px solid black; border-right: 1px solid black; ">
				Existing crossed utility
			</div>
			<div class="col-sm-4" style="text-align: center; border-right: 1px solid black; border-bottom: 0px solid black; vertical-align: bottom">
				Newly installed
			</div>
			<div class="col-sm-4" style="text-align: center; border-bottom: 0px solid black; vertical-align: bottom">
				Test hole
			</div>
		</div>		
		
		<div class="row" style="font-weight:bold; ">
			<div class="col-sm-3" style="border-bottom: 1px solid black; ">
				Type
			</div>
			<div class="col-sm-1" style="border-right: 1px solid black;border-bottom: 1px solid black; vertical-align: bottom">
				Depth
			</div>
			<div class="col-sm-3" style="border-bottom: 1px solid black; vertical-align: bottom">
				Type
			</div>
			<div class="col-sm-1" style="border-right: 1px solid black;border-bottom: 1px solid black; vertical-align: bottom">
				Depth
			</div>
			<div class="col-sm-2" style="border-bottom: 1px solid black; vertical-align: bottom">
				Surface
			</div>
			<div class="col-sm-2" style=" border-bottom: 1px solid black; vertical-align: bottom">
				L x W
			</div>
		</div>				
		<?php
		//Select all UVA records having the same Permit number and UVA location
		//$db = True;
		if ($UVAId <> 0) {
		$q = "Select * from UVACUs  
		Where UVAId = " . $UVAId . " order by Id";
			
		if ($db) {echo '<br>' . $q;}
		$r = mysqli_query($connection, $q) or die("<br/>Query failed 13412 : " . $q . "<br>" . mysqli_error($connection));
			
		While ($row = mysqli_fetch_array($r)) {				
		?>
		<div class="row" style="font-weight:bold; ">
			<div class="col-sm-3" style=" vertical-align: bottom">
				<?php $EUType = "<i>(none)</i>";
				if (trim($row["EUType"]) <> "") { $EUType = $row["EUType"];} ?>
				<a href="UtilityVerificationApplication.php?UVAId=<?php echo $UVAId;?>&UVACUsId=<?php echo $row["Id"];?>">
					<?echo $EUType;?>
				</a>
			</div>
			<div class="col-sm-1" style="border-right: 1px solid black;vertical-align: bottom">
				<?echo $row["EUDepth"];?>
			</div>
			<div class="col-sm-3" style="vertical-align: bottom">
				<?echo $row["IUType"];?>
			</div>
			<div class="col-sm-1" style="border-right: 1px solid black;vertical-align: bottom">
				<?echo $row["IUDepth"];?>
			</div>
			<div class="col-sm-2" style="vertical-align: bottom">
				<?echo $row["THSurface"];?>
			</div>
			<div class="col-sm-2" style="vertical-align: bottom">
				<?
				echo $row["THWidth"];
				if (trim($row["THLength"]) <> "") {
					echo " x " . $row["THLength"];
				}
				?>
			</div>
		</div>		
		<?php
		}
		}
		?>
		
		<div class="row" style="border-top: 1px solid black; ">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<!-- Current UVAs for this permit -->		
		
		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		
		<div class="row" style="font-size: large; font-weight:bold; background-image: linear-gradient(to right, whitesmoke 50%, lightblue )">
			<div class="col-sm-12" style="">
				Current UVAs for this permit
			</div>
		</div>		
		
		<div class="row" style="font-weight:bold; ">
			<div class="col-sm-1" style="border-bottom: 1px solid black; border-right: 1px solid black; ">
				UVA
			</div>
			<div class="col-sm-2" style="border-bottom: 1px solid black; border-right: 1px solid black; ">
				Sketch&nbsp;Sheet&nbsp;#
			</div>
			<div class="col-sm-6" style="border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: bottom">
				Location / Street crossed
			</div>
			<div class="col-sm-2" style="border-right: 1px solid black; text-align: center; border-bottom: 1px solid black; vertical-align: bottom">
				Utility Crossings
			</div>
			<div class="col-sm-1" style="text-align: center; border-bottom: 1px solid black; vertical-align: bottom">
				Delete&nbsp;UVA
			</div>
		</div>		
		
		<?php
		if ($db) {echo "<br>Current UVAs for this permit";}
		if ($db) {echo "<br>UVAId: " . $UVAId;}		
		if ($db) {echo "<br>PIPId: " . $PIPId;}
		//if ($UVAId <> 0) {
			//Select all UVA records having the same Permit number group by UVA location
			if ($PIPId <> 0) {
				$q = "Select LocationAddress, Id, SketchSheet, StreetName  
				from UtilityVerificationApplication 
				Where PermitId = " . $PIPId . " order by LocationAddress";
		
				if ($db) {echo '<br>' . $q;}
				$r = mysqli_query($connection, $q) or die("<br/>Query failed 134131 : " . $q . "<br>" . mysqli_error($connection));
			
				$UVACount = 1;
				While ($row = mysqli_fetch_array($r)) {				
					?>		
					<div class="row" style="font-weight:bold; ">
						<div class="col-sm-1" style="height:23px;border-bottom: 1px solid black; border-right: 1px solid black; ">
							<a href="UtilityVerificationApplication.php?UVAId=<?php echo $row["Id"];?>"><?php echo $UVACount;?></a>
						</div>
						<div class="col-sm-2" style="height:23px;text-align:center; border-bottom: 1px solid black; border-right: 1px solid black; ">
							<?php echo '&nbsp;' . $row[2] . '&nbsp;';?>
						</div>
						<div class="col-sm-6" style="height:23px;border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: bottom">
							<a href="UtilityVerificationApplication.php?UVAId=<?php echo $row[1];?>">
							<?php echo str_replace(", Virginia Beach, VA, United States", "", $row["LocationAddress"]) . ' / ' . $row["StreetName"];?>
							</a>
						</div>
						<div class="col-sm-2" style="border-right: 1px solid black;  height:23px;text-align: center; border-bottom: 1px solid black; vertical-align: bottom">
							<?php 
							$q2 = "Select count(*) from UVACUs  
							Where UVAId = " . $row["Id"] . " and EUType is not Null";
							
							if ($db) {echo '<br>' . $q2;}
							$r2 = mysqli_query($connection2, $q2) or die("<br/>Query failed 1341411 : " . $q2 . "<br>" . mysqli_error($connection2));
			
							if ($row2 = mysqli_fetch_array($r2)) {	
								echo $row2['count(*)'];
							} else {
								echo 'none';
							}
							?>
						</div>			
						
						<div class="col-sm-1" style="text-align: center; border-bottom: 1px solid black; vertical-align: bottom">
							<a title="Delete this UVA" 
							onclick="deleteLine('<?php echo $row["Id"];?>','<?php echo $row["LocationAddress"];?> / <?php echo $row["StreetName"];?> and the <?php echo $row2["count(*)"];?> utility crossing(s) ','<?php echo $PIPId;?>')">
							<img src="delete.jpg" style="height:22px;"></a>
						</div>
						
					</div>		
					<?php
					$UVACount = $UVACount + 1;
				}
			}
			?>
				
		<div class="row">
			<div class="col-sm-12" style="height:10px">
				&nbsp;
			</div>		
		</div>		
		
		<div class="row" style="font-weight:bold; background-color: white; ">
			<div class="col-sm-3">
				<a  name="lnkNew" 
				href="UtilityVerificationApplication.php?action=NewUVA&PIPId=<?php echo $PIPId;?>" ><b>New&nbsp;UVA</b></a>
			</div>
			
			<div class="col-sm-3">
				<?php
				if (isset($lnkPrinterVersion)) { ?>
				<a  name="lnkPrinterVersion" href="<?php echo $lnkPrinterVersion;?>" 
					Target="_blank"><b>Printer&nbsp;Version</b></a>
				<?php } ?>
			</div>
			
			<div class="col-sm-3">
				<?php
				if (isset($PIPId) ) { ?>
				<a  name="" href="UVAPrintAll.php?Id=<?php echo $PIPId;?>" 
					Target="_blank"><b>Print&nbsp;All</b></a>
				<?php } ?>
			</div>
			
			<!--
			<div class="col-sm-3">			
				<input type="checkbox" value="on" name="chkDeleteUVA" >
				Delete&nbsp;this&nbsp;UVA
			</div>
			-->
			
			<?php
			if (1 == 2) { ?>
			<div class="col-sm-3">	
				<?php if (isset($lnkViewAll)) {?>
				<a  name="lnkViewAll" href="<?php echo $lnkViewAll;?>" 
					Target="_blank"><b>View&nbsp;all</b></a>
				<?php } ?>
			</div>						
			<?php
			} ?>				
		</div>
	</div>
	</form>
	
	<script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.

		var placeSearch,
		    autocomplete;
		var componentForm = {
			street_number : 'short_name',
			route : 'long_name',
			locality : 'long_name',
			administrative_area_level_1 : 'short_name',
			country : 'long_name',
			postal_code : 'short_name'
		};

		function initAutocomplete() {
			// Create the autocomplete object, restricting the search to geographical
			// location types.
			autocomplete = new google.maps.places.Autocomplete(
			/** @type {!HTMLInputElement} */(document.getElementById('autocomplete')), {
				types : ['geocode']
			});

			// When the user selects an address from the dropdown, populate the address
			// fields in the form.
			autocomplete.addListener('place_changed', fillInAddress);
		}

		// [START region_fillform]
		function fillInAddress() {
			//alert('fillInAddress');
			// Get the place details from the autocomplete object.	
			var place = autocomplete.getPlace();			
			
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (addressType == 'route') {
					var val = place.address_components[i][componentForm[addressType]];
					document.getElementById("StreetName").value = val;				
				}
			}
			
			
			var addressType = place.address_components[1].types[0];			
			
			var GooMapText = document.getElementById("autocomplete").value;
			var res = GooMapText.replace(" ", "+"); 
			document.getElementById("GooMap").innerHTML = "<a href='https://maps.google.com/maps?q=" + res + "'>Google&nbsp;map</a>";	
			//"https://maps.google.com/maps?q=" . Replace($row["ST_NUM"), " ", "+")		

			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}

			// Get each component of the address from the place details
			// and fill the corresponding field on the form.
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					alert(i + ' ' + val);
					document.getElementById(addressType).value = val;
				}
			}
		}
		
		

		// [END region_fillform]

		// [START region_geolocation]
		// Bias the autocomplete object to the user's geographical location,
		// as supplied by the browser's 'navigator.geolocation' object.
		function geolocate() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var geolocation = {
						lat : position.coords.latitude,
						lng : position.coords.longitude
					};
					var circle = new google.maps.Circle({
						center : geolocation,
						radius : position.coords.accuracy
					});
					autocomplete.setBounds(circle.getBounds());
					document.getElementById("txtLatitude").value = position.coords.latitude;
					//alert(position.coords.latitude);
					document.getElementById("txtLongitude").value = position.coords.longitude;
				});							
			}
		}

		// [END region_geolocation]

	</script>
	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXo25NYFjE0gvH5qZJ3z8xDwyJla1_brU&signed_in=true&libraries=places&callback=initAutocomplete"
	async defer></script> 
	
	<!-- PIP VaBeachPu -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB27LeEtIle55ORNGrVZvpnI__4HANsz98&libraries=places&callback=initAutocomplete"
	async defer></script> 
		
	<!-- PIP Test VaBeachPu 
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZKo7lMb30Uid7UHY9dxl49Pg1hekThcQ&libraries=places&callback=initAutocomplete"
	async defer></script> -->
	
</body>
