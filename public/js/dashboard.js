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
});
