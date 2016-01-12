<?php
namespace Yacare\NominaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para inmuebles.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InmuebleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                    'label' => 'Partida',
                    'class' => 'Yacare\CatastroBundle\Entity\Partida',
                    'required' => true))
            ->add('Domicilio', null, array('label' => 'Domicilio'))
            ->add('Url', null, array('label' => 'Sitio web'))
            ->add('Telefonos', null, array('label' => 'Teléfonos'))
            ->add('Horario', null, array('label' => 'Horario'))
            ->add('Etiquetas', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'Yacare\NominaBundle\Entity\InmuebleEtiqueta',
                'multiple' => true,
                'label' => 'Etiquetas',
                'placeholder' => 'Seleccione una o más etiquetas',
                'required' => false))
            ->add('Obs', null, array('label' => 'Observaciones'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\NominaBundle\Entity\Inmueble'));
    }
}
