<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
?>

<script>
    parent.location = 'editar.php?id=<?php echo $AsignacionDetalleId ?>';
</script>

<body>

<div class="encab">
<div class="encab-izquierda"><img src="yacare_logo_48bw.png" width="48px">&nbsp;Yacaré - Inspección</div>
<div class="encab-derecha">
 <button value='Back' onclick="parent.location='listado.php'">Terminar</button>
</div>
</div>
<div class="contenido">
<?php		
	$AsignacionDetalleId = (int)$_POST['id'];
	$Resultado = $_POST['Resultado'] ? $_POST['Resultado'] : 'NULL';

	$Obs = $_POST['Obs'];
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
    
    $Ubicacion_para_udp = $lat . ", " . $lon;
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_sendto($socket, $Ubicacion_para_udp, strlen($Ubicacion_para_udp), 0, '200.63.163.220', '2044');

	
    if(!$_POST['lat'] || !$_POST['lon']) {
		$Ubicacion = null;
	} else {
		$Ubicacion = 'POINT(' . $lat . ' ' . $lon . ')';
	}
	
  	if($_POST['Imagen']) {
		$imagen = substr($_POST['Imagen'], strpos($_POST['Imagen'], ',') + 1);
		$imagen_binario = base64_decode($imagen);
	} else {	
        $imagen_binario = null;
		$dataURL = null;
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
            :ubicacion)");
    $insert->bindValue('detalle_id', $AsignacionDetalleId, PDO::PARAM_INT);
    $insert->bindValue('resultado_id', $Resultado, PDO::PARAM_INT);
    $insert->bindValue('obs', $Obs, PDO::PARAM_STR);
    $insert->bindValue('ubicacion', $Ubicacion, PDO::PARAM_STR);
    $insert->bindValue('imagen', $imagen_binario, PDO::PARAM_LOB);
    
    if($insert->execute()) {
        $db_local->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET ResultadosCantidad=ResultadosCantidad+1 WHERE id=$AsignacionDetalleId");
    }
	
	echo "<p>Resultado guardado</p>\r\n";
?>
<script>
function RedirEditar()  {
    parent.location = 'editar.php?id=<?php echo $AsignacionDetalleId; ?>';
}
RedirEditar();
</script>

<a href="editar.php?id=<?php echo $AsignacionDetalleId; ?>">Continuar</a>

</div>

</body>

</html>