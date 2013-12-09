function yacareEntityIdSeleccionarItem(destino, id, detalle) {
    $(destino).val(id);
    $(destino + '_Detalle').val(detalle);
}

function yacareMostrarModalEn(url, destino) {
    var modal = $(destino);

    modal.html('<div class="modal-dialog"><div class="modal-content"><div class="modal-body">\n\
<p><i class="fa fa-spinner fa-lg fa-spin"></i> Cargando...</p>\n\
</div></div></div>').modal();

    // Agrego la variable yacare_mostrarmodal=1 para que incluya el marco
    var urlFinal = url;
    if(urlFinal.indexOf('?') < 0) {
        urlFinal = urlFinal + '?';
    } else {
        urlFinal = urlFinal + '&';
    }
    urlFinal = urlFinal + 'yacare_mostrarmodal=1';
    
    $.get(urlFinal, function(data) {
        modal.html(data).modal();
    }).fail(function(jqXHR) {
        // Muestro un error
        modal.html('<div class="modal-dialog"><div class="modal-content">\n\
<div class="modal-header">\n\
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n\
<h4 class="modal-title">Error</h4>\n\
</div>\n\
<div class="modal-body">Error al cargar el contenido de la ventana desde ' + url + ', el error es: ' + jqXHR.responseText + '</div></div></div>').modal();
    });

    return false;
}

function yacareNavegarA(url) {
    //parent.location = url;    // sin AJAX
    yacareCargarUrlEn(url);     // con AJAX
}

function yacareCargarUrlEn(url, destino) {
    //$(destino).html('<p><i class="fa fa-spinner fa-spin"></i> Cargando...</p>');
    $.get(url, function(data) {
        if(destino === undefined) {
            destino = '#page-wrapper';
        }        
        $(destino).html(data);
        if(url !== window.location) {
                window.history.pushState({path:url}, '', url);
        }
        
        //$(destino + ' [data-toggle="ajax-link"]').css('border', '1px solid red');
        $(destino + ' [data-toggle="ajax-link"]').click(function(e) {
            e.preventDefault();
            return yacareCargarUrlEn($(this).attr('href'), $(this).attr('data-target'));
        });
    }).fail(function(jqXHR) {
        // Muestro un error
        $(destino).html(jqXHR.responseText);
    });

    return false;
}


$(document).ready(function(){
    /*
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
    }); */

    //prevent # links from moving to top
    $('a[href="#"][data-top!=true]').click(function(e) {
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


    $('[data-toggle="modal"]').off('click');
    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var modal_id = $(this).attr('data-target');

        return yacareMostrarModalEn(url, modal_id);
    });
    
    window.setTimeout(function() { 
        $('.alert-dismissable').fadeTo(500, 0).slideUp(500, function() {
            $(this).remove(); 
        });
    }, 15000);

    $('[data-toggle="ajax-link"]').click(function(e) {
        e.preventDefault();
        return yacareCargarUrlEn($(this).attr('href'), $(this).attr('data-target'));
    });

});

