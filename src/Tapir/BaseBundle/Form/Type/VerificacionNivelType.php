<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VerificacionNivelType extends ButtonGroupType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                '0' => 'Sin confirmar',
                '10' => 'Confirmado',
                '20' => 'Cotejado',
                '30' => 'Certificado'
            ),
            'label' => 'Nivel de confirmación',
            'attr' => array( 'help' => '<a href="#" class="text-warning" data-toggle="collapse" data-target="#VerificacionNivelType_MasInfo"><i class="fa fa-info-circle"></i> Más información sobre los niveles de confirmación</a>
            <div id="VerificacionNivelType_MasInfo" class="collapse">
                <small><dl class="dl-horizontal">
                    <dt>Sin confirmar</dt>
                    <dd>Datos proporcionados por la persona, por lo general de forma verbal, sobre los cuales
                        no se tiene ninguna confirmación ni se cotejaron con alguna documentación.</dd>
                
                    <dt>Confirmado</dt>
                    <dd>Datos sobre los cuales se tiene alguna confirmación aunque sea informal. Por ejemplo: un número
                        telefónico con el cual Usted se pudo comunicar al menos una vez.</dd>
                
                    <dt>Cotejado</dt>
                    <dd>Datos cotejados con alguna documentación pertinente, por ejemplo: la persona mostró su DNI
                        o dejó una copia para poder cotejar el domicilio.</dd>
                
                    <dt>Certificado</dt>
                    <dd>Datos avalados por alguna prueba y sobre los cuales se conserva algún registro (original, 
                        fotocopia legalizada, fotocopia certificada, etc.).</dd>
                </dl></small>
            </div>'),
        ));
    }
    
    public function getParent()
    {
        return 'buttongroup';
    }

    public function getName()
    {
        return 'verificacion_nivel';
    }
}