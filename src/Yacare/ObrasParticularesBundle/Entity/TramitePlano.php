<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\TramitesBundle\Entity\Tramite;

/**
 * Representa una previa.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TramitePlano")
 */
class TramitePlano extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ObrasParticularesBundle\Entity\ConProfesional;
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function __toString()
    {
        if($this->getId()) {
            return 'Trámite de Planos Nº ' . $this->getId();
        } else {
            return 'Nuevo Trámite de Planos';
        }
    }
}
