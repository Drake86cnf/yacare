<?php
namespace Tapir\TemplateBundle\Controls;

/**
 * Representa un conjunto de pestañas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TabSet
{
    /**
     * Un arreglo (array) con Tab().
     * @var unknown
     */
    public $Tabs;
    
    /**
     * El estilo, puede ser 'tabs' o 'pills'
     * @var unknown
     */
    public $Style = 'tabs';
    
    
    public function __construct($Tabs = array()) {
        $this->Tabs = $Tabs;
    }

    
    /**
     * Establece una pestaña como activa y el resto como inactivas.
     * 
     * @param int $tabnum El número de pestaña.
     */
    public function setActive($tabnum) {
        for($i = 0; $i < count($this->Tabs); $i++) {
            $this->Tabs[$tabnum]->Active = $i == $tabnum;
        }
    }
    
    
    public function render() {
        $res = '<ul class="nav nav-' . $this->Style . '" role="tablist">';
        
        foreach($this->Tabs as $tab) {
            $res .= '<li role="presentation" class="' . ($tab->Active ? ' active' : '') . 
                ($tab->Disabled ? ' disabled' : '') .'">';
            if(! $tab->Disabled) {
                $res .= '<a href="' . $tab->Href . '" role="tab" data-toggle="ajax-link">' . $tab->Label . '</a>';
            } else {
                $res .= '<a href="#" role="tab" data-toggle="ajax-link">' . $tab->Label . '</a>';
            }
            $res .= '</li>';
        }
        
        $res .= '</ul>';
        
        return $res;
    }
}
