<?php
namespace Yacare\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de tipo de faltas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class SeguimientoParamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('EntidadClase', null, array('label' => 'Clase', 'required' => true))
            ->add('DepartamentoInicial', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'class' => 'Yacare\OrganizacionBundle\Entity\Departamento',
                'label' => 'Departamento inicial',
                'required' => false))
            ->add('Departamentos', null, array('label' => 'Departamentos', 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\AdministracionBundle\Entity\SeguimientoParam'));
    }
}
