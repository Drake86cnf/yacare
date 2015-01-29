var nombreAplicacion, nombreCliente;

tapirNombreAplicacion = 'Aplicación sin título';
tapirNombreCliente = 'Cliente';

function tapirIniciar(nombreAplicacion, nombreCliente) {
	tapirNombreAplicacion = nombreAplicacion;
	tapirNombreCliente = nombreCliente;
}

function tapirImprimir() {
	window.print();
}

function tapirAgregarElementoUri(url, nombre, valor) {
    if(url.indexOf('?') >= 0) {
        url = url + '&' + encodeURIComponent(nombre) + '=' + encodeURIComponent(valor);
    } else {
    	url = url + '?' + encodeURIComponent(nombre) + '=' + encodeURIComponent(valor);
    }
    return url;
}

function tapirEnfocarControl(elemId) {
    var elem = $(elemId);

    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', elem.value.length);
            range.select();
        } else {
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(elem.value.length, elem.value.length);
            } else {
                elem.focus();
            }
        }
    }
}


/**
 * Función ayudante de los campos de formulario Symfony tipo "entity_id"
 */
function tapirEntityIdSeleccionarItem(destino, id, detalle) {
	$(destino).val(id);
	$(destino + '_Detalle').val(detalle);
}

/**
 * Mostrar una URL en una ventana modal
 */
function tapirMostrarModalEn(url, destino) {
	if (destino === undefined) {
		destino = '#modal';
	}

	var div_modal = $(destino);

	if (url) {
		// Modal AJAX
		/*
		 * div_modal.html('<div class="modal-dialog"><div
		 * class="modal-content"><div class="modal-body" style="min-height:
		 * 64px;">\n\ <p class="text text-center"><br /><i class="fa
		 * fa-spinner fa-lg fa-spin"></i> Cargando...</p>\n\ </div></div></div>').modal();
		 */
	
		// Agrego la variable tapir_modal=1 para que incluya el marco
		var urlFinal = url;
		if (urlFinal.indexOf('?') < 0) {
			urlFinal = urlFinal + '?';
		} else {
			urlFinal = urlFinal + '&';
		}
		urlFinal = urlFinal + 'tapir_modal=1';
	
		$.get(urlFinal, function(data) {
			div_modal.html(data).modal({
				keyboard : true,
				backdrop : true
			});
		}).fail(function(jqXHR) {
			// Muestro un error
			div_modal.html('<div class="modal-dialog"><div class="modal-content">\n\
	<div class="modal-header">\n\
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n\
	<h4 class="modal-title">Error</h4>\n\
	</div>\n\
	<div class="modal-body">Error al cargar el contenido de la ventana desde '
				+ url
				+ ', el error es: '
				+ jqXHR.responseText
				+ '</div></div></div>').modal({
					keyboard : true,
					backdrop: true
				});
		});
	} else {
		// Sólo mostrar el modal
		div_modal.modal({
			keyboard : true
		});
	}

	return false;
}

/**
 * Vuelve hacia atrás (como el botón atrás del navegador).
 */
function tapirAtras() {
	window.history.back();
	return false;
}

/**
 * Seguir un enlace, pero via AJAX. Si no se pasa un elemento destino, se toma
 * "page-wrapper" que es el contenedor principal. La diferencia con
 * tapirCargarUrlEn() es que tapirNavegarA() indica navegación, incluyendo
 * cambio de URL en la barra de navegación, mientras que tapirCargarUrlEn() es
 * sólo un refresco o actualización de una porción.
 */
function tapirNavegarA(url, destino) {
	// parent.location = url; // sin AJAX
	tapirCambiarDireccion(url);
	tapirCargarUrlEn(url, destino); // con AJAX
}


/**
 * Cambiar la URL en la barra de dirección (y en el historial) del navegador.
 */
function tapirCambiarDireccion(url) {
	if (url !== window.location) {
		urlfinal = url.replace('&sinencab=1', '');
		window.history.pushState({
			path : urlfinal
		}, '', urlfinal);
	}
}

