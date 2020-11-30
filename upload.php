<?php

use Vimeo\Vimeo;
use Vimeo\Exceptions\VimeoUploadException;

$config = require(__DIR__ . '/init.php');

if (empty($config['access_token'])) {
    throw new Exception('You can not upload a file without an access token. You can find this token on your app page, or generate one using auth.php');
}

$lib = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);

//  Get the args from the command line to see what files to upload.
//$files = $argv;
//array_shift($files);

var_dump($_FILES); 

$SafeFile = $_FILES['userfile']['name'];
echo "<p>SafeFile org: " . $SafeFile . "</p>";
				$SafeFile = str_replace("#", "No.", $SafeFile);
				$SafeFile = str_replace("$", "Dollar", $SafeFile);
				$SafeFile = str_replace("%", "Percent", $SafeFile);
				$SafeFile = str_replace("^", "", $SafeFile);
				$SafeFile = str_replace("&", "and", $SafeFile);
				$SafeFile = str_replace("*", "", $SafeFile);
				$SafeFile = str_replace("?", "", $SafeFile);
				$SafeFile = str_replace(" ", "", $SafeFile);

				$uploaddir = "archive/";
				$path = $uploaddir . $SafeFile;
				echo "<br>path: " . $path;
				$file_name = $_FILES['userfile']['tmp_name'];
				echo "<br>file_name: " . $file_name;

//   Keep track of what we have uploaded.
$uploaded = array();

//  Send the files to the upload script.
//foreach ($files as $file_name) {
    //  Update progress.
    print 'Uploading ' . $file_name . "\n";
    try {
        //  Send this to the API library.
        $uri = $lib->upload($file_name);

        //  Now that we know where it is in the API, let's get the info about it so we can find the link.
        $video_data = $lib->request($uri);

        //  Pull the link out of successful data responses.
        $link = '';
        if($video_data['status'] == 200) {
            $link = $video_data['body']['link'];
        }

        //  Store this in our array of complete videos.
        $uploaded[] = array('file' => $file_name, 'api_video_uri' => $uri, 'link' => $link);
    }
    catch (VimeoUploadException $e) {
        //  We may have had an error.  We can't resolve it here necessarily, so report it to the user.
        print 'Error uploading ' . $file_name . "\n";
        print 'Server reported: ' . $e->getMessage() . "\n";
    }
//}

//  Provide a summary on completion with links to the videos on the site.
print 'Uploaded ' . count($uploaded) . " files.\n\n";
foreach ($uploaded as $site_video) {
    extract($site_video);
    print "$file is at $link.\n";
}

