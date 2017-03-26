<?php
//$myfile = fopen("newfile.txt", "wb") or die("Unable to open file!");
$fileName = "one.txt";
$myfile = fopen($fileName, "wb") or die("can't open file");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
?>