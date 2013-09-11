<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Comercio
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;

    public function __construct()
    {
        $this->ActividadesSecundarias = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
