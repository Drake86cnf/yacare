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
<h1>Instalación</h1>
<?php
    if(isset($_REQUEST['confirmar']) && $_REQUEST['confirmar']) {
	echo "<p>Recreando la tabla de tipos de incidente: ";
	$db_local->exec("DROP TABLE Inspeccion_RelevamientoResultado;");
	$db_local->exec("CREATE TABLE Inspeccion_RelevamientoResultado (Id INTEGER PRIMARY KEY, Nombre, Grupo);");
	echo "ok.</p>";

        echo "<p>Recreando la tabla de resultados: ";
	$db_local->exec("DROP TABLE Inspeccion_RelevamientoAsignacionDetalle");
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
		Imagen BLOB,
		ResultadoUbicacion,
		Resultado2_id INTEGER DEFAULT NULL,
		Resultado3_id INTEGER DEFAULT NULL,
		PartidaCalle_id INTEGER DEFAULT NULL)");

	echo "ok</p>";
    } else {
?>
<p>¡ATENCIÓN! Al instalar la aplicación se borrarán todos los datos existentes en este dispositivo.</p>
<button onclick="parent.location='instalar.php?confirmar=1';">Instalar ahora</button>
<?php
    }
?>
</div>

</body>

</html>
