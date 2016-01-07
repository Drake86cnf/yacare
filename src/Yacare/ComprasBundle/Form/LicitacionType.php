<?php
namespace Yacare\ComprasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;;

/**
 * Formulario de licitaciones.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class LicitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Departamento', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Departamento', 
                'empty_value' => 'Sin especificar', 
                'class' => 'YacareOrganizacionBundle:Departamento', 
                'required' => false, 
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.MaterializedPath', 'ASC');
                }, 
                'choice_label' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('Numero', null, array('label' => 'Número'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('PresupuestoOficial', null, array('label' => 'Presupuesto oficial'))
            ->add('Complejidad1', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Cantidad de renglones', 
                'required' => true, 
                'choices' => array('Baja: de 1 a 20' => 0, 'Media: de 21 a 40' => 1, 'Alta: más de 40' => 2)))
            ->add('Complejidad2', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Cantidad de ítem de E.T.', 
                'required' => true, 
                'choices' => array('Baja: de 1 a 5' => 0, 'Media: de 6 a 10' => 1, 'Alta: más de 10' => 2)))
            ->add('Complejidad3', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Presupuesto oficial', 
                'required' => true, 
                'choices' => array(
                    'Baja: más de 800.000, hasta 2.000.000' => 0, 
                    'Media: más de 2.000.000, hasta 5.000.000' => 1, 
                    'Alta: más de 5.000.00' => 2)))
            ->add('Obs', null, array(
                'label' => 'Obs.', 
                'attr' => array('class' => 'tinymce', 'data-theme' => 'simple'))); // simple, advanced, bbcode

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComprasBundle\Entity\Licitacion'));
    }
}
