<?php
namespace Yacare\TramitesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;

use Yacare\TramitesBundle\Entity\ITramite;

class TramiteListener implements EventSubscriber
{
    public function postPersist(LifecycleEventArgs $args)
    {
        echo 'postPersist!';
        $this->container->get('logger')->info('postPersist!');
        exit(0);

        $entity = $args->getEntity();
        if (!($entity instanceof ITramite)) {
            continue;
        }

        $em = $args->getEntityManager();

        if (! $entity->getTramiteTipo()) {
            // La propiedad TramiteTipo está en blanco... es normal al crear un trámite nuevo
            // Busco el TramiteTipo que corresponde a la clase y lo guardo
            $em = $this->getDoctrine()->getManager();

            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));

            $entity->setTramiteTipo($TramiteTipo);
        }

        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        echo 'postUpdate!';
        $this->container->get('logger')->info('postUpdate!');
        exit(0);

        $entity = $args->getEntity();
        if (!($entity instanceof ITramite)) {
            continue;
        }

        $em = $args->getEntityManager();

        $this->AsociarEstadosRequisitos($entity, null, $entity->getTramiteTipo()->getAsociacionRequisitos());
    }

    /**
     * Crear (en cero) un estado para cada uno de los requisitos asociados a este trámite.
     *
     * @param unknown $entity
     * @param unknown $EstadoRequisitoPadre
     * @param unknown $Asociaciones
     */
    protected function AsociarEstadosRequisitos($entity, $EstadoRequisitoPadre, $Asociaciones)
    {
        foreach ($Asociaciones as $AsociacionRequisito) {
            // Primero busco para ver si ya existe
            $EstadoRequisito = null;
            if ($entity->getEstadosRequisitos()) {
                foreach ($entity->getEstadosRequisitos() as $EstReq) {
                    if ($EstReq->getAsociacionRequisito() === $AsociacionRequisito) {
                        // Ya existe, por lo tanto no lo agrego
                        $EstadoRequisito = $EstReq;
                        break;
                    }
                }
            }

            if ($EstadoRequisito == null) {
                // No existe, así que la creo
                $EstadoRequisito = new \Yacare\TramitesBundle\Entity\EstadoRequisito();
                $EstadoRequisito->setTramite($entity);
            }

            $EstadoRequisito->setAsociacionRequisito($AsociacionRequisito);
            $EstadoRequisito->setEstadoRequisitoPadre($EstadoRequisitoPadre);

            if (! $EstadoRequisito->getId()) {
                $entity->AgregarEstadoRequisito($EstadoRequisito);
            }

            if ($AsociacionRequisito->getRequisito()->getTipo() == 'tra') {
                // Es un trámite... asocio los sub-requisitos
                $SubTramiteTipo = $AsociacionRequisito->getRequisito()->getTramiteTipoEspejo();
                if ($SubTramiteTipo) {
                    $this->AsociarEstadosRequisitos($entity, $EstadoRequisito,
                        $SubTramiteTipo->getAsociacionRequisitos());
                }
            }
        }
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::postPersist, \Doctrine\ORM\Events::postUpdate];
    }
}