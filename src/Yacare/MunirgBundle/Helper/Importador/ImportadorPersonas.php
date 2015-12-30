<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de personas desde SiGeMI.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorPersonas extends Importador
{
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAOracle;
    use \Yacare\MunirgBundle\Helper\Importador\ConCalles;
    public $GrupoContribuyentes;

    function __construct($container, $em)
    {
        parent::__construct($container, $em);
    }

    public function Inicializar()
    {
        parent::Inicializar();
        
        $this->ObtenerConexionAOracle();
        
        $this->GrupoContribuyentes = $this->em->getReference('YacareBaseBundle:PersonaGrupo', 3);
    }

    public function ObtenerRegistros($desde, $cantidad)
    {
        $sql = $this->OracleVentana(
            'SELECT * FROM RGR.VVU$INDIVIDUO I LEFT JOIN RGR.VVU$DOMICILIO D
                ON I.DPOST_TG06300_ID=D.TG06300_ID', $desde, $cantidad);
        return $this->Dbmunirg->query($sql);
    }

    public function ObtenerCantidadTotal()
    {
        $sql = 'SELECT COUNT(TG06100_ID) CANT FROM RGR.VVU$INDIVIDUO';
        $Registro = $this->Dbmunirg->query($sql)->fetch();
        if ($Registro) {
            return (int) ($Registro['CANT']);
        } else {
            return 0;
        }
    }

    public function ImportarRegistro($Row)
    {
        $resultado = new ResultadoLote();
        //$resultado->Registros[] = $Row;
        
        if ($Row['INDIVIDUO_TIPO'] != 'PE' && $Row['INDIVIDUO_TIPO'] != 'PJ' && $Row['INDIVIDUO_TIPO'] != 'EN' &&
             $Row['INDIVIDUO_TIPO'] != 'OT') {
            $resultado->RegistrosIgnorados ++;
            return $resultado;
        }
        
        if ($Row['NOMBRE_IND'] != 'NRO.DE CUENTA CEMENTERIO' || $Row['NOMBRE_IND'] != 'NN' ||
             SUBSTR($Row['NOMBRE_IND'], 0, 3) != '???') {
            $resultado->RegistrosIgnorados ++;
            return $resultado;
        }
        
        if ((int) $Row['TRIBUTARIA_ID'] > 0 || (int) $Row['TRIBUTARIA_ID'] <= 9999) {
            $resultado->RegistrosIgnorados ++;
            return $resultado;
        }
        
        $Documento = StringHelper::ObtenerDocumento($Row['TRIBUTARIA_ID']);
        $Apellido = StringHelper::Desoraclizar($Row['APELLIDOS']);
        $Nombre = StringHelper::Desoraclizar($Row['NOMBRES']);
        $RazonSocial = StringHelper::Desoraclizar($Row['RAZON_SOCIAL']);
        
        if (! $Nombre && ! $Apellido && ! $RazonSocial) {
            $resultado->RegistrosIgnorados ++;
            return $resultado;
        }
        
        // echo ($Nombre .'/'. $Apellido .'/'. $RazonSocial);
        // echo "\n";
        
        $Row['TG06100_ID'] = (int) ($Row['TG06100_ID']);
        $entity = $this->em->getRepository('YacareBaseBundle:Persona')->findOneBy(
            array('Tg06100Id' => $Row['TG06100_ID']));
        
        $Cuilt = '';
        if ($Documento[0] == 'CUIL' || $Documento[0] == 'CUIT') {
            $Cuilt = str_replace('-', '', $Documento[1]);
        }
        
        if ($Documento[0] == 'CUIL') {
            // Intento obtener el DNI del CUIL
            $Partes = explode('-', $Documento[1]);
            if (count($Partes) == 3) {
                $Documento[0] = 'DNI';
                $Documento[1] = (int) ($Partes[1]);
            }
        }
        
        if ($entity == null && $Cuilt) {
            $entity = $this->em->getRepository('YacareBaseBundle:Persona')->findOneBy(array('Cuilt' => $Cuilt));
        }
        
        if ($entity == null) {
            $entity = $this->em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                array(
                    /* 'DocumentoTipo' => $TipoDocs[$Documento[0]], */
                    'DocumentoNumero' => $Documento[1]));
        }
        
        if ($entity == null) {
            $entity = new \Yacare\BaseBundle\Entity\Persona();
            if ($Row['TIPO_SOCIEDAD']) {
                switch ($Row['TIPO_SOCIEDAD']) {
                    case 'SA':
                        $entity->setTipoSociedad(1);
                        break;
                    case 'SRL':
                        $entity->setTipoSociedad(8);
                        break;
                    case 'SC':
                        $entity->setTipoSociedad(2);
                        break;
                    case 'SCA':
                        $entity->setTipoSociedad(4);
                        break;
                    case 'SH':
                        $entity->setTipoSociedad(3);
                        break;
                    case 'SD':
                        if (strpos($RazonSocial, 'S.A.') !== false || strpos($RazonSocial, ' SA') !== false) {
                            $entity->setTipoSociedad(1);
                        } elseif (strpos($RazonSocial, 'S.R.L.') !== false || strpos($RazonSocial, ' SRL') !== false) {
                            $entity->setTipoSociedad(8);
                        } elseif (strpos($RazonSocial, 'S/H') !== false || strpos($RazonSocial, ' S.DE H.') !== false ||
                             strpos($RazonSocial, ' S. DE H.') !== false || strpos($RazonSocial, ' S.H') !== false) {
                            $entity->setTipoSociedad(3);
                        }
                        break;
                }
            } elseif ($Row['INDIVIDUO_TIPO'] != 'EN') {
                $entity->setTipoSociedad(11);
            }
            
            if ($Documento[0] == 'CUIL' && (substr($Documento[1], 0, 3) == '30-' || substr($Documento[1], 0, 3) == '33-' ||
                 substr($Documento[1], 0, 3) == '34-')) {
                $Documento[0] = 'CUIT';
            }
            
            if (! $entity->getCuilt() && $Cuilt) {
                $entity->setCuilt($Cuilt);
            }
            
            if (! $entity->getDocumentoNumero()) {
                $entity->setDocumentoNumero($Documento[1]);
            }
            
            if (! $entity->getDocumentoTipo()) {
                $entity->setDocumentoTipo(1);
            }
            
            if (! $entity->getNombre()) {
                $entity->setNombre($Nombre);
            }
            if (! $entity->getApellido()) {
                $entity->setApellido($Apellido);
            }
            if (! $entity->getRazonSocial()) {
                $entity->setRazonSocial($RazonSocial);
            }
            
            if (! $entity->getDomicilioCodigoPostal()) {
                $entity->setDomicilioCodigoPostal('9420');
            }
            $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
            if ($CodigoCalle && ! $entity->getDomicilioCalle()) {
                $Calle = $this->em->find('YacareCatastroBundle:Calle', $CodigoCalle);
                if ($Calle) {
                    $entity->setDomicilioCalle($Calle);
                }
            }
            if (! $entity->getDomicilioCalleNombre()) {
                $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
            }
            if (! $entity->getDomicilioNumero()) {
                $entity->setDomicilioNumero($Row['NUMERO']);
            }
            if (! $entity->getDomicilioPiso()) {
                $entity->setDomicilioPiso($Row['PISO']);
            }
            if (! $entity->getDomicilioPuerta()) {
                $entity->setDomicilioPuerta($Row['DEPTO']);
            }
            
            // Si no está en el grupo Contribuyentes, lo agrego
            // if ($entity->getGrupos()->contains($this->GrupoContribuyentes) == false) {
            // $entity->getGrupos()->add($this->GrupoContribuyentes);
            // }
            if ($Row['SEXO'] == 'F') {
                $entity->setGenero(2);
            } elseif ($Row['SEXO'] == 'M') {
                $entity->setGenero(1);
            }
            
            $entity->setTg06100Id($Row['TG06100_ID']);
            $resultado->RegistrosNuevos ++;
        } else {
            $resultado->RegistrosActualizados ++;
        }
        
        $entity->getNombreVisible();
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
}