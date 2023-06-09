var currrow=null;

var dt_kelas = $('#dt_kelas').DataTable({
	ajax: "./setup_kelas/table?action=getkelas",
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'idno'},
        {'data': 'name'},
        {'data': 'ketua'},
        {'data': 'pengajar'},
        {'data': 'tambahan','className': "center"},
        {'data': 'terbuka','className': "center"},
        {'data': 'adduser'},
        {'data': 'adddate'}
    ],
    columnDefs: [
    	{targets: [4,5],
        	createdCell: function (td, cellData, rowData, row, col) {
				if (cellData != null) {
        			$(td).html('');
					$(td).append(`<i class="check icon"></i>`);
				}
   			}
   		}
	],
	drawCallback: function( settings ) {
    	$(this).find('tbody tr')[0].click();
    }
});

//./setup_kelas/table?action=getjadual&kelas_id=
var dt_jadual = $('#dt_jadual').DataTable({
	ajax: "",
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'idno'},
        {'data': 'kelas_id'},
        {'data': 'description'},
        {'data': 'type'},
        {'data': 'hari'},
        {'data': 'date'},
        {'data': 'time'}
    ],
    columnDefs: [
    	
	],
	drawCallback: function( settings ) {
    	$(this).find('tbody tr')[0].click();
    }
});

$(document).ready(function () {
	$("form#form_kelas").validate({
		ignore: [], //check jgk hidden
	  	invalidHandler: function(event, validator) {
	  		validator.errorList.forEach(function(e,i){
	  			if($(e.element).is("select")){
	  				$(e.element).parent().addClass('error');
	  			}
	  		});
	  		$(validator.errorList[0].element).focus();
	  		alert('Please fill all mandatory field');
	  	}
	});

	$('#dt_kelas tbody').on('click','tr',function(){
		currrow = dt_kelas.row( this ).data();
		if($(this).hasClass('blue')){
			openmodal('edit');
		}else{
			DataTable.$('tr.blue').removeClass('blue');
			$(this).addClass('blue');
		}
	});

	$('#dt_kelas_filter').append(`
		<button class="ui basic button" type="button" id="btn_add_kelas">
		  <i class="icon user"></i>
		  Tambah Kelas
		</button>

		<button class="ui basic button" type="button" id="btn_openmdl_jadual">
		  <i class="chalkboard teacher icon"></i>
		  Setup Jadual Kelas
		</button>
	`);

	$('#dt_jadual_filter').append(`
		<button class="ui basic button" type="button" id="btn_add_jadual">
		  <i class="icon calendar plus"></i>
		  Tambah Jadual
		</button>
	`);

	$('#btn_add_kelas').click(function(){
		openmodal('add');
	});

	$('#btn_openmdl_jadual').click(function(){
		if(currrow == null){
			alert('Please select kelas');
		}else{
			openmodal_jadual();
		}
	});

	$('#btn_add_jadual').click(function(){
		openmodal_add_jadual('add');
	});

	// $('#delete').click(function(){
	// 	if (confirm("Do you want to delete this Kelas")) {
	// 	    save_user('del');
	// 	}
	// });

});

function openmodal(oper){
	if(oper == 'edit'){
		pop_kelas();
	}

	$('.ui.modal#mdl_kelas').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_kelas").valid()) {
  				save_kelas(oper);
				return true;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			emptyFormdata_div('form#form_kelas');
		}
	 }).modal('show');
}

function save_kelas(oper){
	var param = {
		action: 'save_kelas',
		oper:oper
	}

	var form_kelas = $("form#form_kelas").serializeArray();

	$.post( "./setup_kelas/form?"+$.param(param),$.param(form_kelas), function( data ){
		
	},'json').fail(function(data) {

  	}).done(function(data){
  		after_save();
  	});
}

function pop_kelas(){
	$('#idno').val(currrow.idno);
	$('#name').val(currrow.name);
	$('select[name=ketua]').dropdown('set selected', currrow.ketua);
	$('select[name=pengajar]').dropdown('set selected', currrow.pengajar);
	if(currrow.tambahan ==  1)$('input[type=checkbox][name=tambahan]').prop('checked',true);
	if(currrow.terbuka ==  1)$('input[type=checkbox][name=terbuka]').prop('checked',true);
}

function after_save(){
	dt_kelas.ajax.reload();
}

function openmodal_jadual(){
	dt_jadual.ajax.async = false;
	dt_jadual.ajax.url( "./setup_kelas/table?action=getjadual&kelas_id="+currrow.idno).load();
	$('.ui.modal#mdl_jadual').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			
		},
		onHidden:function($element){

		}
	 }).modal('show');
}

function openmodal_add_jadual(oper){
	before_addjad();

	$('.ui.modal#mdl_add_jadual').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_jadual").valid()) {
				save_jadual(oper);
				return true;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			emptyFormdata_div('form#form_jadual');
		}
	 }).modal('show');
}

function before_addjad(){
	$('#form_jadual input[name=kelas_id]').val(currrow.idno);
	$('#divjad_weekly,#divjad_datespec').hide();

	$('select[name=type]').off();
	$('select[name=type]').on('change',function(){
		$('#divjad_weekly,#divjad_datespec').hide();
		$('#form_jadual select[name=hari], #form_jadual input[name=date], #form_jadual input[name=time]').prop('required',false);
		if($(this).val() == 'weekly'){
			$('#divjad_weekly').show();
			$('#form_jadual select[name=hari]').prop('required',true);
		}else if($(this).val() == 'date'){
			$('#divjad_datespec').show();
			$('#form_jadual input[name=date]').prop('required',true);
			$('#form_jadual input[name=time]').prop('required',true);
		}
	});
}

function save_jadual(oper){
	var param = {
		action: 'save_jadual',
		oper:oper
	}

	var form_jadual = $("form#form_jadual").serializeArray();

	$.post( "./setup_kelas/form?"+$.param(param),$.param(form_jadual), function( data ){
		
	},'json').fail(function(data) {
		openmodal_jadual();
  	}).done(function(data){
  		openmodal_jadual();
  	});
}