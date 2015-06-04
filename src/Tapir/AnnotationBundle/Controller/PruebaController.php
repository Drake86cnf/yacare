<?php

namespace Tapir\AnnotationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//Dependencias para la primera prueba de Annotation personalizada
use Doctrine\Common\Annotations\AnnotationReader;
use Tapir\AnnotationBundle\Conversion\PruebaAnnotationConverter;
use Tapir\AnnotationBundle\Entity\Prueba;

//Dependencias para la segunda prueba de Annotation personzalida
use Tapir\AnnotationBundle\Data\ClasePrueba2;

use Tapir\BaseBundle\Controller\AbmController;
use Doctrine\DBAL\DriverManager;

/**
 * @Route("prueba/")
 * 
 * @author eriquelme
 *
 */
class PruebaController extends AbmController
{
	
	/**
	 * @Route("index/")
	 * @Template("TapirAnnotationBundle:Default:index.html.twig")
	 * 
	 * @param unknown $name
	 */
    public function indexAction($name = null)
    {
    	//Primera prueba de una Annotation personalizada.
    	$reader = new AnnotationReader();
    	$converter = new PruebaAnnotationConverter($reader);
    	$prueba = new Prueba();
    	$PruebaAnnotation = $converter->convert($prueba);
    	
    	/* 
    	 * Rutina que trae la Annotation personalizada y extrae los valores que contenga;
    	 * como por ejemplo, una breve descripción por tipo de entidad.
    	 */
    	$procesador = $this->get('tapir_annotation.descripcion_procesador');
    	$objeto = new ClasePrueba2();
    	$procesador->fillObjectWithDefaultValues($objeto);
    	
    	/* 
    	 * Pequeña rutina que trae el listado de todas las tablas existentes en la DB
    	 * incluyendo aquellas que no son referenciadas desde una Entidad o especificada en los metadatos. 
    	 */
    	$em = $this->getDoctrine()->getManager();
    	$allTables = array();
    	$tables = $em->getConnection()->getSchemaManager()->listTables();
    	foreach ($tables as $table) {
    		$allTables[] = $table->getName();
    	}
    	
    	/*
    	 * Creo una pequeña lista negra donde aloja aquellos nombres de tablas que no pertenecen a Doctrine
    	 * y que no necesito. 
    	 */
    	$blackList = array('acta_adjunto', 'estadorequisito_adjunto', 'sys_log');
    	foreach ($allTables as $key => $table) {
    		foreach ($blackList as $elemento)
    			if ($table == $elemento) {
    				unset($allTables[$key]);
    			}
    	}
    	$allTables = array_values($allTables); //Reestablezco la numeración de la indexación.
    	//----------------------------------------------------------------------------------------
    	
    	$id= "1";
    	$em = $this->getEm();
    	$entity = $em->getRepository('Yacare\BaseBundle\Entity\Persona')->find($id);
    	
    	//Conexión a la base de datos
    	$conn = $this->conectarDB();
    	
    	//Variables usadas para ir construyendo inteligentemente la sentencia SQL.
    	$tablaRemitente = 'Base_Persona';
    	//$tablaDestinataria = '';
    	//$metaDes = '';
    	//$paramRem = 'Nombre';
    	//$paramDes = '';
    	 
    	$result = $em->getClassMetadata('Yacare\BaseBundle\Entity\PersonaGrupo')->getAssociationMappings();
    	//var_dump($result);
    	
    	//Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $contador.
    	$contador = $this->rutinaBusqueda ($result, $conn, $id, $tablaRemitente);
    		
    	
    	
    	/* OTRA FORMA DE CREAR UNA SENTENCIA PURA SQL
    	 * Realizo la conexion usando la propia conexion hecha por el EntityManager.
    	 * Preparo la sentencia y la ejecuto.
    	 * $conexion = $em->getConnection();
    	 * $sentencia = $conexion->prepare('SELECT id, ' . $paramRem . ' FROM ' . $tablaRemitente . ' JOIN ' . 
    	 *		$tablaDestinataria . ' ' . $paramDes . ' WHERE id = ' .$paramDes);
    	 * $sentencia->execute();
    	 */
    	
        return array('name'		=> $name, 
        			 'prueba'	=> $PruebaAnnotation, 
        			 'objeto'	=> $objeto, 
        			 'allTables'=> $allTables,
        			 'contador' => $contador
        );
    }
    /**
     * Establezco conexión con la base de datos.
     * 
     * Especifico los parámetros ya definidos en el 'parameters.yml', nuevamente, para
     * hacer conexión a la base de datos y usarla en métodos, propios de Doctrine,
     * que la requieran.
     * 
     * @return \Doctrine\DBAL\Connection
     */
    protected function conectarDB() 
    {
    	$config = new \Doctrine\DBAL\Configuration();
    	$parametros = array(
    			'dbname' => 'yacadev',
    			'user' => 'yacadev',
    			'password' => '123456',
    			'host' => 'localhost',
    			'driver' => 'pdo_mysql',
    			'charset' => 'UTF8',
    	);
    	$conn = DriverManager::getConnection($parametros, $config);
    	return $conn;
    }
    
