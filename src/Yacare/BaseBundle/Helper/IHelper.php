<?php
namespace Yacare\BaseBundle\Helper;

interface IHelper {
    /**
     * Función que se dispara tanto antes de una creación como de una modificación.
     * @param object $entity La entidad.
     * @param LifecycleEventArgs $args Los argumentos, si el evento se disparó desde una llamada LifeCycle.
     */
    function PreUpdatePersist($entity, $args = null);
}