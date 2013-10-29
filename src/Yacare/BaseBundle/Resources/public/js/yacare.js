$(document).ready(function(){
	//establish history variables
	var
		History = window.History, // Note: We are using a capital H instead of a lower h
		State = History.getState(),
		$log = $('#log');

	//bind to State Change
	History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
		var State = History.getState(); // Note: We are using History.getState() instead of event.state
		$.ajax({
			url:State.url,
			success:function(msg){
				$('#content').html($(msg).find('#content').html());
				$('#loading').remove();
				$('#content').fadeIn();
				docReady();
			}
		});
	});
	
	//prevent # links from moving to top
	$('a[href="#"][data-top!=true]').click(function(e){
		e.preventDefault();
	});
	
	//datepicker
        if (!Modernizr.inputtypes.date) {
            $.datepicker.setDefaults($.datepicker.regional['es']);
            $('.datepicker').datepicker({
                showButtonPanel: true,
                dateFormat: 'dd/mm/yy',
                showAnim: '',
                changeMonth: true,
                changeYear: true
                });
        }

	//notifications
	$('.noty').click(function(e){
		e.preventDefault();
		var options = $.parseJSON($(this).attr('data-noty-options'));
		noty(options);
	});

	//chosen - improves select
	/* $('[data-rel="chosen"],[rel="chosen"]').chosen({
            no_results_text: "No se encontraron resultados.",
            placeholder_text_single: "Seleccione...",
            placeholder_text_multiple: "Seleccione...",
            search_contains: true
            }); */
        
        $('[data-rel="ajax-modal"]').click(function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var modal_id = $(this).attr('data-target');
            //var modal = $(modal_id);

            $.get(url, function(data) {
                if(modal_id)
                    $(modal_id).html(data).modal();
                else
                    $('<div class="modal hide fade">' + data + '</div>').modal({
                        keyboard: true
                    });
            }).success(function() {
                /* boom. loaded. */ 
            }).fail(function(a) {
                alert(a.status);
            });
        });
});