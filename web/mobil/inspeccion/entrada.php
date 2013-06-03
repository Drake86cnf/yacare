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
?>
<head>
<meta content="es-ar" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Yacaré - Inspección</title>
<link href="global.css" rel="stylesheet" />
</head>

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

</body>

</html>

<?php
}
?>
