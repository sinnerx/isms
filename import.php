<link rel="stylesheet" href="bootstrap3.1.1/css/bootstrap.css" type="text/css" />
<?php  

//connect to the database 
$connect = mysql_connect("localhost","pidcedu_ismsuser","010203"); 
mysql_select_db("pidcedu_ismsdb",$connect); //select the table 
ini_set("auto_detect_line_endings", "1");
// 


$content = "";
//include_once("header.php");
$x =0;
if (isset($_POST['SubmitStudent'])){
	//echo "student";
	if ($_FILES[csvStudent][size] > 0) { 
	
	    //get the csv file 
	    $file = $_FILES[csvStudent][tmp_name]; 
	    
	    $handle = fopen($file,"r"); 
	     
	    //loop through the csv file and insert into database 
		$flag = true;
		mysql_query("TRUNCATE TABLE student");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
			if($flag) { $flag = false; continue; }
	        if ($data[1]) { 
	        	//if ($data[2])
	            mysql_query("INSERT INTO student (id, name, phone, parentid) VALUES 
	                ( 
	                    '".addslashes($data[0])."', 
	                    '".addslashes($data[1])."', 
	                    '0".addslashes($data[2])."', 
	                    '".addslashes($data[3])."'                   	                    
	                ) 
	            "); 
	            }
	    }
		//}
		print_r($data);
	    // 




	    //redirect 
	    //header('Location: import.php?success=1'); die; 
	    ?>
	    <script type="text/javascript">
		<!--
		window.location = "import.php?success=1";
		//-->
		</script>
	    <?php
	
	} 	
}

if (isset($_POST['SubmitExam'])){
	//echo "exam";
	if ($_FILES[csvExam][size] > 0) { 
	
	    //get the csv file 
	    $file = $_FILES[csvExam][tmp_name]; 
	    $handle = fopen($file,"r"); 
	    $flag = true;
	    //echo "aaa";
	    //loop through the csv file and insert into database 
/*
	    do { 
	        if ($data[0]) { 
	            mysql_query("INSERT INTO recordExam (year, term, examName, ExamValue, stud_id, form) VALUES 
	                ( 
	                    '".addslashes($data[0])."', 
	                    '".addslashes($data[1])."', 
	                    '".addslashes($data[2])."', 
	                    '".addslashes($data[3])."', 
	                    '".addslashes($data[4])."', 	                    	                    
	                    '".addslashes($data[5])."' 	                    	                    
	                ) 
	            "); 
	        }

	    } while ($data = fgetcsv($handle,1000,",","'"));
*/ 

		$flag = true;
		mysql_query("TRUNCATE TABLE recordExam");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if($flag) { $flag = false; continue; }
	        if ($data[0]) { 
	        	//echo "insert working";
	            mysql_query("INSERT INTO recordExam (id, year, term, examName, ExamValue, stud_id, form) VALUES 
	                ( 
	                    '".addslashes($data[0])."', 
	                    '".addslashes($data[1])."', 
	                    '".addslashes($data[2])."', 
	                    '".addslashes($data[3])."', 
	                    '".addslashes($data[4])."', 	                    	                    
	                    '".addslashes($data[5])."', 	                    	                    
	                    '".addslashes($data[6])."' 	                    	                    
	                ) 
	            "); 
	            }
	    }
	    // 
	    print_r($data);
	    //redirect 
	    ?>
	    <script type="text/javascript">
		<!--
		window.location = "import.php?success=1";
		//-->
		</script>
	    <?php
	
	} 	
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 
<?php if (!empty($_GET[success])) { echo "<script type='text/javascript'> alert('Muat Naik Berjaya.')</script>"; } //generic success notice
	/*
else {
		echo "<b>Muat naik fail gagal</b>";
	}
*/
?> 


<!--
  Muat Naik Maklumat Pelajar: <br /> 
  <a href="exportParent.php" class="btn btn-primary">Pautan Senarai IbuBapa</a> &nbsp <a href="exportStudentTemplate.php" class="btn btn-primary">Pautan Fail Pelajar</a> </p>  
  </p>
  
  <p></p><br><p></p>
  Muat Naik Maklumat Peperiksaan: <br />
  <a href="exportstudent.php" class="btn btn-primary">Pautan Senarai Pelajar</a> &nbsp <a href="exportExam.php" class="btn btn-primary">Pautan Fail Peperiksaan Pelajar</a> </p>
   
-->

<p align="center">
  <input type="button" name="menubtn" id="menubtn" value="Menu" onClick='window.open("menu.php","_parent")' style="
    width: 150px;"/>
</p>
<form action="import.php" method="post" enctype="multipart/form-data" name="form1" id="form1">  	
<div align="center" style="margin-top:100px; margin-left:10px">
<div class="well well-lg" style="width:300px; height:200px; float:left;">
	<a href="exportParent.php" class="btn btn-primary" >Senarai IbuBapa</a>
</div>
<div class="well well-lg" style="width:300px; height:200px; float:left; margin-left:10px">
	<a href="exportstudent.php" class="btn btn-primary">Muat Naik Senarai Pelajar</a><p></p>
	 <input name="csvStudent" type="file" id="csvStudent" style="margin-left:40px"/><p></p>
	<input type="submit" name="SubmitStudent" value="Submit" class="btn btn-success"/> 
</div>
<div class="well well-lg" style="width:300px; height:200px; float:left; margin-left:10px">
	<a href="exportExam.php" class="btn btn-primary">Muat Naik Peperiksaan Pelajar</a><p></p>
	<input name="csvExam" type="file" id="csvExam"  style="margin-left:40px"/><p></p>
  <input type="submit" name="SubmitExam" value="Submit" class="btn btn-success"/>  
</div>
</div>
</form> 
</body> 
</html> 