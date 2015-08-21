<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tapir\BaseBundle\Helper\Damm;

/**
 * Trait que agrega los métodos (getter y setter) a una entidad.
 * Requiere ConId.
 *
 * @see ConId
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConIdMetodos
{
    /**
     *
     * @ignore
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @ignore
     *
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Obtiene el código DAMM para el id actual.
     *
     * http://en.wikipedia.org/wiki/Damm_algorithm
     */
    public function getDamm()
    {
        return str_pad(Damm::CalcCheckDigit($this->id), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Obtiene el YRI codificado en base64.
     *
     * @see getYri()
     */
    public function getYri64($incluye_version = true)
    {
        return base64_encode($this->getYri($incluye_version));
    }

    /**
     * Obtiene un YRI, que es un identificador único de esta entidad.
     *
     * El YRI es una URL que apunta a una entidad.
     *
     * @param boot $incluye_version
     * Indica si el YRI es a una versión específica de la entidad (true)
     * o en general a cualquier versión disponible (false).
     */
    public function getYri($incluye_version = true)
    {
        // get_class() devuelve Tapir\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class());
        $BundleName = str_replace('Bundle', '', $PartesNombreClase[1]);
        $ClassName = $PartesNombreClase[3];
        $Res = "http://yacare.riogrande.gob.ar/cp/?en=$BundleName+$ClassName&id=" . $this->getId();
        
        if ($incluye_version && in_array('Tapir\BaseBundle\Entity\Versionable', class_uses($this))) {
            $Res .= "&ver=" . $this->getVersion();
        }
        
        return $Res;
    }

    /**
     * Obtiene un enlace QR al YRI, en base64.
     *
     * @return string La representación base64 del gráfico QR del YRI.
     */
    public function getYriQrBase64()
    {
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
