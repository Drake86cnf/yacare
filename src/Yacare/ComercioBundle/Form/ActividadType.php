<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para un sola actividad.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
class ActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Clamae2014', null, array(
                'label' => 'Código ClaMAE 2014', 
                'required' => true, 
                'attr' => array(
                    'help' => 'No es necesario escribir los guiones. 
                        Para las divisiones 1 a la 9 prefijar con cero (01 a la 09).')))
            ->add('Nombre',null, array('label' => 'Nombre'))
            ->add('Etiquetas', null, array(
                'label' => 'Etiquetas',
                'multiple'=> true))
            ->add('Incluye', null, array('label' => 'Incluye'))
            ->add('NoIncluye', null, array('label' => 'No incluye'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Actividad'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_categoriatype';
    }
}
