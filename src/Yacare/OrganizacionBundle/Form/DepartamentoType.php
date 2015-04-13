<?php
namespace Yacare\OrganizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DepartamentoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Codigo', null, array('label' => 'Código'))
            ->add('Nombre', null, array('label' => 'Nombre','required' => true))
            ->add('Rango', 'choice', 
            array(
                'choices' => array(
                    '1' => 'Ejecutivo',
                    '20' => 'Ministerio',
                    '30' => 'Secretaría',
                    '40' => 'Subsecretaría',
                    '50' => 'Dirección',
                    '60' => 'Subdirección'),
                'label' => 'Rango'))
            ->add('ParentNode', 'entity', 
            array(
                'label' => 'Depende de',
                'class' => 'YacareOrganizacionBundle:Departamento',
                'required' => false,
                'placeholder' => 'Ninguno',
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.MaterializedPath', 'ASC');
                },
                'property' => 'NombreConSangriaDeEspaciosDuros'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\OrganizacionBundle\Entity\Departamento'));
    }

    public function getName()
    {
        return 'yacare_organizacionbundle_departamentotype';
    }
}
