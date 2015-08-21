<?php
namespace Tapir\AnnotationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\Common\Annotations\AnnotationRegistry;

class TapirAnnotationBundle extends Bundle
{

    public function boot()
    {
        $kernel = $this->container->get('kernel');
        
        AnnotationRegistry::registerFile($kernel->locateResource('@TapirAnnotationBundle/Annotation/Descripcion.php'));
        AnnotationRegistry::registerFile(
            $kernel->locateResource('@TapirAnnotationBundle/Annotation/AnnotationPrueba.php'));
    }
}
