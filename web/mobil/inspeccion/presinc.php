<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';
    
    require_once '../db_remota.php.inc';
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
<?php
    
    include '../admin/actualizar_db.php';
    
    if ($YacareDbRemota) {
        $estoy_conectado = TRUE;
    } else {
        $estoy_conectado = FALSE;
    }

    if ($mac && $estoy_conectado) {
        $Dispositivo = $YacareDbRemota->query("SELECT id, Encargado_id, Marca, Modelo, Comentario FROM Base_Dispositivo WHERE IdentificadorUnico='$mac'")->fetch();
        if ($Dispositivo && $Dispositivo['Encargado_id']) {
            $IdDispositivo = (int) ($Dispositivo['Encargado_id']);
            $DispositivoEncargado = $YacareDbRemota->query("SELECT id, NombreVisible FROM Base_Persona WHERE id=$IdDispositivo")->fetch();
            ?>
            <h1>Sincronizar datos</h1>
            <p>Se van a enviar los resultados que pudieran existir en este dispositivo y se van
                a descargar nuevas asignaciones. Haga clic en el botón &quot;Sincronzar ahora&quot; a continuación:</p>
            <p>El encargado de este dispositivo: <?php echo $DispositivoEncargado['NombreVisible'] . ' (' . $Dispositivo['Encargado_id'] . ')' ?></p>
            <p>Información del dispositivo: <?php echo $Dispositivo['Marca'] . ' ' . $Dispositivo['Modelo'] . ' (' . $Dispositivo['Comentario'] . ')' ?></p>
            <button class="btn btn-primary" onclick="parent.location='sinc.php';"><i class="fa fa-refresh"></i> Sincronizar ahora</button>
            <script>
                window.setTimeout(RedireccionarSinc, 10000);
                function RedireccionarSinc() {
                    window.location = 'sinc.php';
                }
            </script>
            <?php
        } else {
            ?>
            <h1>Sincronizar datos</h1>
            <p>Este dispositivo aun no fue dado de alta para la sincronización. Por favor póngase en contacto con
                el área de desarrollo al interno número 253.</p>
            <?php
        }
    } else {
        ?>
        <h1>Error de conexión</h1>
        <p>Para poder sincronizar los datos es necesario que esté conectado a la red municipal
            (normalmente por medio de una conexión inalámbrica WiFi). Si se encuentra en una zona
            de cobertura WiFi habilitada, verifique que la conexión WiFi del dispositivo esté
            habilitada. Si el problema persiste, póngase en contacto con el área de desarrollo
            al interno número 253.
        </p>
        <?php
    }
    ?>
    <p>El identificador único de este dispositivo es: <strong class="text-primary"><?php echo $mac; ?></strong>.</p>
    </div>
</div>
</div>

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>

