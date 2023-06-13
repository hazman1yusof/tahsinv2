var currrow=null;

var dt_jadual = $('#dt_jadual').DataTable({
	ajax: "",
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'idno'},
        {'data': 'kelas_id'},
        {'data': 'title'},
        {'data': 'type'},
        {'data': 'hari'},
        {'data': 'date'},
        {'data': 'time'}
    ],
    columnDefs: [
    	
	],
	drawCallback: function( settings ) {

    }
});

$(document).ready(function () {

	$('select[name=kelas]').change(function(){
		dt_jadual.ajax.url( "./setup/table?action=getjadual&kelas_id="+$(this).val() ).load();
	});

	$('#dt_jadual tbody').on('click','tr',function(){
		currrow = dt_jadual.row( this ).data();
		if($(this).hasClass('blue')){
			openmodal('edit');
		}else{
			DataTable.$('tr.blue').removeClass('blue');
			$(this).addClass('blue');
		}
	});

	$('#dt_jadual_filter').append(`
		<button class="ui basic button" type="button" id="btn_add_jadual">
		  <i class="icon calendar plus"></i>
		  Tambah Jadual
		</button>
	`);

	$('#btn_add_jadual').click(function(){
		if($('select[name=kelas]').val() == ''){
			alert('Pilih Kelas Dahulu');
		}else{
			openmodal('add');
		}
	});

	// $('#delete').click(function(){
	// 	if (confirm("Do you want to delete this Kelas")) {
	// 	    save_user('del');
	// 	}
	// });

});

function openmodal(oper){
	before_addjad(oper);

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

function before_addjad(oper){
	$('#form_jadual input[name=kelas_id]').val($('select[name=kelas]').val());
	$('#divjad_weekly,#divjad_datespec').hide();

	$('select[name=type]').off();
	$('select[name=type]').on('change',function(){
		$('#divjad_weekly,#divjad_datespec').hide();
		$('#form_jadual select[name=hari], #form_jadual input[name=date], #form_jadual input[name=time]').prop('required',false);
		$('#form_jadual input[name=time]').prop('disabled',false);
		if($(this).val() == 'weekly'){
			$('#divjad_weekly').show();
			$('#form_jadual select[name=hari]').prop('required',true);
			$('#form_jadual #time_d').prop('disabled',true);
			$('#form_jadual #time_w').prop('required',true);
		}else if($(this).val() == 'date'){
			$('#divjad_datespec').show();
			$('#form_jadual input[name=date]').prop('required',true);
			$('#form_jadual #time_w').prop('disabled',true);
			$('#form_jadual #time_d').prop('required',true);
		}
	});

	if(oper=='edit'){
		$('input[name=idno]').val(currrow.idno);
		$('input[name=title]').val(currrow.title);
		$('select[name=type]').val(currrow.type).change();
		$('select[name=hari]').val(currrow.hari);
		$('input[name=date]').val(currrow.date);
		$('input[name=time]').val(currrow.time);
	}
}

function save_jadual(oper){
	var param = {
		action: 'save_jadual',
		oper:oper
	}

	var form_jadual = $("form#form_jadual").serializeArray();

	$.post( "./setup/form?"+$.param(param),$.param(form_jadual), function( data ){
		
	},'json').fail(function(data) {
		after_save();
  	}).done(function(data){
  		after_save();
  	});
}

function after_save(){
	dt_jadual.ajax.reload();
}