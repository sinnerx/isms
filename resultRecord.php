<?php include_once("header.php"); ?>
<?php

function ismscURL($link){

    $http = curl_init($link);

    curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
    $http_result = curl_exec($http);
    $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
    curl_close($http);

    return $http_result;
}

if(isset($_POST["submitbtn"])){
	//echo 'aaaa';
	$year = $_POST['yearselect'];
	$term = $_POST['termselect'];
	$form = $_POST['form'];
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

	if ($year == '') $sqlYear = " WHERE recordExam.year LIKE '%%' "; else if ($year != '')$sqlYear .= " WHERE recordExam.year = '" .$year."' ";
	
	if ($form == '') $sqlForm = ""; else if ($form != '')$sqlForm .= " AND recordExam.form = '" .$form."' ";
	
	if ($term == '') $sqlForm =""; else if ($term != '') $sqlTerm .=" AND recordExam.`term` = '".$term."' ";
  	
if ($term == 3){
	$sqlStudent = "SELECT DISTINCT(student.id),name FROM recordExam 
	LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) 
	" . $sqlYear;
}
else {

	$sqlStudent = "SELECT DISTINCT(student.id),name FROM recordExam 
	LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) ". $sqlYear . $sqlTerm;
}

$resultStudent = mysql_query($sqlStudent, $con);
$rowStudent;


$rowStudent = array();

$x=0;
while($row = mysql_fetch_assoc($resultStudent))
  {
  $rowStudent[$x] = $row['id'];
  $x++;
  }

//0195571001
foreach ($rowStudent as $student){
$message = "";
	//echo $student;
	$sqlStudInfo = "SELECT * FROM student WHERE id ='".$student."'";
	$resultStudInfo = mysql_query($sqlStudInfo, $con);
	$recordStudInfo = mysql_fetch_assoc($resultStudInfo);
	//echo $recordStudInfo["name"] ."<br>";
	$message .= $_POST['examtype']."\r\n";
	$message .= "Nama Pelajar : ".$recordStudInfo["name"] ."\r\n";
	if ($term == 3){	
		$sql = "SELECT * FROM recordExam 
		LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) ". $sqlYear ." AND recordExam.stud_id = '".$student."' " . $sqlForm;
	}
	else {	
		$sql = "SELECT * FROM recordExam 
		LEFT OUTER JOIN student ON (recordExam.`stud_id` = student.`id`) " . $sqlYear .
		$sqlTerm . " AND recordExam.stud_id = '".$student."' " . $sqlForm;
	}

	//echo $sql;
	$result = mysql_query($sql, $con);
	//$row = mysqli_fetch_assoc($result);	
	//print_r($row);
	while($row = mysql_fetch_assoc($result))
	  {
	  //echo $row['ExamName']. " " . $row['ExamValue']. " " . $row['phone'];
	 // echo "<br>";
	  $message .= $row['ExamName']. " " . $row['ExamValue']. "\r\n";
	  //$message .= "Tingkatan : " . $row['form']. "\r\n";
	  
	  }
	  
	  //echo "<br><br>";
		$destination = urlencode($recordStudInfo["phone"]);
		   $message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
		   $message = urlencode($message);
		   
		   $username = urlencode("sinnerx");
		   $password = urlencode("rinoa84");
		   $sender_id = urlencode("66300");
		   $type = 1;
		
		   $fp = "https://www.isms.com.my/isms_send.php";
		   $fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
		   //echo $fp."<br>";
		   
		   $result = ismscURL($fp);
		   //echo $result;
	  
	  //$message .= "<br><br>";
	  //echo $message;
	  
	  	
	  }
	  echo '<script type="text/javascript">alert ("Mesej berjaya dihantar!");</script>';
	//echo $message;
  
	mysql_close($con);
}


?>
<link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="jqwidgets/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="jqwidgets/jqxdata.js"></script> 
    
    <script type="text/javascript" src="jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxgrid.filter.js"></script>
    
