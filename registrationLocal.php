<?

	
function list_student(){
	$con=mysqli_connect("localhost","root","","smsdb");
	
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	  
	$sqlStudent = "SELECT student.id as stud_id, student.name as stud_name, student.phone as stud_phone, parent.id as par_id, parent.name as par_name FROM student LEFT OUTER JOIN parent ON student.parentid = parent.id";
	$resultStudent = mysqli_query($con, $sqlStudent);
	$destination = array();
	
	while ($row = mysqli_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);	
	mysqli_close($con);
	
	return $resultJSON;
}

function list_parent(){
	$con=mysqli_connect("localhost","root","","smsdb");
	
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	  
	$sqlStudent = "SELECT * FROM parent";
	$resultStudent = mysqli_query($con, $sqlStudent);
	while ($row = mysqli_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);
	
	mysqli_close($con);	
	return $resultJSON;
}

function list_teacher() {
	$con=mysqli_connect("localhost","root","","smsdb");
	
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	  
	$sqlStudent = "SELECT * FROM teacher";
	$resultStudent = mysqli_query($con, $sqlStudent);
	while ($row = mysqli_fetch_assoc($resultStudent)){
		$destination[] = $row;
	}

	$resultJSON = json_encode($destination);
	
	mysqli_close($con);	
	return $resultJSON;
}


if (isset($_GET['actionbutton']) == 'studentlist'){
	$varStudent =	list_student();
	$varParent 	=	list_parent();
	$varTeacher	=	list_teacher();
	//print_r($varStudent);
}

if ($_GET['actionbutton'] == 'editStudent'){
	$varStudent =	list_student();
	$varParent 	=	list_parent();
	$varTeacher	=	list_teacher();
	echo "editStudent";
	//print_r($varStudent);
}
?>

    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>
    
    <script type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>
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
    
    <script type="text/javascript" src="jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxpanel.js"></script>
    
    <script type="text/javascript" src="jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
    
    <script type="text/javascript" src="jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //var url = "sampledata/data.php";          
           
           var dataStudent; 
           //= '<?php //echo $varStudent; ?>';
           var dataParent = '<?php echo $varParent; ?>';
           var dataTeacher = '<?php echo $varTeacher; ?>';
           
	//Tabs
	 $('#jqxTabs').jqxTabs({
	     width: 900,
	     height: 500,
	     theme: 'energyblue'
	 });
	 
	//tabclicked
	 $('#jqxTabs').on('tabclick', function (event) {
	     var tabclicked = event.args.item;
	     alert('The clicked tab is ' + tabclicked);
	     
	     if (tabclicked == 0){
		     alert ('pelajar');
	         $.post("function.php",
	         	{ action : 'liststudent'}, 
	         		function(data) {
	                	$('#stage').html(data);
	                	dataStudent = data;
	                	alert (dataStudent);
				                });	     
	     }
	 });   
            // prepare the data
            
           
