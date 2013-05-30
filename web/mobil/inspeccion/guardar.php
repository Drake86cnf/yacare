<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
?>

<body>

<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button value='Back' onclick="parent.location='listado.php'">Terminar</button>
</div>
</div>
<div class="contenido">
<?php		
	echo $AsignacionDetalleId = (int)$_POST['id'];
	echo $Resultado = $_POST['Resultado'] ? $_POST['Resultado'] : 'NULL';

	$Obs = $_POST['Obs'];
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	
    if(!$_POST['lat'] || !$_POST['lon']) {
		$Ubicacion = 'NULL';
		echo 'Sin ubicacion';
	} else {
		$Ubicacion = 'POINT(' . $lat . ' ' . $lon . ')';
		echo 'Con ubicación';
	}
	
	if($_POST['Imagen']) {
		$imagen = substr($_POST['Imagen'], strpos($_POST['Imagen'], ',') + 1);
		$imagen_binario = base64_decode($imagen);
		echo 'Con imagen';
	} else {	
        $imagen_binario = null;
		$dataURL = null;
		echo 'Sin imagen';
	}

    $insert = $db_local->prepare("INSERT INTO Inspeccion_RelevamientoAsignacionResultado
        (CreatedAt, UpdatedAt, Version, Detalle_id, Resultado_id, Obs, Imagen, Ubicacion) 
        VALUES (
            datetime(),
            datetime(),
            1,
            :detalle_id,
            :resultado_id,
            :obs,
            :imagen,
            '$Ubicacion')");
    $insert->bindValue('detalle_id', $AsignacionDetalleId, PDO::PARAM_INT);
    $insert->bindValue('resultado_id', $Resultado, PDO::PARAM_INT);
    $insert->bindValue('obs', $Obs, PDO::PARAM_STR);
    $insert->bindValue('imagen', $imagen_binario, PDO::PARAM_LOB);
    
    if($insert->execute()) {
        $db_local->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET ResultadosCantidad=ResultadosCantidad+1 WHERE id=$AsignacionDetalleId");
    }
	
	echo "<p>Incidentes guardados.</p>\r\n";
?>
<button type="button" onclick="parent.location=editar.php?id=<?php echo $AsignacionDetalleId ?>">Continuar</button>

<script type="text/javascript">
window.location = 'editar.php?id=' + <?php echo $AsignacionDetalleId ?>;
</script>

</div>

</body>

</html>