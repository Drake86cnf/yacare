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
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'label' => 'Fecha'))
            ->add('Comercio', null, array('label' => 'Comercio'))            
            ->add('Persona', 'entity_id', array(
                'label' => 'Persona',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                ),
                'required' => false))               
            ->add('NotaNumero', null, array('label' => 'NotaNumero', 'required' => false))
            ->add('Detalle', null, array('label' => 'Detalle'))
            ->add('Obs', null, array('label' => 'Observaciones'))
            ->add('FuncionarioPrincipal', 'entity_id', array(
                'label' => 'Funcionario Principal',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                ),
                'required' => false))
            ->add('FuncionarioSecundario', 'entity_id', array(
                'label' => 'Funcionario Secundario',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                ),
                'required' => false))
            ->add('ResponsableNombre', null, array('label' => 'Responsable'))             
            ->add('Mercaderia', new \Yacare\BromatologiaBundle\Form\Type\MercaderiaType(), array('label' => 'Mercaderia'))            
            ->add('Detalle', null, array('label' => 'Detalle', 'required' => false))
            ->add('Obs', null, array('label' => 'Observaciones', 'required' => false))
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
