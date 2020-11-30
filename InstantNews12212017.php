#!/usr/bin/php -q
<?php
date_default_timezone_set('US/Eastern');

include_once 'includes/fatalHandler.php';
include_once 'includes/db_config.php';
include_once 'includes/db_function.php';
require_once('PHPMailer/class.phpmailer.php');
set_time_limit(0);
 
$dbConnection = new DB_con();
$dbConnection = $dbConnection->ret_obj();

$dbConnection8 = new DB_con();
$dbConnection8 = $dbConnection8->ret_obj();

$dbConnection6 = new DB_con();

$dbFunction = new DB_function();
include_once 'includes/format_function.php';
$formatter = new VAR_formatter();

//$actual_link = "http://" . $_SERVER['SERVER_NAME'];
$actual_link = "http://punews.VaBeachPU.com";

//$host = "{gator4036.hostgator.com:143}";
//$pw = "1GreatPUsite!";

//$host = "{vps34396.inmotionhosting.com}";
$host = "{vps34396.inmotionhosting.com:143/novalidate-cert}INBOX";

$pw = "VaBeachPU1987!"; 

$db = False; 
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
if (isset($db) && $db) {echo "<br>Start ";}
$q = "select Name from Organizations Where Department = 'Public Utilities' and Name <> '' and Name is Not Null";
$r = $dbConnection6->connection->query($q);


$MailBoxNames = array();
$m=0;
while ($row = $r->fetch_array(MYSQLI_ASSOC)) {
	$MailBoxNames[$m] = $row['Name'];
	$m++;
}
mysqli_close($dbConnection6->connection);

foreach ($MailBoxNames as $user) {
	$user= $user . "@vabeachpu.com";
	//$user= $user . "test@vabeachpu.com";
	//$user = str_replace("testtest","test",$user);	

	if (isset($db) && $db) {echo "<br><h2>New mail box: $user</h2>";}

	//if (empty($host) || empty($user) || empty($pw)){		
	//} else {
	//    $bucket = EmailDownload($host, $user, $pw, $dbConnection, $db, $dbConnection8);
  	//}
	
	
	if (isset($_GET["mb"]) && trim($_GET["mb"]) != "") {
		if ($_GET["mb"] == $user) {
			$bucket = EmailDownload($host, $user, $pw, $dbConnection, $db, $dbConnection8);
		}		
	} else {
		if (isset($db) && $db) {echo "<br><h2>New mail box: $user</h2>";}
		if (empty($host) || empty($user) || empty($pw)){		
		} else {
	    	$bucket = EmailDownload($host, $user, $pw, $dbConnection, $db, $dbConnection8);
  		}
  	}
  	exit;
  	
}

mysqli_close($dbConnection);
mysqli_close($dbConnection8);

if (1 == 2) {
while ($row = $r->fetch_array(MYSQLI_ASSOC)) { 
$user= $row['Name'] . "@vabeachpu.com";	
if (isset($db) && $db) {echo "<br><h2>New mail box: $user</h2>";}

if (empty($host) || empty($user) || empty($pw)){
  //echo '<p>To get mail, specify parameters (host, username and password) in url as ' . $_SERVER['REQUEST_URI']. '?=host=hostname&user=username&pw=password</p>';
  //echo '<p>Example: ' . $_SERVER['REQUEST_URI']. '?host=mail.mydomain.com&user=name@mydomain.com&pw=1234567</p>';
  } else {
    $bucket = EmailDownload($host, $user, $pw, $dbConnection, $db, $dbConnection8);
  }
}
}

function EmailEmbeddedLinkReplace($html, $cid, $link)
{
  // In $html locate src="cid:$cid" and replace with $link.
  $cid='cid:'.substr($cid, 1, strlen($cid)-2);
  $newHtml = str_replace($cid, $link, $html);
  return $newHtml;
}

function OpenerIdReplace($html, $OpenerId)
{
  // In $html locate OpenerId=0 and replace with OpenerId=$OpenerId.
  $OpenerId="OpenerId=".$OpenerId;
  $newHtml = str_replace("OpenerId=0", $OpenerId, $html);
  return $newHtml;
}

function EmailConnect($host, $user, $password,$db){
  //$hostName = '{'.$host.':143/novalidate-cert}INBOX';  
  $password = "VaBeachPU1987!"; 
  //$password = "1GreatPUsite!"; HG 
  //if (isset($db) && $db) {echo "<br>EmailConnect $host, $user, $password";}
  //if (isset($db) && $db) {echo '<br>should be: "{gator4036.hostgator.com:143}","punews@vabeachpu.com","1GreatPUsite!"';}
  //$inbox = imap_open("{gator4036.hostgator.com:143}","punews@vabeachpu.com","1GreatPUsite!") or die('Could not connect to mail server');
  //$inbox = imap_open($host,$user,$password) ;
  //$inbox = imap_open('{localhost:143/imap/novalidate-cert}', $user, base64_decode($password), 0, 1); 
  //$inbox = imap_open("{vps34396.inmotionhosting.com:993}","punews@vabeachpu-dnskey.com",$password);
  //$inbox = imap_open("{vps34396.inmotionhosting.com}","punews@vabeachpu-dnskey.com","VaBeachPU1987!");
  //$inbox = imap_open("{vps34396.inmotionhosting.com:993}","punews@vabeachpu.com","VaBeachPU1987!");
  //$inbox = imap_open('{localhost:993/imap/novalidate-cert}', "punews@vabeachpu-dnskey.com", $password); 
  //$inbox = imap_open('{localhost:993/imap/novalidate-cert}', "punews@vabeachpu.com", $password); 
  //$inbox = imap_open("{localhost:143}", "punews@vabeachpu.com-dnskey.com", $password);
  //$inbox = imap_open("{vps34396.inmotionhosting.com:143}","punews@vabeachpu.com","VaBeachPU1987!") or die('Could not connect to mail server');
  //$inbox = imap_open("{mail.vabeachpu-dnskey:143}","punews@vabeachpu-dnskey.com","VaBeachPU1987!") or die('Could not connect to mail server');
  //$inbox = imap_open("{mail.vabeachpu-dnskey:143}INBOX","punews@vabeachpu-dnskey.com","VaBeachPU1987!") or die('Could not connect to mail server');
  //$inbox = imap_open("{mail.vabeachpu-dnskey.com:143}INBOX","punews@vabeachpu-dnskey.com","VaBeachPU1987!") or die('Could not connect to mail server');
  
  $password = "VaBeachPU1987!"; 
  $host = "{mail.vabeachpu-dnskey.com:143}INBOX";
  $user = "punews@vabeachpu.com";
  //imap_open ("{localhost:993/imap/ssl/novalidate-cert}", "user_id", "password");
$hosts = array(
"{mail.vabeachpu.com:143}",
"{mail.vabeachpu.com:143}INBOX",
"{localhost:993/imap/ssl}INBOX",
"{vps34396.inmotionhosting.com:995}",
"{vps34396.inmotionhosting.com:993}",
"{localhost:995}",
"{localhost:993}",
"{localhost:993/imap/ssl/novalidate-cert}",
"{localhost:995/pop3/ssl/novalidate-cert}",
"{localhost:143}", 
"{localhost:143/imap/novalidate-cert}",
"{vps34396.inmotionhosting.com:143}",
"{mail.vabeachpu-dnskey.com:143}",
"{localhost:143}INBOX",
"{localhost:143/imap/novalidate-cert}INBOX",
"{vps34396.inmotionhosting.com:143}INBOX",
"{mail.vabeachpu-dnskey.com:143}INBOX",
"{vps34396.inmotionhosting.com}",
"{vps34396.inmotionhosting.com:143}",
"{vps34396.inmotionhosting.com:143}INBOX",
"{vps34396.inmotionhosting.com:993}",
"{vps34396.inmotionhosting.com:993}INBOX"
);
$maxH = 21;

$users = array(
"punews@vabeachpu.com",
"punews@vabeachpu-dnskey.com"
);
$maxU = 2;

	for ($h=0;$h<=4;$h++) {
  		for($u=0;$u<=0;$u++) {
  			if (isset($db) && $db) {echo "<br>emailConnect $hosts[$h], $users[$u], $password";}
	  		$inbox = imap_open($hosts[$h],$users[$u],$password);
  			if ($inbox === false) {echo "<br>failure";}
  		}
	}
  
  return true;
}  

