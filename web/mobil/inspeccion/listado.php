<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';

    require_once 'db_local.php.inc';
	
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
            <div class="navbar-brand"><img src="../img/yacare_logo_64.png" width="32px">&nbsp;&nbsp;Yacaré :: Inspección</div>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

            </ul>
            <ul class="nav navbar-nav navbar-right">
                    <?php
    if($ListadoOrdenar != 1) {
?>
    <li><a onclick="parent.location='listado.php?orden=1&ver=<?php echo $ListadoVer ?>';"><i class="fa fa-sort"></i> Ordenar por sección</a></li>
<?php
    }
    if($ListadoOrdenar != 2) {
?>
    <li><a onclick="parent.location='listado.php?orden=2&ver=<?php echo $ListadoVer ?>';"><i class="fa fa-sort"></i> Ordenar por calle</a></li>
<?php
    }
    if($ListadoVer != 0) {
?>
    <li><a onclick="parent.location='listado.php?orden=<?php echo $ListadoOrdenar ?>&ver=0';"><i class="fa fa-filter"></i> Ver pendientes</a></li>
<?php
    }
    if($ListadoVer != 1) {
?>
    <li><a onclick="parent.location='listado.php?orden=<?php echo $ListadoOrdenar ?>&ver=1';"><i class="fa fa-filter"></i> Ver todos</a></li>
<?php
    }
?>
    <li><a onclick="parent.location='../actualizar/?ret=..%2Finspeccion%2Fpresinc.php';"><i class="fa fa-refresh"></i> Sincronizar</a></li>
            </ul>
        </div>
    </div>
</nav>
                
<div class="contenido">
<div class="datagrid">
<table class="table table-responsive table-hoverselect">
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
    
    $ListadoVerSql = "Suprimido=0";
    
    if($ListadoVer == 1) {
        // Nada
    } else {
        $ListadoVerSql .= " AND ResultadosCantidad=0";
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
        if($row['ResultadosCantidad'] > 0) {
            echo ' style="text-decoration:line-through; font-style:italic"';
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

<?php
    require_once '../footer.php.inc';
?>
</body>

</html>
