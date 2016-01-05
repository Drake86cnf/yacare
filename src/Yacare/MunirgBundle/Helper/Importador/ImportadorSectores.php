<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de sectores desde Gestión.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorSectores extends Importador {
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAGestion;
    
    function __construct($container, $em) {
        parent::__construct($container, $em);
    }

    public function Inicializar() {
        parent::Inicializar();
        
        mb_internal_encoding('UTF-8');
        $this->ObtenerConexionAGestion();
    }
    
    public function PostImportar() {
        // Suprimo todas las direcciones que ya no existen
        $IdsSectoresActuales = $this->DbGestion->query("SELECT CONCAT(secretaria, '.', direccion, '.', sector) FROM sectores")->fetchAll(\PDO::FETCH_COLUMN);
    
        $qb = $this->em->createQueryBuilder();
        $q = $qb->update('YacareOrganizacionBundle:Departamento', 'd')
            ->set('d.Suprimido', ':suprimido')
            ->where('d.Rango = :rango')
            ->andWhere('d.ImportSrc=:importsrc')
            ->andWhere('d.ImportId NOT IN (:importid)')
            ->setParameter('suprimido', 1)
            ->setParameter('rango', 70)
            ->setParameter('importsrc', 'rr_hh.sectores')
            ->setParameter('importid', $IdsSectoresActuales)
            ->getQuery();
        //echo $q->getSql();
        //print_r($q->getParameters());
        $q->execute();
    
        return parent::PostImportar();
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
        return $this->DbGestion->query("SELECT * FROM sectores LIMIT $desde, $cantidad");
    }
    
    
    public function ObtenerCantidadTotal() {
        $sql = 'SELECT COUNT(sector) AS CANT FROM sectores';
        $Registro = $this->DbGestion->query($sql)->fetch();
        if($Registro) {
            return (int)($Registro['CANT']); 
        } else {
            return 0;
        }
    }
    
    
    public function ImportarRegistro($Row) {
        $resultado = new ResultadoLote();
        //$resultado->Registros[] = $Row;
        
        $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
        $entity = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
            array(
                'ImportSrc' => 'rr_hh.sectores', 
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']));
        
        if (! $entity) {
            $nuevoId = $this->em->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                ->getSingleScalarResult();
            $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
            $entity->setId(++ $nuevoId);
            $entity->setRango(70);
            $entity->setImportSrc('rr_hh.sectores');
            $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']);
            
            $resultado->RegistrosNuevos++;
        } else {
            $resultado->RegistrosActualizados++;
        }
        
        if($entity->getNombreOriginal() != $Row['detalle']) {
            $entity->setNombre($nombreBueno);
            $entity->setNombreOriginal($Row['detalle']);
        }
        
        if ($Row['fecha_baja']) {
            $entity->setSuprimido(true);
        } else {
            $entity->setSuprimido(false);
        }
        
        if ($Row['parte']) {
            $entity->setHaceParteDiario(true);
        } else {
            $entity->setHaceParteDiario(false);
        }
        
        $Dire = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
            array('ImportSrc' => 'rr_hh.direcciones', 'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
        $entity->setParentNode($Dire);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
}