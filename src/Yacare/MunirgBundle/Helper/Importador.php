<?php
namespace Yacare\MunirgBundle\Helper;

use \Yacare\MunirgBundle\Helper\ResultadoImportacion;

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
    
    function __construct($container, $em) {
        $this->container = $container;
        $this->em = $em;
    }
    
    public function Inicializar() {
        
    }
    
    public function Importar($desde, $cantidad) {
        $this->PreImportar();
        
        $resultado = new ResultadoImportacion();
        $resultado->RegistrosTotal = $this->ObtenerCantidadTotal();
        
        $Registros = $this->ObtenerRegistros($desde, $cantidad);
        foreach ($Registros as $Registro) {
            $resultado->AgregarResultados($this->ImportarRegistro($Registro));
        }
        
        // Si se solicitó un parcial y se procesaron todos los solicitados, asumo que hay más.
        // Si se procesó menos de lo solicitado, asumo que es porque se acabaron los registros.
        $resultado->HayMasRegistros = $cantidad != 0 && $resultado->ObtenerCantidadDeRegistrosProcesados() >= $cantidad;
        
        $this->PostImportar();
        
        return $resultado;
    }
    
    
    public function PreImportar() {
        mb_internal_encoding('UTF-8');
        ini_set('display_errors', 1);
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
        $this->em->getConnection()->commit();
    }
}