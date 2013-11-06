function yacareEntityIdSeleccionarItem(destino, id, detalle) {
    $(destino).val(id);
    $(destino + '_Detalle').val(detalle);
}

function yacareMostrarModalEn(url, destino) {
    var modal = $(destino);

    modal.html('<div class="modal-dialog"><div class="modal-content"><div class="modal-body">\n\
<p><i class="fa fa-spinner fa-lg fa-spin"></i> Cargando...</p>\n\
</div></div></div>').modal();

    $.get(url, function(data) {
        modal.html(data).modal();
    }).success(function() {
        //boom. loaded.
    }).fail(function(a) {
        // Muestro un error
        modal.html('<div class="modal-dialog"><div class="modal-content">\n\
<div class="modal-header">\n\
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n\
<h4 class="modal-title">Error</h4>\n\
</div>\n\
<div class="modal-body">Error al cargar el contenido de la ventana desde ' + url + ', el error es: ' + a.status + '</div></div></div>').modal();
    });

    return false;
}

function yacareCargarUrlEn(url, destino) {
    $(destino).html('<p><i class="fa fa-spinner fa-spin"></i> Cargando...</p>');
    $.get(url, function(data) {
        $(destino).html(data);
        /* if(url !== window.location) {
                window.history.pushState({path:url}, '', url);
        } */
    }).success(function() {
        //boom. loaded.
    }).fail(function(a) {
        // Muestro un error
        $(destino).html('<div class="alert alert-dismissable alert-danger">\n\
<p>Sucedió un error al cargar la página solicitada. Haga <a class="alert-link" href="#" onclick="yacareCargarUrlEn(\'' + url + '\', \'' + destino + '\'); return false;">clic aquí</a> para intentarlo nuevamente.</p>\n\
<p>El código de error es: ' + a.status + '</p></div>');
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


    $('[data-toggle="modal"]').off('click');
    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var modal_id = $(this).attr('data-target');

        return yacareMostrarModalEn(url, modal_id);
    });

    /* $('[data-toggle="ajax-link"]').click(function(e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var destino = $(this).attr('data-target');

        return yacareCargarUrlEn(url, destino);
    }); */

});