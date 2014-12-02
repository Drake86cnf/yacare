<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatriculadoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Persona', 'entity_id', array(
                'label' => 'Persona',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true
            ))
            ->add('Profesion', 'choice', array(
                'label' => 'Profesion',
                'required' => true,
                'choices' => array(
                    'Ingeniero civil' => 'Ingeniero civil',
                    'Ingeniero en construcciones' => 'Ingeniero en construcciones',
                    'Arquitecto' => 'Arquitecto',
                    'Maestro mayor de obras' => 'Maestro mayor de obras',
                    'Técnico constructor' => 'Técnico constructor'
                )
            ))
            ->add('FechaVencimiento', 'date', array(
                'years' => range(2000, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de vencimiento',
                'required' => false
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_matriculadotype';
    }
}
