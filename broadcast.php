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

<form id="form1" name="form1" method="post" action="broadcast.php">
<div align="center">
<table>
      <tr>
        <td>For</td>
        <td>: </td>
        <td><select name="for" id="for" style="
    width: 150px;">
          <option value="1">Ibu Bapa</option>
          <option value="2">Guru</option>
<!--           <option value="3">Ibu Bapa & Guru</option> -->
        </select></td>
      </tr> 	
<tr>
	<td>
     Mesej
    </td>
    <td>: </td>
    <td><textarea name="broadtext" id="broadtext" cols="45" rows="5"></textarea></td>
</tr>
<tr>
<td colspan="3">
	<div>
    <div>
    	<div id="jqxgridParent"></div>    	
    </div>
    <div>
    	<div id="jqxgridTeacher"></div>
    </div>
    <div>
    	<div id="jqxgridParentTeacher"></div>
    </div>	
</div>
</td>
</tr>
<tr>
	<td align="center" colspan="3">
    <input type="button" name="hantarbtn" id="hantarbtn" value="Hantar" class="btn btn-primary" style="width:250"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="backbtn" id="backbtn" value="Back" onClick='window.open("menu.php","_parent")' class="btn btn-primary" style="width:250"/>    
	</td>
</tr>
 </table>
</form>
</div>


    <script type="text/javascript">
        $(document).ready(function () {
			function parent (dataParent){
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
			            
			            $("#jqxgridParent").jqxGrid(
			            {
			                autowidth: true,
			                autoheight: true,
			                source: dataAdapterParent,
			                columnsresize: true,
			                pageable: true,
			                sortable: true,
			                selectionmode: 'checkbox',                
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
			                pageable: true,
			                sortable: true,
			                selectionmode: 'checkbox',                
			                columns: [
			                  { text: 'ID', dataField: 'id', width: 100 },
			                  { text: 'Nama', dataField: 'name', width: 300 },
			                  { text: 'Tel No', dataField: 'phone', width: 200, },
			                ]
			            });	
			}
			
					$('#jqxgridParent').show(); 
					$.post("function.php",
						{ action : 'listparent'}, 
		         		function(data) {
		                	//$('#stage').html(data);
		                	 dataParent = data;
		                	//alert (dataParent);
		                	parent (dataParent);
					    });			
			
			$('#for').change(function(){
				//alert('for changed');
				if ($('#for').val() == 1){
					$('#jqxgridParent').show(); 
					$.post("function.php",
						{ action : 'listparent'}, 
		         		function(data) {
		                	//$('#stage').html(data);
		                	 dataParent = data;
		                	//alert (dataParent);
		                	parent (dataParent);
					    });
					$('#jqxgridTeacher').hide();	 
				}
				else if ($('#for').val() == 2){
					$('#jqxgridTeacher').show(); 
					$.post("function.php",
						{ action : 'listteacher'}, 
		         		function(data) {
		                	//$('#stage').html(data);
		                	 dataTeacher = data;
		                	//alert (dataParent);
		                	teacher (dataTeacher);
					    });
					$('#jqxgridParent').hide();    	 
				}
				else if ($('#for').val() == 3){
					$.post("function.php",
						{ action : 'listparentteacher'}, 
		         		function(data) {
		                	//$('#stage').html(data);
		                	 dataParentTeacher = data;
		                	//alert (dataParent);
		                	parent (dataParentTeacher);
					    });	 
				}								
			});
			
				$('#hantarbtn').click(function () {
					//alert ('clicked');
				var messageBroadcast = $('#broadtext').val();
	    		var selectionBroadcast = $('#for').val();
	    		var rows;
	    		var selectedRecords = new Array();
	    		if (selectionBroadcast == '1'){
		    		rows = $("#jqxgridParent").jqxGrid('selectedrowindexes');
	                //var selectedRecords = new Array();
	                for (var m = 0; m < rows.length; m++) {
	                    var row = $("#jqxgridParent").jqxGrid('getrowdata', rows[m]);
	                    selectedRecords[selectedRecords.length] = row;
	                }		    		
	    		}
	    		if (selectionBroadcast == '2'){
		    		rows = $("#jqxgridTeacher").jqxGrid('selectedrowindexes');
	                
	                for (var m = 0; m < rows.length; m++) {
	                    var row = $("#jqxgridTeacher").jqxGrid('getrowdata', rows[m]);
	                    selectedRecords[selectedRecords.length] = row;
	                }		    		
	    		}	    		
	    		
                //console.log(selectedRecords[0].id);
					$.post("function.php",
						{ action : 'selectedBroadcast', records : selectedRecords, selection: selectionBroadcast, message: messageBroadcast}, 
		         		function(data) {
		                	//$('#stage').html(data);
		                	 dataBroadcast = data;
		                	alert (dataBroadcast);
		                	//parent (dataParentTeacher);
					    });	                
});	        
        });
</script>
