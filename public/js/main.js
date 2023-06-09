$(document).ready(function() {
    change_topuserlength();
    // $('.ui.sidebar').sidebar({
    //         onHide: function() {
    //           console.log('on hidden');
    //         }
    //     })
    $('#showSidebar').click(function(){
        $('.ui.sidebar').sidebar('toggle');
    });

    $('.ui.sidebar').onHide

    $('.ui.dropdown').dropdown({'clearable':true});
    $('.ui.checkbox').checkbox();

    $('.ui.left.fixed.vertical.icon.menu a').popup({position:'right center'});

    /* Back to top fade */
	$(window).scroll(function (event) {
		var scroll = $(window).scrollTop();
	    $('#toTop').hide();
	    if (scroll > 200) {
	    	$('#toTop').show();
	    } else {
	    	$('#toTop').hide();
	    }

	    if (scroll == 0) {
	    	$('.fixed.top.menu').removeClass('slide up');
	    }
	});

	/* Scroll Event*/
    $('a[data-slide="slide"]').on('click', function(e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 90
        }, 900, 'swing');
    });

    if($('#navbar_hide').val() == 'navbar'){
        $('a#showSidebar').hide();
    }
});

function change_topuserlength(){
    let username = $('span#topuser').text();

    var resultname = username.slice(0, 12)+' ...';
    $('span#topuser').text(resultname);
}

var getBrowserWidth = function(){
    if(window.innerWidth < 768){
        // Extra Small Device
        return "xs";
    } else if(window.innerWidth < 991){
        // Small Device
        return "sm"
    } else if(window.innerWidth < 1199){
        // Medium Device
        return "md"
    } else {
        // Large Device
        return "lg"
    }
};