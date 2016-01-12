<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            //new Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),

            new Tapir\BaseBundle\TapirBaseBundle(),
            new Tapir\ChartsBundle\TapirChartsBundle(),
        	new Tapir\AnnotationBundle\TapirAnnotationBundle(),
            new Tapir\TemplateBundle\TapirTemplateBundle(),
            new Tapir\FormBundle\TapirFormBundle(),
			new Tapir\AbmBundle\TapirAbmBundle(),
            new Tapir\AyudaBundle\TapirAyudaBundle(),
            new Tapir\OsmBundle\TapirOsmBundle(),

            new Yacare\BaseBundle\YacareBaseBundle(),
            new Yacare\TemplateBundle\YacareTemplateBundle(),
            new Yacare\RecursosHumanosBundle\YacareRecursosHumanosBundle(),
            new Yacare\InspeccionBundle\YacareInspeccionBundle(),
            new Yacare\CatastroBundle\YacareCatastroBundle(),
            new Yacare\OrganizacionBundle\YacareOrganizacionBundle(),
            new Yacare\ComprasBundle\YacareComprasBundle(),
            new Yacare\ComercioBundle\YacareComercioBundle(),
            new Yacare\TramitesBundle\YacareTramitesBundle(),
            new Yacare\MunirgBundle\YacareMunirgBundle(),
            new Yacare\ObrasParticularesBundle\YacareObrasParticularesBundle(),
            new Yacare\RequerimientosBundle\YacareRequerimientosBundle(),
            new Yacare\AdministracionBundle\YacareAdministracionBundle(),
            //new Yacare\SuitBundle\YacareSuitBundle(),
            new Yacare\SitioWebBundle\YacareSitioWebBundle(),
            new Yacare\FlotaBundle\YacareFlotaBundle(),
            new Yacare\AyudaBundle\YacareAyudaBundle(),
            new Yacare\NominaBundle\YacareNominaBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }
    
    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->environment.'/';
    }
    
    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs/';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
