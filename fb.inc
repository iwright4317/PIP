<?php
//echo 'Start of fb.inc';
define('FACEBOOK_SDK_V4_SRC_DIR', './facebook-php-sdk-v4-4.0-dev/src/Facebook/');
//require __DIR__ . './facebook-php-sdk-v4-4.0-dev/autoload.php';
require __DIR__ . '/facebook-php-sdk-v4-4.0-dev/autoload.php';
use Facebook\FacebookJavaScriptLoginHelper;

// Make sure to load the Facebook SDK for PHP via composer or manually
 
use Facebook\FacebookSession;
// add other classes you plan to use, e.g.:
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

//FacebookSession::setDefaultApplication('920710601313441', 'c250d074a266c60dbc0c3080684bc941');
FacebookSession::setDefaultApplication('590196541083386', '992967677b6c9a5e2b629dcf0270d246');

// Add `use Facebook\FacebookJavaScriptLoginHelper;` to top of file
$helper = new FacebookJavaScriptLoginHelper();
	try {
		$session = $helper -> getSession();
	} catch(FacebookRequestException $ex) {
		// When Facebook returns an error
	} catch(\Exception $ex) {
		// When validation fails or other local issues
	}

if ($session) {
	
	try { 
		$user_profile =   (new FacebookRequest($session, 'GET', '/me?fields=email')) -> execute() -> getGraphObject(GraphUser::className());
		$e = $user_profile -> getEmail();		
		//echo '; should have email' . $e;
		if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
			$connection = mysql_connect("localhost", "vmarch5_ecomm", "bobcatalina66") or die('I cannot connect to the database because: ' . mysql_error());
			$dbc = mysql_select_db("vmarch5_ecommercerw") or die("<p>DB select failed ||<p>" . mysql_error());

			$e = mysql_real_escape_string($e);
			$q = "Select FirstName, Id from VMAR_users Where Email = '" . $e . "'  ";
			//echo $q;
			$r = mysql_query($q) or die("<br/>Query failed");

			if ($row = mysql_fetch_array($r)) {
				$_SESSION["user_name"] = $row[0];
				$_SESSION["user_id"] = $row[1];
				?>
				<script>
					//document.getElementById("webFunctions").style.display = 'block';
 				</script>
				<?php
			} else {
				$_SESSION["user_name"] = "username and password not found";
				?>
				<script>
					//document.getElementById("webFunctions").style.display = 'none';
				</script>
  				<?php
				//$_SESSION["user_id"] = "";
			}
	} else {
		$_SESSION["user_name"] = "Please enter a valid email address";
		?>
		<script> 
			//document.getElementById("webFunctions").style.display = 'none'; 
 		</script> 
 		<?php
	}

} catch(FacebookRequestException $e) {
	echo "Exception occured, code: " . $e -> getCode();
	echo " with message: " . $e -> getMessage();
}
} // end session
?>

<script>
	// This is called with the results from from FB.getLoginStatus().
	function statusChangeCallback(response) {
		console.log('statusChangeCallback');
		console.log(response);
		// The response object is returned with a status field that lets the
		// app know the current login status of the person.
		// Full docs on the response object can be found in the documentation
		// for FB.getLoginStatus().
		if (response.status === 'connected') {
			// Logged into your app and Facebook.
			testAPI();
		} else if (response.status === 'not_authorized') {
			// The person is logged into Facebook, but not your app.
			document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
		} else {
			// The person is not logged into Facebook, so we're not sure if
			// they are logged into this app or not.
			// document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
		}
	}

	// This function is called when someone finishes with the Login
	// Button.  See the onlogin handler attached to it in the sample
	// code below.
	function checkLoginState() {
		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});
	}


	window.fbAsyncInit = function() {
		// appId : '920710601313441', // old id
		//appId : '590196541083386', // new id
		//'920710601313441', 
		FB.init({
			appId : '590196541083386', 
			cookie : true, // enable cookies to allow the server to access
			// the session
			xfbml : true, // parse social plugins on this page
			version : 'v2.2' // use version 2.2
		});

		// Now that we've initialized the JavaScript SDK, we call
		// FB.getLoginStatus().  This function gets the state of the
		// person visiting this page and can return one of three states to
		// the callback you provide.  They can be:
		//
		// 1. Logged into your app ('connected')
		// 2. Logged into Facebook, but not your app ('not_authorized')
		// 3. Not logged into Facebook and can't tell if they are logged into
		//    your app or not.
		//
		// These three cases are handled in the callback function.

		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});

	};

	// Load the SDK asynchronously
	( function(d, s, id) {
			var js,
			    fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id))
				return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		// Here we run a very simple test of the Graph API after login is
		// successful.  See statusChangeCallback() for when this call is made.
		function testAPI() {
			console.log('Welcome!  Fetching your information.... ');
			FB.api('/me?fields=name,email', function(response) {
			console.log('Successful login for: ' + response.name);
			document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';
			//document.getElementById('status').innerHTML = response.email;
			//document.getElementById("webFunctions").style.display = 'block';
			document.getElementById("loginDiv").style.display = 'none';
			document.getElementById("signDiv").style.display = 'none';						
		});			
	}
</script>
				
<script>
	function fbLogout2() {
		//alert("fblogout start");
			document.getElementById("signDiv").style.display = 'block';
			//document.getElementById("webFunctions").style.display = 'none';
			FB.logout(function(response) {
				// user is now logged out
				document.getElementById('status').innerHTML = 'Please login to facebook';
			});
		//alert("fblogout end");
	}
</script>

<div id="fb-root"></div>

<!-- <script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script> -->
