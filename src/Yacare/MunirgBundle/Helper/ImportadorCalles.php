<?php
namespace Yacare\MunirgBundle\Helper;

use Yacare\MunirgBundle\Helper\Importador;
use Yacare\MunirgBundle\Helper\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de calles desde SiGeMI.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorCalles extends Importador {
    use \Yacare\MunirgBundle\Helper\ConConexionAOracle;
    use \Yacare\MunirgBundle\Helper\ConCalles;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public function Inicializar() {
        parent::Inicializar();
        
        $this->ObtenerConexionAOracle();
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
        $sql = $this->OracleVentana(
            'SELECT * FROM RGR.VVU$CALLES', $desde, $cantidad);
        return $this->Dbmunirg->query($sql);
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(CODIGO_CALLE) CANT FROM RGR.VVU$CALLES';
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
        
        $nombreBueno = StringHelper::Desoraclizar($Row['CALLE']);
        
        $entity = $this->em->getRepository('YacareCatastroBundle:Calle')
            ->findOneBy(array('ImportId' => $Row['CODIGO_CALLE']));
        
        if (! $entity) {
            $entity = $this->em->getRepository('YacareCatastroBundle:Calle')
                ->findOneBy(array('Nombre' => $nombreBueno));
        }
        if (! $entity) {
            $entity = $this->em->getRepository('YacareCatastroBundle:Calle')
            ->findOneBy(array('NombreAlternativo' => $nombreBueno));
        }
        
        if (! $entity) {
            $entity = new \Yacare\CatastroBundle\Entity\Calle();
            $entity->setNombre($nombreBueno);
            $entity->setNombreOriginal($Row['CALLE']);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['CODIGO_CALLE']);
            
            $resultado->RegistrosNuevos++;
        } else {
            $resultado->RegistrosActualizados++;
        }
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
}