function trimArray($values){
  $trimmed=array();
  foreach ($values as $value){
    $trimmed[]=trim($value);
  }
  return $trimmed;
}

function extractField($fieldName, $values){
  $index=array_search($fieldName, $values);
  $id=($index === FALSE) ? "" : $values[$index+1];
  return $id ;
}

function extractValue($prefix, $values){
  $result="";
  foreach ($values as $value){
    if (0===strpos($value, $prefix)){
      $result=substr($value, strlen($prefix)+2,-1);
      continue;
    }
  }
  return $result;
}

function extractMimeFileName($values){
  $filename=extractField("X-Attachment-Id:", $values);
  if (empty($filename)){
    $filename=extractValue("filename", $values);
  }
  if (empty($filename)){
    $filename=extractValue("name", $values);
  }
  if (empty($filename)){
    $filename="unknown";
  }
  return $filename ;
}

function fetchImageInfo($mailbox, $emailNumber, $partNo){
  $mime=imap_fetchmime($mailbox, $emailNumber, $partNo, (FT_PEEK));
  $mime= preg_split('/\s+/', $mime);
  $mime=trimArray($mime);
  $id=extractField("Content-ID:", $mime);
  $filename=extractMimeFileName($mime);
  $info=array('id'=>$id, 'filename' => $filename);
  return $info;
}

function getBody($imap, $uid) {
    $body = get_part($imap, $uid, "TEXT/HTML");
    // if HTML body is empty, try getting text body
    if ($body == "") {
        $body = get_part($imap, $uid, "TEXT/PLAIN");
    }
    return $body;
}

