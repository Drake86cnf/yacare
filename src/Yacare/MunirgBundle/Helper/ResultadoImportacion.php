<?php
namespace Yacare\MunirgBundle\Helper;

/**
 * Describe el resutlado total o parcial de un proceso de importación de registros. 
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ResultadoImportacion {
    /**
     * La cantidad total de registros importables. 
     */
    public $RegistrosTotal = 0;

    /**
     * La cantidad registros que se agregaron durante esta importación. 
     */
    public $RegistrosNuevos = 0;
    
    /**
     * La cantidad registros que ya existían y se actualizaron durante esta importación.
     */
    public $RegistrosActualizados = 0;
    
    /**
     * La cantidad de registros que fueron ignorados.
     */
    public $RegistrosIgnorados = 0;

    /**
     * Indica si existen más registros para importar, además de los incluidos en este resultado.
     */
    public $HayMasRegistros = false;

    public $Registros = array();
    public $Mensajes = array();
    
    /**
     * Incorpora un resultado parcial dentro de otro resultado parcial o total.
     * 
     * @param ImportarResultado $resultado
     */
    public function AgregarResultados($resultado) {
        $this->AgregarContadores($resultado);
        if($resultado->HayMasRegistros) {
            $this->HayMasRegistros = true;
        }
        
        $this->Registros = array_merge($this->Registros, $resultado->Registros);
        $this->Mensajes = array_merge($this->Mensajes, $resultado->Mensajes);
    }
    
    /**
     * Incorpora los contadores de un resultado parcial dentro de otro resultado parcial o total.
     *
     * @param ImportarResultado $resultado
     */
    public function AgregarContadores($resultado)
    {
        $this->RegistrosNuevos += $resultado->RegistrosNuevos;
        $this->RegistrosActualizados += $resultado->RegistrosActualizados;
        $this->RegistrosIgnorados += $resultado->RegistrosIgnorados;
    }
    
    /**
     * Incorpora un resultado parcial dentro de otro resultado parcial o total.
     * 
     * @param int $nuevos La cantidad de registros nuevos.
     * @param int $actualizados La cantidad de registros actualizados.
     * @param bool $haymas Indica si hay más registros para importar.
     */
    public function AgregarResultado($nuevos, $actualizados, $haymas) {
        $this->RegistrosNuevos += $nuevos;
        $this->RegistrosActualizados += $actualizados;
        if($haymas) {
            $this->HayMasRegistros = true;
        }
    }
    
    
    /**
     * Agrega un registro al resultado.
     * 
     * @param object $registro
     */
    public function AgregarRegistro($registro) {
        $this->Registros[] = $registro;
    }
    
    /**
     * Agrega un mensaje al log del resultado.
     *
     * @param string $mensaje
     */
    public function AgregarMensaje($mensaje) {
        $this->Mensajes[] = $mensaje;
    }
    
    /**
     * Devuelve la cantidad de registros procesados.
     * 
     * @return int La sumatoria de registros nuevos, actualizados e ignorados.
     */
    public function ObtenerCantidadDeRegistrosProcesados() {
        return $this->RegistrosNuevos + $this->RegistrosActualizados + $this->RegistrosIgnorados;
    }
}