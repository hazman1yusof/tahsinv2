document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
  					initialView: 'dayGridMonth',
  					eventSources: [
  						'./kelas/table?action=fcgetkelas',
  					],
  					dateClick: function(info) {
  						$('div#calendar td').removeClass('activetd');
  						$(info.dayEl).addClass('activetd');
					},
					eventClick: function(info) {
						$('div#calendar .fc-event').removeClass('activeev');
						$(info.el).addClass('activeev');

						info.jsEvent.preventDefault();
						console.log(info);
						window.location.href = info.event.url+'&date='+moment(info.event.start).format('YYYY-MM-DD');
				  	}
	});
	calendar.render();
	add_weekly();
	

	if(getBrowserWidth() == 'xs'){
		calendar.setOption('aspectRatio', 0.65);
	}


	function add_weekly(){
		calendar.addEventSource({
					events: [{
							  title: weekly.title,
							  startTime: weekly.time,
						      daysOfWeek: get_daynum(),
						      url:weekly.url
						}]  
					});
	}
});

function get_daynum(){
	switch(weekly.hari) {
	  case 'isnin':
	  		return ['1'];
	    break;
	  case 'selasa':
	  		return ['2'];
	    break;
	  case 'rabu':
	  		return ['3'];
	    break;
	  case 'khamis':
	  		return ['4'];
	    break;
	  case 'jumaat':
	  		return ['5'];
	    break;
	  case 'sabtu':
	  		return ['6'];
	    break;
	  case 'ahad':
	  		return ['7'];
	    break;
	}
}
