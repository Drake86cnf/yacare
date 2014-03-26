<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("inspeccioncomercio/")
 */
class InspeccionComercioController extends \Yacare\BaseBundle\Controller\YacareAbmController
{
    function __construct() {
        parent::__construct();
        
        $this->BuscarPor = 'id, ExpedienteNumero, TitularNombre';
        $this->OrderBy = 'id';
    }
    
    /* 

REPLACE ObrasParticulares_InspeccionComercio
	(id, Superficie, ExpedienteNumero, Obs, NumeroSolicitud, Partida_id, TitularNombre, createdAt, updatedAt, ActividadNombre)
SELECT Tramite, Superficie, NumeroExpediente, Observaciones, NumeroSolicitud, (SELECT id FROM Catastro_Partida WHERE Numero=opart_comercio.Partida AND Numero>0), Propietario, NOW(), NOW(), Rubros
	FROM opart_comercio WHERE Rubros NOT IN ('', 'FINAL DE OBRA');

UPDATE ObrasParticulares_InspeccionComercio SET ExpedienteNumero=REPLACE(ExpedienteNumero, ' ', '');
UPDATE ObrasParticulares_InspeccionComercio SET ExpedienteNumero=NULL WHERE ExpedienteNumero='-/' OR ExpedienteNumero='';
UPDATE ObrasParticulares_InspeccionComercio SET Superficie=NULL WHERE Superficie=0;

     */
}
