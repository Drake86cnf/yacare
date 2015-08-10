<?php
namespace Tapir\TemplateBundle\Controls;

/**
 * Representa una acción que se puede ejecutar. Típicamente es un botón o enlace.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Action
{
    public $Label, $Href, $Type, $Icon, $Disabled = 0;
    
    public function __construct($Label, $Href, $Type = 'default', $Icon = null, $Disabled = 0) {
        $this->Label = $Label;
        $this->Href = $Href;
        $this->Type = $Type;
        $this->Icon = $Icon;
        $this->Disabled = $Disabled;
    }
}
