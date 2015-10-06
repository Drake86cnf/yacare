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
	if (url.indexOf('?') >= 0) {
		url = url + '&' + encodeURIComponent(nombre) + '='
				+ encodeURIComponent(valor);
	} else {
		url = url + '?' + encodeURIComponent(nombre) + '='
				+ encodeURIComponent(valor);
	}
	return url;
}

function tapirEnfocarControl(elemId) {
	var elem = $(elemId);

	if (elem != null) {
		if (elem.createTextRange) {
			var range = elem.createTextRange();
			range.move('character', elem.value.length);
			range.select();
		} else {
			if (elem.selectionStart) {
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
 * Muestra una URL en una ventana modal
 */
function tapirMostrarModalEn(url, destino) {
	if (destino === undefined || destino === '') {
		destinoFinal = '#modal';
	} else {
		destinoFinal = destino;
	}

	var div_modal = $(destinoFinal);

	if (url) {
		// Agrego la variable tapir_modal=1 para que incluya el marco
		
		var urlFinal = tapirAgregarElementoUri(url, 'tapir_modal', '1');

		$.get(urlFinal, function(data) {
			div_modal.html(data);
			MejorarElementos(destinoFinal);
			div_modal.modal({
				keyboard : true,
				backdrop : true
			});
		})
		.fail(function(jqXHR) {
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
				+ '</div></div></div>')
			.modal({
				keyboard : true,
				backdrop : true
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
 * Sigue un enlace, pero mediante AJAX. Si no se pasa un elemento destino, se toma "page-wrapper" que es el contenedor
 * principal. La diferencia con tapirCargarUrlEn() es que tapirNavegarA() indica navegación, incluyendo cambio de URL
 * en la barra de navegación, mientras que tapirCargarUrlEn() es sólo un refresco o actualización de una porción.
 */
function tapirNavegarA(url, destino) {
	// parent.location = url; // sin AJAX
	tapirCambiarDireccion(url);
	tapirCargarUrlEn(url, destino); // con AJAX
}

/**
 * Cambia la URL en la barra de dirección (y en el historial) del navegador.
 */
function tapirCambiarDireccion(url) {
	if (url !== window.location && url.indexOf('hisapi=0') === -1
			&& url.indexOf('/guardar/') === -1
			) {
		//var err = new Error();
		//alert('Cambiar ' + url + ', Error ' + err.stack);
		urlfinal = url.replace('&sinencab=1', '');
		window.history.pushState({
			path : urlfinal
		}, '', urlfinal);
	}
}

/**
 * Carga una URL en un elemento mediante AJAX. Si no se pasa un elemento destino, se toma "page-wrapper" que es el
 * contenedor principal.
 * 
 * @see tapirNavegarA()
 */
function tapirCargarUrlEn(url, destino) {
	var AjaxSpinnerTimeout;

	AjaxSpinnerTimeout = setTimeout(function() {
		$('#ajax-spinner').show();
	}, 700);

	//var err = new Error();
	//alert('Cargar ' + url);// + ', Error ' + err.stack);
	if (destino === undefined || destino === '') {
		destinoFinal = '#page-wrapper';
	} else {
		destinoFinal = destino;
	}

	$(".tinymce").each(function() {
		tinymce.execCommand('mceRemoveEditor', false, this.id);
	});

	// $(destino).html('<p><i class="fa fa-spinner fa-spin"></i>
	// Cargando...</p>');
	$.get(url, function(data) {
		clearTimeout(AjaxSpinnerTimeout);
		try {
			$(destinoFinal).html(data);
		} catch(err) {
			$(destinoFinal).append('<div class="alert alert-dismissable alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert">×</button>Error al cargar fragmento AJAX: ' + err + '</div>');
		}

		var newTitle = $('#page-title').text();
		if (newTitle !== undefined) {
			document.title = tapirNombreAplicacion + ': ' + newTitle;
		} else {
			newTitle = tapirNombreAplicacion;
			document.title = newTitle;
		}

		if (destino === undefined || destino === '') {
			// Si estoy cargando una página completa, muevo el scroll hacia arriba
			$('html, body').animate({
				scrollTop : 0
			}, 'fast');
		}

		clearTimeout(AjaxSpinnerTimeout);
		MejorarElementos(destinoFinal);
		$('#ajax-spinner').hide();
	}).fail(function(jqXHR) {
		// Muestro un error
		clearTimeout(AjaxSpinnerTimeout);
		$(destinoFinal).html(jqXHR.responseText);
		$('#ajax-spinner').hide();
	});

	return false;
}

/**
 * Esta funcion le da el formato DD/MM/AAAA o DD/MM/AA dependiendo de como lo
 * halla ingresado el usuario
 * 
 * @param fecha
 * @returns {String}
 */
function tapirFormatoFecha(fecha) {
	var partes;
	var fechaaux = fecha;
	if (fecha.indexOf('-') > 0) {
		partes = fecha.split("-");
		fecha = partes[0] + "/" + partes[1] + "/" + partes[2];
		return fecha;
	} else {
		if (fecha.indexOf('.') > 0) {
			partes = fecha.split('.');
			fecha = partes[0] + "/" + partes[1] + "/" + partes[2];
			return fecha;
		} else {
			if (fecha.indexOf('/') < 0) {
				fechaaux = fecha.substring(0, 2) + "/" + fecha.substring(2, 4)
						+ "/" + fecha.substring(4);
				return fechaaux;
			}
		}
	}
	return fechaaux;
}

/**
 * Devuelve true si una cadena representa una fecha válida.
 * Los separadores aceptados son "/", "." y "-".
 */
function tapirFechaEsValida(fecha) {
	if ((fecha.length > 4) && (fecha.indexOf("-") < 0)
			&& (fecha.indexOf(".") < 0) && (fecha.indexOf("/") < 0))
		fecha = fecha.substring(0, 2) + "/" + fecha.substring(2, 4) + "/"
				+ fecha.substring(4);
	var er = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
	// var er=/^(\d{2})(\/|-)(\d{2})(\/|-)(\d{2,4})$/;
	if (fecha.match(er)) {
		return true;
	} else {
		return false;
	}

}


/**
 * Mejora elementos, según sus data-toggle u otras características.
 * Incorpora funciones mejoradas como calendario, Select2, validación, formateo, etc.
 */
function MejorarElementos(destino) {
	//alert('Mejorar ' + destino);
	
	if (destino) {
		desintoFinal = destino + ' ';
	} else {
		desintoFinal = '';
	}
	
	// Activar la función de los enalces AJAX
	$(desintoFinal + '[data-toggle="ajax-link"]').off('click');
	$(desintoFinal + '[data-toggle="ajax-link"]').click(
		function(e) {
			e.preventDefault();
			return tapirNavegarA($(this).attr('href'), $(this).attr('data-target'));
		});
	
	
	// Activar la función de formularios AJAX
	$(desintoFinal + '[data-toggle="ajax-form"]').off('submit');
	$(desintoFinal + '[data-toggle="ajax-form"]').submit(function() {
		destino = $(this).attr('data-target');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $(destino).html(data);
            },
            error: function(data, status) {
            	$(destino).html(data.responseText);
            }
        });
        return false; 
    });
	
	
	// Activar el doble clic para editar en campos con edición in situ
	$(desintoFinal + '[data-toggle="inplace-edit"]').off('dblclick');
	$(desintoFinal + '[data-toggle="inplace-edit"]').dblclick(
		function(e) {
			e.preventDefault();
			e.stopPropagation();
			UrlEdicion = $(this).attr('href');
			UrlEdicion = tapirAgregarElementoUri(UrlEdicion, 'data-control', $(this).attr('data-control'));
			UrlEdicion = tapirAgregarElementoUri(UrlEdicion, 'hisapi', 0);
			return tapirNavegarA(UrlEdicion, '#' + $(this).attr('id'));
		});

	// Activar la función de los enlaces que abren modales
	$(desintoFinal + '[data-toggle="modal"]').off('click');
	$(desintoFinal + '[data-toggle="modal"]').click(
		function(e) {
			e.preventDefault();
			return tapirMostrarModalEn($(this).attr('href'), $(this).attr('data-target'));
		});
	
	
	// Dar tratamiento especial a los campos de CUIL/CUIT
	$(desintoFinal + '[data-type="cuilt"]').blur(function() {
		if(tapirCuiltEsValida(this.value)) {
			this.value = tapirFormatearCuilt(this.value);
			$(this).parent().removeClass('has-error').addClass('has-success');
		} else if(this.value) {
			$(this).parent().removeClass('has-success').addClass('has-error');
		} else {
			$(this).parent().removeClass('has-success').removeClass('has-error');
		}
	});
	
	// Dar tratamiento especial a los campos de CBU
	$(desintoFinal + '[data-type="cbu"]').blur(function() {
		if(tapirCbuEsValida(this.value)) {
			this.value = tapirFormatearCbu(this.value);
			$(this).parent().removeClass('has-error').addClass('has-success');
		} else if(this.value) {
			$(this).parent().removeClass('has-success').addClass('has-error');
		} else {
			$(this).parent().removeClass('has-success').removeClass('has-error');
		}
	});

	/* $(desintoFinal + '.input-daterange').datepicker({
		todayBtn : "linked",
		todayHighlight : true,
		language : 'es',
		autoclose : true
	}); */
	
	// Tooltips de Bootstrap
	$(desintoFinal + '[data-toggle="tooltip"]').tooltip()
	
	// Popovers de Bootstrap
	$(desintoFinal + '[data-toggle="popover"]').popover()
	
	// @see tapirEntitySelect()
	$(desintoFinal + '[data-toggle="entity-select"]').each(function() {
        tapirEntitySelect($(this));
    });
	
	// El resto de los <select> con Select2
	$(desintoFinal + '[data-toggle="select"]').select2()

	// Dar tratamiento especial a los campos de fecha
	// (validar y formatear la fecha ingresada al perder el foco)
	$(desintoFinal + '.valirdar-fecha').blur(function(e) {
		var fecha = this.value;
		if (tapirFechaEsValida(fecha)) {
			fecha = tapirFormatoFecha(fecha);
			this.value = fecha;
		} else {
			this.value = '';
		}
	});

	$('.tinymce').each(function() {
		tinymce.execCommand('mceAddEditor', true, this.id);
	});
}


/**
 * Prepara un elemento <select> para utilizar Select2 con AJAX.
 * Auxiliar de Tapir:FormBundle:AjaxEntityType. 
 */
function tapirEntitySelect(element) {
	var entity = element.data('entity');
	var property = element.data('property');
	var allowclear = !element.attr('required');
	var allowmultiple = element.attr('multiple');
	var extradata = element.data('extra-data');
	
	var options = {
        placeholder: function(element) {
            return $(element).data('placeholder');
        },
        width: 'style',
        allowClear: allowclear,
        multiple: allowmultiple,
        ajax: {
            dataType: 'json',
            type: 'post',
            data: function (params) {
                return {
                    q: params.term,
                    entity: entity,
                    property: property,
                    extra: extradata,
                }
            }/* ,
            results: function (data) {
                return { results: data }
            } */
        }
    };
	
	element.select2(options);
	
	var initial = element.data('initial');
	if(typeof initial != 'undefined') {
		if(initial instanceof Array) {
			for (index = 0; index < initial.length; ++index) {
				var option = $('<option selected>Loading...</option>').val(initial[index].id).text(initial[index].text);
				element.append(option);
			}
			element.trigger('change');
		} else {
			var option = $('<option selected>Loading...</option>').val(initial.id).text(initial.text);
			element.append(option).trigger('change');
		}
	}
}

/**
 * Devuelve true si la cadena representa una CUIT válida.
 */
function tapirCuiltEsValida(cuilt) {
	cuiltLimpia = cuilt.toString().replace(/-/g, '').trim();
	if (cuiltLimpia.length == 11) {
		var Caracters_1_2 = cuiltLimpia.charAt(0) + cuiltLimpia.charAt(1);
		if (Caracters_1_2 == "20" || Caracters_1_2 == "23"
				|| Caracters_1_2 == "24" || Caracters_1_2 == "27"
				|| Caracters_1_2 == "30" || Caracters_1_2 == "33"
				|| Caracters_1_2 == "34") {
			var Count = cuiltLimpia.charAt(0) * 5 + cuiltLimpia.charAt(1) * 4
					+ cuiltLimpia.charAt(2) * 3 + cuiltLimpia.charAt(3) * 2
					+ cuiltLimpia.charAt(4) * 7 + cuiltLimpia.charAt(5) * 6
					+ cuiltLimpia.charAt(6) * 5 + cuiltLimpia.charAt(7) * 4
					+ cuiltLimpia.charAt(8) * 3 + cuiltLimpia.charAt(9) * 2
					+ cuiltLimpia.charAt(10) * 1;
			Division = Count / 11;
			if (Division == Math.floor(Division)) {
				return true;
			}
		}
	}
	return false;
}


/**
 * Devuelve true si la cadena representa una CBU válida.
 */
function tapirCbuEsValida(cbu) {
	cbuLimpia = cbu.toString().replace(/-/g, '').trim();
	if (cbuLimpia.length == 22) {
	    var digitoVerificador2 = cbuLimpia[7];
	     
	    var suma = cbuLimpia[0] * 7 + cbuLimpia[1] * 1 + cbuLimpia[2] * 3
	    	+ cbuLimpia[3] * 9 + cbuLimpia[4] * 7 + cbuLimpia[5] * 1 + cbuLimpia[6] * 3;
	     
	    var diferencia = 10 - (suma % 10);
	     
	    if(diferencia != digitoVerificador2) {
	    	return false;
	    }
	    
	    var digitoVerificador = cbuLimpia[21];
	    var suma = cbuLimpia[8] * 3 + cbuLimpia[9] * 9 + cbuLimpia[10] * 7  + cbuLimpia[11] * 1
	    	+ cbuLimpia[12] * 3 + cbuLimpia[13] * 9 + cbuLimpia[14] * 7 + cbuLimpia[15] * 1
	    	+ cbuLimpia[16] * 3 + cbuLimpia[17] * 9 + cbuLimpia[18] * 7 + cbuLimpia[19] * 1 + cbuLimpia[20] * 3;
	    var diferencia = 10 - (suma % 10);
	    return diferencia == digitoVerificador;
	}
	return false;
}

/**
 * Formatea una CUIT.
 * Quita espacios antes y después y agrega los guiones si no los tiene.
 */
function tapirFormatearCuilt(cuilt) {
	cuiltLimpia = cuilt.toString().replace(/-/g, '').trim();
	if (cuiltLimpia.length == 11) {
		return cuiltLimpia.substr(0, 2) + '-' + cuiltLimpia.substr(2, 8) + '-' + cuiltLimpia.substr(10, 1);  
	} else {
		return cuilt;
	}
}


/**
 * Formatea una CBU.
 * Quita espacios antes y después y agrega los guiones si no los tiene.
 */
function tapirFormatearCbu(cbu) {
	cbuLimpia = cbu.toString().replace(/-/g, '').trim();
	if (cbuLimpia.length == 22) {
		return cuiltLimpia.substr(0, 8) + '-' + cuiltLimpia.substr(8, 14);  
	} else {
		return cbu;
	}
}


$(document).ready(function() {
    // Capturo los botones "atrás" y "adelante" del navegador y para funcionar via AJAX
    window.onpopstate = function() {
        tapirCargarUrlEn(document.location);
    };
    
    // Evito que los enlaces href="#" muevan la página hacia el tope
    $('a[href="#"][data-top!=true]').click(function(e) {
            e.preventDefault();
    });

    // Cierro el spinner de "Cargando..."
    $('#ajax-spinner').hide();

    // Mejorar elementos tipo data-toggle
	MejorarElementos();

	// Activo la función de los enlaces que abren modales
	$('[data-toggle="modal"]').off('click');
	$('[data-toggle="modal"]').click(
		function(e) {
			e.preventDefault();
			return tapirMostrarModalEn($(this).attr('href'),
					$(this).attr('data-target'));
		});

	// Pongo a las notificaciones un temporizador para que desaparezcan automáticamente
	window.setTimeout(function() {
		$('.alert-dismissable').fadeTo(500, 0).slideUp(500, function() {
			$(this).remove();
		});
	}, 15000);
});
