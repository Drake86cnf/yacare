<?php
	include_once 'global.php.inc';
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
<?php
	if($db_remota)
		$estoy_conectado = TRUE;
	else
		$estoy_conectado = FALSE;

	if($mac && $estoy_conectado) {
		$IdEncargadoDispositivo = $db_remota->query("SELECT Encargado_id FROM Base_Dispositivo WHERE IdentificadorUnico='$mac'")->fetchColumn();
		if($IdEncargadoDispositivo) {
                    $NombreEncargadoDispositivo = $db_remota->query("SELECT NombreVisible FROM Base_Persona WHERE id='$IdEncargadoDispositivo'")->fetchColumn();

?>
<h1>Sincronizar datos</h1>
<p>Se van a enviar los resultados que pudieran existir en este dispositivo y se van
a descargar nuevas asignaciones. Haga clic en el botón &quot;Sincronzar ahora&quot; a continuación:</p>
<p>El encargado de este dispositivo: <?php echo $IdEncargadoDispositivo . ': ' . $NombreEncargadoDispositivo ?></p>
<button onclick="parent.location='sinc.php';">Sincronizar ahora</button>
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
<p>El identificador único de este dispositivo es: <?php echo $mac; ?>.</p>
</div>

</body>

</html>

