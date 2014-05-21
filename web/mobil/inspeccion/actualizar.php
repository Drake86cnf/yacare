<?php
    include 'global.php.inc';
    include 'head.php.inc';
?>

<body>
<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button onclick="parent.location='listado.php'">Volver</a>
</div>
</div>

<div class="contenido">
<h1>Actualización automática</h1>
<?php

clearstatcache();
ini_set('realpath_cache_size', 0);

$cantidad_archivos = 0;
$cantidad_errores = 0;

if($_SERVER['HTTP_HOST'] === 'webmuni' || $debug) {
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
        
        include 'actualizar_db.php';
}
?>

<p>Se actualizaron <?php echo $cantidad_archivos ?> archivos y hubo <?php echo $cantidad_errores ?> errores.</p>
<p><a href="presinc.php">Haga clic aquí para continuar.</a></p>

<script type="text/javascript">
<?php
    if($cantidad_archivos == 0 && $cantidad_errores == 0) {
?>
window.setTimeout(RedireccionarSinc, 400);
function RedireccionarSinc() {
    window.location='presinc.php';
}

<?php
    } else {
?>
window.setTimeout(RedireccionarSinc, 4000);
function RedireccionarSinc() {
    window.location='presinc.php';
}
<?php
    }
?>
</script>
</div>

<?php
    include 'footer.php.inc';
?>
</body>

</html>