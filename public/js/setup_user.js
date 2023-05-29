var currrow=null;
$(document).ready(function () {
	$("form#form_user").validate({
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

	var dt_user = $('#dt_user').DataTable({
		ajax: "./setup_user/table?action=getuser",
	 	dom: '<f<"datablediv"t>p>',
    	columns: [
	        {'data': 'idno'},
	        {'data': 'username'},
	        {'data': 'name'},
	        {'data': 'type'}
	    ],
	    columnDefs: [
		],
		drawCallback: function( settings ) {
	    	// $(this).find('tbody tr')[0].click();
	    }
	});

	$('#dt_user tbody').on('click','tr',function(){
		currrow = dt_user.row( this ).data();
		if($(this).hasClass('blue')){
			openmodal('edit');
		}else{
			DataTable.$('tr.blue').removeClass('blue');
			$(this).addClass('blue');
		}

	});

	$('#dt_user_filter').append(`
		<button class="ui basic button" type="button" id="btn_add_user">
		  <i class="icon user"></i>
		  Tambah Pelajar
		</button>
	`);

	$('#btn_add_user').click(function(){
		openmodal('add');
	});
});

function openmodal(oper){
	
	if(oper == 'edit'){
		pop_user();
	}

	$('.ui.modal#mdl_user').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_user").valid()) {
  				save_user(oper);
				return true;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			$('select[name=type]').val('AF');
			emptyFormdata_div('form#form_user');
		}
	 }).modal('show');
}

function save_user(oper){
	var param = {
		action: 'save_user',
		oper:oper
	}

	var form_user = $("form#form_user").serializeArray();

	$.post( "./setup_user/form?"+$.param(param),$.param(form_user), function( data ){
		
	},'json').fail(function(data) {

  }).done(function(data){
		init_jadual_setting();
  });
}

function pop_user(){
	$('#username').val(currrow.username);
	$('select[name=kelas]').val(currrow.kelas);
	$('select[name=type]').val(currrow.type);
	if(currrow.ajar ==  1)$('input[type=checkbox][name=ajar]').prop('checked',true);
	if(currrow.ajar ==  1)$('input[type=checkbox][name=setup]').prop('checked',true);
}
