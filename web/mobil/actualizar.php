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
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Inspección:: Actualizar</div>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="text-primary" onclick="parent.location='../';"><i class="fa fa-reply"></i> Volver</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
<div class="row">
    <div class="hidden-xs col-sm-2 col-md-2 col-lg-4">
        <i class="fa fa-5x fa-download text-muted pull-right"></i>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
<h1>Actualización automática</h1>
<?php

clearstatcache();
ini_set('realpath_cache_size', 0);

$cantidad_archivos = 0;
$cantidad_errores = 0;

if(isset($_REQUEST['ret'])) {
    $RetAddress = $_REQUEST['ret'];
} else {
    $RetAddress = '../';
}

if($_SERVER['HTTP_HOST'] === 'webmuni' || $YacareModoDesarrollo) {
        echo "No se descargan actualizaciones.";
} else {
	$carpeta_destino = dirname($_SERVER['SCRIPT_FILENAME']);
	if(substr($carpeta_destino, -1) != '/') {
                $carpeta_destino .= '/';
        }
        
        $ch = curl_init("http://192.168.100.5/yacare/mobil/actualizar.zip");
        $fp = fopen($carpeta_destino . 'actualizar.zip', 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        $zip = new ZipArchive;
        if ($zip->open($carpeta_destino . 'actualizar.zip') === TRUE) {
                if($zip->extractTo($carpeta_destino)) {
                        $cantidad_archivos++;
                }
                $zip->close();
        }

	/* $lista_archivos = fopen("http://192.168.100.5/yacare/mobil/inspeccion/actualizar.txt", 'r');

	if($lista_archivos) {
		while(!feof($lista_archivos)) {
			$archivo = trim(fgets($lista_archivos));
			if($archivo) {
				$contenido = file_get_contents('http://192.168.100.5/yacare/mobil/inspeccion/' . $archivo . '.yuf');
                                if(file_exists($carpeta_destino . $archivo)) {
                                    $contenido_actual = @file_get_contents($carpeta_destino . $archivo);
                                } else {
                                    $contenido_actual = null;
                                }
				
                                if($contenido) {
                                    if($contenido != $contenido_actual) {
                                        file_put_contents($carpeta_destino . $archivo, $contenido);
                                        $cantidad_archivos++;
                                    }
				} else {
                                    $cantidad_errores++;
                                }
			}
		}
	}
	fclose($lista_archivos); */
}
?>

<p>Se actualizaron <?php echo $cantidad_archivos ?> archivos y hubo <?php echo $cantidad_errores ?> errores.</p>
<p><a class="btn btn-primary" href="<?php echo $RetAddress ?>"><i class="fa fa-check"></i> Continuar</a></p>

<script type="text/javascript">
<?php
    if($cantidad_archivos == 0 && $cantidad_errores == 0) {
?>
window.setTimeout(RedireccionarSinc, 500);
function RedireccionarSinc() {
    window.location='<?php echo $RetAddress ?>';
}
window.location='<?php echo $RetAddress ?>';
<?php
    } else {
?>
window.setTimeout(RedireccionarSinc, 4000);
function RedireccionarSinc() {
    window.location='<?php echo $RetAddress ?>';
}
<?php
    }
?>
</script>
    </div>
</div>
</div>

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>