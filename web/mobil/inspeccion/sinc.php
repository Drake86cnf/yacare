<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';
    
    require_once '../db_remota.php.inc';
    require_once '../db_local.php.inc';
?>

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
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Inspección :: Sincronizar</div>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="text-primary" onclick="parent.location='listado.php';"><i class="fa fa-reply"></i> Volver</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
<div class="row">
    <div class="hidden-xs col-sm-2 col-md-2 col-lg-4">
        <i class="fa fa-5x fa-refresh text-muted pull-right"></i>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
        <h1>Resultados de la sincronización</h1>
<?php
    // Hago una copia de seguridad de la base de datos actual
    copy($YacareCarpetaRaiz . '/yacare.sqlite', $YacareCarpetaRaiz . '/yacare-backup-' . date('Ymdhis') . '.sqlite');

    $IdEncargadoDispositivo = $YacareDbRemota->query("SELECT Encargado_id FROM Base_Dispositivo WHERE IdentificadorUnico='$mac'")->fetchColumn();
    //$IdRelevamientoActual = $YacareDbRemota->query("SELECT MAX(id) FROM Inspeccion_Relevamiento WHERE Suprimido=0")->fetchColumn();

    // ********************** Traigo tipos de Incidentes
    echo "<p>Recibiendo tipos de incidente: ";
    $YacareDbLocal->exec("DROP TABLE Inspeccion_RelevamientoResultado;");
    $YacareDbLocal->exec("CREATE TABLE Inspeccion_RelevamientoResultado (Id INTEGER PRIMARY KEY, Nombre, Grupo);");

    $cantidad_tipo_incidente = 0;
    $sql = "SELECT id, Nombre, Grupo FROM Inspeccion_RelevamientoResultado";
    foreach ($YacareDbRemota->query($sql) as $row) {
        $cantidad_tipo_incidente++;
        $Id = $row['id'];
        $Nombre = $row['Nombre'];
        $Grupo = $row['Grupo'];

        $YacareDbLocal->exec("INSERT INTO Inspeccion_RelevamientoResultado VALUES ($Id, '$Nombre', '$Grupo');");
    }

    echo "se importaron $cantidad_tipo_incidente registros.</p>";
    //$YacareDbLocal->exec("CREATE TABLE Inspeccion_RelevamientoResultadoTipo (Id, Nombre, Grupo);");
    // ********************** Envío Relevamientos realizados 2
    echo "Enviando resultados: ";
    $sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionResultado";
    $cantidad_resultado = 0;
    foreach ($YacareDbLocal->query($sql) as $row) {
        $insert = $YacareDbRemota->prepare("INSERT INTO Inspeccion_RelevamientoAsignacionResultado
            (Detalle_id, Resultado_id, Obs, Imagen, Ubicacion, UpdatedAt, CreatedAt, Version)
                    VALUES
            (:detalle_id, :resultado_id, :obs, :imagen,:ubicacion, NOW(), NOW(), 1)");
        $insert->bindValue('obs', $row['Obs'], PDO::PARAM_STR);
        $insert->bindValue('imagen', $row['Imagen'], PDO::PARAM_LOB);
        $insert->bindValue('ubicacion', $row['Ubicacion'], PDO::PARAM_STR);
        $insert->bindValue('resultado_id', $row['Resultado_id'], PDO::PARAM_INT);
        $insert->bindValue('detalle_id', $row['Detalle_id'], PDO::PARAM_INT);
        $insert->execute();
        if ($insert->rowCount()) {
            $YacareDbRemota->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET ResultadosCantidad=ResultadosCantidad+1 WHERE id=" . $row['Detalle_id']);
            $YacareDbRemota->exec("UPDATE Inspeccion_RelevamientoAsignacion SET DetallesResultadosCantidad=DetallesResultadosCantidad+1 WHERE id=" . $row['Asignacion_id']);
            $YacareDbLocal->exec("DELETE FROM Inspeccion_RelevamientoAsignacionResultado WHERE id=${row['id']}");
            $cantidad_resultado++;
        }
    }
    echo "se exportaron $cantidad_resultado registros.</p>";

    // ********************** Recibir asignaciones nuevas
    echo "<p>Recibiendo asignaciones: ";
    $cantidad_incidente = 0;
    $cantidad_incidente_salteado = 0;
    $IdsExistentes = array();   // Array para almacenar los id de los registros no suprimidos (ver más abajo)
    $sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle
            WHERE Encargado_id=$IdEncargadoDispositivo
                    AND Relevamiento_id IN (SELECT id FROM Inspeccion_Relevamiento WHERE Suprimido=0)
                    AND Asignacion_id IN (SELECT id FROM Inspeccion_RelevamientoAsignacion WHERE Suprimido=0)
                    AND ResultadosCantidad=0";
    foreach ($YacareDbRemota->query($sql) as $row) {
        $Id = $row['id'];
        $CreatedAt = $row['createdAt'];
        $UpdatedAt = $row['updatedAt'];
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
        $ResultadosCantidad = (int) $row['ResultadosCantidad'];


        $IdsExistentes[] = $Id;
        // Si existen resultados para el registro que estoy por importar, no lo importo
        // para no pisar el trabajo hecho
        $registro_actual = $YacareDbLocal->query("SELECT id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE id=$Id AND ResultadosCantidad<>0")->fetchColumn();
        if ($registro_actual == $Id) {
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
                                    ResultadosCantidad,
                                    Suprimido)
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
                                    " . $YacareDbLocal->quote($PartidaCalleNombre) . ",
                                    '$PartidaCalleNumero',
                                    $Encargado_id,
                                    $PartidaCalle_id,
                                    $ResultadosCantidad,
                                    0)";
            //echo $sql;
            $YacareDbLocal->exec($sql);
        }
    }
    
    echo "se importaron $cantidad_incidente registros, se saltearon $cantidad_incidente_salteado.</p>";

    // Marco como suprimido todo aquello que no haya sido importado, para eliminar registros obsoletos.
    if(count($IdsExistentes) > 0) {
        $Afectados = $YacareDbLocal->exec("UPDATE Inspeccion_RelevamientoAsignacionDetalle SET Suprimido=1 WHERE id NOT IN (" . join(',', $IdsExistentes) . ")");
        echo "<p>Se suprimieron $Afectados registros</p>";
    }

    $YacareDbRemota->exec("UPDATE Inspeccion_RelevamientoAsignacionResultado
    SET Inspeccion_RelevamientoAsignacionResultado.Asignacion_id=(
        SELECT Inspeccion_RelevamientoAsignacionDetalle.Asignacion_id FROM Inspeccion_RelevamientoAsignacionDetalle
            WHERE Inspeccion_RelevamientoAsignacionDetalle.id=Inspeccion_RelevamientoAsignacionResultado.Detalle_id
    );");
    $YacareDbRemota->exec("UPDATE Inspeccion_RelevamientoAsignacion
    SET DetallesResultadosCantidad=(
        SELECT COUNT(id) FROM Inspeccion_RelevamientoAsignacionResultado
            WHERE Inspeccion_RelevamientoAsignacionResultado.Asignacion_id=Inspeccion_RelevamientoAsignacion.id
    );");
?>

        <script>
            window.setTimeout(RedireccionarSinc, 10000);
            function RedireccionarSinc() {
                window.location = 'listado.php';
            }
        </script>
    </div>
</div>
</div>

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>
