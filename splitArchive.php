<?php
session_start();
?>

<head>
</head>
<body>
	<?php
echo "<br>splitArchive";

$newDir = "2017";
$dirExists= is_dir('archive/'.$newDir);
if (!$dirExists){
	$dirExists= mkdir('archive/'.$newDir, 0755, true) ;
}
	
$limit = 20000;
$count = 0;
$dir = 'archive';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {        	
    		$subfolder = substr($file,0,4);
			if ($subfolder == $newDir) {
				$source = 'archive/' . $file;	
            	//echo "<p>source: ".$source;
            	//echo "<br>filename: ".$file;
				$filename = 'archive/' . $newDir. '/' . $file;
				if (file_exists($filename)) {
					echo "<br>$filename does exist";
					if (file_exists($source)) { 
						unlink($source);
						echo "<br> unlink($source)";
					} else {
						echo "<br>$source already deleted";
					}
				} else {
					echo "<p>$filename does not exist";
					echo "<br>copy($source, $filename)";

					if (!copy($source, $filename)) {
    					echo "<br>failed to copy $file...\n";						
    					$errors= error_get_last();
    					echo "<br>COPY ERROR: ".$errors['type'];
    					echo "<br />\n".$errors['message'];
					} else {
						echo "<br>copy success";
					}
				}
				$count++;
				if ($count > $limit) {exit;}
			}
        }
        closedir($dh);
    }
} else {
	echo "<br>Not a directory " . $dir;
}
?>
</body>

<!-- 
//rename('image1.jpg', 'del/image1.jpg');
//copy('image1.jpg', 'del/image1.jpg'); -->