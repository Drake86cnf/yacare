<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\ImportadorActividades;

class ImportarActividadesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('munirg:importar:actividades')
        ->setDescription('Importar actividades comerciales desde un archivo CSV.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $desde = 0;
        
        $output->writeln('Importando actividades...');

        $cantidad = 100;
        $progress = null;
        
        $importador = new ImportadorActividades($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $procesados = 0;
        while(true) {
            $resultado = $importador->Importar($desde, $cantidad);
            if(!$progress) {
                $progress = new ProgressBar($output, $resultado->RegistrosTotal);
                $progress->start();
            }
            $procesados += $resultado->RegistrosTotal; 
            $progress->setProgress($procesados);
            if(!$resultado->HayMasRegistros) {
                break;
            }
            $desde += $cantidad;
        }

        if($progress) {
            $progress->finish();
            echo "\n";
        }
        $output->writeln('Importación finalizada, se procesaron ' . $procesados . ' registros.');
    }
}
