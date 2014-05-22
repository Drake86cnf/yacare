<?php

    if(file_exists('../global.php.inc')) {
        require_once '../global.php.inc';
        $carpeta_destino = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
    }
    if(file_exists('global.php.inc')) {
        require_once 'global.php.inc';
        $carpeta_destino = dirname($_SERVER['SCRIPT_FILENAME']);
    }
    
    clearstatcache();
    ini_set('realpath_cache_size', 0);

    $cantidad_archivos = 0;
    $cantidad_errores = 0;

    if(isset($_REQUEST['ret'])) {
        $RetAddress = $_REQUEST['ret'];
    } else {
        $RetAddress = '../';
    }

    if($_SERVER['HTTP_HOST'] === 'webmuni' || $YacareModoDesarrollo) {
            echo "No se descargan actualizaciones.";
    } else {
	if(substr($carpeta_destino, -1) != '/') {
                $carpeta_destino .= '/';
        }
        
        $ch = curl_init("http://192.168.100.5/yacare/mobil/actualizar.zip");
        $fp = fopen($carpeta_destino . 'actualizar.zip', 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        $zip = new ZipArchive;
        if ($zip->open($carpeta_destino . 'actualizar.zip') === TRUE) {
                if($zip->extractTo($carpeta_destino)) {
                        $cantidad_archivos++;
                }
                $zip->close();
        }

        header('Location: /');
    }