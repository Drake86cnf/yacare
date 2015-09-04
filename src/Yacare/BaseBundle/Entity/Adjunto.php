<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Representa un archivo adjuntado a otra entidad.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Adjunto")
 */
class Adjunto
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct($Entidad = null, $Archivo = null)
    {
        $this->Token = sha1(openssl_random_pseudo_bytes(256));
        
        if ($Entidad) {
            $this->setEntidadTipo(get_class($Entidad));
            $this->setEntidadId($Entidad->getId());
            
            // Genero un nombre de carpeta bundle/entidad ('Base/Persona', 'Organizacion/Departamento', etc.)
            $PartesNombreClase = explode('\\', $this->getEntidadTipo());
            $this->setCarpeta(
                strtolower(str_replace('Bundle', '', $PartesNombreClase[1]) . '/' . $PartesNombreClase[3]));
        }
        
        if ($Archivo) {
            $this->SubirArchivo($Archivo);
        }
    }
    
    /**
     * El tipo de la entidad.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * La ID de la entidad.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
     * La persona.
     * 
     * @var Persona
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Persona;
    
    /**
     * La carpeta donde se aloja el archivo adjunto.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $Carpeta;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $TipoMime;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $Token;

    /**
     * Devuelve la ruta raíz de la carpeta de adjuntos.
     */
    protected function getRaizDeAdjuntos()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/adjuntos/';
    }

    /**
     * Devuelve la ruta completa de la carpeta.
     * 
     * @return string
     */
    public function getRutaCompleta()
    {
        return $this->getRaizDeAdjuntos() . $this->getCarpeta() . '/';
    }

    /**
     * Devuelve la ruta relativa.
     * 
     * @return string
     */
    public function getRutaRelativa()
    {
        return 'adjuntos/' . $this->getCarpeta() . '/';
    }

    /**
     * Devuelve el nombre del archivo relativo.
     * 
     * @return string
     */
    public function getNombreArchivoRelativo()
    {
        if ($this->TieneMiniatura()) {
            return $this->getRutaRelativa() . $this->getToken();
        } else {
            return $this->getIcono();
        }
    }

    /**
     * Devuelve la ruta del ícono deseado.
     * 
     * @return string
     */
    public function getIcono()
    {
        switch ($this->getTipoMime()) {
            case 'image/jpg':
            // no break
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/svg':
                return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/image-x-generic.png';
                break;
            case 'application/pdf':
                return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-pdf.png';
                break;
            case 'text/plain':
                return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-plain.png';
                break;
            default:
                $Extension = strtolower(pathinfo($this->getNombre(), PATHINFO_EXTENSION));
                switch ($Extension) {
                    case 'pdf':
                    // no break
                    case 'rtf':
                    case 'xml':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-' . $Extension . '.png';
                        break;
                    case 'txt':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-plain.png';
                        break;
                    case 'doc':
                    // no break
                    case 'docx':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-msword.png';
                        break;
                    case 'zip':
                    // no break
                    case 'rar':
                    case '7z':
                    case 'tgz':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-x-archive.png';
                        break;
                    case 'wav':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/audio-x-wav.png';
                        break;
                    case 'csv':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-csv.png';
                        break;
                    case 'htm':
                    // no break
                    case 'html':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-html.png';
                        break;
                    case 'xls':
                    // no break
                    case 'xlsx':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-vnd.ms-excel.png';
                        break;
                    case 'ods':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/x-office-spreadsheet.png';
                        break;
                    case 'odt':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-vnd.
                            openxmlformats-officedocument.wordprocessingml.document.png';
                        break;
                    default:
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/unknown.png';
                        break;
                }
                break;
        }
    }

    /**
     * Comprueba si se trata de una imágen o no.
     * 
     * @return boolean
     */
    public function EsImagen()
    {
        switch ($this->getTipoMime()) {
            case 'image/jpg':
            // no break
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/svg':
                return true;
            default:
                return false;
        }
    }

    /**
     * Devuelve TRUE si tiene miniatura.
     */
    public function TieneMiniatura()
    {
        return $this->EsImagen();
    }

    public function SubirArchivo($Archivo)
    {
        $this->Token .= '.' . $Archivo->getClientOriginalExtension();
        $this->setNombre($Archivo->getClientOriginalName());
        $this->setTipoMime($Archivo->getMimeType());
        
        $RutaFinal = $this->getRutaCompleta();
        if (! file_exists($RutaFinal) && ! is_dir($RutaFinal)) {
            mkdir($RutaFinal, 0775, true);
        }
        $Archivo->move($RutaFinal, $this->getToken());
    }

    /**
     * @ignore
     */
    public function getTipoMime()
    {
        return $this->TipoMime;
    }

    /**
     * @ignore
     */
    public function setTipoMime($TipoMime)
    {
        $this->TipoMime = $TipoMime;
    }

    /**
     * @ignore
     */
    public function getEntidadTipo()
    {
        return $this->EntidadTipo;
    }

    /**
     * @ignore
     */
    public function setEntidadTipo($EntidadTipo)
    {
        $this->EntidadTipo = $EntidadTipo;
    }

    /**
     * @ignore
     */
    public function getEntidadId()
    {
        return $this->EntidadId;
    }

    /**
     * @ignore
     */
    public function setEntidadId($EntidadId)
    {
        $this->EntidadId = $EntidadId;
    }

    /**
     * @ignore
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @ignore
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
    }

    /**
     * @ignore
     */
    public function getCarpeta()
    {
        return $this->Carpeta;
    }

    /**
     * @ignore
     */
    public function setCarpeta($Carpeta)
    {
        $this->Carpeta = $Carpeta;
    }

    /**
     * @ignore
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     * @ignore
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
    }
}