<form id="form1" name="form1" method="post" action="resultRecord.php">
  <p>&nbsp;  </p>
  <div align="center">
    <table width="200" border="0">
      <tr>
        <td>Peperiksaan</td>
        <td>: </td>
        <td><select name="examtype" id="examtype" style="
    width: 350px;">
          <option value="Keputusan Peperiksaan Pertengahan Tahun">Peperiksaan Pertengahan Tahun</option>
          <option value="Keputusan Peperiksaan Akhir Tahun">Peperiksaan Akhir Tahun</option>
        </select></td>
      </tr>    
      <tr>
        <td>Tahun</td>
        <td>: </td>
        <td><select name="yearselect" id="yearselect" style="
    width: 150px;">
          <option value="">Semua</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select></td>
      </tr>
      <tr>
        <td>Semester</td>
        <td>:&nbsp; </td>
        <td><select name="termselect" id="termselect" style="
    width: 150px;">
    	  <option value="3">Semua</option>
          <option value="1">Pertengahan</option>
          <option value="2">Akhir</option>
        </select></td>
      </tr>
      <tr>
        <td>Tingkatan</td>
        <td>: </td>
        <td><select name="formstud" id="formstud" style="
    width: 150px;">
    	  <option value="">Semua</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          
        </select></td>
      </tr>      
      <tr><td><p></td></tr>
      <tr>
          <td colspan="3" align="center"><input type="submit" name="submitbtn" id="submitbtn" value="Submit" style="width: 150px;" class="btn btn-primary"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="backbtn" id="backbtn" value="Back" onclick='window.open("menu.php","_parent")' style="
    width: 150px;" class="btn btn-primary"/></td>
      </tr>

      <tr>      
    </table>
  </div>
  <p align="center">&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div align="center"><div id="jqxgridStudent" ></div></div>
</form>

<script type="text/javascript">
	$(document).ready(function () {
	showResultList($("#yearselect").val(), $("#termselect").val(), $("#formstud").val());
	
	
function showResultList(yearVal, termVal, formVal){
	$.post("function.php",
	         	{ 
				yearselect: yearVal, termselect: termVal, formselect: formVal, action: "list_result"}, 
	         		function(data) {
	         			console.log(data);
	                	//$('#stage').html(data);
	                	dataStudent = data;
	                	//alert (dataStudent);
	                	student (dataStudent);
				                });
}

function student (dataStudent){
			//alert (dataStudent);
            var sourceStudent =
            {
                datatype: "json",                 
                
                datafields: [
                    { name: 'id' , type: 'string'},
                    { name: 'name' },
                    { name: 'year' , type: 'string'},
                    { name: 'term', type: 'string'},
                    { name: 'ExamName'},
                    { name: 'ExamValue'},
                    { name: 'form', type: 'string'},
                ],
                //id: 'id',
                localdata: dataStudent
            };
            
            var dataAdapterStudent = new $.jqx.dataAdapter(sourceStudent);
            //console.log(dataAdapterStudent);
            
            $("#jqxgridStudent").jqxGrid(
            {
                autowidth: true,
                autoheight: true,
                source: dataAdapterStudent,
                columnsresize: true,
                //editable: true,
                pageable: true,
                sortable: true,
               
                columns: [
                  { text: 'ID', dataField: 'id', filtertype: 'checkedlist', width: 100 },
                  { text: 'Nama Pelajar MRSM', dataField: 'name', width: 400 },
                  { text: 'Tahun', dataField: 'year', filtertype: 'checkedlist', width: 200, },
                  { text: 'Semester', dataField: 'term',  width: 200, },       
                  { text: 'Nama Ujian', dataField: 'ExamName', filtertype: 'checkedlist', width: 200, },       
                  { text: 'Nilai Ujian', dataField: 'ExamValue',  width: 200, },       
                  { text: 'Tingkatan', dataField: 'form', filtertype: 'checkedlist', width: 200, },       
                ],
            });
            $("#jqxgridStudent").jqxGrid('autoresizecolumns');
	
            

// select or unselect rows when the checkbox is checked or unchecked.
             
}
	
		
		$("#yearselect").change(function(){
			//alert($("#yearselect").val());
			showResultList($("#yearselect").val(), '', '');
		});

		$("#termselect").change(function(){
			//alert($("#termselect").val());
			showResultList($("#yearselect").val(), $("#termselect").val(), '');
		});
		
		$("#formstud").change(function(){
			//alert($("#formstud").val());
			showResultList($("#yearselect").val(), $("#termselect").val(), $("#formstud").val());
		});
						
		$("#resultbtn").click(function(){
			//alert ("result clicked");
			//alert ($("#yearselect").val());
			//alert ($("#termselect").val());
			//alert ($("#form").val());
/*
			$.post( "function.php", { 
				yearselect: $("#yearselect").val(), termselect: $("#termselect").val(), form: $("#form").val(), action: "list_result"}, function(data){
					console.log(data);
					//alert(data);
					var obj = jQuery.parseJSON(data);
					//alert( obj[2].id);
				}  
				);//post
*/	
		}); //resultbtn
		
	});
</script>
