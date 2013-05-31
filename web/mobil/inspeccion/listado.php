<?php
	include 'global.php.inc';
	include 'db_local.php.inc';
	
    if(isset($_GET['orden']))
        $ListadoVer = (int)$_GET['ver'];
    else
        $ListadoVer = 0;
    
	if(isset($_GET['orden'])) {
        $ListadoOrdenar = $_GET['orden'];
	} else {
        if(isset($_COOKIE['YacareAsignacionesListadoOrdenar'])) {
            $ListadoOrdenar = $_COOKIE['YacareAsignacionesListadoOrdenar'];
        } else {
            $ListadoOrdenar = 1;
        }
    }
?>

<body>
<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
<?php
    if($ListadoOrdenar != 1) {
?>
 <button onclick="parent.location='listado.php?orden=1&ver=<?php echo $ListadoVer ?>';">Ordenar por sección</a>
<?php
    }
    if($ListadoOrdenar != 2) {
?>
 <button onclick="parent.location='listado.php?orden=2&ver=<?php echo $ListadoVer ?>';">Ordenar por calle</a>
<?php
    }
    if($ListadoVer != 0) {
?>
 <button onclick="parent.location='listado.php?orden=<?php echo $ListadoOrdenar ?>&ver=0';">Ver pendientes</a>
<?php
    }
    if($ListadoVer != 1) {
?>
 <button onclick="parent.location='listado.php?orden=<?php echo $ListadoOrdenar ?>&ver=1';">Ver todos</a>
<?php
    }
?> 
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
    
    if($ListadoOrdenar == 1) {	
        $ListadoOrdenarSql = "PartidaSeccion, PartidaMacizo, PartidaParcela";
        setcookie("YacareAsignacionesListadoOrdenar", $ListadoOrdenar, time()+3600*24*60);
    } else if($ListadoOrdenar == 2) { 
        $ListadoOrdenarSql = "PartidaCalleNombre, PartidaCalleNumero";
        setcookie("YacareAsignacionesListadoOrdenar", $ListadoOrdenar, time()+3600*24*60);
    } else {
        $ListadoOrdenarSql = "PartidaSeccion, PartidaMacizo, PartidaParcela";
    }
    
    if($ListadoVer == 1) {
        $ListadoVerSql = "1=1";
    } else {
        $ListadoVerSql = "ResultadosCantidad=0";
    }

    
    $sql = "SELECT * FROM Inspeccion_RelevamientoAsignacionDetalle WHERE $ListadoVerSql ORDER BY $ListadoOrdenarSql";
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
        if($row['ResultadosCantidad'] > 0)
            echo ' style="text-decoration:line-through; font-style:italic"';
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
