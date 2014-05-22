<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';

    include '../db_local.php.inc';

    if(isset($_GET['id'])) {
        $AsignacionDetalleId = $_GET['id'];
    }
?>

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
                <li><a class="text-primary" onclick="window.close();"><i class="fa fa-reply"></i> Cerrar</a></li>
            </ul>
        </div>
    </div>
</nav>

<table class="table table-responsive table-hoverselect">
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
    foreach ($YacareDbLocal->query($sql) as $row) {
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
            <td><?php echo $Incidente = $YacareDbLocal->query("SELECT Nombre FROM Inspeccion_RelevamientoResultado WHERE Id=$ResultadoId")->fetchColumn(); ?></td>
            <td><?php echo $Obs; ?></td>
            <td><img src="<?php echo $Imagen; ?>" /></td>
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
