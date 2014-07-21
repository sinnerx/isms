<?php include_once("header.php"); ?>

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
    <script type="text/javascript" src="jqwidgets/jqxcheckbox.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            //var url = "sampledata/data.php";          
           
           //var dataStudent = '<?php //echo $varStudent; ?>';
           var dataStudent;
           var dataParent;
           var dataTeacher;
	 
	 //tabload
	 $('#jqxTabs').on('created', function (event) { 
	 	         $.post("function.php",
	         	{ action : 'liststudent'}, 
	         		function(data) {
	                	//$('#stage').html(data);
	                	dataStudent = data;
	                	//alert (dataStudent);
	                	student (dataStudent);
				                });	
	  });           
	//Tabs
	 $('#jqxTabs').jqxTabs({
	     width: 900,
	     height: 500,
	     theme: 'energyblue'
	 });
	 
	 

	//tabclicked
	 $('#jqxTabs').on('tabclick', function (event) {
	     var tabclicked = event.args.item;
	     //alert('The clicked tab is ' + tabclicked);
	     
	     if (tabclicked == 0){
		     //alert ('pelajar');
	         $.post("function.php",
	         	{ action : 'liststudent'}, 
	         		function(data) {
	                	//$('#stage').html(data);
	                	console.log(data);
	                	dataStudent = data;
	                	//alert (dataStudent);
	                	student (dataStudent);
				                });	     
	     }	     
	     
	     else if (tabclicked == 1){
		     //alert ('ibubapa');
	         $.post("function.php",
	         	{ action : 'listparent'}, 
	         		function(data) {
	                	//$('#stage').html(data);
	                	dataParent = data;
	                	//alert (dataParent);
	                	parent (dataParent);
				                });	     
	     }
	     
	     else if (tabclicked == 2){
		     //alert ('guru');
	         $.post("function.php",
	         	{ action : 'listteacher'}, 
	         		function(data) {
	                	//$('#stage').html(data);
	                	dataTeacher = data;
	                	//alert (dataTeacher);
	                	teacher (dataTeacher);
				                });	     
	     }	     
	 });   
            // prepare the data
            
           
function student (dataStudent){
			//alert (dataStudent);
            var sourceStudent =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	//console.log(rowdata);
	                $.post("function.php",{id : rowdata.stud_id, name : rowdata.stud_name, phone : rowdata.stud_phone, par_id: rowdata.par_id, action : 'editstudent'},
		                function(data) {
		                	//$('#stage').html(data);
		                	
		                }
	                );                	
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    commit(true);
                },
                deleterow: function(rowid, commit){
                	//alert(rowid);
	                $.post("function.php", {id: rowid, action: 'deletestudent'}, function(data){
		                alert(data);
	                });
	                commit(true);
                },                 
                
                datafields: [
                    { text: 'ID', name: 'stud_id' },
                    { name: 'stud_name' },
                    { name: 'stud_phone'},
                    { name: 'par_name'},
                    { name: 'par_id'},
                ],
                id: 'stud_id',
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
                editable: false,
                pageable: true,
                sortable: true,
                //selectionmode: 'multiplecellsadvanced',
               
                columns: [
                  { text: 'ID', dataField: 'stud_id', width: 100 },
                  { text: 'Nama Pelajar MRSM', dataField: 'stud_name', width: 300 },
                  { text: 'Tel No', dataField: 'stud_phone', width: 200, },
                  { text: 'Nama Ibu Bapa', dataField: 'par_id', displayfield: 'par_name',columntype: 'combobox',  width: 200, },       
                ],
            });
            
           	
}

function parent (dataParent){
            var sourceParent =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	//console.log(rowdata);

	                $.post("function.php",{id : rowdata.id, name : rowdata.name, phone : rowdata.phone, action : 'editparent'},
		                function(data) {
		                	//$('#stage').html(data);
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
            var dataAdapterParent = new $.jqx.dataAdapter(sourceParent);
            
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
                  { text: 'Nama', dataField: 'name', width: 300 },
                  { text: 'Tel No', dataField: 'phone', width: 200, },
                ]
            }); 
                       
}

