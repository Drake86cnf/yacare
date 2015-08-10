<?php
namespace Tapir\TemplateBundle\Controls;

/**
 * Representa un conjunto de acciones.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActionSet
{
    /**
     * Un arreglo (array) de Action().
     * @var unknown
     */
    public $Actions;
    
    
    public function __construct($Actions = array()) {
        $this->Actions = $Actions;
    }


    public function render($style = 'buttons') {
        $res = '';
        foreach($this->Actions as $action) {
            $res .= '<a class="btn btn-' . $action->Type  . ($action->Disabled ? ' disabled' : '') .'" href="' 
                . $action->Href . '" data-toggle="ajax-link">' . $action->Label . '</a>';
        }
        
        return $res;
    }
}
