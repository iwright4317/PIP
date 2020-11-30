<html>
	<head>
		<title>Store Data</title>
	</head>
	<body bgcolor="#E8E8E8" marginheight="0" topmargin="0" vspace="0"
	marginwidth="0" leftmargin="0" hspace="0">
		<center>

			<?php
			set_time_limit(0);

			if (1 == 1) {
				#$SafeFile = $HTTP_POST_FILES['userfile']['name'];
				$SafeFile = $_FILES['userfile']['name'];
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
				//copy($_FILES['userfile']['tmp_name'], $path);
				$ffile = $_FILES['userfile']['tmp_name'];
				echo "<br>Source file: " . $ffile;

				//function chunked_copy($from, $to) {
					# 1 meg at a time, you can adjust this.
					$buffer_size = 1048576;
					$ret = 0;
					
					//$fin = fopen($from, "rb");
					$fin = fopen($_FILES['userfile']['tmp_name'], "rb");
					
					//$fout = fopen($to, "w");
					$fout = fopen($path, "w");
					
					while (!feof($fin)) {
						$ret += fwrite($fout, fread($fin, $buffer_size));
					}
					fclose($fin);
					fclose($fout);
					//return $ret;
					# return number of bytes written
				//}

				if (1 == 2) {
					if (isset($_FILES['userfile2']['name'])) {
						$SafeFile2 = $_FILES['userfile2']['name'];
						$SafeFile2 = str_replace("#", "No.", $SafeFile2);
						$SafeFile2 = str_replace("$", "Dollar", $SafeFile2);
						$SafeFile2 = str_replace("%", "Percent", $SafeFile2);
						$SafeFile2 = str_replace("^", "", $SafeFile2);
						$SafeFile2 = str_replace("&", "and", $SafeFile2);
						$SafeFile2 = str_replace("*", "", $SafeFile2);
						$SafeFile2 = str_replace("?", "", $SafeFile2);
						$SafeFile2 = str_replace(" ", "", $SafeFile2);

						$uploaddir = "archive/";
						$path = $uploaddir . $SafeFile2;
						copy($_FILES['userfile2']['tmp_name'], $path);
					}
				}

			} else {
				if (1 == 2) {

					$target = "archive/";
					$target = $target . basename($_FILES['userfile']['name']);

					//echo "target |" . $target . "|";

					$ok = 1;
					if (move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) {
						//echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
					} else {
						//echo "<p>Sorry, there was a problem uploading your file.";
					}

				}
			}

			//echo "<br>url=\"http://www.VMARchurches.com/newcontent3.php?safefile=" . $SafeFile . "\"";

			if ($_REQUEST["option"] == "CL") {
				echo "<meta http-equiv=REFRESH content=0;url=\"http://www.vmarchurches.com/new_leader.php?safefile=" . $SafeFile . "&safefile2=" . $SafeFile2 . "\">";				
			} else {
				echo "<meta http-equiv=REFRESH content=0;url=\"http://www.vmarchurches.com/newcontent3.php?safefile=" . $SafeFile . "&safefile2=" . $SafeFile2 . "\">";
			}
			
			#echo "<p>|" . $SafeFile . "|";
			?>
			</td>
			</tr>
			</table>
	</body>
</html>