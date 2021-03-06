<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de talonario de actas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaTalonarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Tipo', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Tipo', 'class' => 'YacareInspeccionBundle:ActaTipo', 'required' => true))
            ->add('NumeroDesde', null, array('label' => 'Numeración desde'))
            ->add('NumeroHasta', null, array('label' => 'hasta'))
            ->add('EnPoderDe', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'En poder de', 
                'property' => 'NombreVisible', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'filters' => array('filtro_grupo' => 1), 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\InspeccionBundle\Entity\ActaTalonario'));
    }
}
