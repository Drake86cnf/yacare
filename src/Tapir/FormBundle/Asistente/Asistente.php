<?php

namespace Tapir\FormBundle\Asistente;

/**
 * @package PeytzWizard
 */
class Asistente implements IAsistente, \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    protected $steps = array();

    /**
     * @var object
     */
    protected $entidad;

    /**
     * Generates a token to be used for saving
     */
    public function __construct($entidad = null)
    {
        if ($entidad) {
            $this->setEntidad($entidad);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function add(IPaso $step)
    {
        $this->steps[$step->getName()] = $step;
    }

    /**
     * {@inheritDoc}
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;
    }

    /**
     * {@inheritDoc}
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->steps;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return current($this->all());
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return current(array_reverse($this->all()));
    }

    /**
     * {@inheritDoc}
     */
    public function remove($identifier)
    {
        unset($this->steps[$identifier]);
    }

    /**
     * {@inheritDoc}
     */
    public function set(IPaso $step)
    {
        $this->steps[$step->getName()] = $step;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($identifier)
    {
        return $this->has($identifier) ? $this->steps[$identifier] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function has($identifier)
    {
        return isset($this->steps[$identifier]);
    }


    /**
     * @return IPaso
     */
    public function getLastVisibleStep()
    {
        $report = $this->getReport();

        $steps = array_filter($this->all(), function (IPaso $step) use ($report) {
            return $step->isVisible($report);
        });

        return end($steps);
    }

    /**
     * @param  IPaso $step
     * @return IPaso
     */
    public function getNextStepByStep(IPaso $step)
    {
        $steps = array_keys($this->steps);
        $position = array_search($step->getName(), $steps) + 1;

        return isset($steps[$position]) ? $this->get($steps[$position]) : null;
    }

    /**
     * @param  IPaso $step
     * @return IPaso
     */
    public function getPreviousStepByStep(IPaso $step)
    {
        $steps = array_keys($this->steps);
        $position = array_search($step->getName(), $steps) - 1;

        return isset($steps[$position]) ? $this->get($steps[$position]) : null;
    }

    /**
     * @see IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->steps);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->steps);
    }
}
