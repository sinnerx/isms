<?php
 $host = 'localhost'; // <--  db address
 $user = 'pidcedu_ismsuser'; // <-- db user name
 $pass = '010203'; // <-- password
 $db = 'pidcedu_ismsdb'; // db's name
 $table = 'student'; // table you want to export
 $file = 'student_export'; // csv name.
 mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');
$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
 mysql_select_db($db) or die("Can not connect.");
 
$result = mysql_query("SHOW COLUMNS FROM ".$table."");
 $i = 0;
 
if (mysql_num_rows($result) > 0) {
while ($row = mysql_fetch_assoc($result)) {
$csv_output .= $row['Field'].",";
$i++;}
}
$csv_output .= "\n";
 $values = mysql_query("SELECT * FROM ".$table."");
  
while ($rowr = mysql_fetch_row($values)) {
//$csv_output .=  "=";
for ($j=0;$j<$i;$j++) {
$csv_output .=  "".$rowr[$j]."". ", ";
}
$csv_output .= "\n";
}
 
$filename = $file."_".date("d-m-Y_H-i",time());
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
 
print $csv_output;
mysql_close(); 
exit;

?>