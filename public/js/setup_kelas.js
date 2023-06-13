var currrow=null;

var dt_kelas = $('#dt_kelas').DataTable({
	ajax: "./setup/table?action=getkelas",
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'idno'},
        {'data': 'name'},
        {'data': 'ketua_desc'},
        {'data': 'pengajar_desc'},
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
	`);

	$('#btn_add_kelas').click(function(){
		openmodal('add');
	});

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

	$.post( "./setup/form?"+$.param(param),$.param(form_kelas), function( data ){
		
	},'json').fail(function(data) {

  	}).done(function(data){
  		after_save();
  	});
}

function pop_kelas(){
	$('#idno').val(currrow.idno);
	$('#name').val(currrow.name);
	$('select[name=ketua]').val(currrow.ketua);
	$('select[name=pengajar]').val(currrow.pengajar);
	if(currrow.tambahan ==  1)$('input[type=checkbox][name=tambahan]').prop('checked',true);
	if(currrow.terbuka ==  1)$('input[type=checkbox][name=terbuka]').prop('checked',true);
}

function after_save(){
	dt_kelas.ajax.reload();
}