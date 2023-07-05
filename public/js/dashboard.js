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
			$('#sgmnt_userdtl').slideDown('fast',function(){SmoothScrollTo('div#sgmnt_userdtl');});
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_userdtl').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_prtkls').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_prtkls').slideDown('fast',function(){SmoothScrollTo('div#sgmnt_prtkls');});
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_prtkls').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_klsb4').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_klsb4').slideDown('fast',function(){SmoothScrollTo('div#sgmnt_klsb4');init_textare();});
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_klsb4').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_klsafter').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_klsafter').slideDown('fast',function(){SmoothScrollTo('div#sgmnt_klsafter');init_textare();});
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_klsafter').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	$('#btnhid_naqib').click(function(){
		if($(this).hasClass('plus')){
			$('#sgmnt_naqib').slideDown('fast',function(){SmoothScrollTo('div#sgmnt_naqib');});
			$(this).removeClass('plus').addClass('minus');
		}else if($(this).hasClass('minus')){
			$('#sgmnt_naqib').slideUp();
			$(this).removeClass('minus').addClass('plus');
		}
	});
	SmoothScrollTo('div#sgmnt_klsafter');

	
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

	$('#rating_after').rating('disable');
	$('#rating_b4').rating('disable');

	init_textare();
	
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

function init_textare(){
	$('textarea#remark_b4,textarea#remark_after').each(function () {
		if(this.value.trim() == ''){
			this.setAttribute('style', 'height:' + (40) + 'px;min-height:'+ (40) +'px;overflow-y:hidden;');
		}else{
			this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;min-height:'+ (40) +'px;overflow-y:hidden;');
		}
	});
}