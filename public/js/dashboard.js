if(my_marked==1){
	$('.div_past_marked').hide();
}else{
	$('.div_past_marked').show();
}

if(my_marked == 1){
	$('#div_marked').show();
}

$(document).ready(function () {
	$('#btnhid_userdtl').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_userdtl').slideDown();
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_userdtl').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_prtkls').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_prtkls').slideDown();
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_prtkls').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_klsb4').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_klsb4').slideDown();
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_klsb4').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_klsafter').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_klsafter').slideDown();
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_klsafter').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_naqib').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_naqib').slideDown();
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_naqib').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});

	
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
		$('input[name=status]').val('Tidak Hadir');
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
	});

	init();
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