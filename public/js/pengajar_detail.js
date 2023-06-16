var currrow=null;

var dt_kelas_detail = $('#dt_kelas_detail').DataTable({
	ajax: {
	    url: "./pengajar/table",
	   	data: {
	        action: 'getkelasdetail',
	        kelas_id: kelas_detail.kelas_id,
	        jadual_id: kelas_detail.jadual_id,
	        type: kelas_detail.type,
	        date: kelas_detail.date,
	        time: kelas_detail.time
		},
	},
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'name'},
        {'data': 'surah'},
        {'data': 'ms'},
        {'data': 'status'}
    ],
    columnDefs: [
    	
	],
	drawCallback: function( settings ) {
    	// $(this).find('tbody tr')[0].click();
    }
});

$(document).ready(function() {
	$('#dt_kelas_detail tbody').on('click','tr',function(){
		currrow = dt_kelas_detail.row( this ).data();
		if($(this).hasClass('blue')){
			openmodal('edit');
		}else{
			DataTable.$('tr.blue').removeClass('blue');
			$(this).addClass('blue');
		}

	});
});

function openmodal(oper){
	before_add(oper);

	$('.ui.modal#mdl_kelas_detail').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_kelas_detail").valid()) {
				save_kelas_detail(oper);
				return true;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			emptyFormdata_div('form#form_kelas_detail');
		}
	 }).modal('show');
}

function before_add(oper){
	$('span#span_name').text(currrow.name);
	$('form#form_kelas_detail input[name=idno]').val(currrow.idno);
	$('form#form_kelas_detail input[name=surah]').val(currrow.idno);
	$('form#form_kelas_detail input[name=ms]').val(currrow.idno);

	$('.rating').rating('enable');
}

function save_kelas_detail(oper){
	var param = {
		action: 'save_kelas_detail',
		oper:oper
	}

	var form_kelas_detail = $("form#form_kelas_detail").serializeArray();

	$.post( "./setup/form?"+$.param(param),$.param(form_kelas_detail), function( data ){
		
	},'json').fail(function(data) {
		after_save();
  	}).done(function(data){
  		after_save();
  	});
}

function after_save(){
	dt_kelas_detail.ajax.reload();
}