<?php
    require_once '../global.php.inc';
    require_once '../head.php.inc';
    
    if($_REQUEST['debug']) {
        // Poner en modo de desarrollo
        file_put_contents($YacareCarpetaRaiz . '/debug.txt', 'Si este archivo está presente, la aplicación funciona en modo de desarrollo.');
    } else {
        // Poner en modo de producción
        if(file_exists($YacareCarpetaRaiz . '/debug.txt')) {
            unlink($YacareCarpetaRaiz . '/debug.txt');
        }
    }
    
    header('Location: index.php');
?>

<script type="text/javascript">
window.location='index.php';
</script>

<?php
    require_once '../footer.php.inc';
?>
</html>
