$(document).ready(function() {
    // Capturo los botones "atrás" y "adelante" del navegador y para funcionar via AJAX
    window.onpopstate = function() {
        tapirCargarUrlEn(document.location);
    };

    // Agrego la página actual al historial del navegador
    //window.history.pushState({ path: (window.location + '') }, '', window.location);

    // Evito que los enlaces href="#" muevan la página hacia el tope
    $('a[href="#"][data-top!=true]').click(function(e) {
            e.preventDefault();
    });

    // Activo la función de los enalces AJAX
    $('[data-toggle="ajax-link"]').click(function(e) {
        e.preventDefault();
        return tapirNavegarA($(this).attr('href'), $(this).attr('data-target'));
    });
    
    $('#ajax-spinner').hide();
});