<?php
	include_once 'global.php.inc';
	include_once 'db_local.php.inc';
	include_once 'db_remota.php.inc';
?>

<body>
<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button onclick="parent.location='listado.php'">Volver</a>
</div>
</div>

<div class="contenido">
<h1>Resultados de la sincronización</h1>
<?php
	$IdEncargadoDispositivo = $db_remota->query("SELECT Encargado_id FROM Base_Dispositivo WHERE IdentificadorUnico='$mac'")->fetchColumn();
	$IdRelevamientoActual = $db_remota->query("SELECT MAX(id) FROM Inspeccion_Relevamiento")->fetchColumn();

	//Traigo tipos de Incidentes
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

	// Envío Relevamientos realizados
	echo "Enviando detalles: ";
	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Resultado1_id > 0 OR Resultado1_id IS NOT NULL";
	$cantidad_relevamiento = 0;
	foreach ($db_local->query($sql) as $row) {
		$cantidad_relevamiento++;	
		$Id = $row['id'];
		$Obs = $row['ResultadoObs'];
		$Img = $row['ResultadoImagen'];
		$Ubicacion = $row['ResultadoUbicacion'];
                $Resultado1 = $row['Resultado1_id'] ? $row['Resultado1_id'] : 'NULL';
		$Resultado2 = $row['Resultado2_id'] ? $row['Resultado2_id'] : 'NULL';
		$Resultado3 = $row['Resultado3_id'] ? $row['Resultado3_id'] : 'NULL';
		$update = $db_remota->prepare("UPDATE Inspeccion_RelevamientoAsignacionDetalle
			SET Resultado1_id=$Resultado1,
				Resultado2_id=$Resultado2,
				Resultado3_id=$Resultado3,
				ResultadoObs=:resultadoobs,
				ResultadoImagen=:resultadoimagen,
				ResultadoUbicacion=:resultadoubicacion,
				UpdatedAt=NOW(),
				Version=Version+1
			WHERE id=:id");
		$update->bindValue('resultadoobs', $Obs, PDO::PARAM_STR);
		$update->bindValue('resultadoimagen', $Img, PDO::PARAM_LOB);
		$update->bindValue('resultadoubicacion', $Ubicacion, PDO::PARAM_STR);
		$update->bindValue('id', $Id, PDO::PARAM_INT);
		if($update->execute()) {
			$db_local->exec("DELETE FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id=$Id");
		}
		//echo "UPDATE Inspeccion_RelevamientoAsignacionDetalle SET Resultado1_id=$Resultado1, Resultado2_id=$Resultado2, Resultado3_id=$Resultado3, ResultadoObs='$Obs', ResultadoImagen='$Img', ResultadoUbicacion=$Ubicacion WHERE id='$Id';";
	}
	echo "se exportaron $cantidad_relevamiento registros.</p>";
		
	// Traigo asignaciones (relevamientos a realizar)
	/* $db_local->exec("DROP TABLE Inspeccion_RelevamientoAsignacionDetalle");
	$db_local->exec("CREATE TABLE Inspeccion_RelevamientoAsignacionDetalle
		(id INTEGER PRIMARY KEY,
		CreatedAt,
		UpdatedAt,
		Version INTEGER DEFAULT NULL,
		Relevamiento_id INTEGER DEFAULT NULL,
		Asignacion_id INTEGER DEFAULT NULL,
		Partida_id INTEGER DEFAULT NULL,
		PartidaSeccion,
		PartidaMacizo,
		PartidaParcela,
		PartidaCalleNombre,
		PartidaCalleNumero,
		Encargado_id INTEGER DEFAULT NULL,
		Resultado1_id INTEGER DEFAULT NULL,
		ResultadoObs,
		ResultadoImagen BLOB,
		ResultadoUbicacion,
		Resultado2_id INTEGER DEFAULT NULL,
		Resultado3_id INTEGER DEFAULT NULL,
		PartidaCalle_id INTEGER DEFAULT NULL)"); */

	echo "<p>Recibiendo asignaciones: ";
	$cantidad_incidente = 0;
	$cantidad_incidente_salteado = 0;
	$sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle
		WHERE Encargado_id=$IdEncargadoDispositivo
			AND Relevamiento_id=$IdRelevamientoActual
			AND Resultado1_id IS NULL";
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
		$PartidaCalle_id = $row['PartidaCalle_id'];
		
		// Si existen resultados para el registro que estoy por importar, no lo importo
		// para no pisar el trabajo hecho
		$registro_actual = $db_local->query("SELECT id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id=$Id AND Resultado1_id IS NOT NULL")->fetchColumn();
		if($registro_actual == $Id) {
			$cantidad_incidente_salteado++;
		} else {
			$cantidad_incidente++;
			$db_local->exec("REPLACE INTO Inspeccion_RelevamientoAsignacionDetalle 
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
					PartidaCalle_id)
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
					$PartidaCalle_id)");
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
