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
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ObrasParticularesBundle\Entity\ConProfesional;

    public function __construct()
    {
        parent::__construct();
        
        $this->Titular = new \Yacare\BaseBundle\Entity\Persona();
    }
    
    public function __toString()
    {
        return 'Trámite de Planos Nº ' . $this->getId();
    }
}
