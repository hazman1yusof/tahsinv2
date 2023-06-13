if(all_data.ispast){
	if(all_data.oper == 'add'){
		$('#form_add_past').show();
	}else{
		$('#form_edit_past').show();
	}
}else{
	$('#form_addedit_nonpast').show();
	if(all_data.oper == 'add'){
		$('#confirm,#p_confirm').show();
	}else{
		$('#tak_confirm,#p_tak_confirm').show();
	}
}

$(document).ready(function() {
	$('div#confirm').click(function(){

		$('input[name=status]').val('confirm');
		var formdata = $("form#form_addedit_nonpast").serializeArray();

		$.post( "./kelas/form",$.param(formdata), function( data ){
		},'json').fail(function(data) {
            window.location.href = './kelas';
        }).done(function(data){
			window.location.href = './kelas';
        });
	});

	$('div#tak_confirm').click(function(){

		$('input[name=status]').val('cancel');
		var formdata = $("form#form_addedit_nonpast").serializeArray();

		$.post( "./kelas/form",$.param(formdata), function( data ){
		},'json').fail(function(data) {
            window.location.href = './kelas';
        }).done(function(data){
			window.location.href = './kelas';
        });
	});
});