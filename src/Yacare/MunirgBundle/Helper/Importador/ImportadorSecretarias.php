<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de secretarías desde Gestión.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorSecretarias extends Importador {
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAGestion;
    
    protected $Ejecutivo;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public function Inicializar() {
        parent::Inicializar();
        
        $this->Ejecutivo = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->find(1);
        $this->ObtenerConexionAGestion();
        mb_internal_encoding('UTF-8');
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
        return $this->DbGestion->query("SELECT * FROM secretarias WHERE codigo<>999");
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(codigo) AS CANT FROM secretarias WHERE codigo<>999';
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
            $nuevoId = $this->getDoctrine()->getManager()
                ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
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
        
        $entity->setNombre($nombreBueno);
        
        $entity->setParentNode($this->Ejecutivo);
        if ($Row['fecha_baja']) {
            $entity->setSuprimido(true);
        }
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
}