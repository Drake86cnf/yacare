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
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Panel de control</div>
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
        <h1>Panel de control</h1>

        <p>El identificador único de este dispositivo es: <strong class="text-primary"><?php echo $mac; ?></strong>.</p>
        
        <hr />
        
        <h2>General</h2>
        <button class="btn btn-primary" onclick="parent.location='/actualizar/?esperar=1&ret=%2Fadmin%2F';"><i class="fa fa-download"></i> Actualizar aplicación</button>
        
        <hr />
        
        <h2>Inspección</h2>
        <button class="btn btn-primary" onclick="parent.location='/admin/instalar.php';"><i class="fa fa-warning"></i> Instalación inicial</button>

        <hr />
        
        <h2>Dearrollo</h2>
        <p>La aplicación se encuentra en modo: <?php if($YacareModoDesarrollo) { echo 'desarrollo'; } else { echo 'normal'; } ?></p>
        <?php if($YacareModoDesarrollo) { ?>
            <button class="btn btn-danger" onclick="PonerEnModoDesarrollo(0);"><i class="fa fa-warning"></i> Cambiar a modo normal</button>
        <?php } else { ?>
            <button class="btn btn-danger" onclick="PonerEnModoDesarrollo(1);"><i class="fa fa-warning"></i> Cambiar a modo de desarrollo</button>
        <?php } ?>
    </div>
</div>
</div>

<script>
function PonerEnModoDesarrollo(sino) {
    var conf = confirm("¿Está seguro de que desea continuar? Por favor no cambie el modo de la aplicación si no está seguro de lo que está haciendo.");
        if(conf) {
            parent.location='debug.php?debug=' + sino;
        }
}
</script>
    
<?php
    require_once '../footer.php.inc';
?>
</body>

</html>