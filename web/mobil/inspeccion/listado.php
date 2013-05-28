<?php
	include 'global.php.inc';
	include 'db_local.php.inc';
	
	if(isset($_REQUEST['orden'])) {
	    echo $orden = $_REQUEST['orden'];
	    echo "\n\r";
        if($orden == 1) {	
    	   $ordenar = "PartidaSeccion, PartidaMacizo, PartidaParcela";
        }else if($orden == 2) { 
           echo $ordenar = "PartidaCalleNombre, PartidaCalleNumero";
        }else {
           echo $ordenar = "PartidaSeccion, PartidaMacizo, PartidaParcela";
        }
	}else {
	    echo $ordenar = "PartidaSeccion, PartidaMacizo, PartidaParcela";
	}
    
?>

<body>
<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
 <button onclick="parent.location='listado.php?orden=1';">Ordenar por Sección...</a>
 <button onclick="parent.location='listado.php?orden=2';">Ordenar por Calle</a>
 <button onclick="parent.location='actualizar.php';">Sincronizar</a> 
</div>
</div>

<div class="contenido">
<div class="datagrid">
<table>
    <thead>
        <tr>
            <th>Calle</th>
            <th>Número</th>
            <th>Sección</th>
            <th>Macizo</th>
            <th>Parcela</th>
        </tr>
    </thead>
    <tbody>
<?php
    $tipoLinea = 0;
    echo $sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Resultado1_id IS NULL ORDER BY $ordenar";
    foreach ($db_local->query($sql) as $row) {
        $Id = $row['id'];
        $PartidaCalleNombre = $row['PartidaCalleNombre'];
        $PartidaCalleNumero = $row['PartidaCalleNumero'];
        $PartidaSeccion = $row['PartidaSeccion'];
        $PartidaMacizo = $row['PartidaMacizo'];
        $PartidaParcela = $row['PartidaParcela'];

	if($tipoLinea==0) {
		$tipoLinea = 1;    		
    		echo '<tr class="alt"';
    	} else {
    		$tipoLinea = 0;
    		echo '<tr';
    	}
    	echo " onclick=\"parent.location='editar.php?id=${Id}'\" style=\"cursor: hand; cursor: pointer;\">";
?>
            <td><a href="editar.php?id=<?php echo $Id; ?>"><?php echo $PartidaCalleNombre; ?></a></td>
            <td><a href="editar.php?id=<?php echo $Id; ?>"><?php echo $PartidaCalleNumero; ?></a></td>
            <td><a href="editar.php?id=<?php echo $Id; ?>"><?php echo $PartidaSeccion; ?></a></td>
            <td><a href="editar.php?id=<?php echo $Id; ?>"><?php echo $PartidaMacizo; ?></a></td>
            <td><a href="editar.php?id=<?php echo $Id; ?>"><?php echo $PartidaParcela; ?></a></td>
        </tr>
<?php
	}
?>    
        </tbody>
</table>
</div>

</body>

</html>