/**
 * Cargar una URL en un elemento via AJAX. Si no se pasa un elemento destino, se
 * toma "page-wrapper" que es el contenedor principal.
 * 
 * @see tapirNavegarA()
 */
function tapirCargarUrlEn(url, destino) {
	AjaxSpinnerTimeout = setTimeout(function() {
		$('#ajax-spinner').show();
	}, 700);

	if (destino === undefined || destino === '') {
		destino = '#page-wrapper';
	}

	$(".tinymce").each(function() {
		tinymce.execCommand('mceRemoveEditor', false, this.id);
	});

	// $(destino).html('<p><i class="fa fa-spinner fa-spin"></i>
	// Cargando...</p>');
	$.get(
			url,
			function(data) {
				$(destino).html(data);

				var newTitle = $('#page-title').text();
				if (newTitle !== undefined) {
					document.title = tapirNombreAplicacion + ': ' + newTitle;
				} else {
					newTitle = tapirNombreAplicacion;
					document.title = newTitle;
				}

				if (destino == '#page-wrapper') {
					// Si estoy cargando una página completa, muevo el scroll
					// hacia arriba
					$('html, body').animate({
						scrollTop : 0
					}, 'fast');
				}

				MejorarElementos();

				clearTimeout(AjaxSpinnerTimeout);
				$('#ajax-spinner').hide();

				// Activo la función de los enalces AJAX
				$(destino + ' [data-toggle="ajax-link"]').click(
						function(e) {
							e.preventDefault();
							return tapirNavegarA($(this).attr('href'), $(
									this).attr('data-target'));
						});

				// Activo la función de los enlaces que abren modales
				$(destino + ' [data-toggle="modal"]').click(
						function(e) {
							e.preventDefault();
							return tapirMostrarModalEn($(this).attr('href'), $(
									this).attr('data-target'));
						});
			}).fail(function(jqXHR) {
		// Muestro un error
		clearTimeout(AjaxSpinnerTimeout);
		$(destino).html(jqXHR.responseText);
		$('#ajax-spinner').hide();
	});

	return false;
}

/*
 * Incorporo funciones mejoradas como calendario, chosen, etc.
 */
function MejorarElementos() {
	// datepicker
	/*
	 * if (Modernizr && !Modernizr.inputtypes.date) {
	 * $.datepicker.setDefaults($.datepicker.regional['es']);
	 * $('.datepicker').datepicker({ showButtonPanel: true, dateFormat:
	 * 'dd/mm/yy', showAnim: '', changeMonth: true, changeYear: true }); }
	 */
	$('.with-datepicker').datepicker({
		todayBtn : "linked",
		todayHighlight : true,
		language: 'es',
		autoclose : true
	});

	// notifications
	$('.noty').click(function(e) {
		e.preventDefault();
		var options = $.parseJSON($(this).attr('data-noty-options'));
		noty(options);
	});

	$('.tinymce').each(function() {
		tinymce.execCommand('mceAddEditor', true, this.id);
	});
}

$(document).ready(function() {
	MejorarElementos();

	// Activo la función de los enlaces que abren modales
	$('[data-toggle="modal"]').off('click');
	$('[data-toggle="modal"]').click(
			function(e) {
				e.preventDefault();
				return tapirMostrarModalEn($(this).attr('href'),
						$(this).attr('data-target'));
			});

	// Pongo a las notificaciones un temporizador para que desaparezcan
	// automáticamente
	window.setTimeout(function() {
		$('.alert-dismissable').fadeTo(500, 0).slideUp(500, function() {
			$(this).remove();
		});
	}, 15000);

	// Evitar que algunos dropdown se cierren automáticamente
	// (especial para el menú lateral, se utiliza la clase keep-open)
	$('.dropdown.keep-open').on({
		'shown.bs.dropdown' : function() {
			$(this).data('closable', false);
		},
		'click' : function() {
			$(this).data('closable', true);
		},
		'hide.bs.dropdown' : function() {
			return $(this).data('closable');
		}
	});
});
