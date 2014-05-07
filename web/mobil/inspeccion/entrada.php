<?php

session_start();
$_SESSION['usuario'] = $_REQUEST['usuario'];
$_SESSION['password'] = $_REQUEST['password'];

$nombre = $_SESSION['usuario'];
$clave = $_SESSION['password'];

if ($nombre=="inspector" && $clave =="123456") {
	$_SESSION['habilitado'] = 1;
	header("Location: listado.php");
?>
<script type="text/javascript">
window.location="listado.php?orden=1";
</script>
<?php
	exit;
} else {
    require_once 'head.php.inc';
?>

<body>
<div class="encab">
<div class="encab-izquierda"><img src="yacare_logo_48bw.png" width="48px">&nbsp;Yacaré - Inspección</div>
<div class="encab-derecha">
</div>
</div>

<div class="contenido">

<form action="index.php" method="post">

<h1>Acceso denegado</h1>
<p>El nombre de usuario o la clave no son correctos. Por favor retroceda y vuelva a intentar.</p>

<button type="submit">Volver</button>

</form>

</div>

<?php
    require_once 'footer.php.inc';
?>
</body>

</html>

<?php
}
?>
