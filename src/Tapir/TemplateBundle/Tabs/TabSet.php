<?php
namespace Tapir\TemplateBundle\Tabs;

class TabSet
{
    public $Tabs;
    
    public function __construct($Tabs = array()) {
        $this->Tabs = $Tabs;
    }
    
    
    public function setActive($tabnum, $active) {
        $this->Tabs[$tabnum]->Active = $active;
    }
    
    
    public function render() {
        $res = '<ul class="nav nav-pills" role="tablist">';
        
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
