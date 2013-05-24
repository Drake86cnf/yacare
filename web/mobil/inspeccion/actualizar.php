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
<h1>Resultados de la actualización</h1>
<ul>
<?php

$cantidad_archivos = 0;

if($_SERVER['HTTP_HOST'] == 'webmuni' || $debug) {
        echo "No se descargan actualizaciones.";
} else {
	$carpeta_destino = dirname($_SERVER['SCRIPT_FILENAME']);
	if(substr($carpeta_destino, -1) != '/')
		$carpeta_destino .= '/';
	echo "<p>Carpeta de destino: $carpeta_destino</p>";

	$lista_archivos = fopen("http://192.168.100.5/yacare/mobil/inspeccion/actualizar.txt", 'r');

	if($lista_archivos) {
		while(!feof($lista_archivos)) {
			$archivo = trim(fgets($lista_archivos));
			if($archivo) {
				echo "<li>$archivo: ";
				$contenido = file_get_contents('http://192.168.100.5/yacare/mobil/inspeccion/' . $archivo . '.yuf');
				if($contenido) {
					echo " actualizado";
					file_put_contents($carpeta_destino . $archivo, $contenido);
					$cantidad_archivos++;
				} else {
					echo "error";
				}
				echo "</li>";
			}
		}
	}
	fclose($lista_archivos);
}
?>
</ul>

<p>Se actualizaron <?php echo $cantidad_archivos; ?> archivos.</p>
<p><a href="presinc.php">Haga clic aquí para continuar.</a></p>

<script type="text/javascript">
window.location='presinc.php';
</script>
</div>

</body>

</html>

