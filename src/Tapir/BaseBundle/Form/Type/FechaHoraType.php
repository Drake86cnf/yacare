<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Campo de formulario para ingreso de fecha y hora.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class FechaHoraType extends \Symfony\Component\Form\Extension\Core\Type\DateTimeType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'years' => range(1900, 2099),
                'with_seconds' => false,
                'placeholder' => 'placeholder1',
                'html5' => true
                ));
    }
    
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $dateFieldOptions = $builder->get('date')->getOptions();

        $dateFieldOptions['attr']  = array(
            'placeholder' => 'día/mes/año',
            'class' => 'tapir-input-120 tapir-input-fecha');
        
        $builder->remove('date');
        $builder->add('date', 'Symfony\Component\Form\Extension\Core\Type\DateType', $dateFieldOptions);
        
        $timeFieldOptions = $builder->get('time')->getOptions();
        
        $timeFieldOptions['label'] = '-';
        $timeFieldOptions['attr']  = array(
            'placeholder' => 'h:m',
            'class' => 'tapir-input-80 tapir-input-hora');
        
        $builder->remove('time');
        $builder->add('time', 'Symfony\Component\Form\Extension\Core\Type\TimeType', $timeFieldOptions);
        
        //echo '<pre>'; print_r($builder->get('time')->getOptions());
    }
}
