<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para reportar problema.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ReportarProblemaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Notas', null, array(
                'label' => 'Asunto',
                'attr' => array('autofocus' => 'autofocus'),
                'required' => true))
            ->add('Categoria', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'label' => 'Categoría',
                'class' => 'Yacare\RequerimientosBundle\Entity\Categoria',
                'attr' => array('help' => 'Si no sabe cual seleccionar, puede dejarla en blanco para que el 
                    administrador asigne una.'),
                'required' => false))
            ->add('Obs', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
                'label' => 'Observaciones',
                'attr' => array('readonly' => true),
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'));
    }
}
