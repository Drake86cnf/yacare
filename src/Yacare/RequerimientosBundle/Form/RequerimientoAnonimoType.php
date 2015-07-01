<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoAnonimoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Notas', null, array(
                'label' => 'Asunto',
                'attr' => array ('placeholder' => ''),
                'required' => true))
            ->add('Categoria', null, array(
                'label' => 'Categoría',
                'attr' => array ('help' => 'Si no sabe cual seleccionar, puede dejarla en blanco para que el administrador asigne una.'),
                'required' => false))
            ->add('UsuarioNombre', null, array(
                'label' => 'Nombre',
                'attr' => array ('placeholder' => 'Su nombre'),
                'required' => false))
            ->add('UsuarioEmail', null, array(
                'label' => 'E-mail',
                'attr' => array ('placeholder' => 'Su dirección de correo electrónico.'),
                'required' => false))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento','cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_requerimientoanonimotype';
    }
}
