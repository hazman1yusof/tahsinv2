var currrow=null;

var dt_tilawah = $('#dt_tilawah').DataTable({
	ajax: "./setup/table?action=gettilawah",
 	dom: '<f<"datablediv"t>p>',
 	paging: false,
	columns: [
        {'data': 'idno','class':'idno'},
        {'data': 'giliran','class':'giliran'},
        {'data': 'user_id','class':'user_id'},
        {'data': 'ms1','class':'ms1'},
        {'data': 'ms2','class':'ms2'},
        {'data': 'lastupdate','class':'lastupdate'},
    ],
    order: [[0, 'desc']],
    columnDefs: [
    	{targets: [2,3,4,5], orderable: false },
    	{targets: 0,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == '99999999999' ) {
					$(td).html('');
				}
   			}
   		},{targets: 1,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == 'add' ) {
					$(td).html('');
					$(td).append(`<div class="ui input"><input type="number" name="giliran" id="giliran"></div>`);
				}
   			}
   		},{targets: 2,
        	createdCell: function (td, cellData, rowData, row, col) {
				$(td).html('');
				if (cellData == 'add' ) {
					$(td).append(init_user_select());
				}else{
					$(td).append(init_user_name(cellData));
				}
   			}
   		},{targets: 3,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == 'add' ) {
					$(td).html('');
					$(td).append(`<div class="ui input"><input type="number" name="ms1" id="ms1"></div>`);
				}
   			}
   		},
        {targets: 4,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == 'add' ) {
					$(td).html('');
					$(td).append(`<div class="ui input"><input type="number" name="ms2" id="ms2"></div>`);
				}
   			}
   		},
        {targets: 5,
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData == 'add' ) {
					$(td).html('');
					$(td).append(`<button class="ui tiny primary button" id="save" type="button" >Save</button>
								  <button class="ui tiny red button" id="cancel" type="button" >Cancel</button>
									`);

					$('#dt_tilawah').off('click','button#save');
					$('#dt_tilawah').on('click','button#save', function(){

						var param = {
							action: 'save_tilawah',
							oper:cellData
						}

						var obj = {
							_token: $('#_token').val(),
							giliran: $('#giliran').val(),
							user_id: $('#user_id').val(),
							ms1: $('#ms1').val(),
							ms2: $('#ms2').val(),
						}

						$.post( "./setup/form?"+$.param(param),obj, function( data ){
							
						},'json').fail(function(data) {
							alert('error');
					  		load_table();
					  	}).done(function(data){
					  		load_table();
					  	});
					});

					$('#dt_tilawah').off('click','button#cancel');
					$('#dt_tilawah').on('click','button#cancel', function(){
						load_table();
					});

				}
   			}
   		}
    ],
	drawCallback: function( settings ) {
    	// $(this).find('tbody tr')[0].click();
    }
});
 $('#dt_tilawah').data('addeditmode','false');


$('#dt_tilawah tbody').on('click', 'tr', function () {
    let addeditmmode = $('#dt_tilawah').data('addeditmode');
    if($(this).hasClass('blue') && addeditmmode == 'false'){
		var data = dt_tilawah.row( this ).data();
    	var rows = dt_tilawah.row( this ).selector.rows;
    	$(rows).children('td').each(function(i,td){
    		if($(td).hasClass('idno')){

    		}else if($(td).hasClass('giliran')){
				$(td).html('');
				$(td).append(`<div class="ui input"><input type="number" name="giliran" id="giliran" value="`+data.giliran+`"></div>`);
    		}else if($(td).hasClass('user_id')){
				$(td).html('');
				$(td).append(init_user_select(data.user_id));
    		}else if($(td).hasClass('ms1')){
				$(td).html('');
				$(td).append(`<div class="ui input"><input type="number" name="ms1" id="ms1" value="`+data.ms1+`"></div>`);
    		}else if($(td).hasClass('ms2')){
				$(td).html('');
				$(td).append(`<div class="ui input"><input type="number" name="ms2" id="ms2" value="`+data.ms2+`"></div>`);
    		}else if($(td).hasClass('lastupdate')){
    			$('#dt_tilawah').data('addeditmode','true');
				$(td).html('');
				$(td).append(`<button class="ui tiny primary button" id="save" type="button" >Save</button>
							  <button class="ui tiny red button" id="cancel" type="button" >Cancel</button>
								`);

				$('#dt_tilawah').off('click','button#save');
				$('#dt_tilawah').on('click','button#save', function(){

					var param = {
						action: 'save_tilawah',
						oper:'edit'
					}

					var obj = {
						_token: $('#_token').val(),
						idno:data.idno,
						giliran: $('#giliran').val(),
						user_id: $('#user_id').val(),
						ms1: $('#ms1').val(),
						ms2: $('#ms2').val(),
					}

					$.post( "./setup/form?"+$.param(param),obj, function( data ){
						
					},'json').fail(function(data) {
						alert('error');
				  		load_table();
				  	}).done(function(data){
				  		load_table();
				  	});
				});

				$('#dt_tilawah').off('click','button#cancel');
				$('#dt_tilawah').on('click','button#cancel', function(){
					load_table();
				});
    		}
    	});
	}else{
    	$('#dt_tilawah tbody tr').removeClass('blue');
    	$(this).addClass('blue');
	}
});

$(document).ready(function() {
	$('#dt_tilawah_filter').append(`
		<button class="ui basic button" type="button" id="btn_add_pelajar">
		  <i class="icon user"></i>
		  Tambah Pelajar
		</button>
	`);


	$('#btn_add_pelajar').click(function(){
    	let addeditmmode = $('#dt_tilawah').data('addeditmode');
		if(addeditmmode == 'false'){
			$('#dt_tilawah').data('addeditmode','true');
		    dt_tilawah.row.add({
		        idno : 99999999999,
				giliran : 'add',
				user_id : 'add',
				ms1 : 'add',
				ms2 : 'add',
				lastupdate : 'add'
		    }).draw(true);
		}
	});

	$('#set').click(function(){
		var param = {
			action: 'save_tilawah_effdate'
		}

		var obj = {
			_token: $('#_token').val(),
			effectivedate: $('#effectivedate').val()
		}

		$.post( "./setup/form?"+$.param(param),obj, function( data ){
			
		},'json').fail(function(data) {
			alert('error');
	  	}).done(function(data){
	  	});
	});
});

function init_user_select(user_id=null){
	var ret_select = '<div class="ui input"><select class="ui dropdown" name="user_id" id="user_id">';
	users.forEach(function(e,i){
		if(user_id !=null && user_id == e.id){
			ret_select+='<option value="'+e.id+'" selected>'+e.username+'</option>';
		}else{
			ret_select+='<option value="'+e.id+'">'+e.username+'</option>';
		}
	});
	ret_select+='</select><div>';

	return ret_select;
}

function init_user_name(user_id=null){
	let username = '-'
	users.forEach(function(e,i){
		if(user_id == e.id){
			username=e.username;
		}
	});

	return username;
}

function load_table(){
	$('#dt_tilawah').data('addeditmode','false');
	dt_tilawah.ajax.async = false;
	dt_tilawah.ajax.reload();
} 