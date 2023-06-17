var currrow=null;

$(document).ready(function() {
	$('#rating').rating('enable');

	var timer = 60 * 7,
        display = $('#timer');
    startTimer(timer, display);

	$('#confirm').click(function(){
		mark();
	});
});

function mark(){
	var param = {
		action: 'mark_kd',
		rating: $('#rating').rating('get rating')
	}

	var form_kelas_detail = $("form#form_kelas_detail").serializeArray();

	$.post( "./pengajar/form?"+$.param(param),$.param(form_kelas_detail), function( data ){
		
	},'json').fail(function(data) {
		window.location.replace(document.referrer);
  	}).done(function(data){
		window.location.replace(document.referrer);
  	});
}

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = Math.abs(parseInt(timer / 60, 10));
        seconds = Math.abs(parseInt(timer % 60, 10));

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text( minutes + ":" + seconds);

        if (--timer < 0) {
        	$('div#timer_div').removeClass('pos_time').addClass('neg_time');
        	$('#neg_timer').text('- ')
        }
    }, 1000);
}