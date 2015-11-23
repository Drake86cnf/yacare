<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un trámite en curso de aprobación de planos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com> 
 *        
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TramitePlanos")
 */
class TramitePlanos extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\CatastroBundle\Entity\ConPartida;
}
