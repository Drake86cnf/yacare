<?php
namespace Yacare\ComercioBundle\Helper\Asistentes;

use Tapir\FormBundle\Asistente\Asistente;

/**
 * Un asistente para iniciar un trámite de habilitacion comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class NuevoTramiteHabilitacionComercial extends Asistente
{
    public function __construct($entidad = null)
    {
        parent::__construct($entidad);
        $this->add(new BuscarTitularPaso());
        $this->add(new EditarTitularPaso());
        $this->add(new BuscarLocalPaso());
        $this->add(new EditarLocalPaso());
        $this->add(new EditarComercioPaso());
    }
}