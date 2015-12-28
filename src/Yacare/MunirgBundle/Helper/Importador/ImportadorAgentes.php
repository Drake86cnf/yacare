<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use Yacare\MunirgBundle\Helper\Importador\Importador;
use Yacare\MunirgBundle\Helper\Importador\ResultadoLote;
use Tapir\BaseBundle\Helper\StringHelper;

/**
 * Importador de agentes desde Gestión.
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ImportadorAgentes extends Importador
{
    use \Yacare\MunirgBundle\Helper\Importador\ConConexionAGestion;
    protected $GrupoAgentes;

    function __construct($container, $em)
    {
        parent::__construct($container, $em);
    }

    public function Inicializar()
    {
        parent::Inicializar();
        
        $this->ObtenerConexionAGestion();
        $this->GrupoAgentes = $this->em->getRepository('YacareBaseBundle:PersonaGrupo')->find(1);
    }

    public function ObtenerRegistros($desde, $cantidad)
    {
        return $this->DbGestion->query("SELECT * FROM agentes");
    }

    public function ObtenerCantidadTotal()
    {
        $sql = 'SELECT COUNT(legajo) AS CANT FROM agentes';
        $Registro = $this->DbGestion->query($sql)->fetch();
        if ($Registro) {
            return (int) ($Registro['CANT']);
        } else {
            return 0;
        }
    }

    public function ImportarRegistro($Row)
    {
        $resultado = new ResultadoLote();
        $resultado->Registros[] = $Row;
        
        $entity = $this->em->getRepository('YacareRecursosHumanosBundle:Agente')->findOneBy(
            array('ImportSrc' => 'rr_hh.agentes', 'ImportId' => $Row['legajo']));
        
        if (! $entity) {
            $entity = new \Yacare\RecursosHumanosBundle\Entity\Agente();
            
            // Asigno manualmente el ID
            $entity->setId((int) ($Row['legajo']));
            $metadata = $this->em->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            
            $Persona = $this->em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                array('DocumentoNumero' => trim($Row['nrodoc'])));
            
            if (! $Persona) {
                $Persona = new \Yacare\BaseBundle\Entity\Persona();
                $Persona->setDocumentoNumero($Row['nrodoc']);
                $Persona->setDocumentoTipo((int) $Row['tipodoc']);
            }
            $Persona->setNombre(StringHelper::Desoraclizar($Row['name']));
            $Persona->setApellido(StringHelper::Desoraclizar($Row['lastname']));
            if ($Row['fechanacim']) {
                $Persona->setFechaNacimiento(new \DateTime($Row['fechanacim']));
            }
            $Persona->setTelefonoNumero(trim(str_ireplace('NO DECLARA', '', $Row['telefono']) . ' ' .
                         str_ireplace('NO DECLARA', '', $Row['celular'])));
            $Persona->setGenero($Row['sexo'] == 1 ? 1 : 0);
            $Persona->setEmail(str_ireplace('NO DECLARA', '', strtolower($Row['email'])));
            $Persona->setCuilt(trim($Row['cuil']));
            
            $this->em->persist($Persona);
            $this->em->flush();
            
            $entity->setPersona($Persona);
            
            $entity->setImportSrc('rr_hh.agentes');
            $entity->setImportId($Row['legajo']);
            
            $resultado->RegistrosNuevos++;
        } else {
            $resultado->RegistrosActualizados++;
            $Persona = $entity->getPersona();
        }
        
        $Departamento = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
            array('ImportSrc' => 'rr_hh.sectores', 
                'ImportId' => $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']));
        
        if (! $Departamento) {
            $Departamento = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.direcciones', 'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
        }
        
        if (! $Departamento) {
            $Departamento = $this->em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.secretarias', 'ImportId' => $Row['secretaria']));
        }
        
        $entity->setDepartamento($Departamento);
        $entity->setCategoria($Row['categoria']);
        $entity->setSituacion($Row['situacion']);
        $entity->setFuncion(StringHelper::Desoraclizar($Row['funcion']));
        $entity->setBajaMotivo($Row['motivo']);
        
        if ($Row['excombatie'] == 'S') {
            $entity->setExCombatiente(1);
        }
        
        if ($Row['discapacit'] == 'S') {
            $entity->setDiscapacitado(1);
        }
        
        if ($Row['manohabil'] == 'I') {
            $entity->setManoHabil(1);
        }
        
        $entity->setEstudiosNivel($Row['estudios']);
        if ($Row['titulo'] == 999) {
            $entity->setEstudiosTitulo(null);
        } else {
            $entity->setEstudiosTitulo($Row['titulo']);
        }
        
        if (\Tapir\BaseBundle\Helper\Cbu::EsCbuValida($Row['cbu'])) {
            $entity->setCBUCuentaAgente(\Tapir\BaseBundle\Helper\Cbu::FormatearCbu($Row['cbu']));
        }
        
        // Si no está en el grupo agentes, lo agrego
        if ($Persona->getGrupos()->contains($this->GrupoAgentes) == false) {
            $Persona->getGrupos()->add($this->GrupoAgentes);
            $this->em->persist($Persona);
        }
        
        // Le pongo el número de legajo en la persona
        if ($entity->getId()) {
            $Persona->setAgenteId($entity->getId());
        }
        
        if ($Row['fechaingre']) {
            $entity->setFechaIngreso(new \DateTime($Row['fechaingre']));
        } else {
            $entity->setFechaIngreso(null);
        }
        
        if (is_null($Row['fechabaja']) || $Row['fechabaja'] === '0000-00-00') {
            $entity->setBajaFecha(null);
            $entity->setArchivado(false);
        } else {
            $entity->setBajaFecha(new \DateTime($Row['fechabaja']));
            $entity->setArchivado(true);
        }
        
        if (is_null($Row['fechanacion'] || $Row['fechanacion'] === '0000-00-00')) {
            $entity->setFechaNacionalizacion(null);
        } else {
            $entity->setFechaNacionalizacion(new \DateTime($Row['fechanacion']));
        }
        
        if (is_null($Row['ult_act_d'] || $Row['ult_act_d'] === '0000-00-00')) {
            $entity->setUltimaActualizacionDomicilio(null);
        } else {
            $entity->setUltimaActualizacionDomicilio(new \DateTime($Row['ult_act_d']));
        }
        
        if (is_null($Row['fecha_psico'] || $Row['fecha_psico'] === '0000-00-00')) {
            $entity->setFechaPsicofisico(null);
        } else {
            $entity->setFechaPsicofisico(new \DateTime($Row['ult_act_d']));
        }
        
        if (is_null($Row['fecha_CBC'] || $Row['fecha_CBC'] === '0000-00-00')) {
            $entity->setFechaCertificadoBuenaConducta(null);
        } else {
            $entity->setFechaCertificadoBuenaConducta(new \DateTime($Row['fecha_CBC']));
        }
        
        if (is_null($Row['fecha_CAP'] || $Row['fecha_CAP'] === '0000-00-00')) {
            $entity->setFechaCertificadoAntecedentesPenales(null);
        } else {
            $entity->setFechaCertificadoAntecedentesPenales(new \DateTime($Row['fecha_CAP']));
        }
        
        if (is_null($Row['fecha_CD'] || $Row['fecha_CD'] === '0000-00-00')) {
            $entity->setFechaCertificadoDomicilio(null);
        } else {
            $entity->setFechaCertificadoDomicilio(new \DateTime($Row['fecha_CD']));
        }
        
        if (\Tapir\BaseBundle\Helper\Cbu::EsCbuValida($Row['cbu'])) {
            $entity->setCBUCuentaAgente($Row['cbu']);
        }
        
        if (is_null($Row['finalcontr'] || $Row['finalcontr'] === '0000-00-00')) {
            $entity->setBajaFechaContrato(null);
        } else {
            $entity->setBajaFechaContrato(new \DateTime($Row['finalcontr']));
        }
        
        if ($Row['decreto2']) {
            $entity->setBajaDecreto(\Yacare\MunirgBundle\Helper\StringHelper::FormatearActoAdministrativo($Row['decreto2']));
        } else {
            $entity->setBajaDecreto(null);
        }
        
        $entity->setSuprimido(false);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $resultado;
    }
    

    /**
     * @Route("categoriamovimiento/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarHistorialCategoriasAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 100;
    
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
    
        $em = $this->getDoctrine()->getManager();
    
        $DbRecursos = $this->ConectarRrhh();
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        foreach ($DbRecursos->query("SELECT * FROM movcategorias WHERE legajo= 3236") as $MovimAgente) {
            $entity = $em->getRepository('YacareRecursosHumanosBundle:AgenteCategoriaMovim')->findOneBy(array());
            // 'ImportSrc' => 'rr_hh.movcategorias',
            // 'ImportId' => $MovimAgente['legajo']
    
            if (! $entity) {
                $entity = new \Yacare\RecursosHumanosBundle\Entity\AgenteCategoriaMovim();
                $this->Categorias($entity, $MovimAgente);
                $importar_importados ++;
            } else {
                $this->Categorias($entity, $MovimAgente);
                $importar_actualizados ++;
            }
        }
        log($MovimAgente['legajo']);
        $res = $this->ConstruirResultado(new \Tapir\AbmBundle\Helper\Resultados\ResultadoEditarGuardarAction($this),
            $request);
        $res->Entidad = $entity;
        $res->Actualizados = $importar_actualizados;
        $res->Importados = $importar_importados;
        $res->Procesados = $importar_procesados;
        return array('res' => $res);
    }
    
}