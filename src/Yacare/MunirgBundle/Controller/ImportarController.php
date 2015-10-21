<?php
namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\BaseBundle\Helper\StringHelper;
use Yacare\MunirgBundle\Helper\ImportadorPartidas;

/**
 * Controlador para importar datos de otras DB, a la DB de Yacaré.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 * 
 * @Route("importar/")
 */
class ImportarController extends \Tapir\BaseBundle\Controller\BaseController
{
    use \Yacare\MunirgBundle\Helper\ConConexionAOracle;
    
    /**
     * @Route("partidas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPartidasAction(Request $request)
    {
        $iniciar = (int) ($request->query->get('iniciar'));
        if($iniciar) {
            $desde = (int) ($request->query->get('desde'));
            $cantidad = 100;
            
            $importador = new ImportadorPartidas($this->container, $this->getDoctrine()->getManager());
            $importador->Inicializar();
            $resultado = $importador->Importar($desde, $cantidad);
           
            return $this->ArrastrarVariables($request, array(
                'importando' => 'partidas',
                'resultado' => $resultado,
                'desde' => $desde,
                'cantidad' => $cantidad,
                'hasta' => $desde + $cantidad,
                'siguientedesde' => ($resultado->HayMasRegistros ? $desde + $cantidad : 0)));
        } else {
            return $this->ArrastrarVariables($request, array(
                'importando' => 'partidas',
                'desde' => 0,
                'cantidad' => 0,
                'hasta' => 0
            ));
        }
    }

    /**
     * @Route("personas/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarPersonasAction(Request $request, $desde = 0)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 500;
        
        mb_internal_encoding('UTF-8');
        set_time_limit(600);
        ini_set('display_errors', 1);
        ini_set('memory_limit', '1024M');
        

        
        $Dbmunirg = $this->ConectarOracle();
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $GrupoContribuyentes = $em->getReference('YacareBaseBundle:PersonaGrupo', 3);
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $sql = "
            SELECT * FROM (
                SELECT a.*, ROWNUM rnum FROM (
            SELECT
                a.IND_LEYENDA,
                a.IND_IDENTIFICACION,
                a.NOMBRE,
                a.TG06100_ID,
                a.ALTA_FECHA,
                a.TELEFONOS,
                a.E_MAIL,
                a.BAJA_FECHA,
                a.BAJA_MOTIVO,
                a.INDIVIDUO_TIPO,
                a.TG06300_TG06300_ID,
                a.TR02100_TR02100_ID,
                a.TRIBUTARIA_ID,
                p.APELLIDOS Q_APELLIDOS,
                p.NOMBRES Q_NOMBRES,
                p.SEXO Q_SEXO,
                p.NACIMIENTO_FECHA Q_NACIMIENTO_FECHA,
                p.NACIMIENTO_LUGAR Q_NACIMIENTO_LUGAR,
                p.NACIONALIDAD Q_NACIONALIDAD,
                j.RAZON_SOCIAL J_RAZON_SOCIAL,
                j.TIPO_SOCIEDAD J_TIPO_SOCIEDAD,
                j.NOMBRE_FANTASIA J_NOMBRE_FANTASIA,
                j.IDENTIFICACION_TRIBUTARIA J_IDENTIFICACION_TRIBUTARIA,
                d.PAIS,
                d.PROVINCIA,
                d.CODIGO_POSTAL,
                d.LOCALIDAD,
                d.CODIGO_CALLE,
                d.CALLE,
                d.NUMERO,
                d.NUMERO_EXTENSION,
                d.PISO,
                d.DEPARTAMENTO,
                d.LOCAL,
                d.DOMICILIO_EXTENSION,
                doc.DOCUMENTO_TIPO,
                doc.DOCUMENTO_NRO
            FROM TG06100X a
                LEFT JOIN TG06110 p ON a.TG06100_ID = p.TG06100_TG06100_ID
                LEFT JOIN TG06120 j ON a.TG06100_ID = j.TG06100_TG06100_ID
                LEFT JOIN TG06300 d ON a.TG06300_TG06300_ID = d.TG06300_ID
                LEFT JOIN TG06111 doc ON a.TG06100_ID = doc.TG06110_TG06100_TG06100_ID
                JOIN TR02100 imp ON a.TG06100_ID = imp.TIT_TG06100_ID
            WHERE a.BAJA_MOTIVO IS NULL
                AND a.NOMBRE<>'NN'
                AND imp.IMPONIBLE_TIPO='IND' AND imp.DEFINITIVO='D'
                AND d.LOCALIDAD='RIO GRANDE' 
                AND a.NOMBRE NOT LIKE '?%'
            ORDER BY a.TG06100_ID
            ) a 
                WHERE ROWNUM <=" . ($desde + $cant) . ")
            WHERE rnum >" . $desde . "
            ";
        
        foreach ($Dbmunirg->query($sql) as $Row) {
            $Documento = StringHelper::ObtenerDocumento($Row['IND_IDENTIFICACION']);
            $Apellido = StringHelper::Desoraclizar($Row['Q_APELLIDOS']);
            $Nombre = StringHelper::Desoraclizar($Row['Q_NOMBRES']);
            $RazonSocial = StringHelper::Desoraclizar($Row['J_RAZON_SOCIAL']);
            $PersJur = false;
            
            if ($Documento[0] == 'CUIL' && (substr($Documento[1], 0, 3) == '30-' || substr($Documento[1], 0, 3) == '33-')) {
                $Documento[0] = 'CUIT';
                $PersJur = true;
            }
            
            if ($Row['DOCUMENTO_TIPO'] == 'DU') {
                $Row['DOCUMENTO_TIPO'] = 'DNI';
            }
            
            $Cuilt = '';
            if ($Documento[0] == 'CUIL' || $Documento[0] == 'CUIT') {
                $Cuilt = str_replace('-', '', $Documento[1]);
                if ($Row['DOCUMENTO_TIPO'] && $Row['DOCUMENTO_NRO']) {
                    $Documento[0] = $Row['DOCUMENTO_TIPO'];
                    $Documento[1] = $Row['DOCUMENTO_NRO'];
                }
            } else 
                if ($Row['DOCUMENTO_TIPO'] == 'CUIL' || $Row['DOCUMENTO_TIPO'] == 'CUIT') {
                    $Cuilt = str_replace('-', '', $Row['DOCUMENTO_NRO']);
                }
            
            if ($Documento[0] == 'CUIL') {
                $Partes = explode('-', $Documento[1]);
                if (count($Partes) == 3) {
                    $Documento[0] = 'DNI';
                    $Documento[1] = (int) ($Partes[1]);
                }
            }
            
            if (! $Documento[1]) {
                // No tengo documento, utilizo el campo TRIBUTARIA_ID
                $Documento[0] = 'DNI';
                $Partes = explode('-', $Documento[1]);
                if (count($Partes) == 3) {
                    $Documento[1] = (int) ($Partes[1]);
                } else {
                    $Documento[1] = trim($Row['TRIBUTARIA_ID']);
                }
            }
            
            if (! $Nombre && ! $Apellido) {
                $Apellido = StringHelper::Desoraclizar($Row['NOMBRE']);
            }
            
            if (! $Nombre && $Apellido && strpos($Apellido, '.') === false) {
                $a = explode(' ', $Apellido, 2)[0];
                $b = trim(substr($Apellido, strlen($a)));
                $Nombre = $b;
                $Apellido = $a;
            }
            
            if ($RazonSocial) {
                $NombreVisible = $RazonSocial;
            } else 
                if ($Nombre) {
                    $NombreVisible = $Apellido . ', ' . $Nombre;
                } else {
                    $NombreVisible = $Apellido;
                }
            
            $Row['TG06100_ID'] = (int) ($Row['TG06100_ID']);
            $CodigoCalle = $this->ArreglarCodigoCalle($Row['CODIGO_CALLE']);
            
            if (! $Cuilt) {
                $Cuilt = str_replace(array(' ', '-', '.'), '', $Row['J_IDENTIFICACION_TRIBUTARIA']);
            }
            
            $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                array('Tg06100Id' => $Row['TG06100_ID']));
            
            if ($entity == null && $Cuilt) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(array('Cuilt' => $Cuilt));
            }
            
            if ($entity == null) {
                $entity = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                    array(
                    /* 'DocumentoTipo' => $TipoDocs[$Documento[0]], */
                    'DocumentoNumero' => $Documento[1]));
            }
            
            if ($entity == null) {
                $entity = new \Yacare\BaseBundle\Entity\Persona();
                $entity->setTg06100Id($Row['TG06100_ID']);
                
                $entity->setDomicilioCodigoPostal('9420');
                if ($CodigoCalle) {
                    $entity->setDomicilioCalle($em->getReference('YacareCatastroBundle:Calle', $CodigoCalle));
                }
                $entity->setDomicilioCalleNombre(StringHelper::Desoraclizar($Row['CALLE']));
                $entity->setDomicilioNumero($Row['NUMERO']);
                $entity->setDomicilioPiso($Row['PISO']);
                $entity->setDomicilioPuerta($Row['DEPARTAMENTO']);
                
                // Si no está en el grupo Contribuyentes, lo agrego
                if ($entity->getGrupos()->contains($GrupoContribuyentes) == false) {
                    $entity->getGrupos()->add($GrupoContribuyentes);
                }
                if ($Row['Q_SEXO'] == 'F') {
                    $entity->setGenero(2);
                } else 
                    if ($Row['Q_SEXO'] == 'M') {
                        $entity->setGenero(1);
                    }
                
                $em->persist($entity);
                $importar_importados ++;
            } else {
                $entity->setTg06100Id($Row['TG06100_ID']);
                // $entity->setRazonSocial($RazonSocial);
                $importar_actualizados ++;
            }
            
            $entity->setNombre($Nombre);
            $entity->setApellido($Apellido);
            $entity->setRazonSocial($RazonSocial);
            $entity->setPersonaJuridica($PersJur);
            $entity->setDocumentoNumero($Documento[1]);
            if (! $entity->getCuilt() && $Cuilt) {
                $entity->setCuilt($Cuilt);
            }
            
            // Campos que se actualizan siempre
            $entity->setDocumentoTipo($TipoDocs[$Documento[0]]);
            
            $log[] = $Cuilt . ' / ' . $Documento[0] . ' ' . $Documento[1] . ': ' . $NombreVisible . "\r\n";
            $importar_procesados ++;
            
            $em->flush();
            
            if (($importar_procesados % 100) == 0) {
                ob_flush();
                flush();
                
                $em->getConnection()->commit();
                $em->getConnection()->beginTransaction();
            }
        }
        
        ob_flush();
        flush();
        
        $em->getConnection()->commit();
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0), 
            'log' => $log);
    }

    /**
     * @Route("calles/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarCallesAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();
        
        $Dbmunirg = $this->ConectarOracle();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        foreach ($Dbmunirg->query(
            'SELECT CODIGO_CALLE AS id, CALLE AS Nombre FROM TG06405 WHERE TG06403_TG06403_ID=410') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['NOMBRE']);
            
            $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(
                array('ImportSrc' => 'dbmunirg.TG06405', 'ImportId' => $Row['ID']));
            
            if (! $entity) {
                $entity = $em->getRepository('YacareCatastroBundle:Calle')->findOneBy(array('Nombre' => $nombreBueno));
            }
            
            if (! $entity) {
                $entity = new \Yacare\CatastroBundle\Entity\Calle();
                /*
                 * $entity->setId($Row['ID']); $metadata = $em->getClassMetaData(get_class($entity));
                 * $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                 */
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            $entity->setImportSrc('dbmunirg.TG06405');
            $entity->setImportId($Row['ID']);
            $entity->setNombreOriginal($Row['NOMBRE'] . '!!!');
            
            $em->persist($entity);
            
            $importar_procesados ++;
            $log[] = $Row['ID'] . ' ' . $nombreBueno;
        }
        $em->flush();
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'log' => $log);
    }

    /**
     * @Route("departamentos/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarDepartamentosAction()
    {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        
        $em = $this->getDoctrine()->getManager();
        
        $DbRecursos = $this->ConectarRrhh();
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $Ejecutivo = $em->getRepository('YacareOrganizacionBundle:Departamento')->find(1);
        
        foreach ($DbRecursos->query('SELECT * FROM secretarias WHERE codigo<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.secretarias', 'ImportId' => $Row['codigo']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(30);
                $entity->setImportSrc('rr_hh.secretarias');
                $entity->setImportId($Row['codigo']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            
            $entity->setParentNode($Ejecutivo);
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Secretaría ' . $Row['codigo'] . " \t" . $nombreBueno;
        }
        
        foreach ($DbRecursos->query('SELECT * FROM direcciones WHERE secretaria<>999') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.direcciones', 'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(50);
                $entity->setImportSrc('rr_hh.direcciones');
                $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            }
            
            $Secre = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.secretarias', 'ImportId' => $Row['secretaria']));
            $entity->setParentNode($Secre);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Dirección ' . $Row['secretaria'] . '.' . $Row['direccion'] . " \t" . $nombreBueno;
        }
        
        foreach ($DbRecursos->query('SELECT * FROM sectores') as $Row) {
            $nombreBueno = StringHelper::Desoraclizar($Row['detalle']);
            $entity = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array(
                    'ImportSrc' => 'rr_hh.sectores', 
                    'ImportId' => $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']));
            
            if (! $entity) {
                $nuevoId = $this->getDoctrine()
                    ->getManager()
                    ->createQuery('SELECT MAX(r.id) FROM YacareOrganizacionBundle:Departamento r')
                    ->getSingleScalarResult();
                $entity = new \Yacare\OrganizacionBundle\Entity\Departamento();
                $entity->setId(++ $nuevoId);
                $entity->setRango(70);
                $entity->setImportSrc('rr_hh.sectores');
                $entity->setImportId($Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector']);
                
                $importar_importados ++;
            } else {
                $importar_actualizados ++;
            }
            
            $entity->setNombre($nombreBueno);
            
            if ($Row['fecha_baja']) {
                $entity->setSuprimido(true);
            } else {
                $entity->setSuprimido(false);
            }
            
            if ($Row['parte']) {
                $entity->setHaceParteDiario(true);
            } else {
                $entity->setHaceParteDiario(false);
            }
            
            $Dire = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array('ImportSrc' => 'rr_hh.direcciones', 'ImportId' => $Row['secretaria'] . '.' . $Row['direccion']));
            $entity->setParentNode($Dire);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = 'Sector ' . $Row['secretaria'] . '.' . $Row['direccion'] . '.' . $Row['sector'] . " \t" .
                 $nombreBueno;
        }
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'log' => $log);
    }

    /**
     * @Route("agentes/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarAgentesAction(Request $request)
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
        
        $GrupoAgentes = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find(1);
        
        foreach ($DbRecursos->query("SELECT * FROM agentes WHERE legajo = 54") as $Agente) {
            $entity = $em->getRepository('YacareRecursosHumanosBundle:Agente')->findOneBy(
                array('ImportSrc' => 'rr_hh.agentes', 'ImportId' => $Agente['legajo']));
            
            if (! $entity) {
                $entity = new \Yacare\RecursosHumanosBundle\Entity\Agente();
                
                // Asigno manualmente el ID
                $entity->setId((int) ($Agente['legajo']));
                $metadata = $em->getClassMetaData(get_class($entity));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                    array('DocumentoNumero' => trim($Agente['nrodoc'])));
                
                if (! $Persona) {
                    $Persona = new \Yacare\BaseBundle\Entity\Persona();
                    $Persona->setDocumentoNumero($Agente['nrodoc']);
                    $Persona->setDocumentoTipo((int) $Agente['tipodoc']);
                }
                $Persona->setNombre(StringHelper::Desoraclizar($Agente['name']));
                $Persona->setApellido(StringHelper::Desoraclizar($Agente['lastname']));
                if ($Agente['fechanacim']) {
                    $Persona->setFechaNacimiento(new \DateTime($Agente['fechanacim']));
                }
                $Persona->setTelefonoNumero(
                    trim(
                        str_ireplace('NO DECLARA', '', $Agente['telefono']) . ' ' .
                             str_ireplace('NO DECLARA', '', $Agente['celular'])));
                $Persona->setGenero($Agente['sexo'] == 1 ? 1 : 0);
                $Persona->setEmail(str_ireplace('NO DECLARA', '', strtolower($Agente['email'])));
                $Persona->setCuilt(trim($Agente['cuil']));
                
                $em->persist($Persona);
                $em->flush();
                
                $entity->setPersona($Persona);
                
                $entity->setImportSrc('rr_hh.agentes');
                $entity->setImportId($Agente['legajo']);
                
                $importar_importados ++;
            } else {
                $Persona = $entity->getPersona();
                $importar_actualizados ++;
            }
            
            $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                array(
                    'ImportSrc' => 'rr_hh.sectores', 
                    'ImportId' => $Agente['secretaria'] . '.' . $Agente['direccion'] . '.' . $Agente['sector']));
            
            if (! $Departamento) {
                $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                    array(
                        'ImportSrc' => 'rr_hh.direcciones', 
                        'ImportId' => $Agente['secretaria'] . '.' . $Agente['direccion']));
            }
            
            if (! $Departamento) {
                $Departamento = $em->getRepository('YacareOrganizacionBundle:Departamento')->findOneBy(
                    array('ImportSrc' => 'rr_hh.secretarias', 'ImportId' => $Agente['secretaria']));
            }
            
            $entity->setDepartamento($Departamento);
            $entity->setCategoria($Agente['categoria']);
            $entity->setSituacion($Agente['situacion']);
            $entity->setFuncion(StringHelper::Desoraclizar($Agente['funcion']));
            $entity->setBajaMotivo($Agente['motivo']);
            
            if ($Agente['excombatie'] == 'S') {
                $entity->setExCombatiente(1);
            }
            
            if ($Agente['discapacit'] == 'S') {
                $entity->setDiscapacitado(1);
            }
            
            if ($Agente['manohabil'] == 'I') {
                $entity->setManoHabil(1);
            }
            
            $entity->setEstudiosNivel($Agente['estudios']);
            if ($Agente['titulo'] == 999) {
                $entity->setEstudiosTitulo(null);
            } else {
                $entity->setEstudiosTitulo($Agente['titulo']);
            }
            
            if (\Tapir\BaseBundle\Helper\Cbu::EsCbuValida($Agente['cbu'])) {
                $entity->setCBUCuentaAgente(\Tapir\BaseBundle\Helper\Cbu::FormatearCbu($Agente['cbu']));
            }
            
            // Si no está en el grupo agentes, lo agrego
            if ($Persona->getGrupos()->contains($GrupoAgentes) == false) {
                $Persona->getGrupos()->add($GrupoAgentes);
                $em->persist($Persona);
            }
            
            // Le pongo el número de legajo en la persona
            if ($entity->getId()) {
                $Persona->setAgenteId($entity->getId());
            }
            
            if ($Agente['fechaingre']) {
                $entity->setFechaIngreso(new \DateTime($Agente['fechaingre']));
            } else {
                $entity->setFechaIngreso(null);
            }
            
            if (is_null($Agente['fechabaja']) || $Agente['fechabaja'] === '0000-00-00') {
                $entity->setBajaFecha(null);
                $entity->setArchivado(false);
            } else {
                $entity->setBajaFecha(new \DateTime($Agente['fechabaja']));
                $entity->setArchivado(true);
            }
            
            if (is_null($Agente['fechanacion'] || $Agente['fechanacion'] === '0000-00-00')) {
                $entity->setFechaNacionalizacion(null);
            } else {
                $entity->setFechaNacionalizacion(new \DateTime($Agente['fechanacion']));
            }
            
            if (is_null($Agente['ult_act_d'] || $Agente['ult_act_d'] === '0000-00-00')) {
                $entity->setUltimaActualizacionDomicilio(null);
            } else {
                $entity->setUltimaActualizacionDomicilio(new \DateTime($Agente['ult_act_d']));
            }
            
            if (is_null($Agente['fecha_psico'] || $Agente['fecha_psico'] === '0000-00-00')) {
                $entity->setFechaPsicofisico(null);
            } else {
                $entity->setFechaPsicofisico(new \DateTime($Agente['ult_act_d']));
            }
            
            if (is_null($Agente['fecha_CBC'] || $Agente['fecha_CBC'] === '0000-00-00')) {
                $entity->setFechaCertificadoBuenaConducta(null);
            } else {
                $entity->setFechaCertificadoBuenaConducta(new \DateTime($Agente['fecha_CBC']));
            }
            
            if (is_null($Agente['fecha_CAP'] || $Agente['fecha_CAP'] === '0000-00-00')) {
                $entity->setFechaCertificadoAntecedentesPenales(null);
            } else {
                $entity->setFechaCertificadoAntecedentesPenales(new \DateTime($Agente['fecha_CAP']));
            }
            
            if (is_null($Agente['fecha_CD'] || $Agente['fecha_CD'] === '0000-00-00')) {
                $entity->setFechaCertificadoDomicilio(null);
            } else {
                $entity->setFechaCertificadoDomicilio(new \DateTime($Agente['fecha_CD']));
            }
            
            if (\Tapir\BaseBundle\Helper\Cbu::EsCbuValida($Agente['cbu'])) {
                $entity->setCBUCuentaAgente($Agente['cbu']);
            }
            
            if (is_null($Agente['finalcontr'] || $Agente['finalcontr'] === '0000-00-00')) {
                $entity->setBajaFechaContrato(null);
            } else {
                $entity->setBajaFechaContrato(new \DateTime($Agente['finalcontr']));
            }
            
            if ($Agente['decreto2']) {
                $entity->setBajaDecreto(\Yacare\MunirgBundle\Helper\StringHelper::FormatearDecreto($Agente['decreto2']));
            }

            $entity->setSuprimido(false);
            
            $em->persist($entity);
            $em->flush();
            
            $importar_procesados ++;
            $log[] = $Agente['legajo'] . ': ' . (string) $entity . ($entity->getSuprimido() ? '*' : '') . ' -- ' .
                 (string) $entity->getDepartamento();
        }
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0), 
            'log' => $log);
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
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            // 'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0),
            'log' => $log);
    }

    

    protected function ConectarRrhh()
    {
        return new \PDO('mysql:host=192.168.100.5;dbname=rr_hh;charset=utf8', 'yacare', 'L1n4j3');
    }


    /**
     * @Route("matriculados/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarMatriculadosAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 100;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoMatriculados = fopen('MatriculadosFusion.csv', 'r');
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        $GrupoMatriculados = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find(4);
        
        while (! feof($ArchivoMatriculados)) {
            $Row = fgetcsv($ArchivoMatriculados);
            
            if ($Row && count($Row) > 1 && $Row[0]) {
                $entity = $em->getRepository('YacareObrasParticularesBundle:Matriculado')->find($Row[0]);
                
                if (! $entity) {
                    $entity = new \Yacare\ObrasParticularesBundle\Entity\Matriculado();
                    
                    // Asigno manualmente el ID
                    $entity->setId((int) ($Row[0]));
                    $metadata = $em->getClassMetaData(get_class($entity));
                    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                    
                    $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                        array('DocumentoNumero' => trim($Row[1])));
                    
                    if (! $Persona) {
                        $Persona = new \Yacare\BaseBundle\Entity\Persona();
                        $Persona->setDocumentoNumero($Row[1]);
                        $Persona->setDocumentoTipo(1);
                        
                        $log[] = 'Creando persona: DNI ' . $Row[1] . ', ' . $Row[2];
                    }
                    
                    $entity->setPersona($Persona);
                    
                    $importar_importados ++;
                } else {
                    $Persona = $entity->getPersona();
                    $importar_actualizados ++;
                }
                
                $ApellidoYNombres = StringHelper::ObtenerApellidoYNombres($Row[2]);
                
                $PartesDomicilio = StringHelper::ObtenerCalleYNumero($Row[3]);
                
                /*
                 * $Calle = $em->getRepository ( 'YacareCatastroBundle:Calle' )->findOneBy ( array (
                 * 'Nombre' => $this->ArreglarNombreCalle ( $PartesDomicilio [0] )
                 * ) );
                 */
                
                $Calles = $em->getRepository('YacareCatastroBundle:Calle')
                    ->createQueryBuilder('c')
                    ->where('c.Nombre LIKE :nombre')
                    ->setParameter('nombre', $this->ArreglarNombreCalle($PartesDomicilio[0]))
                    ->getQuery()
                    ->getResult();
                
                if (count($Calles) == 1) {
                    $Calle = $Calles[0];
                }
                
                if (! $Calle) {
                    $log[] = 'No existe la calle ' . $PartesDomicilio[0];
                }
                
                $Persona->setDomicilioCalle($Calle);
                $Persona->setDomicilioCalleNombre($PartesDomicilio[0]);
                $Persona->setDomicilioNumero($PartesDomicilio[1]);
                if (count($PartesDomicilio) > 2) {
                    $Persona->setDomicilioPuerta($PartesDomicilio[2]);
                }
                
                $Persona->setApellido(StringHelper::Desoraclizar($ApellidoYNombres[0]));
                $Persona->setNombre(StringHelper::Desoraclizar($ApellidoYNombres[1]));
                $Persona->setTelefonoNumero(trim($Row[5]));
                $Persona->setEmail(trim($Row[6]));
                
                $em->persist($Persona);
                $em->flush();
                
                switch ($Row[4]) {
                    case 'Arquitecto':
                    // no break
                    case 'Artquitecto':
                    case 'Arquiteto':
                        $Profesion = 'Arquitecto';
                        break;
                    case 'M.M. Obras':
                    // no break
                    case 'M.M Obras':
                    case 'M.M. Obra':
                    case 'M.M. Obrasº':
                    case 'M.M.Obras':
                        $Profesion = 'Maestro mayor de obras';
                        break;
                    case 'Ing. Construcc':
                    // no break
                    case 'Ing.Construcciones':
                    case 'Ing. Construcciones':
                        $Profesion = 'Ingeniero en construcciones';
                        break;
                    case 'Ing. Civil':
                    // no break
                    case 'Ing.Civil':
                        $Profesion = 'Ingeniero civil';
                        break;
                    case 'T. Constructor':
                        $Profesion = 'Técnico constructor';
                        break;
                    default:
                        $Profesion = '???';
                        break;
                }
                
                $entity->setProfesion($Profesion);
                
                if ($Row[7]) {
                    $fecha = \DateTime::createFromFormat('Y-m-d', $Row[7]);
                    $entity->setFechaVencimiento($fecha);
                } else {
                    $entity->setFechaVencimiento(null);
                }
                
                // Si no está en el grupo agentes, lo agrego
                if ($Persona->getGrupos()->contains($GrupoMatriculados) == false) {
                    $Persona->getGrupos()->add($GrupoMatriculados);
                    $em->persist($Persona);
                }
                
                $em->persist($entity);
                $em->flush();
                
                $importar_procesados ++;
                $log[] = $Row[0] . ': ' . (string) $entity . ' (' . $entity->getProfesion() . ')';
            }
        }
        
        fclose($ArchivoMatriculados);
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0), 
            'log' => $log);
    }

    /**
     * @Route("badabum/")
     * @Template("YacareMunirgBundle:Importar:importar.html.twig")
     */
    public function importarBadabumAction(Request $request)
    {
        $desde = (int) ($request->query->get('desde'));
        $cant = 500;
        
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $em = $this->getDoctrine()->getManager();
        
        $ArchivoCsv = fopen('badaum.csv', 'r');
        
        $importar_importados = 0;
        $importar_actualizados = 0;
        $importar_procesados = 0;
        $log = array();
        
        for ($i = 0; $i < $desde; $i ++) {
            fgetcsv($ArchivoCsv);
        }
        
        while (! feof($ArchivoCsv)) {
            $Row = fgetcsv($ArchivoCsv);
            
            if ($Row && count($Row) > 1 && $Row[0]) {
                $Persona = $em->getRepository('YacareBaseBundle:Persona')->findOneBy(
                    array('DocumentoNumero' => trim($Row[0])));
                
                if (! $Persona) {
                    $Persona = new \Yacare\BaseBundle\Entity\Persona();
                    $Persona->setDocumentoNumero($Row[0]);
                    $Persona->setDocumentoTipo(1);
                    
                    $ApellidoYNombres = StringHelper::ObtenerApellidoYNombres($Row[1]);
                    $Persona->setApellido(StringHelper::Desoraclizar($ApellidoYNombres[0]));
                    $Persona->setNombre(StringHelper::Desoraclizar($ApellidoYNombres[1]));
                    
                    $log[] = 'Creando persona: DNI ' . $Row[0] . ', ' . $Row[1];
                    
                    $importar_importados ++;
                } else {
                    $importar_actualizados ++;
                }
                
                $PartesDomicilio = StringHelper::ObtenerCalleYNumero($Row[2]);
                
                /*
                 * $Calle = $em->getRepository ( 'YacareCatastroBundle:Calle' )->findOneBy ( array (
                 * 'Nombre' => $this->ArreglarNombreCalle ( $PartesDomicilio [0] )
                 * ) );
                 */
                
                $Calles = $em->getRepository('YacareCatastroBundle:Calle')
                    ->createQueryBuilder('c')
                    ->where('c.Nombre LIKE :nombre')
                    ->setParameter('nombre', $this->ArreglarNombreCalle($PartesDomicilio[0]))
                    ->getQuery()
                    ->getResult();
                
                if (count($Calles) == 1) {
                    $Calle = $Calles[0];
                    $PartesDomicilio[0] = $Calle->getNombre();
                } else {
                    $Calle = null;
                }
                
                if ($Row[3]) {
                    $PartesDomicilio[1] = $Row[3];
                }
                
                if ($Row[4]) {
                    $PartesDomicilio[2] = $Row[4];
                }
                
                if (! $Calle) {
                    $log[] = 'No existe la calle ' . $PartesDomicilio[0];
                }
                
                $Persona->setDomicilioCalle($Calle);
                $Persona->setDomicilioCalleNombre($PartesDomicilio[0]);
                $Persona->setDomicilioNumero($PartesDomicilio[1]);
                if (count($PartesDomicilio) > 2) {
                    $Persona->setDomicilioPuerta($PartesDomicilio[2]);
                }
                
                if (! $Persona->getTelefonoNumero()) {
                    $Persona->setTelefonoNumero(trim($Row[6]));
                } else {
                    $Persona->setTelefonoNumero($Persona->getTelefonoNumero() . ', ' . trim($Row[6]));
                }
                
                if ((! $Persona->getFechaNacimiento()) && $Row[7]) {
                    $fecha = \DateTime::createFromFormat('d/m/Y', $Row[7]);
                    if ($fecha) {
                        $Persona->setFechaNacimiento($fecha);
                    }
                }
                
                // Si no está en el grupo, lo agrego
                if ($Row[8]) {
                    $Grupo = $em->getRepository('YacareBaseBundle:PersonaGrupo')->find($Row[8]);
                    if ($Persona->getGrupos()->contains($Grupo) == false) {
                        $Persona->getGrupos()->add($Grupo);
                    }
                }
                
                $em->persist($Persona);
                $em->flush();
                
                $importar_procesados ++;
                $log[] = $Row[0] . ': ' . (string) $Persona;
            }
            
            if ($importar_procesados >= $cant) {
                break;
            }
        }
        
        fclose($ArchivoCsv);
        
        return array(
            'importar_importados' => $importar_importados, 
            'importar_actualizados' => $importar_actualizados, 
            'importar_procesados' => $importar_procesados, 
            'redir_desde' => ($importar_procesados == $cant ? $desde + $cant : 0), 
            'log' => $log);
    }
}
