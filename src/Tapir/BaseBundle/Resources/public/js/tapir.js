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
	div_modal
			.html(
					'<div class="modal-dialog"><div class="modal-content"><div class="modal-body" style="min-height: 64px;">\n\
<p class="text text-center"><br /><i class="fa fa-spinner fa-lg fa-spin"></i> Cargando...</p>\n\
</div></div></div>')
			.modal();

	// Agrego la variable tapir_mostrarmodal=1 para que incluya el marco
	var urlFinal = url;
	if (urlFinal.indexOf('?') < 0) {
		urlFinal = urlFinal + '?';
	} else {
		urlFinal = urlFinal + '&';
	}
	urlFinal = urlFinal + 'tapir_mostrarmodal=1';

	$
			.get(urlFinal, function(data) {
				div_modal.html(data).modal({
					keyboard : true
				});
			})
			.fail(
					function(jqXHR) {
						// Muestro un error
						div_modal
								.html(
										'<div class="modal-dialog"><div class="modal-content">\n\
<div class="modal-header">\n\
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n\
<h4 class="modal-title">Error</h4>\n\
</div>\n\
<div class="modal-body">Error al cargar el contenido de la ventana desde '
												+ url
												+ ', el error es: '
												+ jqXHR.responseText
												+ '</div></div></div>').modal({
									keyboard : true
								});
					});

	return false;
}

/**
 * Seguir un enlace, pero via AJAX.
 */
function tapirNavegarA(url) {
	// parent.location = url; // sin AJAX
	tapirCargarUrlEn(url); // con AJAX
}

/**
 * Cargar una URL en un elemento via AJAX. Si no se pasa un elemento destino, se
 * toma "page-wrapper" que es el contenedor principal.
 */
function tapirCargarUrlEn(url, destino) {
	if (destino === undefined) {
		destino = '#page-wrapper';

		// Agrego la nueva URL al historial del navegador
		if (url !== window.location) {
			window.history.pushState({
				path : url
			}, '', url);
		}
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

				$('html, body').animate({
					scrollTop : 0
				}, 'fast');

				MejorarElementos();

				// Activo la función de los enalces AJAX
				$(destino + ' [data-toggle="ajax-link"]').click(
						function(e) {
							e.preventDefault();
							return tapirCargarUrlEn($(this).attr('href'), $(
									this).attr('data-target'));
						});

				// Activo la función de los enlaces que abren modales
				$(destino + ' [data-toggle="modal"]').click(
						function(e) {
							e.preventDefault();
							return tapirMostrarModalEn($(this).attr('href'),
									$(this).attr('data-target'));
						});
			}).fail(function(jqXHR) {
		// Muestro un error
		$(destino).html(jqXHR.responseText);
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

	// notifications
	$('.noty').click(function(e) {
		e.preventDefault();
		var options = $.parseJSON($(this).attr('data-noty-options'));
		noty(options);
	});

	$('.tinymce').each(function() {
		tinymce.execCommand('mceAddEditor', true, this.id);
	});
	// $('.tinymce').tinymce();
}

$(document).ready(
		function() {
			MejorarElementos();

			// chosen - improves select
			/*
			 * $('[data-rel="chosen"],[rel="chosen"]').chosen({ no_results_text:
			 * "No se encontraron resultados.", placeholder_text_single:
			 * "Seleccione...", placeholder_text_multiple: "Seleccione...",
			 * search_contains: true });
			 */

			// Activo la función de los enlaces que abren modales
			$('[data-toggle="modal"]').off('click');
			$('[data-toggle="modal"]').click(
					function(e) {
						e.preventDefault();
						return tapirMostrarModalEn($(this).attr('href'), $(
								this).attr('data-target'));
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
				"shown.bs.dropdown" : function() {
					$(this).data('closable', false);
				},
				"click" : function() {
					$(this).data('closable', true);
				},
				"hide.bs.dropdown" : function() {
					return $(this).data('closable');
				}
			});
		});
