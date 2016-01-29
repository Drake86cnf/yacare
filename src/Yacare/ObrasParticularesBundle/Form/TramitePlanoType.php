<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de movimiento de previas.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class TramitePlanoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('Titular', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array(
                'label' => 'Titular',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'required' => false)) */
            ->add('Partida', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => true))
            ->add('SuperficieProyectada', 'Tapir\BaseBundle\Form\Type\SuperficieType', array(
                  'label' => 'Superficie Proyectada',
                  'required' => false))
            ->add('SuperficieAprobada', 'Tapir\BaseBundle\Form\Type\SuperficieType', array(
                  'label' => 'Superficie Apobada',
                  'required' => false))
            ->add('SuperficieRelevada', 'Tapir\BaseBundle\Form\Type\SuperficieType', array(
                  'label' => 'Superficie relevada',
                  'required' => false))
            ->add('ObraDestinos','Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                  'label' => 'Destino de la obra',
                  'class' => 'Yacare\ObrasParticularesBundle\Entity\ObraDestino',
                  'multiple'=> true,
                  'required' => true))
            ->add('Profesional', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Profesional',
                'class' => 'Yacare\ObrasParticularesBundle\Entity\Matriculado',
                'required' => true))
            ->add('PlanoTipo','Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                  'label' => 'Tipo de plano',
                  'required' => false,
                  'choices'=> array(
                    'Relevamiento' => 1,
                    'Conforme a obra'=> 2,
                    'Obra nueva' => 4,
                    'Relevamiento y ampliación'=> 5,
                    'Conforme a obra y ampliación'=> 6
                )))
            ->add('Obs', null, array(
                'label' => 'Observaciones', 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\TramitePlano'));
    }
}
