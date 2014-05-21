<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';
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
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Inspección:: Instalar</div>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="text-primary" onclick="parent.location='/';"><i class="fa fa-reply"></i> Volver</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
<div class="row">
    <div class="hidden-xs col-sm-2 col-md-2 col-lg-4">
        <i class="fa fa-5x fa-wrench text-muted pull-right"></i>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
        <h1>Instalación inicial</h1>
<?php
    if(isset($_REQUEST['confirmar']) && $_REQUEST['confirmar']) {
        $YacareDbLocal = new PDO('sqlite:' . $YacareCarpetaRaiz . '/yacare.sqlite');
        $YacareDbLocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<p>Recreando la tabla de inspección/relevamientos/tipos de incidente: ";
        $YacareDbLocal->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoResultado;");
        $YacareDbLocal->exec("CREATE TABLE Inspeccion_RelevamientoResultado (Id INTEGER PRIMARY KEY, Nombre, Grupo);");
        echo "ok.</p>";

        echo "<p>Recreando la tabla de inspección/relevamientos/asignaciones: ";
        $YacareDbLocal->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoAsignacionDetalle");
        $YacareDbLocal->exec("CREATE TABLE Inspeccion_RelevamientoAsignacionDetalle
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
            PartidaCalle_id INTEGER DEFAULT NULL,
            ResultadosCantidad INTEGER NOT NULL DEFAULT 0,
            Suprimido INTEGER NOT NULL DEFAULT 0)");
        echo "ok</p>";
        
        echo "<p>Recreando la tabla de inspección/relevamientos/resultados: ";
        $YacareDbLocal->exec("DROP TABLE IF EXISTS Inspeccion_RelevamientoAsignacionResultado");
        $YacareDbLocal->exec("CREATE TABLE Inspeccion_RelevamientoAsignacionResultado
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
        
        echo "<p>Recreando la tabla de versión: ";
        $YacareDbLocal->exec("DROP TABLE IF EXISTS version");
        $YacareDbLocal->exec("CREATE TABLE version (ver INTEGER)");
        $YacareDbLocal->exec("INSERT INTO version (ver) VALUES (2)");
        echo "ok</p>";
?>
        <button class="btn btn-success" onclick="parent.location='/';"><i class="fa fa-thumbs-o-up"></i> Continuar</button>
<?php
    } else {
?>
    <p>Al parecer, es la primera vez que utilizar Yacaré Móvil en este equipo. Es necesario realizar una instalación inicial.</p>
    <p>¡ATENCIÓN! Al instalar la aplicación se borrarán todos los datos existentes en este dispositivo. Pulse el botón para continuar:</p>
    <button class="btn btn-warning" onclick="parent.location='instalar.php?confirmar=1';"><i class="fa fa-warning"></i> Instalar ahora</button>
<?php
    }
?>
   </div>
</div>
</div>

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>