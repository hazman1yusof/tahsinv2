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
				location.reload();
	        }).done(function(data){
	        	if(data.operation == 'SUCCESS'){
					location.reload();
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
				location.reload();
	        }).done(function(data){
	        	if(data.operation == 'SUCCESS'){
					location.reload();
	        	}else{
	        		$('#div_error').show();
	        		$('#span_error').text(data.msg);
	        	}
	        });
		}
	});

	$('button.copy').click(function(){
		let kelas_id = $(this).data('kelas_id');
		var sharedata='*Tilawah BerKPI Bil '+bill+'*\n\nTadarus Bacaan Al-Quran\n*Mula :  Isnin '+currdate_mula+'*\n*Hingga : Ahad '+currdate+'*\n\n*'+$('span#'+kelas_id).text()+'* \n';

		tilawah_dtl.forEach(function(e,i){
			if(e.kelas == kelas_id){
				sharedata+='MS '+e.ms1+' - '+e.ms2+' : '+e.name;
				if(e.done == true){
					sharedata+=' ✅';
				}
				sharedata+='\n'
			}
		});

		// sharedata=sharedata+'\nCatatan:\n';
		// user_kd_xhadir.forEach(function(e,i){
		// 	sharedata=sharedata+e+'\n';
		// });

		// let sharedata = 'mycopy';
	
		unsecuredCopyToClipboard(sharedata);
		// if (navigator.share && navigator.canShare(sharedata)) {
		//    navigator.share(sharedata)
		// } else {
		//    navigator.clipboard.writeText(sharedata);
		// }
	});
	$('button.copy').popup({on:'click'});
});

const unsecuredCopyToClipboard = (text) => { const textArea = document.createElement("textarea"); textArea.value=text; document.body.appendChild(textArea); textArea.focus();textArea.select(); try{document.execCommand('copy')}catch(err){console.error('Unable to copy to clipboard',err)}document.body.removeChild(textArea)};