function student (){
	
}
            var sourceParent =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	//console.log(rowdata);

	                $.post("function.php",{id : rowdata.id, name : rowdata.name, phone : rowdata.phone, action : 'editparent'},
		                function(data) {
		                	$('#stage').html(data);
		                }
	                );                	
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    commit(true);
                },                 
                datafields: [
                    { name: 'id' },
                    { name: 'name' },
                    { name: 'phone'},
                ],
                id: 'id',
                localdata: dataParent,
                async: false,
            };
            var sourceTeacher =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	//console.log(rowdata);

	                $.post("function.php",{id : rowdata.id, name : rowdata.name, phone : rowdata.phone, action : 'editteacher'},
		                function(data) {
		                	$('#stage').html(data);
		                }
	                );                	
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    commit(true);
                },                 
                datafields: [
                    { name: 'id' },
                    { name: 'name' },
                    { name: 'phone'},
                ],
                id: 'id',
                localdata: dataTeacher
            };                        
            
            var dataAdapterParent = new $.jqx.dataAdapter(sourceParent);
            var dataAdapterTeacher = new $.jqx.dataAdapter(sourceTeacher);

            var sourceStudent =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	console.log(rowdata);
                	console.log(parentAdapter.records);
	                $.post("function.php",{id : rowdata.stud_id, name : rowdata.stud_name, phone : rowdata.stud_phone, par_id: rowdata.par_id, action : 'editstudent'},
		                function(data) {
		                	$('#stage').html(data);
		                }
	                );                	
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    commit(true);
                },                 
                
                datafields: [
                    { name: 'stud_id' },
                    { name: 'stud_name' },
                    { name: 'stud_phone'},
                    { name: 'par_name'},
                    { name: 'par_id'},
                    

                ],
                id: 'stud_id',
                localdata: dataStudent
            };
            
            var dataAdapterStudent = new $.jqx.dataAdapter(sourceStudent);
            
            
            $("#jqxgridStudent").jqxGrid(
            {
                autowidth: true,
                autoheight: true,
                source: dataAdapterStudent,
                columnsresize: true,
                editable: true,
                pageable: true,
                sortable: true,
                selectionmode: 'multiplecellsadvanced',
               
                columns: [
                  { text: 'ID', dataField: 'stud_id', width: 100 },
                  { text: 'Name', dataField: 'stud_name', width: 300 },
                  { text: 'Phone Number', dataField: 'stud_phone', width: 200, },
                  { text: 'Parent', dataField: 'par_id', displayfield: 'par_name',columntype: 'combobox',  width: 200, },       
                ]
            });

            $("#jqxgridParent").jqxGrid(
            {
                autowidth: true,
                autoheight: true,
                source: dataAdapterParent,
                columnsresize: true,
                editable: true,
                pageable: true,
                sortable: true,
                selectionmode: 'multiplecellsadvanced',                
                columns: [
                  { text: 'ID', dataField: 'id', width: 100 },
                  { text: 'Name', dataField: 'name', width: 300 },
                  { text: 'Phone Number', dataField: 'phone', width: 200, },
                ]
            });
            
            $("#jqxgridTeacher").jqxGrid(
            {
                autowidth: true,
                autoheight: true,
                source: dataAdapterTeacher,
                columnsresize: true,
                editable: true,
                pageable: true,
                sortable: true,
                selectionmode: 'multiplecellsadvanced',                
                columns: [
                  { text: 'ID', dataField: 'id', width: 100 },
                  { text: 'Name', dataField: 'name', width: 300 },
                  { text: 'Phone Number', dataField: 'phone', width: 200, },
                ]
            });
            
            //Grid Events
            // events student
            $("#jqxgridStudent").on('cellbeginedit', function (event) {
                var args = event.args;
                $("#cellbegineditevent").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });
            $("#jqxgridStudent").on('cellendedit', function (event) {
                var args = event.args;
                $("#cellendeditevent").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });
            
            //events parent
            $("#jqxgridParent").on('cellbeginedit', function (event) {
                var args = event.args;
                $("#cellbegineditevent").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });
            $("#jqxgridParent").on('cellendedit', function (event) {
                var args = event.args;
                $("#cellendeditevent").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });

            //events teacher
            $("#jqxgridTeacher").on('cellbeginedit', function (event) {
                var args = event.args;
                $("#cellbegineditevent").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });
            $("#jqxgridTeacher").on('cellendedit', function (event) {
                var args = event.args;
                $("#cellendeditevent").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
            });   

//event	buttons	
//student	
            $('#showWindowStudentButton').click(function () {
                $('#createStudent').jqxWindow('open');
                //alert ('clicked');
            });
            
            $('#cancelStudentButton').click(function () {
                    $('#createStudent').jqxWindow('close');
            });
            
             
            $('#createStudentButton').click(function () {

                     var checkboxes = $("#jqxComboBox").jqxComboBox('selectedIndex');
                     
                    var item = $('#jqxComboBox').jqxComboBox('getItem', checkboxes);
                    // get value.
                    var valueParentId = item.value;
                    //alert (valueParentId);                     
                 $.post("function.php",
                 	{name : $('#inputnameStudent').val(), phone : $('#inputphoneStudent').val(), parentid : valueParentId, action : 'addstudent'}, 
                 	function(data) {
		                	$('#stage').html(data);
					                });
                location.reload();				                
                 $('#createStudent').jqxWindow('close');
            });
            
//parent	
            $('#showWindowParentButton').click(function () {
                $('#createParent').jqxWindow('open');
                //alert ('clicked');
            });
            
            $('#cancelParentButton').click(function () {
                    $('#createParent').jqxWindow('close');
            });
            
             
            $('#createParentButton').click(function () {
                 $.post("function.php",
                 	{name : $('#inputnameParent').val(), phone : $('#inputphoneParent').val(), action : 'addparent'}, 
                 	function(data) {
		                	$('#stage').html(data);
					                });
                //location.reload();				                
                 $('#createParent').jqxWindow('close');
            });
            
//teacher
            $('#showWindowTeacherButton').click(function () {
                $('#createTeacher').jqxWindow('open');
                //alert ('clicked');
            });
            
            $('#cancelTeacherButton').click(function () {
                    $('#createTeacher').jqxWindow('close');
            });
            
             
            $('#createTeacherButton').click(function () {
            	
                 $.post("function.php",
                 	{name : $('#inputnameTeacher').val(), phone : $('#inputphoneTeacher').val(), action : 'addteacher'}, 
                 	function(data) {
		                	$('#stage').html(data);
					                });
                location.reload();				                
                 $('#createTeacher').jqxWindow('close');
            });                                      
