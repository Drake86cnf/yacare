<?php
namespace Yacare\MunirgBundle\Helper;

use Yacare\MunirgBundle\Helper\Importador;
use Yacare\MunirgBundle\Helper\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de personas desde SiGeMI.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorPersonas extends Importador {
    use \Yacare\MunirgBundle\Helper\ConConexionAOracle;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public function Inicializar() {
        parent::Inicializar();
        
        $this->ObtenerConexionAOracle();
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
        $sql = $this->OracleVentana(
            'SELECT * FROM RGR.VVU$INDIVIDUO', $desde, $cantidad);
        return $this->Dbmunirg->query($sql);
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(TG06100_ID) CANT FROM RGR.VVU$INDIVIDUO';
        $Registro = $this->Dbmunirg->query($sql)->fetch();
        if($Registro) {
            return (int)($Registro['CANT']); 
        } else {
            return 0;
        }
    }
    
    
    public function ImportarRegistro($Row) {
        $resultado = new ResultadoLote();
        $resultado->Registros[] = $Row;
        
        $Documento = StringHelper::ObtenerDocumento($Row['IND_IDENTIFICACION']);
        $Apellido = StringHelper::Desoraclizar($Row['Q_APELLIDOS']);
        $Nombre = StringHelper::Desoraclizar($Row['Q_NOMBRES']);
        $RazonSocial = StringHelper::Desoraclizar($Row['J_RAZON_SOCIAL']);
        $PersJur = false;
        
        if ($Documento[0] == 'CUIL' && (substr($Documento[1], 0, 3) == '30-' || substr($Documento[1], 0, 3) == '33-')) {
            $Documento[0] = 'CUIT';
            $PersJur = true;
        }
        
        if ($Row['DOCUMENTO_TIPO'] == 'DU') {
            $Row['DOCUMENTO_TIPO'] = 'DNI';
        }
        
        $Cuilt = '';
        if ($Documento[0] == 'CUIL' || $Documento[0] == 'CUIT') {
            $Cuilt = str_replace('-', '', $Documento[1]);
            if ($Row['DOCUMENTO_TIPO'] && $Row['DOCUMENTO_NRO']) {
                $Documento[0] = $Row['DOCUMENTO_TIPO'];
                $Documento[1] = $Row['DOCUMENTO_NRO'];
            }
        } else 
            if ($Row['DOCUMENTO_TIPO'] == 'CUIL' || $Row['DOCUMENTO_TIPO'] == 'CUIT') {
                $Cuilt = str_replace('-', '', $Row['DOCUMENTO_NRO']);
            }
        
        if ($Documento[0] == 'CUIL') {
            $Partes = explode('-', $Documento[1]);
            if (count($Partes) == 3) {
                $Documento[0] = 'DNI';
                $Documento[1] = (int) ($Partes[1]);
            }
        }
        
        if (! $Documento[1]) {
            // No tengo documento, utilizo el campo TRIBUTARIA_ID
            $Documento[0] = 'DNI';
            $Partes = explode('-', $Documento[1]);
            if (count($Partes) == 3) {
                $Documento[1] = (int) ($Partes[1]);
            } else {
                $Documento[1] = trim($Row['TRIBUTARIA_ID']);
            }
        }
        
        if (! $Nombre && ! $Apellido) {
            $Apellido = StringHelper::Desoraclizar($Row['NOMBRE']);
        }
        
        if (! $Nombre && $Apellido && strpos($Apellido, '.') === false) {
            $a = explode(' ', $Apellido, 2)[0];
            $b = trim(substr($Apellido, strlen($a)));
            $Nombre = $b;
            $Apellido = $a;
        }
        
        if ($RazonSocial) {
            $NombreVisible = $RazonSocial;
        } else {
            if ($Nombre) {
                $NombreVisible = $Apellido . ', ' . $Nombre;
            } else {
                $NombreVisible = $Apellido;
            }
        }
        
        $Row['TG06100_ID'] = (int) ($Row['TG06100_ID']);
        $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
        
        if (! $Cuilt) {
            $Cuilt = str_replace(array(' ', '-', '.'), '', $Row['J_IDENTIFICACION_TRIBUTARIA']);
        }
        
        $entity = $this->em->getRepository('YacareBaseBundle:Persona')->findOneBy(
            array('Tg06100Id' => $Row['TG06100_ID']));
        
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
            $entity->setTg06100Id($Row['TG06100_ID']);
            
            $entity->setDomicilioCodigoPostal('9420');
            if ($CodigoCalle) {
                $entity->setDomicilioCalle($this->em->getReference('YacareCatastroBundle:Calle', $CodigoCalle));
            }
            $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
            $entity->setDomicilioNumero($Row['NUMERO']);
            $entity->setDomicilioPiso($Row['PISO']);
            $entity->setDomicilioPuerta($Row['DEPARTAMENTO']);
            
            // Si no está en el grupo Contribuyentes, lo agrego
            if ($entity->getGrupos()->contains($GrupoContribuyentes) == false) {
                $entity->getGrupos()->add($GrupoContribuyentes);
            }
            if ($Row['Q_SEXO'] == 'F') {
                $entity->setGenero(2);
            } else 
                if ($Row['Q_SEXO'] == 'M') {
                    $entity->setGenero(1);
                }
            
            $this->em->persist($entity);
            $resultado->RegistrosNuevos++;
        } else {
            $entity->setTg06100Id($Row['TG06100_ID']);
            // $entity->setRazonSocial($RazonSocial);
            $resultado->RegistrosActualizados++;
        }
        
        
        return $resultado;
    }
}