    /**
     * Método para construir inteligentemente la sentencia SQL a partir de los parámetros dados.
     * 
     * Recibe los parámetros necesarios para construir cada parte de la sentencia SQL,
     * SELECT, FROM, JOIN y los WHERE (AND WHERE, OR WHERE). Luego prepara dicha consulta 
     * y la ejecuta. 
     * El resultado es llevado a un array, y se lo devuelve como variable de devolución del método
     * 
     * @param mixed $conn
     * @param string $paramRem
     * @param string $tablaRemitente
     * @param string $tablaDestinataria
     * @param string $paramDes
     * @param integer $id
     * @return mixed $resultado
     */
    protected function construirSQL ($conn, $tablaRemitente, $tablaDestinataria, $paramDes, $id) 
    {
    	//Creo un constructor de query y empiezo a construir la sentencia.
    	$queryBuilder = $conn->createQueryBuilder();
    	$queryBuilder
    	->select('p.id')
    	->from($tablaRemitente, 'p')
    	->join('p', $tablaDestinataria, 'r', 'r.' .$paramDes)
    	->where('p.id = '. $id)
    	->andwhere('p.id = r.' . $paramDes);
    		
    	//Preparo la sentencia y luego la mando a ejecutar.
    	$statement = $conn->prepare($queryBuilder);
    	$statement->execute();
    		
    	//Mando el resultado a un array.
    	$resultado = $statement->fetchAll();
    	//var_dump($resultado);
    	
    	return $resultado;
    }
    
    /**
     * Rutina de búsqueda de asociaciones, a partir de una entidad.
     * 
     * Realiza una búsqueda a través de todas aquellas tablas en donde, la entidad,
     * estudiada, tenga relaciones de asociaciones. Identifica y devuelve un contador
     * con la cantidad de asociaciones encontradas, tanto del lado propietario, como
     * del lado inverso.
     * Por el momento sólo identifica con relaciones bidireccionales ManyToMany.
     * 
     * @param mixed $result resultado de la consulta a la metadata de ORM.
     * @param mixed $conn coenxión a la base de datos.
     * @param integer $id ID de la entidad a analizar.
     * @param string $tablaRemitente contiene la ruta a la clase de la entidad a estudiar.  
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function rutinaBusqueda($result, $conn, $id, $tablaRemitente) 
    {
    	$em = $this->getEm();
    	$contador = 0; 
    	 
    	//Preparo la rutina de recorrido e identificación de las partes que compondrán la sentencia SQL.
    	 
    	//Lado inverso de la relación ManToMany.
    	foreach ($result as $llave1 => $valorRes) {//Recorro el primer nivel del array devuelto 
    											  //con el mapeado de asociaciones. INVERSO
    		$flag = false;
    		foreach ($valorRes as $llave2 => $res) {//Recorro el 2do. nivel del array. De acuerdo al campo que apunte el 'foreach' padre.
    			
    			if ($llave2 == 'joinTable' && $res == null) {
    				$flag = true;
    			}
    			if ($llave2 == 'targetEntity' && $flag) {
    				$metaDes = (string)$res;
    			}
    			if ($llave2 == 'mappedBy' && $flag) {
    				$nomVarPropietario = (string)$res;
    			}
    		}
    		if ($flag) {//Bandera que me determina si, en el lado inverso de la relación ManyToMany,
    					//se encontró el índice que referencia a la tabla intermedia.
    			$resPropietario = $em->getClassMetadata($metaDes)->getAssociationMappings();
    			
    			foreach ($resPropietario as $clave => $resProp) {//Recorro el primer nivel del array devuelto 
    															//con el mapeado de asociaciones. PROPIETARIO
    				if ($clave == $nomVarPropietario) {
    					//var_dump($resProp);
    					$ban=0;
    					foreach ($resProp as $clave2 => $r) { //Recorro el 2do. nivel del array. 
    													 	 //De acuerdo al campo que apunte el 'foreach' padre.
    						
    						if ($clave2 == 'joinTable' && $r != null) {
    							$ban = 1;
    							$tablaDestinataria = $r['name'];
    						}
    						if ($clave2 == 'joinTableColumns'){//Índice que señala las columnas de la tabla intermedia.
    							$paramDes = $r[1]; //El índice es 1 porque siempre el 0 (primer índice) señalará a
    											  //la columna de la tabla que es propietaria.
    						}
    					}
    					if ($ban == 1) {
    						$contador += count($this->construirSQL($conn, $tablaRemitente, $tablaDestinataria, $paramDes, $id));
    					}
    				}
    			}
    		}
    	}
    	
    	
    	$result2 = $em->getClassMetadata('Yacare\BaseBundle\Entity\Persona')->getAssociationMappings();
    	//var_dump($result2); 
    	$contador2=0;
    	/*
    	foreach ($result2 as $llave1 => $valorRes) { //Recorro el primer nivel del array devuelto con el mapeado de asociaciones.
    		print_r($llave1);
    		echo " ";
    		foreach ($valorRes as $llave2 => $res) { //Recorro el 2do. nivel del array.
    			var_dump($llave2);
    			if ($llave2 == 'joinTable' && $res != null) {
    				$ban = 1;
    				$tablaDestinataria = $res['name'];
    				print_r($tablaDestinataria);
    			}
    			if ($llave2 == 'joinTableColumns'){
    				$ban = 1;
    				$paramDes = $res[0];
    				print_r($paramDes);
    			}
    			var_dump($res);
    		}
    		if ($ban == 1) {
    			$contador2 += count($this->construirSQL($conn, $tablaRemitente, $tablaDestinataria, $paramDes, $id));
    			print_r($contador2);
    		}
    		$ban = 0;
    	}*/
    	return $contador;
    }
}
