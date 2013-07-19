<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConId
 *
 */
trait ConId
{
     /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
    
    
    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getYri64($incluye_version = true)
    {
        return base64_encode($this->getYri($incluye_version));
    }
    
    public function getYri($incluye_version = true)
    {
        // get_class() devuelve Yacare\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class());
        $BundleName = str_replace('Bundle', '', $PartesNombreClase[1]);
        $ClassName = $PartesNombreClase[3];
        $Res = "ye://$BundleName/$ClassName?id=" . $this->getId();
        
        if($incluye_version && in_array('Yacare\BaseBundle\Entity\Versionable', class_uses($this))) {
            $Res .= "&ver=" . $this->getVersion();
        }
        
        return $Res;
    }
}
