<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_TramiteHabilitacionComercial")
 */
class TramiteHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    
    public function setTitular($Titular) {
        $this->setNombre('Habilitación comercial de ' . (string)$Titular);
        parent::setTitular($Titular);
    }
}
