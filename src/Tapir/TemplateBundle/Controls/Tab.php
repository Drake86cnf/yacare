<?php
namespace Tapir\TemplateBundle\Controls;

class Tab
{
    public $Label, $Href, $Active = 0, $Disabled = 0;
    
    public function __construct($Label, $Href, $Active = 0, $Disabled = 0) {
        $this->Label = $Label;
        $this->Href = $Href;
        $this->Active = $Active;
        $this->Disabled = $Disabled;
    }
}
