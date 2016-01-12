<?php
namespace Yacare\NominaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulario para una etiqueta de inmuebles.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InmuebleEtiquetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre', 'required' => true))
            ->add('Obs', null, array('label' => 'Obs.', 'required' => false));
    }
}
