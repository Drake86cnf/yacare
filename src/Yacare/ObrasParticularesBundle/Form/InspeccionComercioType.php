<?php

namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InspeccionComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TitularNombre', null, array('label' => 'Propietario'))
            ->add('ActividadNombre', null, array('label' => 'Actividades'))
            ->add('NumeroSolicitud', null, array('label' => 'Nº de solicitud'))
            ->add('ExpedienteNumero', null, array('label' => 'Nº de expediente'))
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => true))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                ))  
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\InspeccionComercio'
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_inspeccioncomerciotype';
    }
}
