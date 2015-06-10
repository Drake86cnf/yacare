<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\DBAL\DriverManager;

/**
 * Trait que agrega la capacidad de eliminar entidades.
 *
 * La entidad controlada por el controlador debe ser Eliminable o Suprimible.
 *
 * @see \Tapir\BaseBundle\Entity\Eliminable
 * @see \Tapir\BaseBundle\Entity\Suprimible
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConEliminar
{
	/**
	 * @ignore
	 */
	protected function getEm()
	{
		$em = $this->getDoctrine()->getManager();
		return $em;
	}
	

    /**
     * Crea el formulario de eliminación.
     */
    protected function crearFormEliminar($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar.html.twig")
     */
    public function eliminarAction(Request $request, $id)
    {
        $deleteForm = $this->crearFormEliminar($id);
        
        $em = $this->getEm();
        $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }
        else {
        	/*
        	 * Pequeña rutina que trae el listado de todas las tablas existentes en la DB
        	 * incluyendo aquellas que no son referenciadas desde una Entidad o especificada en los metadatos.
        	 */
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
        	//----------------------------------------------------------------------------------------//
        	
        	//Variables usadas para ir construyendo inteligentemente la sentencia SQL.
        	$tablaRemitente = $this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName;
        	$tablaRemitente = $em->getMetadataFactory()->getMetadataFor($tablaRemitente)->getTableName();
        	 
        	$resultado = $em->getClassMetadata($this->VendorName . $this->BundleName . 'Bundle:'. $this->EntityName)->getAssociationMappings();
        	 
        	//Llamo a la rutina de búsqueda y el valor devuelto (el contador) se lo asigno a esta variable $contador.
        	$contador = $this->rutinaBusqueda ($resultado, $id, $tablaRemitente);
        	print_r('Valor del contador: ' . $contador);
        }
        
        
        return $this->ArrastrarVariables($request, 
            array('entity' => $entity,'create' => $id ? false : true,'delete_form' => $deleteForm->createView()));
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar2/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar2.html.twig")
     */
    public function eliminar2Action(Request $request, $id)
    {
        $form = $this->crearFormEliminar($id);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository($this->VendorName . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);
            
            if (in_array('Tapir\BaseBundle\Entity\Suprimible', class_uses($entity))) {
                // Es suprimible (soft-deletable), lo marco como borrado, pero no lo borro
                $entity->Suprimir();
                $em->persist($entity);
                $em->flush();
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Se suprimió el elemento "' . $entity . '".');
                return $this->afterEliminar($entity, true);
            } else 
                if (in_array('Tapir\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                    // Es eliminable... lo elimino de verdad
                    $em->remove($entity);
                    $em->flush();
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'Se eliminó el elemento "' . $entity . '".');
                    return $this->afterEliminar($entity, true);
                } else {
                    // No es eliminable ni suprimible... no se puede borrar
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'No se puede eliminar el elemento "' . $entity . '".');
                }
        }
        
        return $this->afterEliminar($entity);
    }

    /**
     * Este método se dispara después de eliminar una entidad.
     *
     * @param bool $eliminado
     *            Indica si el elemento fue eliminado.
     */
    public function afterEliminar($entity, $eliminado = false)
    {
        return $this->redirect(
            $this->generateUrl($this->obtenerRutaBase('listar'), $this->ArrastrarVariables($request, null, false)));
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
    protected function construirSQL ($tablaRemitente, $id, $tablaDestinataria = null, $paramDes = null, $paramRem = null)
    {
    	$conn = $this->conectarDB();
    	 
    	//Creo un constructor de query y empiezo a construir la sentencia.
    	$queryBuilder = $conn->createQueryBuilder();
    	if($paramRem == null) {
    		$queryBuilder->select('p.id');
    	}
    	else {
    		$queryBuilder
    		->select('p.' . $paramRem);
    	}
    	$queryBuilder->from($tablaRemitente, 'p');
    	if ($tablaDestinataria != null) {
    		$queryBuilder->join('p', $tablaDestinataria, 'r', 'r.' .$paramDes);
    	}
    	$queryBuilder
    	->where('p.id = '. $id);
    	if ($tablaDestinataria != null && $paramDes != null) {
    		$queryBuilder->andwhere('p.id = r.' . $paramDes);
    	}
    
    	//Preparo la sentencia y luego la mando a ejecutar.
    	$statement = $conn->prepare($queryBuilder);
    	$statement->execute();
    
    	//Mando el resultado a un array.
    	$resultado = $statement->fetchAll();
    	 
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
     * @param array $result resultado de la consulta a la metadata de ORM.
     * @param mixed $conn conexión a la base de datos.
     * @param integer $id ID de la entidad a analizar.
     * @param string $tablaRemitente contiene la ruta a la clase de la entidad a estudiar.
     * @return integer $contador variable con la cantidad de relaciones encontradas para esa entidad.
     */
    protected function rutinaBusqueda($result, $id, $tablaRemitente)
    {
    	//$em = $this->getEm();
    	$contador = 0;
    	//Preparo la rutina de recorrido e identificación de las partes que compondrán la sentencia SQL.
    	 
    	//Recorro el array de la relación de la entidad a suprimir.
    	foreach ($result as $valorRes) {//Recorro el primer nivel del array devuelto
    		//con el mapeado de asociaciones.
    		
    	switch ($valorRes['type']) {
    		//Reconozco que es una relación OneToOne.
    		case 1:
    			break;
    			 
    			//Reconozco que es una relación ManyToOne. (No modifica el comportamiento si es uni o bidireccional)
    		case 2:
    			$contador += $this->rutinaManyToOne($valorRes, $tablaRemitente, $id);
    			break;
    
    			//Reconozco que es una relación OneToMany. (Indistinto si se trata de bidireccionales o unidireccionales)
    		case 4:
    			$contador += $this->rutinaOneToMany($valorRes, $id);
    			break;
    
    			//Reconozco que es una relación ManyToMany. (bidireccionales)
    		case 8:
    			$contador += $this->rutinaManyToMany($id, $tablaRemitente, $valorRes, $flag = false);
    			break;
    
    		default:
    			$contador = 'No posee relaciones';
    			break;
    	}
    	}
    	 
    	//$result2 = $em->getClassMetadata('Yacare\ObrasParticularesBundle\Entity\Acta')->getAssociationMappings();
    	//var_dump($result2);
    	 
    	return $contador;
    }
    /**
     * Rutina destinada a la consulta de asociaciones para relaciones de ManyToOne.
     *
     * Rutina simple, en la que sólo detecta la entidad objetivo, en el array de asociaciones
     * y busca concordancia entre la ID de la entidad estudiada, con la entidad objetivo.
     *
     * @param array $valorRes
     * @param string $tablaRemitente
     * @param int $id
     * @return int $contador
     */
    protected function rutinaManyToOne($valorRes, $tablaRemitente, $id)
    {
    	$em = $this->getEm();
    	$contador = 0;
    	$paramRemitente = $valorRes['targetToSourceKeyColumns']['id'];
    	$resultado = $this->construirSQL($tablaRemitente, $id, null, null, $paramRemitente);
    	 
    	if($resultado[0][$paramRemitente] != null){
    		$paramRemitente = $resultado[0][$paramRemitente];
    		$tablaDestinataria = $valorRes['targetEntity'];
    		$tablaDestinataria = $em->getMetadataFactory()->getMetadataFor($tablaDestinataria)->getTableName();
    		$contador = count($this->construirSQL($tablaDestinataria, $paramRemitente));
    	}
    	return $contador;
    }
    
    /**
     * Rutina encargada de manejar consulta en relaciones OneToMany.
     *
     * Rutina simple, extrae, la variable y la dirección de la entidad, que refieren al lado inverso de la relación.
     * Finaliza realizando una búsqueda en la entidad destinataria a partir del nombre de la variable extraída previamente, donde
     * ésta sea igual (=) a la $id de la entidad estudiada.
     *
     * @param array $valorRes
     * @param int $id
     * @return int
     */
    protected function rutinaOneToMany($valorRes, $id)
    {
    	$em = $this->getEm();
    	$contador = 0;
    	$paramDestinatario = $valorRes['mappedBy'];
    	$tablaDestinataria = $valorRes['targetEntity'];
    	$contador += count($em->getRepository($tablaDestinataria)->findBy(array($paramDestinatario => $id)));
    	return $contador;
    }
    
    /**
     * Rutina que se encarga de realizar la consulta para la relación ManyToMany.
     *
     * Comienza a partir del segundo nivel del array de relaciones correspondiente a la entidad estudiada.
     * Continúa buscando e identificando distintas partes para diferenciar los lados PROPIETARIOS e INVERSOS.
     *
     * @param int $id
     * @param string $tablaRemitente
     * @param array $valorRes
     * @return int $contador
     */
    protected function rutinaManyToMany($id, $tablaRemitente, $valorRes, $flag)
    {
    	$em = $this->getEm();
    	$contador = 0;
    	foreach ($valorRes as $llave2 => $res) {//Recorro el 2do. nivel del array. De acuerdo al campo que apunte el 'foreach' padre.
    		 
    		if ($llave2 == 'joinTable' && $res == null) {//Reconozco que se trata del lado INVERSO.
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
    		 
    		$contador += $this->rutinaLadoPropietario($id, $resPropietario, $nomVarPropietario, $tablaRemitente);
    	}
    	else {
    		$arraySegundoLvl = $this->esPropietarioOInverso($valorRes);
    		if ($arraySegundoLvl['ban'] == 1) {
    			$contador += count($this->construirSQL($tablaRemitente, $id, $arraySegundoLvl['tablaDes'], $arraySegundoLvl['paramDes']));
    		}
    	}
    	return $contador;
    }
    
    /**
     * Rutina para recorrer el array, de mapeado de asociacion, del lado Propietario de la relación en ManyToMany.
     *
     * @param int $id
     * @param array $resultado
     * @param string $clave
     * @param string $nomVarPropietario
     * @param string $tablaRemitente
     */
    protected function rutinaLadoPropietario ($id, $resultado, $nomVarPropietario = null, $tablaRemitente)
    {
    	$contador = 0;
    	foreach ($resultado as $clave => $valorRes) { //Recorro el primer nivel del array devuelto
    		//con el mapeado de asociaciones.
    	if ($clave == $nomVarPropietario) {
    		$indice = 1;
    		$arraySegundoLvl= $this->esPropietarioOInverso ($valorRes, $indice);
    		if ($arraySegundoLvl['ban'] == 1) {
    			$contador += count($this->construirSQL($tablaRemitente, $id, $arraySegundoLvl['tablaDes'], $arraySegundoLvl['paramDes']));
    		}
    		break;
    	}
    	else {
    		$arraySegundoLvl= $this->esPropietarioOInverso ($valorRes);
    		if ($arraySegundoLvl['ban'] == 1) {
    			$contador += count($this->construirSQL($tablaRemitente, $id, $arraySegundoLvl['tablaDes'], $arraySegundoLvl['paramDes']));
    		}
    	}
    	}
    	return $contador;
    }
    /**
     * Segunda parte de la rutina de Lado Propietario.
     *
     * En esta rutina, puede diferenciar si el acceso al lado propietario fue efectuado
     * después de acceder al lado INVERSO, o si el acceso fue directamente desde la
     * consulta raíz, es decir, el usuario ha querido suprimir una entidad la cual se
     * correspondia con el lado PROPIETARIO de una relación de asociación.
     *
     * @see rutinaLadoPropietario()
     *
     * @param array $valorRes
     * @param number $indice
     * @return multitype:number array de datos necesarios para la posterior cnsulta SQL.
     */
    private function esPropietarioOInverso ($valorRes, $indice = 0) {
    	$ban=0;
    	foreach ($valorRes as $llave2 => $res) { //Recorro el 2do. nivel del array.
    		//De acuerdo al campo que apunte el 'foreach' padre. (en caso de INVERSO)
    	if ($llave2 == 'joinTable' && $res != null) {
    		$ban = 1;
    		$tablaDestinataria = $res['name'];
    	}
    	if ($llave2 == 'joinTableColumns' && $ban == 1){//Índice que señala las columnas de la tabla intermedia.
    		$paramDes = $res[$indice]; //El índice es 1 para señañar la columna de la tabla INVERSA. 0 (cero) señalará a
    		//la columna de la tabla que es PROPIETARIA.
    	}
    	}
    	return array ('tablaDes' => $tablaDestinataria, 'paramDes' => $paramDes, 'ban' => $ban);
    }
}