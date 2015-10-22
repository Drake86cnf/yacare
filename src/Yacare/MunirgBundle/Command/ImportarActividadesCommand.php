<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\ImportadorActividades;
use Yacare\MunirgBundle\Helper\ResultadoImportacion;

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
        $ResultadoTotal = new ResultadoImportacion();
        
        $importador = new ImportadorActividades($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $procesados = 0;
        while(true) {
            $ResultadoParcial = $importador->Importar($desde, $cantidad);
            $ResultadoTotal->AgregarResultados($ResultadoParcial);
            if(!$progress) {
                $progress = new ProgressBar($output, $ResultadoParcial->RegistrosTotal);
                $progress->start();
            }
            $procesados += $ResultadoParcial->ObtenerCantidadDeRegistrosProcesados();
            $progress->setProgress($procesados);
            if(!$ResultadoParcial->HayMasRegistros) {
                break;
            }
            $desde += $cantidad;
        }

        if($progress) {
            $progress->finish();
            echo "\n";
        }
        
        $output->writeln(' Se importaron   ' . $ResultadoTotal->RegistrosNuevos . ' registros nuevos.');
        $output->writeln(' Se actualizaron ' . $ResultadoTotal->RegistrosActualizados . ' registros.');
        $output->writeln(' Se ignoraron    ' . $ResultadoTotal->RegistrosIgnorados . ' registros.');
        $output->writeln('Importación finalizada, se procesaron ' . $ResultadoTotal->ObtenerCantidadDeRegistrosProcesados() . ' registros.');
    }
}
