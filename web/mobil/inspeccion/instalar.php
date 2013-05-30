<?php
	include_once 'global.php.inc';
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
        include_once 'db_local.php.inc';
        include_once 'db_remota.php.inc';

        echo "<p>Recreando la tabla de tipos de incidente: ";
        $db_local->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoResultado;");
        $db_local->exec("CREATE TABLE Inspeccion_RelevamientoResultado (Id INTEGER PRIMARY KEY, Nombre, Grupo);");
        echo "ok.</p>";

        echo "<p>Recreando la tabla de asignaciones: ";
        $db_local->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoAsignacionDetalle");
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
            Resultado2_id INTEGER DEFAULT NULL,
            Resultado3_id INTEGER DEFAULT NULL,
            Resultado4_id INTEGER DEFAULT NULL,
            Resultado5_id INTEGER DEFAULT NULL,
            Resultado6_id INTEGER DEFAULT NULL,
            PartidaCalle_id INTEGER DEFAULT NULL,
            ResultadosCantidad_id INTEGER NOT NULL,
            ResultadoObs,
            Imagen BLOB,
            ResultadoUbicacion)");
        echo "ok</p>";
        
        echo "<p>Recreando la tabla de resultados: ";
        $db_local->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoAsignacionResultado");
        $db_local->exec("CREATE TABLE Inspeccion_RelevamientoAsignacionResultado
            (id INTEGER PRIMARY KEY,
            CreatedAt,
            UpdatedAt,
            Version INTEGER,
            Relevamiento_id INTEGER DEFAULT NULL,
            Asignacion_id INTEGER DEFAULT NULL,
            Detalle_id INTEGER DEFAULT NULL,
            Encargado_id INTEGER DEFAULT NULL,
            Resultado_id INTEGER DEFAULT NULL,
            Partida_id INTEGER DEFAULT NULL,
            PartidaCalle_id INTEGER DEFAULT NULL,
            PartidaSeccion DEFAULT NULL,
            PartidaMacizo DEFAULT NULL,
            PartidaParcela DEFAULT NULL,
            PartidaCalleNombre DEFAULT NULL,
            PartidaCalleNumero DEFAULT NULL,
            Obs,
            Imagen BLOB,
            Ubicacion)");

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
