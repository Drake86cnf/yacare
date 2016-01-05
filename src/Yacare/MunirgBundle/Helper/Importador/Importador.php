<?php
namespace Yacare\MunirgBundle\Helper\Importador;

use \Yacare\MunirgBundle\Helper\Importador\ResultadoImportacion;

/**
 * Clase abstracta para crear importadores de datos.
 * 
 * @author @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
abstract class Importador {
    protected $container;
    protected $em;
    
    public $ResultadoNuevos;
    public $ResultadoActualizados;
    public $Where;
    
    function __construct($container, $em) {
        $this->container = $container;
        $this->em = $em;
    }
    
    public function Inicializar() {
        mb_internal_encoding('UTF-8');
    }
    
    public function Importar($desde, $cantidad) {
        $this->PreImportar();
        
        $resultado = new ResultadoImportacion($this);
        $resultado->Desde = $desde;
        
        $Registros = $this->ObtenerRegistros($desde, $cantidad);
        foreach ($Registros as $Registro) {
            $resultado->AgregarResultadoLote($this->ImportarRegistro($Registro));
        }
        
        $this->PostImportar();
        
        return $resultado;
    }
    
    
    public function PreImportar() {
        //ini_set('display_errors', 1);
        set_time_limit(600);
        ini_set('memory_limit', '2048M');
        
        $this->em->getConnection()->beginTransaction();
    }
    
    public function ObtenerCantidadTotal() {
        return 0;
    }
    
    public function ObtenerRegistros($desde, $cantidad) {
    
    }
    
    public function ImportarRegistro($Registro) {
    
    }
    
    public function PostImportar() {
        $this->em->flush();
        $this->em->getConnection()->commit();
        $this->em->clear();
    }
}
