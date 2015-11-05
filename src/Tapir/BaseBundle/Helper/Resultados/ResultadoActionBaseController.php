<?php
namespace Tapir\BaseBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de un BaseController.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoActionBaseController extends ResultadoAction
{
    public $Vendor, $Bundle, $RutaBase;
    public $Paginar = false, $Pagina = 1;
    public $Arrastre = array();
    public $EntidadClase, $EntidadEtiqueta, $EntidadEtiquetaPlural;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }

    /**
     * Magic setter para las variables del arrastre (cualquier propiedad no definida explícitamente).
     */
    public function __set($name, $value)
    {
        $this->Arrastre[$name] = $value;
    }

    /**
     * Obtiene el nombre de la entidad gestionada (sin espacio de nombres).
     */
    public function EntidadNombre()
    {
        $Partes = explode('\\', $this->EntidadClase);
        
        return $Partes[count($Partes) - 1];
    }

    /**
     * Obtiene el nombre de una ruta a una acción dentro de este controlador.
     */
    public function ObtenerRutaAccion($accion)
    {
        if ($accion == 'crear') {
            $accion = 'editar_1';
        }
        return $this->RutaBase . '_' . $accion;
    }
}
