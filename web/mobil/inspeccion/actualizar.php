<?php
	include 'global.php.inc';
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

$cantidad_archivos = 0;
$cantidad_errores = 0;

if($_SERVER['HTTP_HOST'] == 'webmuni' || $debug) {
        echo "No se descargan actualizaciones.";
} else {
	$carpeta_destino = dirname($_SERVER['SCRIPT_FILENAME']);
	if(substr($carpeta_destino, -1) != '/')
		$carpeta_destino .= '/';

	$lista_archivos = fopen("http://192.168.100.5/yacare/mobil/inspeccion/actualizar.txt", 'r');

	if($lista_archivos) {
		while(!feof($lista_archivos)) {
			$archivo = trim(fgets($lista_archivos));
			if($archivo) {
				$contenido = file_get_contents('http://192.168.100.5/yacare/mobil/inspeccion/' . $archivo . '.yuf');
                                if($carpeta_destino . $archivo)
                                    $contenido_actual = @file_get_contents($carpeta_destino . $archivo);
                                else
                                    $contenido_actual = null;
				
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
	fclose($lista_archivos);
}
?>

<p>Se actualizaron <?php echo $cantidad_archivos; ?> archivos.</p>
<p><a href="presinc.php">Haga clic aquí para continuar.</a></p>

<script type="text/javascript">
<?php
    if(false) {
?>
window.location='presinc.php';
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

</body>

</html>