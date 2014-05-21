<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';

    require_once '../db_local.php.inc';

    $AsignacionDetalleId = (int)($_GET["id"]);

    $sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id='$AsignacionDetalleId'";
    $row = $YacareDbLocal->query($sql)->fetch();
?>

<script>
    // *********************** Evitar el uso del botón atrás
    var ConfirmarSalida = 0;

    location.hash = '#no-back';
    // It works without the History API, but will clutter up the history
    var history_api = typeof history.pushState !== 'undefined';

    // Push "#no-back" onto the history, making it the most recent "page"
    if (history_api)
        history.pushState(null, '', '#stay');
    else
        location.hash = '#stay';

    // When the back button is pressed, it will harmlessly change the url
    // hash from "#stay" to "#no-back", which triggers this function
    window.onhashchange = function() {
        // User tried to go back; warn user, rinse and repeat
        if (location.hash == '#no-back') {
            //alert("You shall not pass!");
            if (history_api)
                history.pushState(null, '', '#stay');
            else
                location.hash = '#stay';
            //initCamara();
            document.querySelector('#video').play();
        }
    }
    
    function confirmarYTerminar() {
        if(ConfirmarSalida) {
            var conf = confirm("Está a punto de abandonar la página sin guardar su trabajo. ¿Está seguro de que desea salir sin guardar?");
            if(conf)
                parent.location='listado.php';
            //else
                // Me quedo
        } else {
            parent.location='listado.php';
        }
    }
</script>

<body>
    
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Inspección</div>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a id="restartbutton" style="display: none;"><i class="fa fa-camera"></i> Tomar foto nuevamente</a></li>
                <li><a onclick="window.open('mostrar_historial.php?id=<?php echo $AsignacionDetalleId; ?>')"><i class="fa fa-history"></i> Historial</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="text-warning" onclick="confirmarYTerminar()"><i class="fa fa-reply"></i> Terminar</a></li>
                <li><a class="text-success" onclick="$('#form-editar').submit();" type='submit' name='Aceptar'><i class="fa fa-check"></i> Guardar y continuar</a></li>
            </ul>
        </div>
    </div>
</nav>

<form name="editar" id="form-editar" action="guardar.php" method="post" onsubmit="ConfirmarSalida=0;">
<input type="hidden" id="id" name="id" value="<?php echo $AsignacionDetalleId; ?>" />
<input type="hidden" id="asignacion_id" name="asignacion_id" value="<?php echo $row['Asignacion_id']; ?>" />
<input type="hidden" id="Imagen" name='Imagen'/>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

<fieldset name='Domicilio'>
<legend><?php echo $row['PartidaCalleNombre']; ?> Nº <?php echo $row['PartidaCalleNumero']; ?></legend>
Sección <?php echo $row['PartidaSeccion']; ?>,
Macizo <?php echo $row['PartidaMacizo']; ?>,
Parcela <?php echo $row['PartidaParcela']; ?>
</fieldset>

<fieldset>
<legend>Incidentes</legend>
<select name='Resultado' style="width: 95%; max-width: 240px;" required='required' onchange='ConfirmarSalida=1;'>
<option value=''>Seleccione una incidencia</option>
<?php
	$sql = "SELECT * FROM inspeccion_relevamientoResultado ORDER BY Grupo, Nombre ASC";
	foreach ($YacareDbLocal->query($sql) as $row) {
?>
<option value="<?php echo $row['Id'] ?>"><?php echo $row['Grupo'] ? $row['Grupo'] . ': ' : '' ?><?php echo $row['Nombre'] ?></option>
<?php
	}
?>
</select>
<fieldset name='Ubicacion'>
<legend>Georeferencia</legend>
Latitud <input type='text' name='lat' id='lat' maxlength=16 size=5 readonly />, longitud <input type='text' maxlength=16 size=5 name='lon' id='lon' readonly /><br />
</fieldset>

<legend>Observaciones</legend>
<fieldset name='Observaciones'>
<textarea name='Obs' cols='50' rows='10' style="width: 95%" placeholder="Escriba aquí las observaciones" onchange='ConfirmarSalida=1;'></textarea>
</fieldset>
    
        </div><!-- col-*-4 -->

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">

<video id="video" width="320" height="240" style="margin: 0; padding: 0; border: 12px solid white" autoplay></video>
<canvas id="canvas" width="320" height="240" style="display: none; margin: 0; padding: 0; background-color: silver; border: 12px solid #33d23e"></canvas>
    
        </div><!-- col-*-8 -->
    </div>
</div>
</form>

<script>

// ************************** Uso de WebRTC (cámara)

var streaming = false,
    video         = document.querySelector('#video'),
    canvas        = document.querySelector('#canvas'),
    restartbutton = document.querySelector('#restartbutton'),
    width = 800,
    finalheight = 600;
function initCamara() {
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
  ConfirmarSalida = 1;
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
  video.play();
}

initCamara();

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
    require_once '../footer.php.inc';
?>
</body>
</html>
