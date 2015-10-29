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

    public function __construct($archivo = null, $entity = null, $id = null)
    {
        $this->Token = sha1(openssl_random_pseudo_bytes(256));
        
        if ($entity) {
            if(is_string($entity)) {
                $this->setEntidadTipo($entity);
                if($id) {
                    $this->setEntidadId($id);
                }
            } else {
                $this->setEntidadTipo(get_class($entity));
                $this->setEntidadId($entity->getId());
            }
            
            // Genero un nombre de carpeta bundle/entidad ('Base/Persona', 'Organizacion/Departamento', etc.)
            $PartesNombreClase = explode('\\', $this->getEntidadTipo());
            $this->setCarpeta(strtolower(str_replace('Bundle', '', $PartesNombreClase[1]) . '/' . $PartesNombreClase[3]));
        }
        
        if ($archivo) {
            $this->SubirArchivo($archivo);
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
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Tamano;
    
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
            case 'application/vnd.oasis.opendocument.text':
                return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-vnd.openxmlformats-officedocument.wordprocessingml.document.png';
                break;
            default:
                $Extension = strtolower(pathinfo($this->getNombre(), PATHINFO_EXTENSION));
                switch ($Extension) {
                    case 'pdf':
                    case 'rtf':
                    case 'xml':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-' . $Extension . '.png';
                        break;
                    case 'txt':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-plain.png';
                        break;
                    case 'doc':
                    case 'docx':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-msword.png';
                        break;
                    case 'zip':
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
                    case 'html':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/text-html.png';
                        break;
                    case 'xls':
                    case 'xlsx':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-vnd.ms-excel.png';
                        break;
                    case 'ods':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/x-office-spreadsheet.png';
                        break;
                    case 'odt':
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/application-vnd.openxmlformats-officedocument.wordprocessingml.document.png';
                        break;
                    default:
                        return '/bundles/tapirtemplate/img/oxygen/256x256/mimetypes/unknown.png';
                        break;
                }
                break;
        }
    }

    /**
     * Devuelve true si es un archivo de imagen.
     */
    public function EsImagen()
    {
        switch ($this->getTipoMime()) {
            case 'image/jpg':
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
     * Devuelve true si es un archivo de texto plano. 
     */
    public function EsTextoPlano()
    {
        $TipoMime = $this->getTipoMime();
        if(strlen($TipoMime) >= 5 && substr($TipoMime, 0, 5) == 'text/') {
            return true;
        }
        $Extension = strtolower(pathinfo($this->getNombre(), PATHINFO_EXTENSION));
        switch ($Extension) {
            case 'txt':
            case 'xml':
            case 'csv':
            case 'json':
                return true;
        }
    }

    /**
     * Devuelve true si tiene miniatura.
     */
    public function TieneMiniatura()
    {
        return $this->EsImagen();
    }
    
    
    /**
     * Devuelve true si es un archivo PDF.
     */
    public function EsPdf() {
        return $this->getTipoMime() == 'application/pdf';
    }
    
    /**
     * Devuelve true si es HTML.
     */
    public function EsHtml() {
        $Extension = strtolower(pathinfo($this->getNombre(), PATHINFO_EXTENSION));
        return $this->getTipoMime() == 'text/html' || $Extension == 'htm' || $Extension == 'html';
    }
    
    /**
     * Devuelve true si el archivo se puede mostrar directamente en el navegador.
     */
    public function SePuedeMostrarEnNavegador() {
        if($this->EsImagen() || $this->EsTextoPlano()) {
            return true;
        }

        switch ($this->getTipoMime()) {
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/svg':
                return true;
                break;
            case 'application/pdf':
                return false;
                break;
            case 'text/plain':
                return true;
                break;
            default:
                $Extension = strtolower(pathinfo($this->getNombre(), PATHINFO_EXTENSION));
                switch ($Extension) {
                    //case 'pdf':
                    case 'rtf':
                        return true;
                        break;
                    case 'xml':
                    case 'txt':
                    case 'csv':
                        return true;
                    case 'htm':
                    case 'html':
                        return true;
                        break;
                }
                break;
        }
        
        return false;
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
        $NombreArchivoFinal = $RutaFinal . $this->getToken();
        if(file_exists($NombreArchivoFinal)) {
            $this->setTamano(filesize($NombreArchivoFinal));
        }
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

    /**
     * @ignore
     */
    public function getTamano()
    {
        return $this->Tamano;
    }

    /**
     * @ignore
     */
    public function setTamano($Tamano)
    {
        $this->Tamano = $Tamano;
        return $this;
    }
 
}
