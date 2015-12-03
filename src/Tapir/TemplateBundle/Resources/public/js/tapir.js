var nombreAplicacion, nombreCliente;

tapirNombreAplicacion = 'Aplicación sin título';
tapirNombreCliente = 'Cliente';

String.prototype.toTitleCase = function() {
	var i, j, str, lowers, uppers;
	str = this.replace(/([^\W_]+[^\s-]*) */g, function(txt) {
		return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	});
	
	// Certain minor words should be left lowercase unless 
	// they are the first or last words in the string
	lowers = ['Y', 'De', 'Del', 'A', 'Al', 'Con', 'Sin', 'En', 'E', 'O', 'U', 'Por', 'Para'];
	for (i = 0, j = lowers.length; i < j; i++) {
		str = str.replace(new RegExp('\\s' + lowers[i] + '\\s', 'g'), function(txt) { return txt.toLowerCase(); });
	}
	
	// Certain words such as initialisms or acronyms should be left uppercase
	uppers = ['Dvd', 'Ara', 'Agp', 'Ypf', 'Ycf', 'Ipv', 'Cap', 'Ii', 'Iii', 'Iv', 'Vi', 'Vii', 'Viii', 'Ix', 'Xi',
	    'Xii', 'Xiii', 'Xiv', 'Xv', 'Xvi', 'Sa', 'Srl', 'Sh', 'Sdh', 'S.a', 'S.r.l', 'S.h', 'S.d.h'];
	for (i = 0, j = uppers.length; i < j; i++) {
		str = str.replace(new RegExp('\\b' + uppers[i] + '\\b', 'g'), uppers[i].toUpperCase());
	}
	
	return str;
}

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
	$('.ocultar-al-seleccionar-item').addClass('hidden');
	$(destino).change();
	$(destino + '_Detalle').focus();
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
	tapirCambiarDireccion(url);
	tapirCargarUrlEn(url, destino); // con AJAX
}

/**
 * Cambia la URL en la barra de dirección (y en el historial) del navegador.
 */
function tapirCambiarDireccion(url) {
	if (url !== window.location && url.indexOf('hisapi=0') === -1
			&& url.indexOf('/guardar/') === -1
			&& url.indexOf('/eliminar/') === -1
			&& url.indexOf('/eliminar2/') === -1
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
 * Carga una URL en un elemento mediante AJAX. Si no se pasa un elemento destino, se toma "ajax-wrapper" que es el
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
	var destinoFinal;
	if (destino === undefined || destino === '') {
		destinoFinal = '#ajax-wrapper';
	} else {
		destinoFinal = destino + '';
	}

	// Eliminar TinyMCE de elementos que se van a quitar
	$(destinoFinal + '.tinymce').each(function() {
		tinymce.execCommand('mceRemoveEditor', false, this.id);
	});
	
	// Cerrar los select2 antes de recargar por AJAX
	$(destinoFinal + '.select2-hidden-accessible').each(function() {
		$(this).select2("close");
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
 * Formatea y sanitiza una fecha.
 * 
 * Acepta varios formatos como DD/MM/AA, DD-MM-AAAA, DD-MM, etc. y devuelve siempre DD/MM/AAAA.
 * 
 * @param fecha
 * @returns {String}
 */
function tapirFormatearFecha(fecha) {
	var FechaAux = fecha.replace(/ /g, '').replace(/-/g, '/').replace(/\./g, '/').replace(/\/\//g, '/');
	var Partes = FechaAux.split('/');
	if(Partes.length < 2) {
		return '';
	} else if(Partes.length == 2) {
		Partes[2] = new Date().getFullYear();
	} else if(Partes.length == 3) {
		if(Partes[0].length == 1) {
			Partes[0] = '0' + Partes[0];
		}
		if(Partes[1].length == 1) {
			Partes[1] = '0' + Partes[1];
		}
		if(Partes[2].length == 2) {
			if(Partes[2] > 30) {
				Partes[2] = '19' + Partes[2];
			} else {
				Partes[2] = '20' + Partes[2];
			}
		}
	}
	return Partes[0] + '/' + Partes[1] + '/' + Partes[2];;
}

/**
 * Devuelve true si una cadena representa una fecha válida.
 * Los separadores aceptados son "/", "." y "-".
 */
function tapirFechaEsValida(fecha) {
	var FechaFormateada = tapirFormatearFecha(fecha);
	var Partes = FechaFormateada.split('/');
    var Fecha = new Date(Partes[2], Partes[1] - 1, Partes[0]);
    return Fecha && Fecha.getFullYear() == Partes[2] && (Fecha.getMonth() + 1) == Partes[1] && Fecha.getDate() == Number(Partes[0]);
}


/**
 * Mejora elementos, según sus data-toggle u otras características.
 * Incorpora funciones mejoradas como calendario, Select2, validación, formateo, etc.
 */
function MejorarElementos(destino) {
	//alert('Mejorar ' + destino);
	
	var desintoFinal;
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

	// Dar tratamiento especial a los campos de fecha
	// (validar y formatear la fecha ingresada al perder el foco)
	$(desintoFinal + '[data-type="date"]').blur(function(e) {
		var fecha = $.trim($(this).val());
		$(this).val(tapirFormatearFecha(fecha));
		if (tapirFechaEsValida(fecha)) {
			$(this).parent().removeClass('has-error');
		} else {
			$(this).parent().addClass('has-error');
		}
	});

	// Todos los campos de texto eliminan espacios antes y después
	$(desintoFinal + 'input[type=text]').blur(function(e) {
		var currVal = $.trim($(this).val());
		if(currVal != $(this).val()) {
			$(this).val(currVal);
		}
	});
	// Campos de texto de mayúsculas y minúsculas obligatorias
	$(desintoFinal + '.tapir-input-maymin').blur(function(e) {
		var currVal = $(this).val().replace(/  /g, ' ');
		if(currVal == currVal.toLowerCase() || currVal == currVal.toUpperCase()) {
			// Sólo cambios a TitleCase si escribió todo en mayúsculas o todo en minúsculas
			currVal = currVal.toTitleCase();
		}
		if(currVal != $(this).val()) {
			$(this).val(currVal);
		}
	});
	// Campos de texto de mayúsculas obligatorias
	$(desintoFinal + '.tapir-input-mayus').blur(function(e) {
		var currVal = $(this).val().replace(/  /g, ' ').toUpperCase();
		if(currVal != $(this).val()) {
			$(this).val(currVal);
		}
	});
	// Campos de texto de minúsculas obligatorias
	$(desintoFinal + '.tapir-input-minus').blur(function(e) {
		var currVal = $(this).val().replace(/  /g, ' ').toLowerCase();
		if(currVal != $(this).val()) {
			$(this).val(currVal);
		}
	});
	// Campos de texto que no admiten espacios
	$(desintoFinal + '.tapir-input-sinespacios').blur(function(e) {
		var currVal = $(this).val().replace(/ /g, '');
		if(currVal != $(this).val()) {
			$(this).val(currVal);
		}
	});
	
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

	$('.tinymce').each(function() {
		tinymce.execCommand('mceAddEditor', true, this.id);
	});
	
	setTimeout(function() {
		$("[autofocus]").focus(); 
	}, 100);
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
        width: 'resolve',
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
	}, 60000);
	
	// Fix para búsqueda en Select2 en un modal de Bootstrap 3.3.5.
	// Quitar cuando bootstrap solucione el problema
	$.fn.modal.Constructor.prototype.enforceFocus =function(){};
});
