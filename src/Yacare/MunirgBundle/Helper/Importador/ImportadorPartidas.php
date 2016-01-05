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
    
    
    public function PreImportar()
    {
        $res = parent::PreImportar();
        
        $IdsPartidasActuales = $this->Dbmunirg->query('SELECT PARTIDA FROM RGR.VVU$CATASTRO')->fetchAll(\PDO::FETCH_COLUMN);
        $qb = $this->em->createQueryBuilder();
        $qb->select('p')
            ->from('Yacare\CatastroBundle\Entity\Partida', 'p')
            ->add('where', $qb->expr()->notIn('p.Numero', '?1'))
            ->setParameter(1, $IdsPartidasActuales);
        
            
        $q = $qb->getQuery();
        $PartidasObsoletas = $q->getResult();
        foreach($PartidasObsoletas as $Partida) {
            $Partida->setSuprimido(1);
            $this->em->persist($Partida);
        }

        
        return $res;
    }
    
    
    public function ObtenerRegistros($desde, $cantidad) {
        $sql = 'SELECT C.*, D.*, I.TG06100_TG06100_ID FROM RGR.VVU$CATASTRO C
                LEFT JOIN RGR.VVU$DOMICILIO D ON D.TG06300_ID=C.DPROP_TG06300_ID
                LEFT JOIN RGR.VVU$REL_CAT_IND I ON I.TR3A100_ID=C.TR3A100_ID';
        if($this->Where) {
            $sql .= ' WHERE ' . $this->Where;
        }
        $sql .= ' ORDER BY C.PARTIDA';
        $sqlventana = $this->OracleVentana($sql, $desde, $cantidad);
        return $this->Dbmunirg->query($sqlventana);
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(C.PARTIDA) CANT FROM RGR.VVU$CATASTRO C';
        if($this->Where) {
            $sql .= ' WHERE ' . $this->Where;
        }
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
        //$resultado->Registros[] = $Row;
        
        $Seccion = strtoupper(trim($Row['SECCION'], ' .'));
        $MacizoNum = trim($Row['MACIZO_NUM'], ' .');
        $MacizoAlfa = trim($Row['MACIZO_ALFA'], ' .');
        $ParcelaNum = trim($Row['PARCELA_NUM'], ' .');
        $ParcelaAlfa = trim($Row['PARCELA_ALFA'], ' .');
        $SubparcelaNum = trim($Row['SUBPARC_NUM'], ' .');
        $SubparcelaAlfa = trim($Row['SUBPARC_ALFA'], ' .');
        $UnidadFuncional = (int) ($Row['UNID_FUNC']);
        
        $entity = $this->em->getRepository('YacareCatastroBundle:Partida')->findOneBy(array( 'ImportSrc' =>
            'dbmunirg.TR3A100', 'ImportId' => $Row['TR3A100_ID'] ));
        
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
        //} else {
        //    $entity->setTitular(null);
        }    

        $entity->setUnidadFuncional($UnidadFuncional);
        $entity->setDomicilioNumero((int) ($Row['NUMERO']));
        $entity->setDomicilioPiso(trim($Row['PISO']));
        $entity->setDomicilioPuerta(trim($Row['DEPTO']));
        $entity->setNumero((int) ($Row['PARTIDA']));
        
        // Guardo los TG06100_ID de los titulares de las partidas, para debug
        $Tg06100Id = trim($Row['TG06100_TG06100_ID']);
        $Tg06100IdActual = $entity->getTg06100Id();
        if($Tg06100IdActual) {
            if(strpos($Tg06100IdActual, $Tg06100Id) === false) {
                $entity->setTg06100Id($Tg06100IdActual . ','. $Tg06100Id);
            }
        } else {
            $entity->setTg06100Id($Tg06100Id);
        }
    
        $entity->setImportSrc('dbmunirg.TR3A100');
        $entity->setImportId($Row['TR3A100_ID']);
        $entity->setSuprimido(0);

        $this->em->persist($entity);
        $this->em->flush();

        return $resultado;
    }
}