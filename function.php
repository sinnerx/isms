<?php

//student
if ($_REQUEST['action'] == 'list_result_student'){
	//echo 'liststudent';
	list_result_student();
}

if ($_REQUEST['action'] == 'list_result'){
	//echo 'liststudent';
	list_result();
}

if ($_REQUEST['action'] == 'liststudent'){
	//echo 'liststudent';
	list_student();
}

if ($_REQUEST['action'] == 'editstudent'){
	//echo 'editstudent';
	edit_student();
}

if ($_REQUEST['action'] == 'addstudent'){
	//echo 'addstudent';
	add_student();
}

if ($_REQUEST['action'] == 'deletestudent'){
	//echo 'addstudent';
	del_student();
}
//parent
if ($_REQUEST['action'] == 'listparent'){
	//echo 'liststudent';
	list_parent();
}

if ($_REQUEST['action'] == 'editparent'){
	//echo 'editparent';
	edit_parent();
}

if ($_REQUEST['action'] == 'addparent'){
	//echo 'addparent';
	add_parent();
}

if ($_REQUEST['action'] == 'deleteparent'){
	//echo 'addstudent';
	del_parent();
}

//teacher
if ($_REQUEST['action'] == 'listteacher'){
	//echo 'liststudent';
	list_teacher();
}

if ($_REQUEST['action'] == 'editteacher'){
	//echo 'editteacher';
	edit_teacher();
}

if ($_REQUEST['action'] == 'addteacher'){
	//echo 'addteacher';
	add_teacher();
}

if ($_REQUEST['action'] == 'deleteteacher'){
	//echo 'addteacher';
	del_teacher();
}

//broadcast
if($_REQUEST['action'] == 'selectedBroadcast'){
	select_broadcast();
}

function list_result(){
	$year = $_REQUEST['yearselect'];
	$term = $_REQUEST['termselect'];
	$form = $_REQUEST['formselect'];
	// Create connection
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
	if (!$con) {
	    die('Not connected : ' . mysql_error());
	}
	// make foo the current db
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}	  	
	
	//0195571001
		//echo $recordStudInfo["name"] ."<br>";
	if ($year == '') $sqlYear = " WHERE recordExam.year LIKE '%%' "; else if ($year != '')$sqlYear .= " WHERE recordExam.year = '" .$year."' ";
	
	if ($form == '') $sqlForm = ""; else if ($form != '')$sqlForm .= " AND recordExam.form = '" .$form."' ";
	
	if ($term == '') $sqlForm =""; else if ($term != '') $sqlTerm .=" AND recordExam.`term` = '".$term."' ";
	
		if ($term == 3){	
			$sql = "SELECT * FROM recordExam 
			LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) ". $sqlYear. $sqlForm . "ORDER BY student.id";
		}
		else {	
			$sql = "SELECT * FROM recordExam 
			LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) 
			 ". $sqlYear . $sqlForm . $sqlTerm. "ORDER BY student.id";
		}
	
		//echo $sql;
		$result = mysql_query($sql, $con);

		$destination = array();
		
			while ($row = mysql_fetch_assoc($result)){
				$destination[] = $row;
			}

		$resultJSON = json_encode($destination);	

		mysql_close($con);
		echo $resultJSON;
}