/*
                var datafield 	= args.datafield;
               
                var value		= args.value;
                
                var params = {};
                params[datafield] = value;
                $.post("function.php",params,
	                function(data) {
	                	$('#stage').html(data);
	                }
                );
*/

//windows
//CreateStudent
			$('#createStudent').jqxWindow({
			    theme: 'energyblue',
			    autoOpen:false,
			    height: 300,
			    width: 500,
			    initContent: function (){
				    $("#inputnameStudent").jqxInput({placeHolder: "Masukkan nama pelajar", height: 25, width: 400, minLength: 1 });
				    $("#inputphoneStudent").jqxInput({placeHolder: "Masukkan nombor telefon", height: 25, width: 400, minLength: 1 });
				    $("#createStudentButton").jqxButton({ width: '150'});
				    $("#cancelStudentButton").jqxButton({ width: '150'});
			    }
			}); 

//CreateParent
			$('#createParent').jqxWindow({
			    theme: 'energyblue',
			    autoOpen:false,
			    height: 300,
			    width: 500,
			    initContent: function (){
				    $("#inputnameParent").jqxInput({placeHolder: "Masukkan nama ibu/bape", height: 25, width: 400, minLength: 1 });
				    $("#inputphoneParent").jqxInput({placeHolder: "Masukkan nombor telefon", height: 25, width: 400, minLength: 1 });
				    $("#createParentButton").jqxButton({ width: '150'});
				    $("#cancelParentButton").jqxButton({ width: '150'});
			    }
			});
			
//CreateTeacher
			$('#createTeacher').jqxWindow({
			    theme: 'energyblue',
			    autoOpen:false,
			    height: 300,
			    width: 500,
			    initContent: function (){
				    $("#inputnameTeacher").jqxInput({placeHolder: "Masukkan nama guru", height: 25, width: 400, minLength: 1 });
				    $("#inputphoneTeacher").jqxInput({placeHolder: "Masukkan nombor telefon", height: 25, width: 400, minLength: 1 });
				    $("#createTeacherButton").jqxButton({ width: '150'});
				    $("#cancelTeacherButton").jqxButton({ width: '150'});
			    }
			});
         
		        var dataAdapter = new $.jqx.dataAdapter(sourceParent);
                // Create a jqxComboBox
                $("#jqxComboBox").jqxComboBox({ 
                	source: dataAdapter, 
                	width: '200px', 
                	height: '25px',  
                	selectedIndex: 0,
                	displayMember: 'name',
                	valueMember: 'id'
                });  
                
               $('#jqxComboBox').bind('select', function (event) {
                    var args = event.args;
                    var item = $('#jqxComboBox').jqxComboBox('getItem', args.index);
                    // get value.
                    var value = item.value;
                    // get label.
                    var label = item.label;
                    
                    //alert(value);
                });                		                                           
        });
    </script>

<div id='jqxTabs'>
    <ul style='margin-left: 20px;'>
        <li>Pelajar</li>
        <li>Ibu Bapa</li>
        <li>Guru</li>
    </ul>
    <div>
	    <div id="jqxgridStudent"></div>
	    <input type="button" value="New Student" id="showWindowStudentButton" />
    </div>
    <div>
    	<div id="jqxgridParent"></div>
    	<input type="button" value="New Parent" id="showWindowParentButton" />
    	
    </div>
    <div>
    	<div id="jqxgridTeacher"></div>
    	 <input type="button" value="New Teacher" id="showWindowTeacherButton" />
    </div>
</div>

    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
    
		<div id="stage">
          STAGE
        </div>
        
             
    </div>
    
            <div id="createStudent">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameStudent"/>
			    <br>
			    Phone : <input type="text" id="inputphoneStudent"/>
			    <br>
			    Parent : <div id="jqxComboBox"></div><br>  
			    <input type="submit" id="createStudentButton" value="Hantar">
			    <input type="button" id="cancelStudentButton" value="Batal">
			    
		    </div>
		    
        	</div>
        	
            <div id="createParent">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameParent"/>
			    <br>
			    Phone : <input type="text" id="inputphoneParent"/>
			    <input type="submit" id="createParentButton" value="Hantar">
			    <input type="button" id="cancelParentButton" value="Batal">
		    </div>
        	</div> 
        	
            <div id="createTeacher">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameTeacher"/>
			    <br>
			    Phone : <input type="text" id="inputphoneTeacher"/>
			    <input type="submit" id="createTeacherButton" value="Hantar">
			    <input type="button" id="cancelTeacherButton" value="Batal">
		    </div>
        	</div>  
        	
        	     	        	  