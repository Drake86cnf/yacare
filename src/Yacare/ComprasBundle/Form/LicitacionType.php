<?php
namespace Yacare\ComprasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LicitacionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Departamento', 'entity', 
            array(
                'label' => 'Departamento',
                'empty_value' => 'Sin especificar',
                'class' => 'YacareOrganizacionBundle:Departamento',
                'required' => false,
                'empty_value' => false,
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er)
                {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.MaterializedPath', 'ASC');
                },
                'property' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('Numero', null, array('label' => 'Número'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('PresupuestoOficial', null, array('label' => 'Presupuesto oficial'))
            ->add('Complejidad1', 'choice', 
            array(
                'label' => 'Cantidad de renglones',
                'required' => true,
                'choices' => array('0' => 'Baja: de 1 a 20','1' => 'Media: de 21 a 40','2' => 'Alta: más de 40')))
            ->add('Complejidad2', 'choice', 
            array(
                'label' => 'Cantidad de ítem de E.T.',
                'required' => true,
                'choices' => array('0' => 'Baja: de 1 a 5','1' => 'Media: de 6 a 10','2' => 'Alta: más de 10')))
            ->add('Complejidad3', 'choice', 
            array(
                'label' => 'Presupuesto oficial',
                'required' => true,
                'choices' => array(
                    '0' => 'Baja: más de 800.000, hasta 2.000.000',
                    '1' => 'Media: más de 2.000.000, hasta 5.000.000',
                    '2' => 'Alta: más de 5.000.00')))
            ->add('Obs', null, 
            array(
                'label' => 'Obs.',
                'attr' => array('class' => 'tinymce','data-theme' => 'simple')) // simple, advanced, bbcode
);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComprasBundle\Entity\Licitacion'));
    }

    public function getName()
    {
        return 'yacare_comprasbundle_licitaciontype';
    }
}
