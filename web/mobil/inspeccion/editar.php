<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';

    $AsignacionDetalleId = (int)($_GET["id"]);

	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id='$AsignacionDetalleId'";
	$row = $db_local->query($sql)->fetch();
?>

<body onload='getLocation();'>

<form name="editar" action="guardar.php" method="post" onsubmit="ConfirmarSalida=0;">
<input type="hidden" id="id" name="id" value="<?php echo $AsignacionDetalleId; ?>" />
<input type="hidden" id="Imagen" name='Imagen'/>

<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button type='submit' name='Aceptar'>Guardar</button>
 <button type='button' onclick="parent.location='listado.php';">Terminar</button>
</div>
</div>

<div class="barraizquierda">

<fieldset name='Domicilio'>
<legend>Calle <?php echo $row['PartidaCalleNombre']; ?> Nº <?php echo $row['PartidaCalleNumero']; ?></legend>
Sección <?php echo $row['PartidaSeccion']; ?>,
Macizo <?php echo $row['PartidaMacizo']; ?>,
Parcela <?php echo $row['PartidaParcela']; ?>
</fieldset>

<fieldset>
<legend>Incidentes</legend>
<select name='Resultado' style="width: 360px;" required='required' onchange='ConfirmarSalida=1;'>
<option value=''>Seleccione una incidencia</option>
<?php
	$sql = "SELECT * FROM inspeccion_relevamientoResultado ORDER BY Grupo, Nombre ASC";
	foreach ($db_local->query($sql) as $row) {
?>
<option value="<?php echo $row['Id'] ?>"><?php echo $row['Grupo'] ? $row['Grupo'] . ': ' : '' ?><?php echo $row['Nombre'] ?></option>
<?php
	}
?>
<fieldset name='Ubicacion'>
<legend>Georeferencia</legend>
Latitud <input type='text' name='lat' id='lat' maxlength=16 size=5 readonly />, longitud <input type='text' maxlength=16 size=5 name='lon' id='lon' readonly /><br />
</fieldset>

<fieldset name='Observaciones'>
<textarea name='Obs' cols='50' rows='10' style="width: 95%" placeholder="Escriba aquí las observaciones" onchange='ConfirmarSalida=1;'></textarea>
</fieldset>
</div>

<div class="contenido">

<fieldset>
<button type="button" id="restartbutton" style="display: none;">Tomar foto nuevamente</button>
<video id="video" width="800" height="600" autoplay></video><br />
<canvas id="canvas" width="800" height="600" style="display: none; background-color: silver; border: 1px solid gray"></canvas>
<fieldset>

</div>
</form>

<script>

var ConfirmarSalida = 0;

window.onbeforeunload = confirmaSalida;
    
function confirmaSalida(){
    if (ConfirmarSalida){
        return "Está a punto de abandonar la página sin guardar su trabajo. Asegúrese de haber guardado antes de abandonar esta página.";
    }
}

(function() {
  var streaming = false,
      video         = document.querySelector('#video'),
      canvas        = document.querySelector('#canvas'),
      restartbutton = document.querySelector('#restartbutton'),
      width = 800,
      finalheight = 600;
  function init() {
    navigator.getMedia = ( navigator.getUserMedia ||
                           navigator.webkitGetUserMedia ||
                           navigator.mozGetUserMedia ||
                           navigator.msGetUserMedia);

    navigator.getMedia(
      {
        video: true,
        audio: false
      },
      function(stream) {
        if (navigator.mozGetUserMedia) {
          video.mozSrcObject = stream;
        } else {
          var vendorURL = window.URL || window.webkitURL;
          video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
        }
        video.play();
      },
      function(err) {
        console.log("An error occured! " + err);
      }
    );
  }

  function takepicture() {
    canvas.width = video.width;
    canvas.height = video.height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, finalheight);
    video.style.display = 'none';
    restartbutton.style.display = '';
    canvas.style.display = '';
    document.getElementById("Imagen").value = canvas.toDataURL('image/jpeg');
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    }
  };
  
  function restart() {
    restartbutton.style.display = 'none';
    video.style.display = '';
    canvas.style.display = 'none';
  }

/* Event Handlers */

  video.addEventListener('loadedmetadata', function(ev){
    if (!streaming) {
      if(video.videoHeight > 0)
        finalheight = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', finalheight);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', finalheight);
      streaming = true;
    }
  }, false);

  video.addEventListener('click', function(ev){
    takepicture();
  }, false);
  
  restartbutton.addEventListener('click', function(ev){
    restart();
  }, false);
  
  init();
})();

function getLocation() {
	x = document.getElementById("geo");
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		x.innerHTML='Este navegador no soporta localización';
	}
}

function showPosition(position) {
	//x.innerHTML="Latitude: " + position.coords.latitude +
	//"<br>Longitude: " + position.coords.longitude;
	document.getElementById("lat").value = position.coords.latitude;
	document.getElementById("lon").value = position.coords.longitude;  
}

</script>

<?php
	$_SESSION['habilitado'] = 1;
?>

</body>
</html>
