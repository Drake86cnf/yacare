<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para un grupo asociativo de personas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaGrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\PersonaGrupo'));
    }

    public function getName()
    {
        return 'yacare_basebundle_personagrupotype';
    }
}
