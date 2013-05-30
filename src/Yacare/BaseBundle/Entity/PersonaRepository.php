<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PersonaRepository extends BaseRepository
{
    function __construct() {
        $this->BundleName = 'Base';
        $this->EntityName = 'Persona';
    }
}