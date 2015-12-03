<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para persona.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Apellido', null, array(
                'label' => 'Apellido',
                'attr' => array('class' => 'tapir-input-maymin')
            ))
            ->add('Nombre', null, array(
                'label' => 'Nombre',
                'attr' => array('class' => 'tapir-input-maymin')
            ))
            ->add('TipoSociedad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array('label' => 'Tipo',
                 'choices' => array(
                     0 => 'Persona física',
                     '1' => 'Sociedad Anónima',
                     '8' => 'Sociedad de Responsabilidad Limitada',
                     '3' => 'Sociedad de Hecho',
                     '2' => 'Sociedad Colectiva',
                     '4' => 'Sociedad en Comandita por Acciones',
                     '5' => 'Sociedad de Capital e Industria',
                     '6' => 'Sociedad Accidental o en Participación',
                     '7' => 'Sociedad en Comandita Simple',
                     '9' => 'Cooperativa',
                     '10' => 'Asociación Sin Fines de Lucro',
                     '11' => 'Entidad Gubernamental',
                     '99' => 'Otra persona jurídica'
                 )
            ))
            ->add('RazonSocial', null, array(
                'label' => 'Razón social',
                'attr' => array('class' => 'tapir-input-maymin')
            ))
            ->add('Documento', 'Yacare\BaseBundle\Form\Type\DocumentoType', array(
                'label' => 'Documento',
                'required' => false
            ))
            ->add('Cuilt',  'Tapir\BaseBundle\Form\Type\CuiltType', array(
                'label' => 'CUIL/CUIT',
                'required' => false
            ))
            ->add('Nib',  null, array(
                'label' => 'Nº de Ingresos Brutos',
                'attr' => array('class' => 'tapir-input-sinespacios')
            ))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'attr' => array('style' => 'width: 100%'),
                'multiple' => true,
                'required' => false))
            ->add('Domicilio', 'Yacare\BaseBundle\Form\Type\DomicilioType', array(
                'label' => 'Domicilio'
            ))
            ->add('TelefonoNumero', null, array(
                'label' => 'Teléfonos',
                'attr' => array('class' => 'tapir-input-maymin')
            ))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus tapir-input-sinespacios')
            ))
            ->add('FechaNacimiento', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', 'Tapir\BaseBundle\Form\Type\GeneroType', array('label' => 'Género', 'required' => true))
            ->add('Pais', 'entity', array(
                'label' => 'Nacionalidad',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'property' => 'NombreYGentilicio',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
