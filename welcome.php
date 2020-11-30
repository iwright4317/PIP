<?php
session_start();
?>
<head>
	<?php
	include ('./includes/js_css.inc');
	?>

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
			var regexp = /^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/
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

			if (isblankentry(theform.title)) {
				alert("The title is blank. Please re-enter with a title and click the Save button again. ");
				returnval = false;
			}

			if (isblankentry(theform.description)) {
				alert("The description is blank. Please re-enter with a description and click the Submit button again. ");
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
			$('#nofiles').click(function() {
				var checked_status = this.checked;
				if (checked_status == true) {
					$('#submit').show();
					document.getElementById("submit").value = "Done";
					$('#submission').hide();
					$('#selectfiles').hide();
					$('#fileselectform').hide();
					$('#nofileselectform').show();
					var sf = document.getElementById('nofileselectform')
					sf.style.visibility = 'visible';
				} else {
					$('#submit').hide();
					document.getElementById("submit").value = "Upload file";
					$('#submission').show();
					var fileInput = document.getElementById("submission");
					if (fileInput.files.length > 0) {
						$('#submit').show();
					}
					$('#selectfiles').show();
					$('#fileselectform').show();
					$('#nofileselectform').hide();
					var sf = document.getElementById('nofileselectform')
					sf.style.visibility = 'hidden';
				}
			});
			// end click
		});
		// end ready

		function checkfile() {
			var fileInput = document.getElementById("submission");
			var message = "";
			if ('files' in fileInput) {
				if (fileInput.files.length == 0) {
					message = "Please browse for one or more files.";
				} else {
					for (var i = 0; i < fileInput.files.length; i++) {
						message += "<br /><b>" + (i + 1) + ". file</b><br />";
						var file = fileInput.files[i];
						if ('name' in file) {
							message += "name: " + file.name + "<br />";
						} else {
							message += "name: " + file.fileName + "<br />";
						}
						if ('size' in file) {
							message += "size: " + file.size + " bytes <br />";
						} else {
							message += "size: " + file.fileSize + " bytes <br />";
						}
						if ('mediaType' in file) {
							message += "type: " + file.mediaType + "<br />";
						}
					}
				}
				$('#submit').show();
				document.getElementById("submit").value = "Upload file";
			} else {
				if (fileInput.value == "") {
					message += "Please browse for one or more files.";
					message += "<br />Use the Control or Shift key for multiple selection.";
				} else {
					message += "Your browser doesn't support the files property!";
					message += "<br />The path of the selected file: " + fileInput.value;
				}
			}
		}

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
	include ('./includes/banner.inc');
	?>

	<div class="container">
		<div class="row">
			<div class="col-md-12 ">
				<h2>Welcome to the Vineyard Mid Atlantic Region website (VMAR)</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 " style="font-size : large; font-weight: bold;">		
				This web site was build for you and it is yours to use!<p>	
				If you have not registered as a VMAR user, please register using the <a href=new_user.php>Register</a> link above.<br/>
				VMAR users can add content, such as special church events, to the VMAR web site.  
				<p>
				</div>
				<div class="col-md-12 " style="font-size : normal; font-weight: normal;">	
				<h3>Goals and features of VMAR:</h3>
<ul class="list-group">
	<li class="list-group-item">
<b> Share Information </b> - 
A core feature of Vineyard Mid-Atlantic Region (VMAR) is to be a tool to share information among the Vineyard Churches of the mid-Atlantic region. VMAR provides a Search function to allow easy searches of posted information and an Add Content function to allow easy uploads of content including files such as videos, pictures, fliers, documents, or audio files. Topics include special church events, regional events, sermons, and announcements.
</li>
<li class="list-group-item">
<b>Promote Vineyard Churches</b> - 
VMAR will use the VMAR map any other functions to promote Vineyard churches. One hope is that prospective church members will use VMAR to find a local Vineyard church. The VMAR map shows Vineyard church locations and provides introductory text as well and links to Vineyard churches. 
</li>
<li class="list-group-item">
<b>Broadcast new content</b> - 
VMAR will broadcast email to all VMAR users whenever new content is posted to VMAR. 
</li>
<li class="list-group-item">
<b>Login</b> - 
Login is required to make any changes to VMAR content. Email addresses are used for usernames. 
The passwords are selected by, and only know to, each VMAR user. Each user will register 
themselves to the VMAR site, and password entry will occur at the time of registration. 
VMAR users can not completely self-register since the VMAR Administrator will approve each VMAR user request. 
</li>

<li class="list-group-item">
<b>Mobile, Tablet or Desktop</b> - 
VMAR uses a web technology called Bootstrap that allows the same web page to display and operate well no matter what size device is being used. This technology uses basic building components of the Internet and this technology is device independent. Bootstrap only considers the width of the display to adapt the web page and it works just as well on an iPhone, Android or desktop. 
</li>
</ul>
				
				</p>
			</div>
		</div>
	</div><!-- /.container -->

</body>