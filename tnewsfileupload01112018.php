<html>
	<head>
		<title>Store Data</title>
	</head>
	<body bgcolor="#E8E8E8" marginheight="0" topmargin="0" vspace="0"
	marginwidth="0" leftmargin="0" hspace="0">
		<center>

			<?php
			set_time_limit(0);

			//echo "<p>userfile: |" . $_FILES['userfile']['name'] . "|";

			if (trim($_FILES['userfile']['name']) <> "") {
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
					
					//echo "<br>Source file1 uploaded";
				
					//return $ret;
					# return number of bytes written
				}

				//echo "<p>userfile2: |" . $_FILES['userfile2']['name'] . "|";
				if (trim($_FILES['userfile2']['name']) <> "") {
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
						//echo "<br>Source file2 uploaded";
					}
				}


				
				//echo "<p>userfile3: |" . $_FILES['userfile3']['name'] . "|";
				if (trim($_FILES['userfile3']['name']) <> "") {
					if (isset($_FILES['userfile3']['name'])) {
						$SafeFile3 = $_FILES['userfile3']['name'];
						$SafeFile3 = str_replace("#", "No.", $SafeFile3);
						$SafeFile3 = str_replace("$", "Dollar", $SafeFile3);
						$SafeFile3 = str_replace("%", "Percent", $SafeFile3);
						$SafeFile3 = str_replace("^", "", $SafeFile3);
						$SafeFile3 = str_replace("&", "and", $SafeFile3);
						$SafeFile3 = str_replace("*", "", $SafeFile3);
						$SafeFile3 = str_replace("?", "", $SafeFile3);
						$SafeFile3 = str_replace(" ", "", $SafeFile3);

						$uploaddir = "archive/";
						$path = $uploaddir . $SafeFile3;
						copy($_FILES['userfile3']['tmp_name'], $path);
						//echo "<br>Source file3 uploaded";
					}
				}


				
				//echo "<p>userfile4: |" . $_FILES['userfile4']['name'] . "|";
				if (trim($_FILES['userfile4']['name']) <> "") {
					if (isset($_FILES['userfile4']['name'])) {
						$SafeFile4 = $_FILES['userfile4']['name'];
						$SafeFile4 = str_replace("#", "No.", $SafeFile4);
						$SafeFile4 = str_replace("$", "Dollar", $SafeFile4);
						$SafeFile4 = str_replace("%", "Percent", $SafeFile4);
						$SafeFile4 = str_replace("^", "", $SafeFile4);
						$SafeFile4 = str_replace("&", "and", $SafeFile4);
						$SafeFile4 = str_replace("*", "", $SafeFile4);
						$SafeFile4 = str_replace("?", "", $SafeFile4);
						$SafeFile4 = str_replace(" ", "", $SafeFile4);

						$uploaddir = "archive/";
						$path = $uploaddir . $SafeFile4;
						copy($_FILES['userfile4']['tmp_name'], $path);
						//echo "<br>Source file4 uploaded";
					}
				}

			//echo "<br>url=\"http://www.VMARchurches.com/newcontent.php?safefile=" . $SafeFile . "\"";

			//Enable to restore normal function
			echo "<meta http-equiv=REFRESH content=0;url=\"http://pip.vabeachpu.com/NewEdit.php?Id=" . 
			$_GET['Id'] . "&safefile=" . $SafeFile . "&safefile2=" . $SafeFile2 . "&safefile3=" . $SafeFile3 . "&safefile4=" . $SafeFile4 . "\">";	
			
			?>
			</td>
			</tr>
			</table>
	</body>
</html>