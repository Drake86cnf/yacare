<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<title>Yacaré - Consulta de comprobantes</title>

<style type="text/css">

    @import url('http://fonts.googleapis.com/css?family=Open+Sans:400,700');

body {
    margin: 32px;
    font-family: 'Segoe UI', 'Open Sans', "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    background-color: #f0f0f0;
}

.vistaprevia {
    border: 0px;
    margin: 4px;
}

</style>
</head>

<body>
<?php
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors',1);

    include_once(dirname(__FILE__) . '/Damm.php');

    global $db_remota;
	
    try {
        $db_remota = @new PDO('mysql:host=200.63.163.220;dbname=yacare;charset=utf8', 'yacare', '123456');
        if($db_remota)
            $db_remota->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (Exception $e) {
        // Nada
        $db_remota = null;
    }

    $EntidadTipo = str_replace(' ', '/', ($_GET['en']));
    $EntidadId = (int)($_GET['id']);
    $ImpresionToken = $_GET['tk'];
    $Descargar = @$_GET['dl'];
    
    $select = $db_remota->prepare("SELECT * FROM Base_Impresion WHERE EntidadTipo=:en AND EntidadId=:id AND Token=:tk");
    $select->bindValue('en', $EntidadTipo, PDO::PARAM_STR);
    $select->bindValue('id', $EntidadId, PDO::PARAM_INT);
    $select->bindValue('tk', $ImpresionToken, PDO::PARAM_STR);
    $select->execute();
    $row= $select->fetch();
    
    if($row) {
        if($Descargar == 1) {
            // Descargar archivo
            ob_clean();
            header('Content-type: ' . $row['TipoMime']);
            header('Content-Length: ' . strlen($row['Contenido']));
            header('Content-Disposition: attachment; filename="' . str_replace('/', '_', $EntidadTipo) . $EntidadId . '.pdf"');
            echo $row['Contenido'];
            exit(0);
        } elseif ($Descargar == 2) {
            // Descargar imagen
            ob_clean();
            header('Content-type: image/png');
            header('Content-Length: ' . strlen($row['Imagen']));
            header('Content-Disposition: filename="' . str_replace('/', '_', $EntidadTipo) . $EntidadId . '.png"');
            echo $row['Imagen'];
            exit(0);
        } else {
            header("Cache-Control: no-cache, must-revalidate"); 
?>
<div>
    <img class="vistaprevia" src="?en=<?php echo str_replace('/', '+', $EntidadTipo) ?>&id=<?php echo $EntidadId ?>&tk=<?php echo $ImpresionToken ?>&dl=2" align="right" alt="Vista previa del documento" />
    Comprobante Nº <?php echo str_pad(Damm::CalcCheckDigit($row['id']), 5, '0', STR_PAD_LEFT) ?><br />
    Tipo <?php echo $row['EntidadTipo'] ?><br />
    Id <?php echo $row['EntidadId'] ?><br />
    Versión <?php echo $row['EntidadVersion'] ?><br />
    <br />
    <a href="?en=<?php echo str_replace('/', '+', $EntidadTipo) ?>&id=<?php echo $EntidadId ?>&tk=<?php echo $ImpresionToken ?>&dl=1">Descargar una copia del comprobante</a><br />
</div>
<?php
        }
    } else {
?>
No se encuentra el comprobante.
<?php
    }
   
?>
</body>
</html>
