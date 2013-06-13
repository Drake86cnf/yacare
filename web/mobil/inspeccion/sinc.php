<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
	include_once 'db_remota.php.inc';
?>

<body>
<div class="encab">
<div class="encab-izquierda"><img src="yacare_logo_48bw.png" width="48px">&nbsp;Yacaré - Inspección</div>
<div class="encab-derecha">
 <button onclick="parent.location='listado.php'">Volver</a>
</div>
</div>

<div class="contenido">
<h1>Resultados de la sincronización</h1>
<?php
    $SqliteOrigen = "inspeccion.sqlite";
    $SqliteDestino = "inspeccion-backup-" . date('Ymdhis') . ".sqlite";
    copy($SqliteOrigen, $SqliteDestino);

    $AgregarColumnas = @$db_remota->exec("ALTER TABLE Inspeccion_RelevamientoAsignacionDetalle ADD COLUMN
        Resultado4_id INTEGER DEFAULT NULL,
        Resultado5_id INTEGER DEFAULT NULL,
        Resultado6_id INTEGER DEFAULT NULL
        ");
        
	$IdEncargadoDispositivo = $db_remota->query("SELECT Encargado_id FROM Base_Dispositivo WHERE IdentificadorUnico='$mac'")->fetchColumn();
	$IdRelevamientoActual = $db_remota->query("SELECT MAX(id) FROM Inspeccion_Relevamiento")->fetchColumn();

	// ********************** Traigo tipos de Incidentes
	echo "<p>Recibiendo tipos de incidente: ";
	$db_local->exec("DROP TABLE Inspeccion_RelevamientoResultado;");
	$db_local->exec("CREATE TABLE Inspeccion_RelevamientoResultado (Id INTEGER PRIMARY KEY, Nombre, Grupo);");

	$cantidad_tipo_incidente = 0;
	$sql = "SELECT id, Nombre, Grupo FROM Inspeccion_RelevamientoResultado";
	foreach ($db_remota->query($sql) as $row) {
		$cantidad_tipo_incidente++;
		$Id = $row['id'];
		$Nombre = $row['Nombre'];
		$Grupo = $row['Grupo'];

		$db_local->exec("INSERT INTO Inspeccion_RelevamientoResultado VALUES ($Id, '$Nombre', '$Grupo');");
	}

	echo "se importaron $cantidad_tipo_incidente registros.</p>";
	//$db_local->exec("CREATE TABLE Inspeccion_RelevamientoResultadoTipo (Id, Nombre, Grupo);");

	// ********************** Envío Relevamientos realizados
    /* 
	echo "Enviando detalles: ";
	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Resultado1_id > 0 OR Resultado1_id IS NOT NULL";
	$cantidad_relevamiento = 0;
	foreach ($db_local->query($sql) as $row) {
		$cantidad_relevamiento++;	
		$Id = $row['id'];
		$Obs = $row['ResultadoObs'];
		$Img = $row['Imagen'];
		$Ubicacion = $row['ResultadoUbicacion'];
                $Resultado1 = $row['Resultado1_id'] ? $row['Resultado1_id'] : 'NULL';
		$Resultado2 = $row['Resultado2_id'] ? $row['Resultado2_id'] : 'NULL';
		$Resultado3 = $row['Resultado3_id'] ? $row['Resultado3_id'] : 'NULL';
		$Resultado4 = $row['Resultado4_id'] ? $row['Resultado4_id'] : 'NULL';
		$Resultado5 = $row['Resultado5_id'] ? $row['Resultado5_id'] : 'NULL';
		$Resultado6 = $row['Resultado6_id'] ? $row['Resultado6_id'] : 'NULL';
		$update = $db_remota->prepare("UPDATE Inspeccion_RelevamientoAsignacionDetalle
			SET Resultado1_id=$Resultado1,
				Resultado2_id=$Resultado2,
				Resultado3_id=$Resultado3,
				Resultado4_id=$Resultado4,
				Resultado5_id=$Resultado5,
				Resultado6_id=$Resultado6,
				ResultadoObs=:resultadoobs,
				Imagen=:imagen,
				ResultadoUbicacion=:resultadoubicacion,
				UpdatedAt=NOW(),
				Version=Version+1
			WHERE id=:id");
		$update->bindValue('resultadoobs', $Obs, PDO::PARAM_STR);
		$update->bindValue('imagen', $Img, PDO::PARAM_LOB);
		$update->bindValue('resultadoubicacion', $Ubicacion, PDO::PARAM_STR);
		$update->bindValue('id', $Id, PDO::PARAM_INT);
		$update->execute();
        if($update->rowCount()) {
			$db_local->exec("DELETE FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id=$Id");
		}
	}
	echo "se exportaron $cantidad_relevamiento registros.</p>";
     */

    
    // ********************** Envío Relevamientos realizados 2
	echo "Enviando resultados: ";
	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionResultado";
	$cantidad_resultado = 0;
	foreach ($db_local->query($sql) as $row) {
		$cantidad_resultado++;	
		$insert = $db_remota->prepare("INSERT INTO Inspeccion_RelevamientoAsignacionResultado
            (Detalle_id, Resultado_id, Obs, Imagen, Ubicacion, UpdatedAt, CreatedAt, Version)
			VALUES
            (:detalle_id, :resultado_id, :obs, :imagen,:ubicacion, NOW(), NOW(), 1)");
		$insert->bindValue('obs', $row['Obs'], PDO::PARAM_STR);
		$insert->bindValue('imagen', $row['Imagen'], PDO::PARAM_LOB);
		$insert->bindValue('ubicacion', $row['Ubicacion'], PDO::PARAM_STR);
        $insert->bindValue('resultado_id', $row['Resultado_id'], PDO::PARAM_INT);
        $insert->bindValue('detalle_id', $row['Detalle_id'], PDO::PARAM_INT);
        $insert->execute();
		if($insert->rowCount()) {
            $db_remota->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET ResultadosCantidad=ResultadosCantidad+1 WHERE id=" . $row['Detalle_id']);
            $db_remota->exec("UPDATE Inspeccion_RelevamientoAsignacion SET DetallesResultadosCantidad=DetallesResultadosCantidad+1 WHERE id=" . $row['Asignacion_id']);
			$db_local->exec("DELETE FROM Inspeccion_RelevamientoAsignacionResultado WHERE id=${row['id']}");
		}
	}
	echo "se exportaron $cantidad_resultado registros.</p>";
    
    
    
    // ********************** Recibir asignaciones nuevas
	echo "<p>Recibiendo asignaciones: ";
	$cantidad_incidente = 0;
	$cantidad_incidente_salteado = 0;
	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle
		WHERE Encargado_id=$IdEncargadoDispositivo
			AND Relevamiento_id=$IdRelevamientoActual
			AND ResultadosCantidad=0";
	foreach ($db_remota->query($sql) as $row) {
		$Id = $row['id'];
		$CreatedAt = $row['CreatedAt'];
		$UpdatedAt = $row['UpdatedAt'];
		$Version = $row['Version'];
		$Relevamiento_id = $row['Relevamiento_id'];
		$Asignacion_id = $row['Asignacion_id'];
		$Partida_id = $row['Partida_id'];
		$PartidaSeccion = $row['PartidaSeccion'];
		$PartidaMacizo = $row['PartidaMacizo'];
		$PartidaParcela = $row['PartidaParcela'];
		$PartidaCalleNombre = $row['PartidaCalleNombre'];
		$PartidaCalleNumero = $row['PartidaCalleNumero'];
		$Encargado_id = $row['Encargado_id'];
		$PartidaCalle_id = $row['PartidaCalle_id'] ? $row['PartidaCalle_id'] : 'NULL';
        $ResultadosCantidad = (int)$row['ResultadosCantidad'];
		
		// Si existen resultados para el registro que estoy por importar, no lo importo
		// para no pisar el trabajo hecho
		$registro_actual = $db_local->query("SELECT id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id=$Id AND ResultadosCantidad<>0")->fetchColumn();
		if($registro_actual == $Id) {
			$cantidad_incidente_salteado++;
		} else {
			$cantidad_incidente++;
            $sql = "REPLACE INTO Inspeccion_RelevamientoAsignacionDetalle 
					(id,
					CreatedAt,
					UpdatedAt,
					Version,
					Relevamiento_id,
					Asignacion_id,
					Partida_id,
					PartidaSeccion,
					PartidaMacizo,
					PartidaParcela,
					PartidaCalleNombre,
					PartidaCalleNumero,
					Encargado_id,
					PartidaCalle_id,
                    ResultadosCantidad)
				VALUES ($Id,
					'$CreatedAt',
					'$UpdatedAt',
					$Version,
					$Relevamiento_id,
					$Asignacion_id,
					$Partida_id,
					'$PartidaSeccion',
					'$PartidaMacizo',
					'$PartidaParcela',
					'$PartidaCalleNombre',
					'$PartidaCalleNumero',
					$Encargado_id,
					$PartidaCalle_id,
                    $ResultadosCantidad)";
			//echo $sql;
            $db_local->exec($sql);
		}
	}
	echo "se importaron $cantidad_incidente registros, se saltearon $cantidad_incidente_salteado.</p>";

?>

<script>
window.setTimeout(RedireccionarSinc, 10000);
function RedireccionarSinc() {
    window.location='listado.php';
}
</script>
</div>

</body>

</html>