function teacher (dataTeacher){
            var sourceTeacher =
            {
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                	//console.log(rowdata);

	                $.post("function.php",{id : rowdata.id, name : rowdata.name, phone : rowdata.phone, action : 'editteacher'},
		                function(data) {
		                	//$('#stage').html(data);
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
            
           
            var dataAdapterTeacher = new $.jqx.dataAdapter(sourceTeacher);

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
                  { text: 'Nama', dataField: 'name', width: 300 },
                  { text: 'Tel No', dataField: 'phone', width: 200, },
                ]
            });	
}

            
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
		                	//$('#stage').html(data);
					                });
					                
				 $('#inputnameStudent').jqxInput('val', '');
				 $('#inputphoneStudent').jqxInput('val', '');
				 	                
				 $( "#pelajartab" ).trigger( "click" );		                				                
                 $('#createStudent').jqxWindow('close');
            });
            
            // delete row.
            $("#DeleteStudButton").on('click', function () {
            	$('#YesNoDialog').jqxWindow('open');

            });
            
            //deleteDialogEvent
            $('#okdelbtn').click(function(){
            	//alert("del button clicked");
                var selectedrowindex = $("#jqxgridStudent").jqxGrid('getselectedrowindex');
                //alert (selectedrowindex);
                var rowscount = $("#jqxgridStudent").jqxGrid('getdatainformation').rowscount;
                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                    var id = $("#jqxgridStudent").jqxGrid('getrowid', selectedrowindex);
                    //alert(id);
                    var commit = $("#jqxgridStudent").jqxGrid('deleterow', id);
                }
                $('#YesNoDialog').jqxWindow('close');	            
            });  

			$('#canceldelbtn').click(function () {
                $('#YesNoDialog').jqxWindow('close');
                //alert ('clicked');
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
		                	//$('#stage').html(data);
					                });
					                
				 $('#inputnameParent').jqxInput('val', '');
				 $('#inputphoneParent').jqxInput('val', '');					           
				 $( "#ibubapatab" ).trigger( "click" );	
				// $('#jqxTabs').on('tabclick', function (event) {		                
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
		                	//$('#stage').html(data);
					                });
				 $('#inputnameTeacher').jqxInput('val', '');
				 $('#inputphoneTeacher').jqxInput('val', '');				 	                
				 $( "#gurutab" ).trigger( "click" );			                
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
				    //alert ('oi');
	         $.post("function.php",
	         	{ action : 'listparent'}, 
	         		function(data) {
	                	//$('#stage').html(data);
	                	dataParent = data;
	                	//alert (dataParent);
	                	//alert ('ok');
	                	//parent (dataParent);
			            var sourceParent =
			            {
			                datatype: "json",                
			                datafields: [
			                    { name: 'id' },
			                    { name: 'name' },
			                    { name: 'phone'},
			                ],
			                id: 'id',
			                localdata: dataParent,
			                async: false,
			            };
			            var dataAdapterParent = new $.jqx.dataAdapter(sourceParent);
	                	
				        //alert(dataAdapterParent);
		                // Create a jqxComboBox
		                $("#jqxComboBox").jqxComboBox({ 
		                	source: dataAdapterParent, 
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
			    }
			}); 
			
//YesNo Dialog Box
						
			$('#YesNoDialog').jqxWindow({
			    theme: 'energyblue',
			    autoOpen:false,
			    height: 100,
			    width: 350,
			    initContent: function (){
				    $("#okdelbtn").jqxButton({ width: '150'});
				    $("#canceldelbtn").jqxButton({ width: '150'});
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
         
/*
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
*/               		                                           
        });
    </script>

<div align="center">
<div id='jqxTabs' >
    <ul style='margin-left: 20px;'>
        <li id="pelajartab">Pelajar</li>
        <li id="ibubapatab">Ibu Bapa</li>
        <li id="gurutab">Guru</li>
    </ul>
    <div align="center">
	    <div id="jqxgridStudent"></div>
	    <input type="button" value="Tambah Pelajar" id="showWindowStudentButton" class="btn btn-primary"/>
	    <input type="button" value="Padam Pelajar" id="DeleteStudButton" class="btn btn-danger"/>
    </div>
    <div align="center">
    	<div id="jqxgridParent"></div>
    	<input type="button" value="Tambah Rekod Ibu Bapa" id="showWindowParentButton" class="btn btn-primary"/>
    	
    </div>
    <div align="center">
    	<div id="jqxgridTeacher"></div>
    	 <input type="button" value="Tambah Rekod Guru" id="showWindowTeacherButton" class="btn btn-primary"/>
    </div>
</div>

    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
    
		<div id="stage">
  
        </div>
        
<p align="center">
  <input type="button" name="menubtn" id="menubtn" value="Menu" onClick='window.open("menu.php","_parent")' class="btn btn-primary"/>
</p>             
    </div>
</div >    
            <div id="createStudent">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameStudent"/>
			    <br>
			    Phone : <input type="text" id="inputphoneStudent"/>
			    <br>
			    Parent : <div id="jqxComboBox"></div><br>  
			    <input type="submit" id="createStudentButton" value="Hantar" class="btn btn-primary">
			    <input type="button" id="cancelStudentButton" value="Batal" class="btn btn-primary">
			    
			    
		    </div>
		    
        	</div>
        	
            <div id="createParent">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameParent"/>
			    <br>
			    Phone : <input type="text" id="inputphoneParent"/>
			    <input type="submit" id="createParentButton" value="Hantar" class="btn btn-primary">
			    <input type="button" id="cancelParentButton" value="Batal" class="btn btn-primary">
		    </div>
        	</div> 
        	
            <div id="createTeacher">
		    <div>Header</div>
		    <div>
			    Name : <input type="text" id="inputnameTeacher"/>
			    <br>
			    Phone : <input type="text" id="inputphoneTeacher"/>
			    <input type="submit" id="createTeacherButton" value="Hantar" class="btn btn-primary">
			    <input type="button" id="cancelTeacherButton" value="Batal" class="btn btn-primary">
		    </div>
        	</div>
        	
        	<div id="YesNoDialog">
        	<div>Padam Rekod Pelajar</div>
        	<div>
        		Adakah anda pasti?
        	
        		<br>
        		<input type="button" id="okdelbtn" value="Padam" class="btn btn-primary">
        		<input type="button" id="canceldelbtn" value="Batal" class="btn btn-primary">
        	</div>	
        	</div>  
        	
        	     	        	  