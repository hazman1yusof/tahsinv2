var currrow=null;
console.log(kelas_detail);
var dt_kelas_detail = $('#dt_kelas_detail').DataTable({
	ajax: {
	    url: "./pengajar/table",
	   	data: {
	        action: 'getkelasdetail',
	        kelas_id: kelas_detail.kelas_id,
	        jadual_id: kelas_detail.jadual_id,
	        type: kelas_detail.type,
	        date: kelas_detail.date,
	        time: kelas_detail.time
		},
	},
 	dom: '<f<"datablediv"t>p>',
	columns: [
        {'data': 'name'},
        {'data': 'surah'},
        {'data': 'ms'}
    ],
    columnDefs: [
    	
	],
	drawCallback: function( settings ) {
    	// $(this).find('tbody tr')[0].click();
    }
});

$(document).ready(function() {
	$('#dt_kelas_detail tbody').on('click','tr',function(){
		currrow = dt_kelas_detail.row( this ).data();
		if($(this).hasClass('blue')){
			openmodal('edit');
		}else{
			DataTable.$('tr.blue').removeClass('blue');
			$(this).addClass('blue');
		}

	});
});


function openmodal(oper){
	// before_addjad(oper);

	$('.ui.modal#mdl_add_jadual').modal({
		autofocus: false,
		closable:false,
		onApprove:function($element){
			if($("form#form_jadual").valid()) {
				save_jadual(oper);
				return true;
			}else{
				return false;
			}
		},
		onHidden:function($element){
			emptyFormdata_div('form#form_jadual');
		}
	 }).modal('show');
}