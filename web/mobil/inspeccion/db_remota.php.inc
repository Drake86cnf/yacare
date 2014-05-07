<?php

    global $db_remota;

    try {
        $db_remota = @new PDO('mysql:host=localhost;dbname=yacare;charset=utf8', 'yacare', '123456');
    } catch (Exception $e) {
        // Nada
        $db_remota = null;
    }

    if($db_remota) {
        $db_remota->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //$db_remota = @mysql_connect("192.168.100.5", "yacare","123456");
    //@mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8'", $db_remota);
    //@mysql_select_db("yacare", $db_remota);
?>
