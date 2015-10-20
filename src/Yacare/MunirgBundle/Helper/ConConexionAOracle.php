<?php
namespace Yacare\MunirgBundle\Helper;

/**
 * Trait que agrega la capacidad de conectar con la base de Oracle.
 *
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
trait ConConexionAOracle {
    protected $Dbmunirg;
    
    protected function ObtenerConexionAOracle()
    {
        $DbmuniHost = $this->container->getParameter('munirg_dbmuni_host');
        $DbmuniUsuario = $this->container->getParameter('munirg_dbmuni_usuario');
        $DbmuniContrasena = $this->container->getParameter('munirg_dbmuni_contrasena');
        
        $tns = '(DESCRIPTION =
			    (ADDRESS_LIST =
			        (ADDRESS =
			          (COMMUNITY = tcp.world)
			          (PROTOCOL = TCP)
			          (Host = ' . $DbmuniHost . ')
			          (Port = 1521)
			        )
			    )
			    (CONNECT_DATA = (SID = dbmunirg)
			    )
			  )';
    
        $this->Dbmunirg = new \PDO('oci:charset=UTF8;dbname=' . $tns, $DbmuniUsuario, $DbmuniContrasena);
        $this->Dbmunirg->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        return $this->Dbmunirg;
    }
    
    /**
     * Agrega una función de ventana a una consulta de Oracle.
     * 
     * @param string $sql La consulta a la cual agregar la función de ventana.
     * @param int $desde El registro inicial.
     * @param int $cantidad La cantidad de registros a obtener.
     */
    protected function OracleVentana($sql, $desde, $cantidad) {
        return 'SELECT * FROM (
            SELECT TMPSL.*, ROWNUM rnum FROM (' . $sql . ') TMPSL
                WHERE ROWNUM <=' . ($desde + $cantidad) . ')
                WHERE rnum >' . $desde;
    }
}