function list_result_student(){
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
	  
	$sqlStudent = "SELECT student.id, name, year, term, ExamName, ExamValue, form FROM recordExam 
	LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`)";
	$resultStudent = mysql_query($sqlStudent,$con);
	$destination = array();
	
	while ($row = mysql_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);	
	mysql_close($con);
	
	echo $resultJSON;
}


function list_student(){
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "SELECT student.id as stud_id, student.name as stud_name, student.phone as stud_phone, parent.id as par_id, parent.name as par_name FROM student LEFT OUTER JOIN parent ON student.parentid = parent.id";
	$resultStudent = mysql_query($sqlStudent,$con);
	$destination = array();
	
	while ($row = mysql_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);	
	mysql_close($con);
	
	echo $resultJSON;
}

function edit_student(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	$parentid = $_REQUEST['par_id'];
	$id		= $_REQUEST['id'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "UPDATE student SET name = '".$name."', phone = '".$phone."' , parentid = '".$parentid."' WHERE id = '".$id."'";
	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	
}

function add_student(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	$parentid	= $_REQUEST['parentid'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	//echo $name . $phone . $parentid;
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "INSERT INTO student(name, phone, parentid) VALUES('".$name."', '".$phone."', '".$parentid."') ";

	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	
}

function del_student(){
	$id		= $_REQUEST['id'];
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	//echo $name . $phone . $parentid;
	// Check connection
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
	
	$sqlStudent = "DELETE FROM student WHERE id = '".$id."'";
	mysql_query($sqlStudent, $con);
	mysql_close($con);
	
	echo "Rekod Pelajar Berjaya di padam";	
}

function list_parent(){
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "SELECT * FROM parent";
	$resultStudent = mysql_query($sqlStudent, $con);
	while ($row = mysql_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	echo $resultJSON;
}

function edit_parent(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	$id		= $_REQUEST['id'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "UPDATE parent SET name = '".$name."', phone = '".$phone."' WHERE id = '".$id."'";
	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	
}

function add_parent(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	//$id		= $_REQUEST['id'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "INSERT INTO parent(name, phone) VALUES('".$name."', '".$phone."') ";
	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	
}

function del_parent(){
	$id		= $_REQUEST['id'];
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	//echo $name . $phone . $parentid;
	// Check connection
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
	
	$sqlParent = "DELETE FROM parent WHERE id = '".$id."'";
	mysql_query($sqlParent, $con);
	mysql_close($con);
	
	echo "Rekod IbuBapa Berjaya di padam";	
}

//////teacher
function list_teacher() {
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "SELECT * FROM teacher";
	$resultStudent = mysql_query($sqlStudent, $con);
	while ($row = mysql_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	echo $resultJSON;
}

function edit_teacher(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	$id		= $_REQUEST['id'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "UPDATE teacher SET name = '".$name."', phone = '".$phone."' WHERE id = '".$id."'";
	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);	
	
}

function add_teacher(){

	$name 	= $_REQUEST['name'];
	$phone	= $_REQUEST['phone'];
	//$id		= $_REQUEST['id'];
		
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	  
	$sqlStudent = "INSERT INTO teacher(name, phone) VALUES('".$name."', '".$phone."') ";
	mysql_query($sqlStudent, $con);

	$resultJSON = json_encode($destination);
	
	mysql_close($con);
		
	
}

function del_teacher(){
	$id		= $_REQUEST['id'];
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	//echo $name . $phone . $parentid;
	// Check connection
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
	
	$sqlTeacher = "DELETE FROM teacher WHERE id = '".$id."'";
	mysql_query($sqlTeacher, $con);
	mysql_close($con);
	
	echo "Rekod Guru Berjaya di padam";	
}

//broadcast
//We create our own function to submit our link
//Certain hosts do not support the usage of "fopen"
function ismscURL($link){

    $http = curl_init($link);

    curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
    $http_result = curl_exec($http);
    $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
    curl_close($http);

    return $http_result;
}

function select_broadcast(){
	$selected 		= $_REQUEST['records'];
	$selectionCombo = $_REQUEST['selection'];
	$broadtext		= $_REQUEST['message'];
	
	//echo $broadtext;
	//echo $selected[0]["id"];
	foreach ($selected as $value) {
	  $inClause .= $value["id"]. ",";
	}
	
	
	$inClause = rtrim($inClause,",");
	
// Create connection
	$con=mysql_connect("localhost","pidcedu_ismsuser","010203");
	
	// Check connection
	if (!$con) {
	    die('Not connected : ' . mysql_error());
	}
	// make foo the current db
	$db_selected = mysql_select_db('pidcedu_ismsdb', $con);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
	  	
	
	$rowBroadcast;
	
	
	$rowBroadcast = array();
	$x=0;
	$username = urlencode("sinnerx");
	$password = urlencode("rinoa84");
	$sender_id = urlencode("66300");
	$type = 1;	
	//$fp = "https://www.isms.com.my/isms_send.php";
	    	
	if ($selectionCombo == 1){
		$sqlBroadcast 	= "SELECT * FROM parent WHERE parent.id IN (".$inClause.")";
		$output			= "Mesej berjaya dihantar ke Ibu Bapa";
	}
	else if ($selectionCombo == 2) {
	
		$sqlBroadcast = "SELECT * FROM teacher WHERE teacher.id IN (".$inClause.")";
		$output			= "Mesej berjaya dihantar ke Guru-guru";		
	}

	$resultBroadcast = mysql_query($sqlBroadcast, $con);
		while($row = mysql_fetch_assoc($resultBroadcast))
		  {
		   $destination = urlencode($row["phone"]);
			$message = html_entity_decode($broadtext, ENT_QUOTES, 'utf-8'); 
			$message = urlencode($broadtext);
			$fp = "https://www.isms.com.my/isms_send.php?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
			//print_r($fp);

			$result = ismscURL($fp);
		  }
		  
	echo $output;			
	}
?>