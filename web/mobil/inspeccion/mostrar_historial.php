<?php
	include 'global.php.inc';
	include 'db_local.php.inc';
	    
	if(isset($_GET['id']))
        $AsignacionDetalleId = $_GET['id'];
?>

<body>
<div class="encab">
    <div class="encab-izquierda"><img src="yacare_logo_48bw.png" width="48px">&nbsp;Yacaré - Inspección</div>
<div class="encab-derecha">
 <button onclick="window.close();">Cerrar</button> 
</div>
</div>

<div class="contenido">
<div class="datagrid">
<table>
    <thead>
        <tr>
            <th>Incidente</th>
            <th>Observaciones</th>
            <th>Fotografia</th>
        </tr>
    </thead>
    <tbody>
<?php
    $tipoLinea = 0;
    
    $sql = "SELECT Resultado_id, Obs, Imagen FROM Inspeccion_RelevamientoAsignacionResultado WHERE Detalle_id=$AsignacionDetalleId ORDER BY CreatedAt DESC";
    foreach ($db_local->query($sql) as $row) {
        $ResultadoId = $row['Resultado_id'];
        $Obs = $row['Obs'];
        $data = $row['Imagen'];
        $Imagen = 'data:image/png' . ';base64,' . base64_encode($data);

	if($tipoLinea==0) {
		$tipoLinea = 1;    		
    		echo '<tr class="alt"';
    	} else {
    		$tipoLinea = 0;
    		echo '<tr';
    	}

        echo " style=\"cursor: hand; cursor: pointer;\">";
?>
            <td><?php echo $Incidente = $db_local->query("SELECT Nombre FROM Inspeccion_RelevamientoResultado WHERE Id=$ResultadoId")->fetchColumn(); ?></td>
            <td><?php echo $Obs; ?></td>
            <td><img src="<?php echo $Imagen; ?>" /></td>
        </tr>
<?php
	}
?>    
        </tbody>
</table>
</div>

</body>

</html>
