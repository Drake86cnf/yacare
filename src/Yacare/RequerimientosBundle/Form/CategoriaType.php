<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre',
                'required' => true))
            ->add('Encargado', 'entity', array(
                'label' => 'Encargado predet.',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'query_builder' => function(\Yacare\BaseBundle\Entity\PersonaRepository $er) {
                    return $er->ObtenerQueryBuilderPorRol('ROLE_REQUERIMIENTOS_ENCARGADO');
                },
                'required' => true))
            ->add('PermiteAnonimos', new \Tapir\BaseBundle\Form\Type\SiNoType(), array(
                'label' => 'Admite anónimos',
                'required' => true))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\RequerimientosBundle\Entity\Categoria','cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_categoriatype';
    }
}
