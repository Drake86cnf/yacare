<?php
namespace Yacare\MunirgBundle\Helper\Importador;

/**
 * Describe el resutlado de un proceso de importación de registros. 
 * 
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
class ResultadoImportacion {
    /**
     * El importador del cual provienen estos datos.
     */
    protected $Importador;
    
    /**
     * El número de registro inicial de esta importación.
     */
    public $Desde = 0;
    
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
     * La cantidad total de registros disponibles en origen.
     */
    public $RegistrosTotal = 0;

    public $Registros = array();
    public $Mensajes = array();
    
    function __construct(Importador $importador) {
        $this->Importador = $importador;
        $this->RegistrosTotal = $this->Importador->ObtenerCantidadTotal();
    }
    
    /**
     * Incorpora el resultado de un lote al resultado de la importación.
     * 
     * @param RestuladoLote $resultado
     */
    public function AgregarResultadoLote($resultado) {
        $this->AgregarContadoresLote($resultado);
        $this->Registros = array_merge($this->Registros, $resultado->Registros);
        $this->Mensajes = array_merge($this->Mensajes, $resultado->Mensajes);
    }
    
    /**
     * Incorpora los contadores de un resultado parcial dentro de otro resultado parcial o total.
     *
     * @param ImportarResultado $resultado
     */
    public function AgregarContadoresLote($resultado)
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
     */
    public function IncrementarContadores($nuevos, $actualizados, $haymas) {
        $this->RegistrosNuevos += $nuevos;
        $this->RegistrosActualizados += $actualizados;
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
    public function TotalRegistrosProcesados() {
        return $this->RegistrosNuevos + $this->RegistrosActualizados + $this->RegistrosIgnorados;
    }
    
    /**
     * Devuelve la posición del cursor (el último registro procesado).
     */
    public function PosicionCursor() {
        return $this->Desde + $this->TotalRegistrosProcesados();
    }
    
    /**
     * Devuelve true si hay más registros para importar.
     */
    public function HayMasRegistros() {
        return $this->PosicionCursor() < $this->RegistrosTotal;
    }
}
