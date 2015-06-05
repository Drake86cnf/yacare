<?php
namespace Yacare\RecursosHumanosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenteGrupoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'))->add('NombreLdap', null, 
            array('label' => 'Nombre LDAP'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\RecursosHumanosBundle\Entity\AgenteGrupo'));
    }

    public function getName()
    {
        return 'yacare_recursoshumanosbundle_agentegrupotype';
    }
}
