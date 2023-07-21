if(ispast == 'true' || my_dtl_got == 'false'){
	$('.div_past').hide();
}else{
	$('.div_past').show();
}

$(document).ready(function () {

	$('div#confirm').click(function(){
		$.validator.messages.required = '';
		if($("form#form_nonpast").valid()){
			$('input[name=oper]').val('add');
			var formdata = $("form#form_nonpast").serializeArray();

			$.post( "./tilawah/form",$.param(formdata), function( data ){
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
		$.validator.messages.required = '';
		if($("form#form_nonpast").valid()){
			$('input[name=oper]').val('del');
			var formdata = $("form#form_nonpast").serializeArray();

			$.post( "./tilawah/form",$.param(formdata), function( data ){
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
});