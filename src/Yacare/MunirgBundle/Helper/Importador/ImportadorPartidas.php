<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de partidas de catastro desde SiGeMI.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorPartidas extends Importador {
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAOracle;
    use \Yacare\MunirgBundle\Helper\Importador\ConCalles;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public $Zonas = array(
            'ZC' => 2, 
            'ZCB' => 7, 
            'ZCM' => 4, 
            'ZCP' => 5, 
            'CRT1' => 3, 
            'ZCRT1' => 3, 
            'ZCS' => 6, 
            'ZMC' => 1, 
            'ZC-MC' => 1, 
            'ZPE' => 15, 
            'ZR1' => 8, 
            'ZR2' => 9, 
            'ZR3' => 10, 
            'ZR4' => 11, 
            'ZR5' => 12, 
            'ZR6' => 13, 
            'ZREU' => 16, 
            'ZRM' => 14, 
            'ZSEU' => 18, 
            
            // Estos no existen en el SIGEMI
            'Z extra urb. zona costera' => 19, 
            'Z residencial extraurbano 2' => 17, 
            
            // Estos no existen en el anexo 6 de planificación territorial
            'ZEIA' => null, 
            'ZEIS' => null, 
            'ZEIU' => null);
    
    public $TipoDocs = array(
        'DNI' => 1,
        'CF' => 1,
        'LE' => 2,
        'LC' => 3,
        'CI' => 4,
        'PAS' => 5,
        'CUIL' => 98,
        'CUIT' => 99);
    
    
    public function Inicializar() {
        parent::Inicializar();
        
        $this->ObtenerConexionAOracle();
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
        $sql = $this->OracleVentana(
            'SELECT * FROM RGR.VVU$CATASTRO 
                LEFT JOIN RGR.VVU$DOMICILIO
                    ON RGR.VVU$DOMICILIO.TG06300_ID=RGR.VVU$CATASTRO.DPROP_TG06300_ID'
            , $desde, $cantidad);
        return $this->Dbmunirg->query($sql);
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(PARTIDA) CANT FROM RGR.VVU$CATASTRO';
        $Registro = $this->Dbmunirg->query($sql)->fetch();
        if($Registro) {
            return (int)($Registro['CANT']); 
        } else {
            return 0;
        }
    }
    
    
    public function ObtenerTitularesPorId($tr3a100_id) {
        $res = array();
        
        $sql = 'SELECT * FROM RGR.VVU$REL_CAT_IND WHERE TR3A100_ID=' . $tr3a100_id;
        $RegistrosTitulares = $this->Dbmunirg->query($sql);
        foreach ($RegistrosTitulares as $RegistroTitular) {
            if($RegistroTitular['ASOCIACION_TIPO'] == 'TIT') {
                $tg06100_id = (int)($RegistroTitular['TG06100_TG06100_ID']);
                $Persona = $this->em->getRepository('Yacare\BaseBundle\Entity\Persona')->findOneBy(array(
                    'Tg06100Id' => $tg06100_id 
                ));
                
                if($Persona) {
                    $res[] = $Persona;
                }
            }
        }
        return $res;
    }
    
    
    public function ImportarRegistro($Row) {
        $resultado = new ResultadoLote();
        $resultado->Registros[] = $Row;
        
        $Seccion = strtoupper(trim($Row['SECCION'], ' .'));
        $MacizoNum = trim($Row['MACIZO_NUM'], ' .');
        $MacizoAlfa = trim($Row['MACIZO_ALFA'], ' .');
        $ParcelaNum = trim($Row['PARCELA_NUM'], ' .');
        $ParcelaAlfa = trim($Row['PARCELA_ALFA'], ' .');
        $SubparcelaNum = trim($Row['SUBPARC_NUM'], ' .');
        $SubparcelaAlfa = trim($Row['SUBPARC_ALFA'], ' .');
        //$Macizo = trim($MacizoNum . $MacizoAlfa);
        //$Parcela = trim($ParcelaNum . $ParcelaAlfa);
        //$Subparcela = trim($SubparcelaNum . $SubparcelaAlfa);
        $UnidadFuncional = (int) ($Row['UNID_FUNC']);
        
        $entity = null;
        /*
         * $entity = $em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array( 'ImportSrc' =>
         * 'dbmunirg.TR3A100', 'ImportId' => $Row['TR3A100_ID'] ));
         */
        
        if (! $entity) {
            $entity = $this->em->getRepository('YacareCatastroBundle:Partida')->findOneBy(
                array(
                    'Seccion' => $Seccion,
                    'MacizoNum' => $MacizoNum,
                    'MacizoAlfa' => $MacizoAlfa,
                    'ParcelaNum' => $ParcelaNum,
                    'ParcelaAlfa' => $ParcelaAlfa,
                    'SubparcelaNum' => $SubparcelaNum,
                    'SubparcelaAlfa' => $SubparcelaAlfa,
                    'UnidadFuncional' => $UnidadFuncional));
        }
        
        if (! $entity) {
            $entity = $this->em->getRepository('YacareCatastroBundle:Partida')->findOneBy(
                array('Numero' => (int) ($Row['PARTIDA'])));
        }
        
        if (! $entity) {
            $entity = new \Yacare\CatastroBundle\Entity\Partida();
            $entity->setSeccion($Seccion);
            $entity->setMacizoAlfa($MacizoAlfa);
            $entity->setMacizoNum($MacizoNum);
            $entity->setParcelaAlfa($ParcelaAlfa);
            $entity->setParcelaNum($ParcelaNum);
            $entity->setSubparcelaAlfa($SubparcelaAlfa);
            $entity->setSubparcelaNum($SubparcelaNum);
            $entity->setUnidadFuncional($UnidadFuncional);
            
            $resultado->RegistrosNuevos++;
        } else {
            $resultado->RegistrosActualizados++;
        }
        
        $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
        
        if ($entity && $Seccion) {
            if ($CodigoCalle) {
                $entity->setDomicilioCalle($this->em->getReference('YacareCatastroBundle:Calle', $CodigoCalle));
            } else {
                $entity->setDomicilioCalle(null);
            }
        
            if ($Row['ZONA_CODIGO']) {
                $ZonaId = @$this->Zonas[$Row['ZONA_CODIGO']];
                if ($ZonaId) {
                    $entity->setZona($this->em->getReference('YacareCatastroBundle:Zona', $ZonaId));
                } else {
                    $entity->setZona(null);
                }
            } else {
                $entity->setZona(null);
            }
            
            $Titulares = $this->ObtenerTitularesPorId($Row['TR3A100_ID']);
            if(count($Titulares) >= 1) {
                $entity->setTitular($Titulares[0]);
            } else {
                $entity->setTitular(null);
            }
        

            $entity->setUnidadFuncional($UnidadFuncional);
            $entity->setDomicilioNumero((int) ($Row['NUMERO']));
            $entity->setDomicilioPiso(trim($Row['PISO']));
            $entity->setDomicilioPuerta(trim($Row['DEPTO']));
            $entity->setNumero((int) ($Row['PARTIDA']));
        
            // $entity->setImportSrc('dbmunirg.TR3A100');
            // $entity->setImportId($Row['TR3A100_ID']);
        
            $this->em->persist($entity);
            $this->em->flush();
        }
        
        return $resultado;
    }
}