function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
    if (!$structure) {
           $structure = imap_fetchstructure($imap, $uid);
    }
    if ($structure) {
        if ($mimetype == get_mime_type($structure)) {
            if (!$partNumber) {
                $partNumber = 1;
            }
            $text = imap_fetchbody($imap, $uid, $partNumber);
            switch ($structure->encoding) {
                case 3: return imap_base64($text);
                case 4: return imap_qprint($text);
                default: return $text;
           }
       }

        // multipart 
        if ($structure->type == 1) {
            foreach ($structure->parts as $index => $subStruct) {
                $prefix = "";
                if ($partNumber) {
                    $prefix = $partNumber . ".";
                }
                $data = get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                if ($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}


function calMins($PrevSent, $CurSent) {
	$PrevSent = str_replace("&nbsp;","",$PrevSent);
	$PrevSent = trim($PrevSent);
	$CurSent = str_replace("&nbsp;","",$CurSent);
	$CurSent = trim($CurSent);
	if (checkDates($PrevSent, $CurSent)) {
		$start_date = new DateTime($PrevSent);
		$since_start = $start_date->diff(new DateTime($CurSent));
		$minutes = $since_start->days * 24 * 60;
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;		
		return $minutes;
	} else {
		return 0;
	}
}

function checkDates($PrevSent, $CurSent) {
	$goodDates = False;
	if (isset($PrevSent) && strtotime($PrevSent) !== false) {$goodDates = True;}
	if (isset($CurSent) && strtotime($CurSent) !== false && $goodDates) {$goodDates = True;	}
	return $goodDates;	
}

function get_mime_type($structure) {
    $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

    if ($structure->subtype) {
       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
    }
    return "TEXT/PLAIN";
}

function getAttachments($imap, $mailNum, $part, $partNum, $dbConnection,$db) {
	//echo '<p><b>Start of getAttachments</b>';
    $attachments = array();

    if (isset($part->parts)) {
    	//echo '<br>We have parts';
        foreach ($part->parts as $key => $subpart) {
            if($partNum != "") {
                $newPartNum = $partNum . "." . ($key + 1);
            }
            else {
                $newPartNum = ($key+1);
            }
			//echo '<br>newPartNum: ' . $newPartNum;
            $result = getAttachments($imap, $mailNum, $subpart,
                $newPartNum, $dbConnection,$db);
			
            if (count($result) != 0) {
                 array_push($attachments, $result);
             }
        }
    }
    else if (isset($part->disposition)) {
    	//echo '<br>check disposition: ' . $part->disposition;
        if (strtolower($part->disposition) == "attachment") {
        	//echo '<br>Attachment found ';
            $partStruct = imap_bodystruct($imap, $mailNum,
                $partNum);
            $attachmentDetails = array(
                "name"    => $part->dparameters[0]->value,
                "partNum" => $partNum,
                "enc"     => $partStruct->encoding
            );
            return $attachmentDetails;
        }
    }

    return $attachments;
}

// Based upon http://php.net/manual/en/function.imap-fetchstructure.php.
function EmailGetPart($mailbox, $emailNumber, $part, $partNo, $result, $dbConnection,$db){
	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	
  $parameter = array();
  $attachments = array();
  $plainText = '';
  $htmlText = '';
  // GET DATA
  $data = ($partNo) ? imap_fetchbody($mailbox,$emailNumber,$partNo) : imap_body($mailbox, $emailNumber);
  // Any part may be encoded, even plain text messages, so check everything.
  $encoding = $part->encoding ;
  $type=$part->type;
  $ifid=$part->ifid;
  
  if ($encoding==ENCQUOTEDPRINTABLE){
      $data = quoted_printable_decode($data);
  } elseif ($encoding==ENCBASE64) {
      $data = base64_decode($data);
  }
  // PARAMETERS
  // get all parameters, like charset, filenames of attachments, etc.
  if($part->ifdparameters) {
    foreach($part->dparameters as $object) {
      $parameter[strtolower($object->attribute)] = $object->value;
    }
  }
  if($part->ifparameters) {
    foreach($part->parameters as $object) {
      $parameter[strtolower($object->attribute)] = $object->value;
    }
  }

  // ATTACHMENT
  // Any part with a filename is an attachment,
  // so an attached text file (type 0) is not mistaken as the message.
  if(isset($parameter['filename']) || isset($parameter['name'])) {
    $filename = ($parameter['filename'])? $parameter['filename'] : $parameter['name'];
  	if (isset($db) && $db) {echo "<br>EmailGetPart - " . $filename;}
    $filename=iconv_mime_decode($filename, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8');
    $id = isset($part->id) ? $part->id : '' ;
    $attachments[] = array('inline' => false, 'filename' => $filename, 'part' => $partNo, 'data' => $data, 'id' => $id, 'ifid' => $ifid);
  }
  if (isset($db) && $db) {echo "<br>EmailGetPart - type" . $type;}
  if ($type==TYPEIMAGE){
    $info=fetchImageInfo($mailbox, $emailNumber, $partNo);
    $attachments[] = array('inline' => true, 'filename' => $info['filename'], 'part' => $partNo, 'data' => $data, 'id' => $info['id'], 'ifid' => $ifid);
  }
  if ((!empty($data)) && empty($filename)){
    if ($type==TYPETEXT) {
      // Messages may be split in different parts because of inline attachments,
      // so append parts together with blank row.
      if (strtolower($part->subtype)=='plain') {
          $plainText.= trim($data) ."\n\n";
      } else {
          $htmlText.= $data ."<br><br>";
      }
      // assume all parts are same charset
      $result->charset = $parameter['charset'];
    } elseif ($type==TYPEMESSAGE) {
      // EMBEDDED MESSAGE
      // Many bounce notifications embed the original message as type 2,
      // but AOL uses type 1 (multipart), which is not handled here.
      // There are no PHP functions to parse embedded messages,
      // so this just appends the raw source to the main message.
          $plainText.= $data."\n\n";
    }
  }
  // SUBPART RECURSION
  $result->attachments = array_merge($result->attachments, $attachments);
  $result->plainText   = $result->plainText . $plainText;
  $result->htmlText    = $result->htmlText . $htmlText;
  if (isset($part->parts)){
    $result = EmailGetParts($mailbox,$emailNumber, $part->parts, $partNo, $result, $dbConnection,$db);
  }
  return $result;
}



function EmailGetParts($mailbox, $emailNumber, $parts, $partNo, $result, $dbConnection,$db){
	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	$showHead = False;
	if (isset($_GET["head"]) && trim($_GET["head"]) == "yes") {
		$showHead = True;
	}
	if (isset($db) && $db) {echo "<br>EmailGetParts";}
	
	include_once 'includes/db_config.php';
	include_once 'includes/db_function.php';
	include_once 'includes/format_function.php';
	
	//$dbConnection = new DB_con();
	//$dbConnection = $dbConnection->ret_obj();
	$dbFunction = new DB_function();
	$formatter = new VAR_formatter();
	
  	if (isset($parts) && count($parts)) {
    	foreach ($parts as $partIx=>$subPart){
      		$subPartNo = empty($partNo) ? ($partIx+1) : $partNo . '.' . ($partIx+1);
      		$result = EmailGetPart($mailbox,$emailNumber, $subPart, $subPartNo, $result, $dbConnection,$db);
    	}
  	}
  
	$dbFunction = new DB_function();
			
  	// Need limit this to one time per email; database?
  	
  	$uid = imap_uid($mailbox,$emailNumber); 
	$q = "Select Id from Message Where imap_uid = " . $uid;
	
	if (isset($db) && $db) {echo "<br>EmailGetParts $q";}
	
	$r = $dbConnection->query($q);	
	if ($row = $r->fetch_array(MYSQLI_ASSOC)) {if (isset($db) && $db) {echo "<br>exsiting record: $uid -> no new processing";}  }
	
	else {		
  	//if (1 == 1) {
  		$hops = array(array("FromAddr", "ToAddr", 0.0, "Prev", "Cur"));
		$hopsIndex = 0;
		$CurSent = date_create();
		$PrevFromName  = 'Destination';
		$PrevSent = '';
  
		$date = date_create();
		$PrevSent =  date_format($date, 'm/d/Y h:i:s A');	
	
		$header2 = imap_headerinfo($mailbox,$emailNumber); 
	
    	$fromInfo = $header2->from[0];
    	$replyInfo = $header2->reply_to[0];
    	$toInfo = $header2->to[0];

    	$details = array(
 	       "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
    	        ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        	"fromName" => (isset($fromInfo->personal))
            	? $fromInfo->personal : "",
	        "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
    	        ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        	"replyName" => (isset($replyTo->personal))
            	? $replyto->personal : "",
	        "subject" => (isset($header2->subject))
    	        ? $header2->subject : "",
        	"toName" => (isset($toInfo->personal))
            	? $toInfo->personal : "",
	        "toAddr" => (isset($toInfo->mailbox) && isset($toInfo->host))
    	        ? $toInfo->mailbox . "@" . $toInfo->host : "",
        	"udate" => (isset($header2->udate))
            	? $header2->udate : ""
    	);
		
		if (isset($db) && $db) {echo "<p>EmailGetParts - before getValidateMember " . $details["fromAddr"];}
		if ($dbFunction->getValidateMember($details["fromAddr"])) {

		if (isset($db) && $db) {echo "<br>EmailGetParts - valid member";}
    	$uid = imap_uid($mailbox,$emailNumber); 

    	//echo "<br><strong>" . $details["subject"] . "</strong>";
    	if (isset($db) && $db) {echo "<br><strong>To:</strong> " . $details["toName"];}
    	if (isset($db) && $db) {echo "<br><strong>From:</strong> " . $details["fromName"];}
    	if (isset($db) && $db) {echo " " . $details["fromAddr"] . "";}
	
		$date = date_create();
		$PrevSent =  date_format($date, 'm/d/Y h:i:s A');
	
		if (isset($header2->Date)) {
			$date = date_create($header2->Date);
			date_sub($date, date_interval_create_from_date_string('5 hours'));
			$PrevSent =  date_format($date, 'm/d/Y h:i:s A');
    		if (isset($db) && $db) {echo "<br><strong>Date:</strong> " . $PrevSent;}
		}				
		
		// Get full header to find importance of email 
		$hlines = explode("\n", imap_fetchheader($mailbox,$emailNumber)); 
		if (isset($db) && $db) {echo "<p>Start of email header search by line";}
		$htmlAttachments = '';
		$importance = "normal";
	
		for ($h=0; $h < count($hlines); $h++) {
			if (isset($db) && $db && $showHead) {echo '<br>h|' . $hlines[$h]; }
			$pos = strpos($hlines[$h], 'Importance: high');		
			if ($pos !== false) {
				$importance = 'high';
			}			
			$pos = strpos($hlines[$h], 'Importance: low');		
			if ($pos !== false) {
				$importance = 'low';
			}			
		}	
			
  		if (isset($db) && $db) {echo "<br>get mailbox number: |$mailbox|";}
  		$msgInfo = imap_mailboxmsginfo($mailbox);
		$mailBoxName = $formatter->MailboxName($msgInfo->Mailbox);		
  		if (isset($db) && $db) {echo "<br>get mailbox name: |$mailBoxName|";}
		
		//imap_mailboxmsginfo
		$q = "Insert into Message (Title, SendDate, imap_uid, Importance, MailBox) values (
		'" . str_replace("'","''",$details["subject"]) . "','" . 
		str_replace("'","''",$formatter->SQLDateTime($formatter->todayIfEmpty($PrevSent))) . "',
		" . $uid . ",'" . $importance . "','" . $mailBoxName ."')"; 

		if (isset($db) && $db) {echo "<br>Update message record: " . $q;}
		$r = $dbConnection->query($q);	
	
		if (isset($details["fromAddr"]) && trim($details["fromAddr"]) <> ""){
			//$SentBy = $dbFunction->getMemberInfo($details["fromAddr"]);
			$SentBy = $details["fromAddr"];
			if (isset($db) && $db) {echo "<br>SentBy: $SentBy";}
			$sourceSection = $dbFunction->getMemberInfo($details["fromAddr"],"Section");
			if (isset($db) && $db) {echo "<br>432 sourceSection: $sourceSection";}
			$source = $dbFunction->getMemberInfo($details["fromAddr"],"Source");
			if (isset($db) && $db) {echo "<br>434 source: $source";}
		} else {
			if (isset($db) && $db) {echo "<br>No fromAddr";}
		}
	
		if (isset($db) && $db) {echo "<br><b>Check SQLDateTime :$PrevSent </b>";}	
	
		$hops = array(array("From", "To", 0.0, "Prev", "Cur"));
		$hops[0][0] = $details["fromAddr"];
		$hops[0][1] = "punews receiver";
	
		$blines = explode("\n", getBody($mailbox,$emailNumber)); 
		if (isset($db) && $db) {echo "<p>Start of email message search by line";}
	
		for ($m=0; $m < count($blines); $m++) {			
			if (isset($db) && $db && $showHead) {echo "<br>blines[m]: " . $blines[$m];}
			//
			// From line
			//
			$pos = strpos($blines[$m], 'From:');
			if ($pos !== false) { 
				if (isset($db) && $db) {echo '<p>b|' . $blines[$m];}		
				$fromName = substr($blines[$m],$pos);
				$fromName = trim(strip_tags(str_replace("From:","",$fromName)));
				if (isset($db) && $db) {echo"<br>New fromName: |" . $fromName . "|";	}
			
				if ($hopsIndex == 0) {if (isset($db) && $db) {echo "<br>Index 0 update hops & PrevFromName";}
					$hops[1][0] = $fromName;
					$PrevFromName = $fromName;
				} else { if (isset($db) && $db) {echo "<br>Index not 0 update hops & PrevFromName";}
					If ((isset($hops[$hopsIndex][0]) && trim($hops[$hopsIndex][0]) <> "") && 
					(isset($hops[$hopsIndex][1]) && trim($hops[$hopsIndex][1]) <> ""))
					{ $hopsIndex = $hopsIndex + 1; if (isset($db) && $db) {echo "<br>New hop";} 	}
						
					if (isset($db) && $db) {echo "<br>Index after advance check: |" . $hopsIndex . "|";}

					$hops[$hopsIndex][0] = $fromName;	
				
					// the line below seems to be the responsble for not recognizing a hop if sender and receiver are the same
					// Not sure about this.
					if ($PrevFromName <> $fromName) { $hops[$hopsIndex][1] = $PrevFromName; }						
					$PrevFromName = $fromName;
				}
			}


			//
			// Sent line
			//
			$pos = strpos($blines[$m], 'Sent:');		
			if ($pos !== false) {
				if (isset($db) && $db) {echo "<p>Send line found";	}
				$CurSent = substr($blines[$m],$pos);
				$CurSent = trim(strip_tags(str_replace("Sent:","",$CurSent)));
				if (isset($db) && $db) {echo "<br>New Current Sent: |" . $CurSent . "|";	}
				if (isset($db) && $db) {echo "<br>PrevSent: |" . $PrevSent . "|";}
			
				// need to check for reachback			
				if (isset($db) && $db) {echo "<br>Index before check reachback: |" . $hopsIndex . "|";}
				if ($hopsIndex == 0) { if (isset($db) && $db) {echo "<br>Index 0 check for 0 duration ";}
					// Check for an existing duration
					if ((isset($hops[$hopsIndex][2]) && $hops[$hopsIndex][2] == 0) or
						!isset($hops[$hopsIndex][2])) { if (isset($db) && $db) {echo "<br>Check for cur and prev dates ";}
					
						if (checkDates($PrevSent, $CurSent)) {
							if ($PrevSent <> $CurSent && $PrevSent <> '') { if (isset($db) && $db) {echo "<br>Cur and prev dates good, calculate duration";}
								$hops[$hopsIndex][2] = calMins($PrevSent, $CurSent);	
								$hops[$hopsIndex][3] = $PrevSent;	
								$hops[$hopsIndex][4] = $CurSent;				
							} 
						} 
						if (isset($db) && $db) {echo "<br>Fresh duration: |" .$hops[$hopsIndex][2] . "</br>";}
						$PrevSent = $CurSent;						
					}
				
					// forward the previous From to the "current" To
					if (isset($db) && $db) {echo "<br>forward the previous From to the 'current' To";	}
					if (!isset($hops[1][1])) {$hops[1][1] = $hops[0][0];}
				}
			
				If ((isset($hops[$hopsIndex][0]) && trim($hops[$hopsIndex][0]) <> "") && 
				(isset($hops[$hopsIndex][1]) && trim($hops[$hopsIndex][1]) <> "") &&
				(isset($hops[$hopsIndex][2]) && $hops[$hopsIndex][2] <> 0)) { $hopsIndex = $hopsIndex + 1;if (isset($db) && $db) {echo "<br>New hop"; } }			
			
				if (isset($db) && $db) {echo "<br>Index after check for advance: |" . $hopsIndex . "|";}
			
				if (checkDates($PrevSent, $CurSent)) {
					if ($PrevSent <> $CurSent && $PrevSent <> '') { if (isset($db) && $db) {echo "<br>Cur and prev dates good, calculate duration";}
						if ($hopsIndex > 0) {
							$hops[$hopsIndex-1][2] = calMins($PrevSent, $CurSent);		
							$hops[$hopsIndex-1][3] = $PrevSent;	
							$hops[$hopsIndex-1][4] = $CurSent;						
						}			
					} else { if (isset($db) && $db) {echo "<br>Cur and prev same value, placehold duration at 0";}
						$hops[$hopsIndex][2] = 0;
					}
				} 
				if (isset($db) && $db && isset($hops[$hopsIndex][2])) {echo "<br>Fresh duration: |" .$hops[$hopsIndex][2] . "</br>";}
				$PrevSent = $CurSent;					
			}		
			
			//
			// Date line
			//
			$pos = strpos($blines[$m], 'Date:');		
			if ($pos !== false) {
				$CurSent = substr($blines[$m],$pos);
				$CurSent = str_replace("(GMT-05:00)","",$CurSent);
				$CurSent = trim(strip_tags(str_replace("Date:","",$CurSent)));
				if (isset($db) && $db) {echo "<br>Current Sent: |" . $CurSent . "|";}	
				if (isset($db) && $db) {echo "<br>PrevSent: |" . $PrevSent . "|";}
			
				If ((isset($hops[$hopsIndex][0]) && trim($hops[$hopsIndex][0]) <> "") && 
				(isset($hops[$hopsIndex][1]) && trim($hops[$hopsIndex][1]) <> "") &&
				(isset($hops[$hopsIndex][2]) && $hops[$hopsIndex][2] <> 0)) {
					 $hopsIndex = $hopsIndex + 1; if (isset($db) && $db) {echo "<br>New hop";} 	}		
			
				if (isset($db) && $db) {echo "<br>hopsIndex: |" . $hopsIndex . "|";}
						
				if (checkDates($PrevSent, $CurSent)) {
					if ($PrevSent <> $CurSent && $PrevSent <> '') {	
						if ($hopsIndex > 0) {			
							$hops[$hopsIndex-1][2] = calMins($PrevSent, $CurSent);	
							$hops[$hopsIndex-1][3] = $PrevSent;	
							$hops[$hopsIndex-1][4] = $CurSent;	
						}					
					} 
				} 
				if (isset($db) && $db && 1 == 2) {echo "<br>Fresh duration: |" .$hops[$hopsIndex][2] . "</br>";}
				$PrevSent = $CurSent;	
			
			}	
			
			if (isset($db) && $db && 1 == 2){
				for ($n=0; $n < count($hops); $n++) {			
					if (isset($db) && $db) {echo "<p>n: " . $n;} 
					if (isset($hops[$n][1])) {echo "<p>To: " . $hops[$n][1]; }
					if (isset($hops[$n][0])) {echo "<br>From: " . $hops[$n][0]; }
					if (isset($hops[$n][2])) {echo "<br>Duration: " . $hops[$n][2]; }
				}									
				echo "<br>End of hops&nbsp;<br>";			
				echo "<p>PrevSent: |" . $PrevSent . "|";	
				echo "<br>Current Sent: |" . $CurSent . "|";	
				echo "<br>PrevFromName: |" . $PrevFromName . "|";	
				echo "<br>fromName: |" . $fromName . "|";
			}		
		} // All of the lines in the body
	
		if (isset($db) && $db) {echo "<p><b>Thread Report</b>";}

		$TotalDuration = 0;
		for ($n=0; $n < count($hops); $n++) {
	
			if (isset($db) && $db) {
				echo "<p>Hop: " . $n ."";
				if (isset($hops[$n][1])) {echo "<p>To: " . $hops[$n][1] .""; }
				if (isset($hops[$n][0])) {echo "<br>From: " . $hops[$n][0] .""; }
				if (isset($hops[$n][2])) {
					echo "<br>Duration: " . $hops[$n][2] . " minutes"; 
				} else {
					echo "<br>Source of email thread: " . $hops[$n][0];
				}
	
				if (isset($hops[$n][3])) {echo "<p>Prev: " . $hops[$n][3] .""; }
				if (isset($hops[$n][4])) {echo "<br>Cur: " . $hops[$n][4] .""; }
			}
	
			$ToAddr = "unknown";
			if (isset($hops[$n][1])) {$ToAddr = $hops[$n][1];}
			$FromAddr = "unknown";
			if (isset($hops[$n][0])) {$FromAddr = $hops[$n][0];}
			$Todate = "unknown";
			if (isset($hops[$n][4])) {$Todate = $formatter->SQLDateTime($hops[$n][4]);}
			$FromDate = "unknown";
			if (isset($hops[$n][3])) {$FromDate = $formatter->SQLDateTime($hops[$n][3]);}
			$Duration = 0;		
			if (isset($hops[$n][2])) {$Duration = $hops[$n][2];}
		
			$TotalDuration += $Duration;
	
			if (isset($db) && $db) {echo "<p>getSection" . $FromAddr;}
	
			$sourceSection = $dbFunction->getMemberInfo($FromAddr,"Section");
			if (isset($db) && $db) {echo "<br>617 sourceSection: $sourceSection";}
			$source = $dbFunction->getMemberInfo($FromAddr,"Source");
			if (isset($db) && $db) {echo "<br>619 source: $source";}
			$destination = 'Public Utilites';
			$destinationSection = $dbFunction->getMemberInfo($ToAddr,"Section");
			if (isset($db) && $db) {echo "<br>destinationSection: $destinationSection";}
			$destination = $dbFunction->getMemberInfo($ToAddr);
			if (isset($db) && $db) {echo "<br>destination: $destination";}
			$hopType = 'intermediate';
		
			$q = "Insert into Hop (ToAddr, FromAddr, Todate, FromDate, Duration, 
				Source, Destination, HopType, MessageId, SourceSection, DestinationSection, MB) values ('" . 
				$ToAddr . "','" . $FromAddr . "','" .
				$formatter->SQLDateTime($formatter->todayIfEmpty($Todate)) . "','" . 
				$formatter->SQLDateTime($formatter->todayIfEmpty($FromDate)) . "'," .
				$Duration . ",'" . $source . "','" . $destination . "','" . 
				$hopType . "'," . $uid . ",'" . $sourceSection . "','" . $destinationSection . "','" .
				$mailBoxName . "')"; 
		
			if (isset($db) && $db) {echo "<p>" . $q;}
			$r = $dbConnection->query($q);	
		
		}

		if (isset($db) && $db) {echo "<p>Total duration: " . $TotalDuration . " minutes";}
		if (isset($db) && $db) {echo "<p>Total hops: " . count($hops) . " count";	}

			$sourceSection = $dbFunction->getMemberInfo($hops[count($hops)-1][0],"Section");
			if (isset($db) && $db) {echo "<br>644 sourceSection: $sourceSection";}
			$source = $dbFunction->getMemberInfo($hops[count($hops)-1][0],"Source");
			

		$q = "Update Message set 
			Hops = " . count($hops) . ", 
			Duration = " . $TotalDuration . ",
			SendBy = '" . $hops[count($hops)-1][0] . "',
			Source = '" . $source . "',
			SourceSection = '" . $sourceSection . "' 
			Where imap_uid = " . $uid;
			
		if (isset($db) && $db) {echo "<br>update message" . $q;}
		$r = $dbConnection->query($q);		
	}  else {
		if (isset($db) && $db) {echo "<br>EmailGetParts - Not valid member";}
	}
	}
  	return $result;
}

function DecodeMailHeader($headerInfo, $fieldName){
  $value='';
  if (isset($headerInfo->$fieldName)){
    $value=iconv_mime_decode($headerInfo->$fieldName, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8');
  }
  return $value ;
}

function EmailGetOne($mailbox, $email_number, $dbConnection,$db){
	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	
	$formatter = new VAR_formatter();
	
  $structure = imap_fetchstructure($mailbox,$email_number);
  $mail = new stdClass();
  $mail->attachments = array();
  $mail->plainText   = '';
  $mail->htmlText    = '';
  $mail->charset     = 'auto';
  $uid		 = imap_uid($mailbox,$email_number); 
  //echo "<p>EmailGetOne put uid: $uid";  
  $mail->uid     = $uid; 
  $mail->email_number     = $email_number;
  
  
  		if (isset($db) && $db) {echo "<br>714 get mailbox number: |$mailbox|";}
  		$msgInfo = imap_mailboxmsginfo($mailbox);
		$mailBoxName = $formatter->MailboxName($msgInfo->Mailbox);		
  		if (isset($db) && $db) {echo "<br>get mailbox name: |$mailBoxName|";}
  $mail->mailboxName     = $mailBoxName;
		
		
  if (isset($db) && $db) {echo "<br>put mailbox number: $mailbox";}
  $mail->mailbox     = $mailbox;
  if (empty($structure->parts)){
    // Simple message.
    $mail = EmailGetPart($mailbox, $email_number, $structure, 0, $mail, $dbConnection,$db);
  } else {
    // Multipart message.
    $mail = EmailGetParts($mailbox, $email_number, $structure->parts, 0, $mail, $dbConnection,$db);
  }
  
  $headerInfo= imap_headerinfo($mailbox,$email_number,0);
  $fromInfo = $headerInfo->from[0];
  $fromaddress = $fromInfo->mailbox . "@" . $fromInfo->host;
  $headerInfo->fromaddress = DecodeMailHeader($headerInfo, 'fromaddress') ;
  //$headerInfo->fromaddress = $fromaddress;
  $headerInfo->toaddress = DecodeMailHeader($headerInfo, 'toaddress') ;
  $headerInfo->ccaddress = DecodeMailHeader($headerInfo, 'ccaddress') ;
  $headerInfo->subject = DecodeMailHeader($headerInfo, 'subject') ;
  
  $mail->headerInfo=$headerInfo;
  ini_set('mbstring.substitute_character', 'none'); //32 to substitute a space, "none" to remove
  $mail->plainText = mb_convert_encoding($mail->plainText , 'UTF-8', $mail->charset);
  //$mail->htmlText  = mb_convert_encoding($mail->htmlText, 'UTF-8', $mail->charset);
  if (empty($mail->htmlText)){
    $mail->htmlText='<p>'.$mail->plainText.'</p>';
  } else {
  	if (1 == 2) { // pretty sure this block is not needed
	  	if (isset($db) && $db && 1 == 2) {echo "<p>|||EmailGetOne htmlText: <<$mail->htmlText>>|||";}
  		$needle = "…";
		//Calibri
		//$needle = "<o:p></o:p>";
	  	$pos = strpos($mail->htmlText, $needle);
		if ($pos !== false) {
			if (isset($db) && $db) {
				echo "<br><h1>EmailGetOne htmlText : found char: at $pos</h1>";
				//$mail->htmlText = $formatter->convertEntity($mail->htmlText);
				$pos = strpos($mail->htmlText, $needle);
				if ($pos !== false) {
					if (isset($db) && $db) {			
						echo "<br><h2>EmailGetOne htmlText : found after conversion (bad) char: $pos</h2>";
					}		
				}
			}
		}
		}	
  	}
  	return $mail;
}

function EmailGetMany($host, $user, $password, $dbConnection,$db){
  $mailbox = EmailConnect($host, $user, $password,$db);
  $mails=array();
  if (!empty($mailbox)){
  	
	$numMessages = imap_num_msg($mailbox);
	$emailLimit = 100;
	if (isset($_GET["limit"]) && trim($_GET["limit"]) != "") {
		$emailLimit = $_GET["limit"];
	}
	
	if (isset($_GET["filter"]) && trim($_GET["filter"]) != "") {
		$emails = imap_search($mailbox, $_GET["filter"]);
	} else {
		$emails = imap_search($mailbox, 'UNSEEN');
	}
	
	$emailCount = 0;
    if($emails) {
      /* put the newest emails on top */
      rsort($emails);
      foreach($emails as $email_number) {
        $mails[]=EmailGetOne($mailbox, $email_number, $dbConnection,$db);      
		if ($emailCount >= $emailLimit) {return $mails;}
      }
    }
    imap_close($mailbox);
  }
  return $mails;
}

function EmailAttachmentsSave(&$mail, $dbConnection,$db){
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	include_once 'includes/db_config.php';
	include_once 'includes/db_function.php';
	include_once 'includes/format_function.php';
	
	//$dbConnection = new DB_con();
	//$dbConnection = $dbConnection->ret_obj();
	$dbFunction = new DB_function();
	$formatter = new VAR_formatter();
	
	$dbFunction = new DB_function();
  	$headerInfo=$mail->headerInfo;
	if ($dbFunction->getValidateMember(htmlentities($headerInfo->fromaddress))) {
		if (isset($db) && $db) {echo "<br>EmailAttachmentsSave - valid member";}
		
  $html = ''; $ATitle = '<br><b>Attachments:</b>';
  $LinkCount = 0;
  $attachments=$mail->attachments;
  	$mailBoxName = $mail->mailboxName;
	$uid = $mail->uid;
  foreach ($attachments as $attachment) {
    $partNo=$attachment['part'];
    $tmpDir= "imapClient/$uid/$partNo";
    $dirExists= is_dir($tmpDir);
    if (!$dirExists){
      $dirExists= mkdir($tmpDir, 0777, true) ;
    }
    $fileName=$attachment['filename'];
	$fileName=str_replace('&quot;','',$fileName);
	$fileName=str_replace('"','',$fileName);
    $fileName = str_replace('&', 'and', $fileName);
	$needle=$attachment['filename'];
	$ifid=$attachment['ifid'];
	if (isset($db) && $db) {echo "<br>EmailAttachments Save ifid: " . $ifid;}
	if (isset($db) && $db) {echo "<br>EmailAttachments Save needle: " . $needle;}
    $tmpName = "$tmpDir/$fileName";
    $saved = $dirExists && file_put_contents($tmpName, $attachment['data']);
    $tmpName=htmlentities($tmpName);
    $fileName=htmlentities($fileName); 
	$actual_link = "http://punews.VaBeachPU.com";
	
	$pos = strpos($mail->htmlText, $needle);
	if ($pos !== false) {
	//if ($ifid == 1) {
		if (isset($db) && $db) {echo "<br>EmailAttachmentsSave $needle is an embedded image";}}
	else {
		if (isset($db) && $db) {echo "<br>EmailAttachmentsSave not an embedded image -> adding to attachments";}
		if (isset($db) && $db) {echo "<br>Checking to see is already seen this file name";}
		$q = "Select Id From Attachment Where 
		MessageId = " . $uid . " and 
		Name = '" . $fileName . "' and 
		Link = 'http://punews.VaBeachPU.com/$tmpName'";

		$r = $dbConnection->query($q);			
		if (isset($db) && $db) {echo "<br>$q";}
		if ($row = $r->fetch_array(MYSQLI_ASSOC)) { 
			if (isset($db) && $db) {echo "<br>Already stored this attachfilename: " . $row["Id"];}
		} else {
			if (isset($db) && $db) {echo "<br>New file name";}
	  		$html .= $ATitle . "<br><b><a href='".$actual_link."/viewFile.php?MailBoxAddress=$mailBoxName&Id=".$uid."&OpenerId=0&filename=".$tmpName."'>".$fileName."</a></b>";
		
			$q = "Insert into Attachment (MessageId, Name, Link, MailboxAddress) values (
			" . $uid . ",'" . $fileName . "','http://punews.VaBeachPU.com/$tmpName','$mailBoxName')";
			$r = $dbConnection->query($q);			
		
		  	$LinkCount++;
		  	$ATitle = '';
		}
						
    }
    $cid =$attachment['id'];
    if (isset($cid)){
      //$mail->htmlText=EmailEmbeddedLinkReplace($mail->htmlText,$cid,$tmpName);
      if (isset($db) && $db) {echo "<br>checking to see if replace the imbedded image link to reference uploaded copy of the image at punews";} 
	  $mail->htmlText=EmailEmbeddedLinkReplace($mail->htmlText,$cid,'http://punews.vabeachpu.com/'.$tmpName);
    }
  }
  	$uid = $mail->uid;
  	// might work here
	$q = "Update Message set 
			LinkCount = " . $LinkCount . " 
			Where imap_uid = " . $uid . " and MailBox = '" . $mailBoxName . "'";
	//echo "<br>LinkCOunt: $q";
	$r = $dbConnection->query($q);	
		
	//echo "<p>EmailAttachmentsSave: q: " . $q;
  return $html ;
  } else {
  	return ; // sender non-existing punews email -> block sender
  }
}

function EmailPrint($mail,$html, $dbConnection, $db, $dbConnection8){
  	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	
	$verbose = FALSE;
	if (isset($_GET["verbose"]) && trim($_GET["verbose"]) != "") {
		$verbose = $_GET["verbose"];
	}
	
	$formatter = new VAR_formatter();

	if (isset($db) && $db && $verbose) {echo "<p>EmailPrint html: |$html|";}

 	$emailNumber = $mail->email_number;
 	$mailboxnumber = $mail->mailbox; 	
	
	if (1 == 2) {
  		if (isset($db) && $db) {echo "<br>882 get mailbox number: |$mailboxnumber|";}
  		$msgInfo = imap_mailboxmsginfo($mailboxnumber);
		$mailBoxName = $formatter->MailboxName($msgInfo->Mailbox);		
  		if (isset($db) && $db) {echo "<br>get mailbox name: |$mailBoxName|";}
	}
		
	$mailBoxName = $mail->mailboxName;
	$dbFunction = new DB_function();
  	$headerInfo=$mail->headerInfo;
	if (isset($db) && $db) {echo "<br>EmailPrint - Checking for valid punews sender";}
	if ($dbFunction->getValidateMember(htmlentities($headerInfo->fromaddress))) {
		if (isset($db) && $db) {echo "<br>EmailPrint - valid sender";}
		if (isset($headerInfo->date)) {
			$date = date_create($headerInfo->date);
			date_sub($date, date_interval_create_from_date_string('5 hours'));
			$Sent =  date_format($date, 'D, m/d/Y h:i A');
		}	
		
	  	  
  		$actual_link = "http://punews.VaBeachPU.com";
	  	$uid = $mail->uid;		
						
		$q = "Select Importance From Message 
		Where imap_uid = '" . $uid . "' and MailBox = '" . $mailBoxName . "' ";
		$importance = 'normal';
		if (isset($db) && $db) {echo "<br>retreive importance of email $q";}
		$r = $dbConnection->query($q);	
		if ($row = $r->fetch_array(MYSQLI_ASSOC)) {
			if (isset($row['Importance']) && trim($row['Importance']) <> "") {
				$importance = $row['Importance'];
			}
		} 			
		if (isset($db) && $db) {echo "<br>importance: $importance";}
		
		$itext = '<div style="font-family: Arial; font-size: small">';
		if ($importance == 'high') {$itext .= "<b>This message is sent with high importance</b><br>"; }
  		$html = $itext . 
	  	'<b>From:&nbsp;</b>' . htmlentities($headerInfo->fromaddress) . '<br>' . 
  		'<b>Sent:&nbsp;</b>' . $Sent . '<br>' . 
	  	'<b>To:&nbsp;</b>punews user<br>' . 
  		'<b>Subject:&nbsp;</b>' . $headerInfo->subject . '<br>' .
	  	$html; 
  		// 09052017 '<b>Subject:&nbsp;</b>' . $formatter->convertEntity(htmlentities($headerInfo->subject)) . '<br>' . 
			  	
		if (isset($db) && $db) {echo "<br>get fromaddress: " . $headerInfo->fromaddress;}
		
		// 09052017 
		$q = "Update Message set 
			Title = '" . str_replace("'","''",$formatter->convertEntity(htmlentities($headerInfo->subject)))  . "' 
			Where imap_uid = " . $uid . " and MailBox = '" . $mailBoxName . "' ";
			
		$q = "Update Message set 
			Title = '" . str_replace("'","''",$headerInfo->subject)  . "' 
			Where imap_uid = " . $uid . " and MailBox = '" . $mailBoxName . "' ";
		if (isset($db) && $db) {echo "<br>update message title: ". $q;}
		$r = $dbConnection->query($q);		
		
		if (trim($mailBoxName) != "archive@vabeachpu.com") {
			// Loop for each recipient and method
			if (isset($db) && $db) {echo "<br>Email Print Check for section: $headerInfo->toaddress";}
		
			$q = "";
			$pos = strpos(strtolower($headerInfo->toaddress), 'punews@vabeachpu.com');		
			if ($pos !== false) {
				// not filter by section
				if (isset($db) && $db) {echo "<br>No section filter - all punews";}
				$q = "Select * from Email Where Block <> 'yes'";
			} else {
				// get and check section					
				if (isset($db) && $db) {echo "<br>Check for section filter";}				 
				
				$pos = strpos(strtolower($headerInfo->toaddress), 'engineering@vabeachpu.com');		
				if ($pos !== false) {
					$q = "Select * from Email Where Block <> 'yes' and Section = 'Engineering'";				
				}					
				
				$pos = strpos(strtolower($headerInfo->toaddress), 'opertions@vabeachpu.com');		
				if ($pos !== false) {
					if (trim($q) == "") {
						$q = "Select * from Email Where Block <> 'yes' and Section = 'Opertions'";
					} else {
						$q = $q . " and Section = 'Opertions' ";
					}				
				}	
				
				$pos = strpos(strtolower($headerInfo->toaddress), 'business@vabeachpu.com');		
				if ($pos !== false) {
					if (trim($q) == "") {
						$q = "Select * from Email Where Block <> 'yes' and Section = 'Business'";
					} else {
						$q = $q . " and Section = 'Business' ";
					}				
				}	
				
				$pos = strpos(strtolower($headerInfo->toaddress), 'director@vabeachpu.com');		
				if ($pos !== false) {
					if (trim($q) == "") {
						$q = "Select * from Email Where Block <> 'yes' and Section = 'Director'";
					} else {
						$q = $q . " and Section = 'Director' ";
					}				
				}							
			}
			if (isset($db) && $db) {echo "<br>q should be set: $q";}
			$r = $dbConnection->query($q);
			$mynum = "7783r9879287Q!";
			$messageCount = 0;
		
			while ($row = $r->fetch_array(MYSQLI_ASSOC)) { 			
		
		  		$LikeText = "&nbsp;<br><table><tr><td style='font-family: Arial; font-size: small'><a href='".$actual_link."/likeemail.php?Id=".$uid."&LikerId=" . 
	  			$row["Id"] . "&mynum=" . $mynum . "&MailBox=" . $mailBoxName. "'  style='font-family: Arial; font-size: small'>Like this message</a></td>";
		  	
	  			$LikeText .= "<td style='font-family: Arial; font-size: small'><a href='".$actual_link."/viewMail.php?uid=".$uid."&LikerId=" . 
		  		$row["Id"] . "&mynum=" . $mynum . "&MailBox=" . $mailBoxName. "'  style='font-family: Arial; font-size: small'>View as web page</a></td></tr>";
			
			  	$LikeText .= "<tr><td style='font-family: Arial; font-size: small'><a href='".$actual_link."/userprofile.php?Id=".$row["Id"]."&mynum=" . 
  				$mynum . "'  style='font-family: Arial; font-size: small'>Update your punews profile</a>&nbsp;&nbsp;&nbsp;</td>
  				<td style='font-family: Arial; font-size: small'>
	  			<a href='".$actual_link."/archiveSummary.php?Id=".$row["Id"]."&mynum=" . 
  				$mynum . "&MailBox=" . $mailBoxName. "'  style='font-family: Arial; font-size: small'>Previous news</a></td><tr></table>";	
		
				$body2 = $html . $LikeText . '</div><div style="font-family: Arial; font-size: small">' . 
				(empty($mail->htmlText) ? ('<p>' . $mail->plainText . 
				'</p>') : $mail->htmlText) . '</div>';
  			  	 
		  		$email = new PHPMailer();
	  			if (isset($db) && $db) {echo "<br>toaddress: " . htmlentities($headerInfo->toaddress);}
				$toaddress = htmlentities($headerInfo->toaddress);
				$taArray = explode('&lt;',$toaddress);
				$toaddress = str_replace('&gt;','',$taArray[1]);
				$toaddress = str_replace('&quot;', '', trim($toaddress));
	  			if (isset($db) && $db) {echo "<br>toaddress: " . $toaddress;}
				//$email->setFrom($toaddress,'PU News');
				$email->setFrom($mailBoxName,'PU News');
				// 09052017  $email->Subject   = $formatter->convertEntity(htmlentities($headerInfo->subject));
				$email->Subject   = $headerInfo->subject;
			
				$email->IsHTML(true);  
				// Send to all contact methods
		
				// Regular email
				If (isset($row["byRegEmail"]) && $row["byRegEmail"] == 'yes') {
					if (isset($row["Email"])) {$email->AddAddress($row["Email"]);}
					if (isset($db) && $db) {echo "<br>send to regular email: ". $row["Email"];}
				} 
		
				// Alternate email		
				if (isset($db) && $db) {echo "<br>checking if send to alt email: ";}
				If (isset($row["byAltEmail"]) && $row["byAltEmail"] == 'yes' && isset($row["AltEmail"])) {
					if (isset($row["AltEmail"])) {$email->AddAddress($row["AltEmail"]);}				
					if (isset($db) && $db) {echo "<br>send by alt email: ". $row["AltEmail"];}
				} 		
					
				$body2=OpenerIdReplace($body2,$row["Id"]);			
				//if (isset($db) && $db) {echo "<br>>>>" . $body;}
				
				// Seems convertEntity does too much 09/25/2017 - might need to revisit to address the odd special chars
				// Only a few special chars
				$body2 = $formatter->convertEntity($body2);
				$email->Body      = $body2;	
			
				if ($formatter->testSubject($headerInfo->subject)) {
					if ($dbFunction->notReply($mailBoxName,$uid)) {  // $headerInfo->subject)) {
						if (isset($db) && $db) {echo "<p>Sending email to: ". $row["Email"];}	
								
						$email->Send();
				
						if (1 == 1) {
						$date = date_create();
						$SQLDate = date_format($date , "Y-m-d h:i:s A") ; 
				
						$q8 = "Insert into Send (SendDate, Email, FromMailBox, Uid) values ( 
						'$SQLDate','" . $row["Email"] . "','$toaddress',$uid)";		
								
						if (isset($db) && $db) {echo "<br>Recording message Send: ". $q8;}
						$r8 = $dbConnection8->query($q8);
						}	
					} else {
						if ($messageCount == 0) { // this loops though all recepients so only send one reply
							if (isset($db) && $db) {echo "<br>Is a reply";}	
							SendReply($mail, $html, $dbConnection, $db, $dbConnection8);	
						}		
					}
				}
				$messageCount++;				
			}

			$q = "Update Message set SendCount = " . $messageCount . " 
				Where imap_uid = " . $uid;
			if (isset($db) && $db) {echo "<br>Update Message SendCount: ". $q;}
			$r = $dbConnection->query($q);	
		}
  		return $html ;
  	} else {
	  	$email = new PHPMailer();
		$email->setFrom('punews@VaBeachPU.com','PU News ');
		$email->Subject   = 'Invalid user';
		$email->IsHTML(true); 		
		$body  ='An unauthorized user sent an email to punews : ' . $headerInfo->fromaddress;
		// 09052017 $body .= 'Email subject: ' . htmlentities($headerInfo->subject);					
		$body .= 'Email subject: ' . $headerInfo->subject;					
		$email->Body      = $body;							
		$email->Send();		
  		return ;
  	}
}


function SendTooSoon($mail,$html, $dbConnection, $db, $dbConnection8){
  	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	
	$verbose = FALSE;
	if (isset($_GET["verbose"]) && trim($_GET["verbose"]) != "") {
		$verbose = $_GET["verbose"];
	}
	
	$formatter = new VAR_formatter();

	if (isset($db) && $db ) {echo "<p><b>EmailPrint </b>";}

 	$emailNumber = $mail->email_number;
 	$mailboxnumber = $mail->mailbox; 				
	$mailBoxName = $mail->mailboxName;
	$dbFunction = new DB_function();
  	$headerInfo=$mail->headerInfo;
	if (isset($db) && $db) {echo "<br>EmailPrint - Checking for valid punews sender";}
	if ($dbFunction->getValidateMember(htmlentities($headerInfo->fromaddress))) {
		if (isset($db) && $db) {echo "<br>EmailPrint - valid sender";}
		if (isset($headerInfo->date)) {
			$date = date_create($headerInfo->date);
			date_sub($date, date_interval_create_from_date_string('4 hours'));
			$Sent =  date_format($date, 'D, m/d/Y h:i A');
		}			
	  	  
  		$actual_link = "http://punews.VaBeachPU.com";
	  	$uid = $mail->uid;		
						
		$importance = 'normal';
		
		$itext = '<div style="font-family: Arial; font-size: small">';

  		$html = $itext . 
	  	'<b>From:&nbsp;</b>' . htmlentities($headerInfo->fromaddress) . '<br>' . 
  		'<b>Sent:&nbsp;</b>' . $Sent . '<br>' . 
	  	'<b>To:&nbsp;</b>punews user<br>' . 
  		'<b>Subject:&nbsp;TOO SOON - </b>' . $headerInfo->subject . '<br>' .
	  	$html; 
  		// 09052017 '<b>Subject:&nbsp;</b>' . $formatter->convertEntity(htmlentities($headerInfo->subject)) . '<br>' . 
			  	
		if (isset($db) && $db) {echo "<br>get fromaddress: " . $headerInfo->fromaddress;}		
		
		if (isset($db) && $db) {echo "<br>Check for section: $headerInfo->toaddress";}
		
		$pos = strpos(strtolower($headerInfo->toaddress), 'punews');	
		$mynum = "7783r9879287Q!";
		$messageCount = 0;
		
		$body2 = $html . '</div><div style="font-family: Arial; font-size: small">' . 
		(empty($mail->htmlText) ? ('<p>' . $mail->plainText . 
		'</p>') : $mail->htmlText) . '</div>';
  			  	 
  		$email = new PHPMailer();
		if (isset($db) && $db) {echo "<br>toaddress: " . htmlentities($headerInfo->toaddress);}
		
		$toaddress = htmlentities($headerInfo->toaddress);
		$taArray = explode('&lt;',$toaddress);
		$toaddress = str_replace('&gt;','',$taArray[1]);
		$toaddress = str_replace('&quot;', '', trim($toaddress));
		
		if (isset($db) && $db) {echo "<br>toaddress: " . $toaddress;}
		$email->setFrom($mailBoxName,'PU News');
		$email->Subject   = 'TOO SOON - ' . $headerInfo->subject;
			
		$email->IsHTML(true);  
		// Send to all contact methods
		$fromaddress = htmlentities($headerInfo->fromaddress);
		$faArray = explode('&lt;',$fromaddress);
		$fromaddress = str_replace('&gt;','',$faArray[1]);
		$fromaddress = str_replace('&quot;', '', trim($fromaddress));
		
		if (isset($db) && $db) {echo "<p><b>TooSoon email to : </b>" . $fromaddress;}
		$email->AddAddress($fromaddress);				
					
		//$body2=OpenerIdReplace($body2,$row["Id"]);			
		$body2 = $formatter->convertEntity($body2);
		$email->Body      = '<b> **** Please wait one hour and send this again **** </b><br>' . $body2;	
			
		if ($formatter->testSubject($headerInfo->subject)) {
			if (isset($db) && $db) {echo "<br>Checking for reply to punews email 1081";}				
			//if ($dbFunction->notReply($mailBoxName,$uid)) {  // $headerInfo->subject)) {
				if (isset($db) && $db) {echo "<br>Not a reply";}		
						
				if (isset($db) && $db) {echo "<p><b>>>>> TOO SOON - Really Sending (next line) email to: $fromaddress </b>";}				
				
				$email->Send();
											
			//} else {
			//	if (isset($db) && $db) {echo "<br>Is a reply";}
					// need to insert real replace to punews sender
			//	}
		}
		$messageCount++;				
	}
	return True ;  	
}


function SendReply($mail,$html, $dbConnection, $db, $dbConnection8){
  	
	if (isset($_GET["debug"]) && trim($_GET["debug"]) != "") {
		$db = $_GET["debug"];
	}
	
	$verbose = FALSE;
	if (isset($_GET["verbose"]) && trim($_GET["verbose"]) != "") {
		$verbose = $_GET["verbose"];
	}
	
	$formatter = new VAR_formatter();

	if (isset($db) && $db ) {echo "<p><b>SendReply </b>";}

 	$emailNumber = $mail->email_number;
 	$mailboxnumber = $mail->mailbox; 				
	$mailBoxName = $mail->mailboxName;
	$dbFunction = new DB_function();
  	$headerInfo=$mail->headerInfo;
	if (isset($db) && $db) {echo "<br>SendReply - Checking for valid PUNews sender";}
	if (isset($db) && $db) {echo "<br><b>SendReply - From Address: getValidateMember : " . $headerInfo->fromaddress . "</b>";}
	if ($dbFunction->getValidateMember(htmlentities($headerInfo->fromaddress))) {
		if (isset($db) && $db) {echo "<br>SendReply - valid sender";}
		if (isset($headerInfo->date)) {
			$date = date_create($headerInfo->date);
			date_sub($date, date_interval_create_from_date_string('4 hours'));
			$Sent =  date_format($date, 'D, m/d/Y h:i A');
		}			
	  	  
  		$actual_link = "http://PUNews.VaBeachPU.com";
	  	$uid = $mail->uid;		
						
		$importance = 'normal';
		
		$itext = '<div style="font-family: Arial; font-size: small">';

  		$html = $itext . $html;
	  	//'<b>From:&nbsp;</b>' . htmlentities($headerInfo->fromaddress) . '<br>' . 
  		//'<b>Sent:&nbsp;</b>' . $Sent . '<br>' . 
	  	//'<b>To:&nbsp;</b>PUNews user<br>' . 
  		//'<b>Subject:&nbsp;Reply - </b>' . $headerInfo->subject . '<br>' .
	  	//$html; 
  		// 09052017 '<b>Subject:&nbsp;</b>' . $formatter->convertEntity(htmlentities($headerInfo->subject)) . '<br>' . 
			  	
		if (isset($db) && $db) {echo "<br>SendReply - get fromaddress: " . $headerInfo->fromaddress;}		
		
		if (isset($db) && $db) {echo "<br>SendReply - Check for section: $headerInfo->toaddress";}
		
		$pos = strpos(strtolower($headerInfo->toaddress), 'PUNews');	
		$mynum = "7783r9879287Q!";
		$messageCount = 0;
		
		$body2 = $html . '</div><div style="font-family: Arial; font-size: small">' . 
		(empty($mail->htmlText) ? ('<p>' . $mail->plainText . 
		'</p>') : $mail->htmlText) . '</div>';
  			  	 
  		$email = new PHPMailer();
		if (isset($db) && $db) {echo "<br>SendReply - toaddress: " . htmlentities($headerInfo->toaddress);}
		
		$toaddress = htmlentities($headerInfo->toaddress);
		$taArray = explode('&lt;',$toaddress);
		$toaddress = str_replace('&gt;','',$taArray[1]);
		$toaddress = str_replace('&quot;', '', trim($toaddress));
		$toaddress = $dbFunction->getReplyTo($mailBoxName, $uid);
		if (isset($db) && $db) {echo "<br>SendReply - toaddress: " . $toaddress;}
		//$email->setFrom($mailBoxName,'PU News');
		$email->Subject   = 'Reply - ' . $headerInfo->subject;
			
		$email->IsHTML(true);  
		// Send to all contact methods
		$fromaddress = htmlentities($headerInfo->fromaddress);
		$faArray = explode('&lt;',$fromaddress);
		$fromaddress = str_replace('&gt;','',$faArray[1]);
		$fromaddress = str_replace('&quot;', '', trim($fromaddress));
		$email->setFrom($fromaddress);
		
		if (isset($db) && $db) {echo "<p><b>SendReply - Send Reply to </b>" . $toaddress;}
		//$email->AddAddress($fromaddress); $toaddress			
		$email->AddAddress($toaddress);	
					
		//$body2=OpenerIdReplace($body2,$row["Id"]);			
		$body2 = $formatter->convertEntity($body2);
		$email->Body      = '<b> **** This is a reply from a PUNews receiver **** </b><br>' . 
		'&nbsp;<p>' . $body2;	
			
		if ($formatter->testSubject($headerInfo->subject)) {
			if (isset($db) && $db) {echo "<br>Checking for reply to PUNews email 1081";}				
			//if ($dbFunction->notReply($mailBoxName,$uid)) {  // $headerInfo->subject)) {
				//if (isset($db) && $db) {echo "<br>Not a reply";}		
						
				if (isset($db) && $db) {echo "<p><b>>>>> SendReply - Really Sending (next line) email to: $toaddress </b>";}				
				
				$email->Send();
											
			//} else {
			//	if (isset($db) && $db) {echo "<br>SendReply -  Is a reply";}
					// need to insert real replace to PUNews sender
			//	}
		}
		$messageCount++;				
	}
	return True ;  	
}


function EmailDownload($host, $user, $password, $dbConnection, $db, $dbConnection8){
	$dbFunction = new DB_function();
  $html = '<head> <meta charset="UTF-8"> </head>';
  if (isset($db) && $db) {echo "<br>EmailDownload";}
  $mails=EmailGetMany($host, $user, $password, $dbConnection,$db);
  $count=count($mails);
  //$html .= "<p>$user has $count mails at $host.</p>";
  foreach ($mails as $mail){
  	
  	if (isset($db) && $db) {echo "<p><h2><b>New message uid: $mail->uid </b></h2>";}  	
  	if ($dbFunction->OKtoSend() || !$dbFunction->notReply($mail->mailboxName,$mail->uid)) { 
  		if (isset($db) && $db) {echo "<br>OKtoSend</b>";} 
      $html = '';
      $html .= EmailAttachmentsSave($mail, $dbConnection, $db);
      $html .= EmailPrint($mail,$html, $dbConnection, $db, $dbConnection8);
	} else {
		if (isset($db) && $db) {echo "<br>Not OKtoSend</b>";} 
		$returnValue = SendTooSoon($mail,$html, $dbConnection, $db, $dbConnection8);
	}
  }
  return $html ;
}

?>

