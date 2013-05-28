<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
?>

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
	$Id = $_POST["id"];
/*	$Resultado1 = $_POST["Resultado1"] ? $_POST["Resultado1"] : 'NULL';
	$Resultado2 = $_POST["Resultado2"] ? $_POST["Resultado2"] : 'NULL';
	$Resultado3 = $_POST["Resultado3"] ? $_POST["Resultado3"] : 'NULL';
	$Resultado4 = $_POST["Resultado4"] ? $_POST["Resultado4"] : 'NULL';
	$Resultado5 = $_POST["Resultado5"] ? $_POST["Resultado5"] : 'NULL';
	$Resultado6 = $_POST["Resultado6"] ? $_POST["Resultado6"] : 'NULL';
	if($Resultado6 && !$Resultado5) {
            $Resultado5 = $Resultado6;
            $Resultado6 = 'NULL';
	}*/

	if($_POST["Resultado1"]) {
		$Resultados[] = $_POST["Resultado1"];
	}
	if($_POST["Resultado2"]) {
		$Resultados[] = $_POST["Resultado2"];
	}
	if($_POST["Resultado3"]) {
		$Resultados[] = $_POST["Resultado3"];
	}
	if($_POST["Resultado4"]) {
		$Resultados[] = $_POST["Resultado4"];
	}
	if($_POST["Resultado5"]) {
		$Resultados[] = $_POST["Resultado5"];
	}
	if($_POST["Resultado6"]) {
		$Resultados[] = $_POST["Resultado6"];
	}

	$Resultado1 = isset($Resultados[0]) ? $Resultados[0] : 'NULL';
	$Resultado2 = isset($Resultados[1]) ? $Resultados[1] : 'NULL';
	$Resultado3 = isset($Resultados[2]) ? $Resultados[2] : 'NULL';
	$Resultado4 = isset($Resultados[3]) ? $Resultados[3] : 'NULL';
	$Resultado5 = isset($Resultados[4]) ? $Resultados[4] : 'NULL';
	$Resultado6 = isset($Resultados[5]) ? $Resultados[5] : 'NULL';

	$Obs = $_POST["Obs"];
	$lat = $_POST["lat"];
	$lon = $_POST["lon"];
	if(!$_POST["lat"] || !$_POST["lon"]) {
		$Ubicacion = 'NULL';
	} else {
		$Ubicacion = "POINT(".$lat." ".$lon.")";
	}
	
	if($_POST["Imagen"]) {
		$imagen = substr($_POST["Imagen"], strpos($_POST["Imagen"], ',')+1);
		$imagen_binario = base64_decode($imagen);
	}else {	
		$dataURL = null;
	}

	$update = $db_local->prepare("UPDATE Inspeccion_RelevamientoAsignacionDetalle 
		SET Resultado1_id = $Resultado1, 
			Resultado2_id = $Resultado2, 
			Resultado3_id = $Resultado3, 
			Resultado4_id = $Resultado4, 
			Resultado5_id = $Resultado5, 
			Resultado6_id = $Resultado6, 
			ResultadoObs = :resultadoobs, 
			Imagen = :imagen, 
			ResultadoUbicacion = '$Ubicacion'
		WHERE id = :id;");
		$update->bindValue('resultadoobs', $Obs, PDO::PARAM_STR);
		$update->bindValue('imagen', $imagen_binario, PDO::PARAM_LOB);
		$update->bindValue('id', $Id, PDO::PARAM_INT);
		$update->execute();
	
	echo "<p>Incidentes guardados.</p>";
?>
<script type="text/javascript">
window.location='listado.php';
</script>

</div>

</body>

</html>