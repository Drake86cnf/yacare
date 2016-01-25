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
     * Obtiene el nombre de la entidad gestionada (sin espacio de nombres).
     */
    public function EntidadNombre()
    {
        $Partes = explode('\\', $this->EntidadClase);
        
        return $Partes[count($Partes) - 1];
    }
    
    /**
     * Obtiene el nombre de la ruta al inicio del bundle.
     */
    public function ObtenerRutaInicio()
    {
        return strtolower($this->Vendor) . '_' . strtolower($this->Bundle) . '_default_inicio';
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
    
    /**
     * Devuelve un array combinando las variables de arrastre con las variables proporcionadas. 
     */
    public function Arrastrar($variables) {
        return array_merge($this->Arrastre, $variables);
    }
    
    /**
     * Devuelve la URL de una acción, con sus parámetros más las variables de arrastre.
     */
    public function UrlAccion($accion, $variables) {
        return $this->Container->get('router')->generate($this->ObtenerRutaAccion($accion), $this->Arrastrar($variables));
    }
    
    /**
     * Devuelve el número de la página siguiente.
     */
    public function PaginaSiguiente() {
        return $this->Pagina + 1;
    }
}
