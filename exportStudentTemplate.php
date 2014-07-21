<?php
//$file = basename($_GET['file']);
//$file = '/path/to/your/dir/'.$file;
$file = 'StudentTemplate.csv';

if(!$file){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($file);
}

exit;

?>