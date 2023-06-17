var currrow=null;

$(document).ready(function() {
	$('div.item.myitem.hadir').click(function(){
		window.location.href = $(this).data('url');
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
	// dt_kelas_detail.ajax.reload();
}