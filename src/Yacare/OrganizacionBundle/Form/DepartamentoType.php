<?php
namespace Yacare\OrganizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

/**
 * Formulario para Departamentos Municipales.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DepartamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array(
                'label' => 'Código'))
            ->add('Nombre', null, array(
                'label' => 'Nombre', 
                'required' => true))
            ->add('Rango', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => \Yacare\OrganizacionBundle\Entity\Departamento::NombresRangos(),
                'label' => 'Rango'))
            ->add('ParentNode', 'entity', array(
                'label' => 'Depende de', 
                'class' => 'YacareOrganizacionBundle:Departamento', 
                'required' => false, 
                'placeholder' => 'Ninguno', 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.MaterializedPath', 'ASC');
                }, 
                'property' => 'NombreConSangriaDeEspaciosDuros'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\OrganizacionBundle\Entity\Departamento'));
    }
}
