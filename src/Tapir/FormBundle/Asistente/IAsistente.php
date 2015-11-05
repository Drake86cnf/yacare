<?php

namespace Tapir\FormBundle\Asistente;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
interface IAsistente
{
    /**
     * @return object
     */
    public function getEntidad();

    /**
     * @param object $entidad
     */
    public function setEntidad($entidad);

    /**
     * @return IPaso[]
     */
    public function all();

    /**
     * @return IPaso
     */
    public function first();

    /**
     * @param IPaso $step
     */
    public function set(IPaso $step);

    /**
     * @param  string        $identifier
     * @return IPaso
     */
    public function get($identifier);

    /**
     * @param  string  $identifier
     * @return boolean
     */
    public function has($identifier);

    /**
     * @return IPaso
     */
    public function last();

    /**
     * @param string $identifier
     */
    public function remove($identifier);

    /**
     * Run through all steps after and including `$step` and call `IPaso::process`.
     * This makes it possible to cleanup values that have been defined when jumping back
     * and forth between steps.
     *
     * @param IPaso $step
     */
    public function process(IPaso $step);
}
