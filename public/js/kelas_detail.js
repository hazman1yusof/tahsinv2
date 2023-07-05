if(all_data.ispast || my_marked==1){
	$('.div_past_marked').hide();
}else{
	$('.div_past_marked').show();
}

if(my_marked == 1){
	$('#div_marked').show();
}

$("#form#form_nonpast").validate({
    showErrors: function(errorMap, errorList) {
        // Do nothing here
    },
});

$(document).ready(function() {

	init();

	$('div#confirm').click(function(){

		$.validator.messages.required = '';
		if($("form#form_nonpast").valid()){
			$('input[name=status]').val('Hadir');
			var formdata = $("form#form_nonpast").serializeArray();

			$.post( "./kelas/form",$.param(formdata), function( data ){
			},'json').fail(function(data) {
				location.reload()
	        }).done(function(data){
	        	if(data.operation == 'SUCCESS'){
					location.reload()
	        	}else{
	        		$('#div_error').show();
	        		$('#span_error').text(data.msg);
	        	}
	        });
		}
		
	});

	$('div#tak_confirm').click(function(){
		openmodal_alasan();
	});
});

function init(){
	for (let i = 1; i <= count_kelas; i++) {
		if(!user_kd.includes(i)){
	  		$('select#pos').append(`<option value='`+i+`'>`+i+`</option>`);
		}
	}
	if(my_pos != null){
		$('select#pos').val(my_pos);
	}

	$('#rating').rating('disable');
}

function openmodal_alasan(){

	$("#alasan").off('keydown');
	$("#alasan").on('keydown',function(e) {
        if(e.key === 'Enter') {
        	e.preventDefault();
            $("div#alasan_ok").click();
        }
    });

	$('.ui.modal#alasan_modal').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_alasan").valid()) {
				$('input[name=status]').val('Tidak Hadir');
				var formdata = $("form#form_nonpast").serializeArray();
				var obj={alasan:$('#alasan').val()}

				$.post( "./kelas/form",$.param(formdata)+'&'+$.param(obj), function( data ){
				},'json').fail(function(data) {
					location.reload()
		        }).done(function(data){
		        	if(data.operation == 'SUCCESS'){
						location.reload()
		        	}else{
		        		$('#div_error').show();
		        		$('#span_error').text(data.msg);
		        	}
		        });
				return false;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			emptyFormdata_div('form#form_alasan');
		}
	}).modal('show');
}