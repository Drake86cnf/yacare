<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de agentes desde Gestión.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorAgentes extends Importador {
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAGestion;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public function Inicializar() {
        parent::Inicializar();
        
        $this->ObtenerConexionAGestion();
    }

    
    public function ObtenerRegistros($desde, $cantidad) {
        return $this->DbGestion->query("SELECT * FROM agentes");
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(codigo) AS CANT FROM agentes';
        $Registro = $this->DbGestion->query($sql)->fetch();
        if($Registro) {
            return (int)($Registro['CANT']); 
        } else {
            return 0;
        }
    }
    
    
    public function ImportarRegistro($Row) {
        $resultado = new ResultadoLote();
        $resultado->Registros[] = $Row;
        
        $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
        $entity = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
            array('ImportSrc' => 'rr_hh.secretarias', 'ImportId' => $Row['codigo']));
        
        if (! $entity) {
            $nuevoId = $this->em->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                ->getSingleScalarResult();
            $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
            $entity->setId(++ $nuevoId);
            $entity->setRango(30);
            $entity->setImportSrc('rr_hh.secretarias');
            $entity->setImportId($Row['codigo']);
        
            $resultado->RegistrosNuevos++;
        } else {
            $resultado->RegistrosActualizados++;
        }
        
        if($entity->getNombreOriginal() != $Row['detalle']) {
            $entity->setNombre($nombreBueno);
            $entity->setNombreOriginal($Row['detalle']);
        }
        
        $entity->setParentNode($this->Ejecutivo);
        if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            } else {
                $entity->setSuprimido(false);
            }
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
}