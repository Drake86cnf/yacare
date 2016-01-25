# Tgen - Generador de HTML para Twig

Tgen es una extensión de Twig para generar HTML.

Tgen permite emitir HTML sin escribir etiquetas, y de una forma orientada a objetos. Soporta distintos renderers para
emitir diferentes variantes de HTML. La implementación actual incluye de un renderer para Bootstrap 3. 

## Formato general

La forma normal de generar HTML con Tgen es la siguiente:

```html
{{ tgen.Comando([contenido [, atributos]]) }}
```

Donde:

`contenido` es el contenido interno del comando. Puede ser texto, HTML o el resultado de otro comando.
`atributos` es un arreglo de atributos Tgen o HTML para incluir en la etiqueta.

Ejemplo:

```html
{{ tgen.Link('Google', { href: 'http://www.google.com' })|raw }}
```

Emite el siguiente resultado:

```html
<a href="http://www.google.com">Google</a>
```

### Anidar comandos

```html
{{ tgen.Button(
    tgen.IconAndText('Google', 'link')
    , { href: 'http://www.google.com' })|raw }}
```

Emite el siguiente resultado:

```html
<a href="http://www.google.com"><i class="fa fa-link"></i> Google</a>
```

## Referencia

La siguiente es una lista de los comandos soportados y sus parámetros Tgen con sus valores predeterminados.

Los parámetros entre corchetes son opcionales. Los parámetros que se muestran con valores expresan sus valores
predeterminados en caso de que estén ausentes.

### .Button

`tgen.Button(texto [, atributos = { }])`

Soporta los atributos `icon`, `ajax` y `modal` al igual que .Link. 


### .DropdownButton

`tgen.DropdownButton(texto, opciones[, atributos = {} ])`

Las `opciones` son las mismas que para .OrderedList y .UnorderedList, pero deben ser todos enlaces o separadores. No se
admiten elementos de texto simple.


### .Header1, .Header2 y .Header3

Genera una etiqueta `<h1>`, `<h2>` y `<h3>` respectivamente.

`tgen.Header1(texto)`


### .Icon

`tgen.Icon(nombre [, atributos = { fw: false } ])`

Donde `nombre` es el nombre de un icono Font Awesome, por ejemplo 'edit'. `fw` indica si se usa un icono de ancho
fijo.


### .IconAndText

`tgen.Icon(nombre, texto [, atributos = { } ])`

`nombre` y `atributos` son los mismos que para .Icon.


### .Link

Genera una etiqueta `<a>`.

`tgen.Link(texto [, atributos = { icon: null, ajax: false, modal: false}])`

Dispone de un acceso rápida para especificar un icono de Font Awesome en `icon`, por ejemplo 'edit' y de esa manera el
texto se convierte automáticamente en un .IconAndText.  Los atributos `ajax` y `modal` son convertidos a atributos HTML
data-toggle="ajax" y data-toggle="modal" respectivamente.  


### .OrderedList, UnorderedList

`tgen.OrderedList(opciones[, atributos = {} ])`
`tgen.UnorderedList(opciones[, atributos = {} ])`

Opciones es un arreglo que puede contener cadenas que se muestran como elementos de la lista, puede contener arreglos
de dos cadenas ([ cadena, cadena ]) que se muestran como texto y enlace del elemento o una combinación de ambos. El
texto especial 'bootstrap-divider' hace un elemento sin texto que funciona como divisor.

Ejemplo:

```html
tgen.OrderedList([
    'Elemento de texto',
    'Otro elemento de texto',
    'bootstrap-divider',
    [ 'Enlace a Google', 'http://www.google.com' ]
])
```

Resultado:

```html
<ol>
    <li>Elemento de texto</li>
    <li>Otro elemento de texto</li>
    <li role="separator" class="divider"></li>
    <li><a href="http://www.google.com">Enlace a Google</a></li>
</ol>
```


### .Progress

`tgen.Progress(valor_actual, [valor_maximo = 100[, atributos = {}]])`

Ejemplo:

`tgen.Progress(54)`


