<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActaRutinaDecomisoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('Talonario', null, array('label' => 'Talonario')) 
            ->add('Numero', null, array('label' => 'Numero'))
            ->add('SubTipo', 'choice', array(
                'choices'   => array(
                    'Compulsivo' => 'Compulsivo',
                    'Desnaturalización' => 'Desnaturalización',
                    'Voluntario' => 'Voluntario',
                    'Otro' => 'Otro',
                    ),
                'required'  => true,
                'label' => 'Tipo de acta'))
            ->add('Fecha', 'date', array(
                'years' => range(1900, 2099),
                'widget' => 'single_text',
                'label' => 'Fecha'))
            ->add('Comercio', null, array('label' => 'Comercio'))
            ->add('Persona', null, array('label' => 'Persona'))
            ->add('NotaNumero', null, array('label' => 'NotaNumero'))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ->add('FuncionarioPrincipal', null, array('label' => 'Funcionario Principal'))
            ->add('FuncionarioSecundario', null, array('label' => 'Funcionario Secundario'))
            ->add('Responsable', null, array('label' => 'Responsable'))            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\ActaRutinaDecomiso'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_actarutinadecomisotype';
    }    
}
