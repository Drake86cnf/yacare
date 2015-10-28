<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante cambios en los comercios.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null) {
        parent::__construct($em);
    }
    
    public function PreUpdatePersist($comercio, $args = null) {
        $this->ReordenarActividades($comercio);
    }
    
    /**
     * Reordena las actividades en un comercio para que estén consolidadas (sin espacios
     * intermedios en blanco).
     *
     * @param  \Yacare\ComercioBundle\Entity\Comercio $comercio El comercio.
     */
    public function ReordenarActividades($comercio)
    {
        $Reordenado = false;
    
        if ($comercio->getActividad6() && ! $comercio->getActividad5()) {
            $comercio->setActividad5($comercio->getActividad6());
            $comercio->setActividad6(null);
            $Reordenado = true;
        }
    
        if ($comercio->getActividad5() && ! $comercio->getActividad4()) {
            $comercio->setActividad4($comercio->getActividad5());
            $comercio->setActividad5(null);
            $Reordenado = true;
        }
    
        if ($comercio->getActividad4() && ! $comercio->getActividad3()) {
            $comercio->setActividad3($comercio->getActividad4());
            $comercio->setActividad4(null);
            $Reordenado = true;
        }
    
        if ($comercio->getActividad3() && ! $comercio->getActividad2()) {
            $comercio->setActividad2($comercio->getActividad3());
            $comercio->setActividad3(null);
            $Reordenado = true;
        }
    
        if ($Reordenado) {
            // Si hice cambios, uso recursión para hacer una pasada más, que puede ser necesaria.
            return $this->ReordenarActividades($comercio);
        } else {
            // No hice cambios. La lista está ordenada.
            return;
        }
    }
}
