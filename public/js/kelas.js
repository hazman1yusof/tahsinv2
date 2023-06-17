document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
  					initialView: 'dayGridMonth',
  					eventSources: [
  						'./kelas/table?action=fcgetkelas',
  						'./kelas/table?action=fcgetkelas_weekly',
  					],
  					dateClick: function(info) {
  						$('div#calendar td').removeClass('activetd');
  						$(info.dayEl).addClass('activetd');
					},
					eventClick: function(info) {
						$('div#calendar .fc-event').removeClass('activeev');
						$(info.el).addClass('activeev');

						info.jsEvent.preventDefault();
						window.location.href = info.event.url+'&date='+moment(info.event.start).format('YYYY-MM-DD');
				  	},
				  	eventDidMount: function(info) {
		                // Add additional functionality or styles to the event element here
		                // info.el.querySelector('.fc-title').textContent = info.event.title;
		                let oth = info.event._def.extendedProps
		                if(oth.status == 'Hadir'){
		                	$(info.el).css('background','green');
		                }else if(oth.status == 'Tidak Hadir'){
		                	$(info.el).css('background','red');
		                }
		            },
	});
	calendar.render();

	if(getBrowserWidth() == 'xs'){
		calendar.setOption('aspectRatio', 0.65);
	}
});