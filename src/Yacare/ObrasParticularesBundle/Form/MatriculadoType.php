<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de matriculados.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class MatriculadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Profesion', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Profesion',
                'required' => true,
                'choices' => array(
                    'Ingeniero civil' => 'Ingeniero civil',
                    'Ingeniero en construcciones' => 'Ingeniero en construcciones',
                    'Arquitecto' => 'Arquitecto',
                    'Maestro mayor de obras' => 'Maestro mayor de obras',
                    'Técnico constructor' => 'Técnico constructor')))
            ->add('FechaVencimiento', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'years' => range(2000, 2099),
                'input' => 'datetime',
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de vencimiento',
                'required' => false))
            ->add('Persona', 'Yacare\ObrasParticularesBundle\Form\PersonaMatriculadoType', array(
                'label' => 'Persona'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado'));
    }
}
