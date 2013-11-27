<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Yacare\BaseBundle\Entity\Adjunto
 *
 * @ORM\Table(name="Base_Adjunto")
 * @ORM\Entity
 */
class Adjunto
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct($Entidad = null, $Archivo = null)
    {
        $this->Token = sha1(openssl_random_pseudo_bytes(256));
        
        if($Entidad) {
            $this->setEntidadTipo(get_class($Entidad));
            $this->setEntidadId($Entidad->getId());
            
            // Genero un nombre de carpeta bundle/entidad ('Base/Persona', 'Organizacion/Departamento', etc.)
            $PartesNombreClase = explode('\\', $this->getEntidadTipo());
            $this->setCarpeta(strtolower(str_replace('Bundle', '', $PartesNombreClase[1]) . '/' . $PartesNombreClase[3]));
        }
        
        if($Archivo) {
            $this->SubirArchivo($Archivo);
        }
    }
    
    protected function getRaizDeAdjuntos()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/adjuntos/';
    }
    
    public function getRutaCompleta() {
        return $this->getRaizDeAdjuntos() . $this->getCarpeta() . '/';
    }

    
    public function SubirArchivo($Archivo) {
        $this->Token .= '.' . $Archivo->getClientOriginalExtension();
        $this->setNombre($Archivo->getClientOriginalName());
        $this->setTipoMime($Archivo->getMimeType());
        
        $RutaFinal = $this->getRutaCompleta();
        if (!file_exists($RutaFinal) && !is_dir($RutaFinal)) {
            mkdir($RutaFinal, 0775, true);
        }
        $Archivo->move($RutaFinal, $this->getToken());
    }
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $Carpeta;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $TipoMime;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Token;


    public function getTipoMime() {
        return $this->TipoMime;
    }

    public function setTipoMime($TipoMime) {
        $this->TipoMime = $TipoMime;
    }
    
    public function getEntidadTipo() {
        return $this->EntidadTipo;
    }

    public function setEntidadTipo($EntidadTipo) {
        $this->EntidadTipo = $EntidadTipo;
    }

    public function getEntidadId() {
        return $this->EntidadId;
    }

    public function setEntidadId($EntidadId) {
        $this->EntidadId = $EntidadId;
    }
    
    public function getToken() {
        return $this->Token;
    }

    public function setToken($Token) {
        $this->Token = $Token;
    }
    
    public function getCarpeta() {
        return $this->Carpeta;
    }

    public function setCarpeta($Carpeta) {
        $this->Carpeta = $Carpeta;
    }
}