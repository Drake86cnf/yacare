<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';

    require_once '../db_local.php.inc';
?>

<script>
    parent.location = 'editar.php?id=<?php echo $AsignacionDetalleId ?>';
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

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="text-primary" onclick="parent.location='listado.php'"><i class="fa fa-reply"></i> Continuar</a></li>
            </ul>
        </div>
    </div>
</nav>
    
<div class="contenido">
<?php		
    $AsignacionDetalleId = (int)$_POST['id'];
    $AsignacionId = (int)$_POST['asignacion_id'];
    $Resultado = $_POST['Resultado'] ? $_POST['Resultado'] : 'NULL';

    $Obs = $_POST['Obs'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];

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
    
    $insert = $YacareDbLocal->prepare("INSERT INTO Inspeccion_RelevamientoAsignacionResultado
        (CreatedAt, UpdatedAt, Version, Detalle_id, Asignacion_id, Resultado_id, Obs, Imagen, Ubicacion) 
        VALUES (
            datetime(),
            datetime(),
            1,
            :detalle_id,
            :asignacion_id,
            :resultado_id,
            :obs,
            :imagen,
            :ubicacion)");
    $insert->bindValue('detalle_id', $AsignacionDetalleId, PDO::PARAM_INT);
    $insert->bindValue('asignacion_id', $AsignacionId, PDO::PARAM_INT);
    $insert->bindValue('resultado_id', $Resultado, PDO::PARAM_INT);
    $insert->bindValue('obs', $Obs, PDO::PARAM_STR);
    $insert->bindValue('ubicacion', $Ubicacion, PDO::PARAM_STR);
    $insert->bindValue('imagen', $imagen_binario, PDO::PARAM_LOB);
    
    if($insert->execute()) {
        $YacareDbLocal->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET ResultadosCantidad=ResultadosCantidad+1 WHERE id=$AsignacionDetalleId");
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

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>