<?php
namespace Yacare\MunirgBundle\Helper\Importador;

/**
 * Trait que agrega la capacidad de conectar con la base de Gestión.
 *
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
trait ConConexionAGestion {
    protected $DbGestion;
    
    protected function ObtenerConexionAGestion()
    {
        if(!$this->DbGestion) {
            $this->DbGestion = new \PDO('mysql:host=192.168.130.5;dbname=rr_hh;charset=utf8',
                $this->container->getParameter('database_user'), $this->container->getParameter('database_password'));
        }
        
        return $this->DbGestion;
    }
}