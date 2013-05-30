<head>
<meta content="es-ar" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Yacaré - Inspección</title>
<link href="global.css" rel="stylesheet" />
</head>

<body>

<div class="encab">
<div class="encab-izquierda">Yacaré - Inspección</div>
<div class="encab-derecha">
</div>
</div>

<?php
    if(isset($_REQUEST['entrar']) && $_REQUEST['entrar']) {
?>
<div class="contenido">

<form action="entrada.php" method="post">

<h1>Ingreso al sistema</h1>
<p>Por favor proporcione su nombre de usuario y contraseña a continuación.</p>

Usuario <input type="text" name="usuario" autofocus="autofocus" /><br />
Contraseña <input type="password" name="password" /><br />
<br />

<button type="submit">Ingresar</button>

</form>

</div>
<?php
    } else {
?>
    <p>La aplicación se abre en una nueva ventana. Si no es así, por favor permita ventanas emergentes en su navegador.</p>
<script>
    var popup = window.open('index.php?entrar=1', 'ventanaingreso','status=1,toolbar=0,resizable=yes,scrollbars=yes,location=no,fullscreen=yes,maximized=yes,height=' + screen.height + 'width='+screen.width);
    popup.moveTo(0, 0);
</script>
<?php
    }
?>
</body>

</html>
