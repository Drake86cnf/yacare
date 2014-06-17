<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * ConIdMetodos
 *
 */
trait ConIdMetodos
{
    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getDamm()
    {
        return str_pad(Damm::CalcCheckDigit($this->id), 5, '0', STR_PAD_LEFT);
    }
 

    public function getYri64($incluye_version = true)
    {
        return base64_encode($this->getYri($incluye_version));
    }
    
    public function getYri($incluye_version = true)
    {
        // get_class() devuelve Yacare\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class());
        $BundleName = str_replace('Bundle', '', $PartesNombreClase[1]);
        $ClassName = $PartesNombreClase[3];
        $Res = "http://yacare.riogrande.gob.ar/cp/?en=$BundleName+$ClassName&id=" . $this->getId();
        
        if($incluye_version && in_array('Tapir\BaseBundle\Entity\Versionable', class_uses($this)))
            $Res .= "&ver=" . $this->getVersion();
        
        return $Res;
    }
    
    
    public function getYriQrBase64() {
        $ContenidoQr = $this->getYri(true);

        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
        
        // PHPQRCode cambia el content-type a image/png... lo volvemos a html
        header("Content-type: text/html");
        return base64_encode($imagen_contenido);
    }
}