<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de editar una.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoEditarGuardarAction extends ResultadoActionAbmController
{
    /**
     * Indica la acción a la cual lleva el formulario de editar.
     *
     * Si no se especifica ninguna, el predeterminado es 'guardar'.
     * Se puede especificar una ruta relativa, como 'guardar' o absoluta como 'vendor_bundle_accion'.
     */
    public $AccionGuardar;
    public $Entidad, $FormularioEditar, $FormularioEliminar, $Errores;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }

    public function EsCrear()
    {
        if ($this->Entidad->getId()) {
            return false;
        } else {
            return true;
        }
    }

    public function TieneEliminar()
    {
        return $this->FormularioEliminar != null;
    }

    public function ObtenerRutaAccionGuardar()
    {
        if ($this->AccionGuardar) {
            if (strpos($this->AccionGuardar, '_') === false) {
                return $this->ObtenerRutaAccion($this->AccionGuardar);
            } else {
                return $this->AccionGuardar;
            }
        } else {
            return $this->ObtenerRutaAccion('guardar');
        }
    }
}
