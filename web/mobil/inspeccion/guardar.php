<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
?>

<script>
// Convert dataURL to Blob object
function dataURLtoBlob(dataURL) {
	// Decode the dataURL    
	var binary = atob(dataURL.split(',')[1]);
	// Create 8-bit unsigned array
	var array = [];
	for(var i = 0; i < binary.length; i++) {
		array.push(binary.charCodeAt(i));
	}
	// Return our Blob object
	return new Blob([new Uint8Array(array)], {type: 'image/png'});
}
</script>

<body>
<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button type='submit' name='Aceptar'>Guardar</button>
 <button value='Back' onclick="parent.location='listado.php'">Cancelar</button>
</div>
</div>
<div class="contenido">
<?php
	//$db_local->exec("CREATE TABLE Incidentes (id INTEGER PRIMARY KEY, calle INTEGER, altura INTEGER, seccion TEXT, macizo_num INTEGER, macizo_let TEXT, parcela_num INTEGER, parcela_let TEXT, tipo TEXT, obs TEXT, fecha NUMERIC, foto BLOB, lat TEXT, lon TEXT)");
		
	$Id = $_POST["id"];
	$Resultado1 = $_POST["Resultado1"] ? $_POST["Resultado1"] : 'NULL';
        $Resultado2 = $_POST["Resultado2"] ? $_POST["Resultado2"] : 'NULL';
        $Resultado3 = $_POST["Resultado3"] ? $_POST["Resultado3"] : 'NULL';
	if($Resultado3 && !$Resultado2) {
            $Resultado2 = $Resultado3;
            $Resultado3 = 'NULL';
        }

	$Obs = $_POST["Obs"];
	$lat = $_POST["lat"];
	$lon = $_POST["lon"];
	if(!$_POST["lat"] || !$_POST["lon"]) {
		$Ubicacion = 'NULL';
	} else {
		$Ubicacion = "POINT(".$lat." ".$lon.")";
	}
	
	if(!$_POST["Foto"]) {
		$dataURL = 'NULL';
	}else {	
		$imagen = substr($_POST["Foto"], strpos($_POST["Foto"], ',')+1);
		$imagen_binario = base64_decode($imagen);
		//$encoded = str_replace(' ', '+', $dataURL);
		//$decoded = base64_decode($encoded);
	}

	$update = $db_local->prepare("UPDATE Inspeccion_RelevamientoAsignacionDetalle 
		SET Resultado1_id = $Resultado1, 
			Resultado2_id = $Resultado2, 
			Resultado3_id = $Resultado3, 
			ResultadoObs = :resultadoobs, 
			ResultadoImagen = :resultadoimagen, 
			ResultadoUbicacion = '$Ubicacion'
		WHERE id = :id;");
		$update->bindValue('resultadoobs', $Obs, PDO::PARAM_STR);
		$update->bindValue('resultadoimagen', $imagen_binario, PDO::PARAM_LOB);
		$update->bindValue('id', $Id, PDO::PARAM_INT);
		$update->execute();
	
	echo "Incidentes guardados.<br><br>";
	
	//$db_local->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET Resultado1_id='$Resultado1', Resultado2_id='$Resultado2', Resultado3_id='$Resultado3', ResultadoObs='$Obs', ResultadoImagen='$dataURL', ResultadoUbicacion='$ResultadoUbicacion' WHERE id=$Id);");
	//echo "<br><button value='Back' onclick='goBack()' class='label-style'>Volver</button>";
	$db_local=null;
	$_SESSION['habilitado'] = 1;

?>
<script type="text/javascript">
window.location='listado.php';
</script>

</div>

</body>

</html>

