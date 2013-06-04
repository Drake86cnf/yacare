<?php

namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("agente/")
 */
class AgenteController extends \Yacare\BaseBundle\Controller\YacareBaseController
{
    /*
    CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS SELECT 
	legajo as id, fechaingre as FechaIngreso,
	nombre as NombreVisible, situacion, categoria,
	funcion, secretaria, direccion, sector, planta, cargo, antiguedad,
	antiguedad2, sexo, tipodoc, nrodoc, nacionalidad, fechanacion, domicilio, fechanacim, estadocivi,
	conyuge, excombatie, discapacit, finalcontr, categoriaa, decreto1, fechabaja, motivo,
	decreto2, estudios, titulo, telefono, celular, observacio, puestolabo, franjahora, horasxdia,
	horasxmes, psecretari, pdireccion, psector, desdehora, hastahora, email, cuil FROM rr_hh.agentes;
     */
    
    function __construct() {
        $this->BundleName = 'RecursosHumanos';
        $this->EntityName = 'Agente';
        parent::__construct();
    }
}
