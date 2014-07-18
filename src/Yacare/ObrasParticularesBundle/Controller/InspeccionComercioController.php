<?php

namespace Yacare\ObrasParticularesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("inspeccioncomercio/")
 */
class InspeccionComercioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Yacare\BaseBundle\Controller\ConImprimir;
    
    function IniciarVariables() {
        parent::IniciarVariables();
        
        $this->BuscarPor = 'id, ExpedienteNumero, TitularNombre';
        $this->OrderBy = 'id DESC';
    }
    
    /* 

REPLACE ObrasParticulares_InspeccionComercio
	(id, Superficie, ExpedienteNumero, Obs, NumeroSolicitud, Partida_id, TitularNombre, createdAt, updatedAt, ActividadNombre)
SELECT Tramite, Superficie, NumeroExpediente, 
		TRIM(CONCAT(TRIM(BOTH CHAR(0x00) FROM Observaciones), ' ', TRIM(BOTH CHAR(0x00) FROM Observac2), ' ', TRIM(BOTH CHAR(0x00) FROM Observac3))),
		NumeroSolicitud,
		(SELECT id FROM Catastro_Partida WHERE Numero=opart_comercio.Partida AND Numero>0),
		TRIM(TRIM(BOTH CHAR(0x00) FROM Propietario)),
		NOW(),
		NOW(),
		TRIM(TRIM(BOTH CHAR(0x00) FROM Rubros))
	FROM opart_comercio WHERE Rubros NOT IN ('', 'FINAL DE OBRA');

UPDATE ObrasParticulares_InspeccionComercio SET ExpedienteNumero=REPLACE(ExpedienteNumero, ' ', '');
UPDATE ObrasParticulares_InspeccionComercio SET ExpedienteNumero=NULL WHERE ExpedienteNumero='-/' OR ExpedienteNumero='';
UPDATE ObrasParticulares_InspeccionComercio SET Superficie=NULL WHERE Superficie=0;

     */
}
