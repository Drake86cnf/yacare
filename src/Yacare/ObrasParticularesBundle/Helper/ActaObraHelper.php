<?php
namespace Yacare\ObrasParticularesBundle\Helper;

class ActaObraHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if (! $entity->getActaTipo()) {
            // La propiedad ActaTipo está en blanco... es normal al crear un acta nueva
            // Busco el ActaTipo que corresponde a la clase y lo guardo
            
            $NombreClase = '\\' . get_class($entity);
            $ActaTipo = $this->em->getRepository('YacareInspeccionBundle:ActaTipo')->findOneBy(
                array('Clase' => $NombreClase));
            
            $entity->setActaTipo($ActaTipo);
            $entity->setNombre('Acta de ' . $entity->getSubtipo() . ' Nº ' . $entity->getNumero());
        } else {
            $entity->setNombre('Acta de Obra');
        }
        $entity->setNombre('Acta de ' . $entity->getSubtipo() . ' Nº ' . $entity->getNumero());
    }
}
