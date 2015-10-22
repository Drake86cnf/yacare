<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\ResultadoImportacion;

class ImportarPartidasCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('munirg:importar:partidas')
        ->setDescription('Importar partidas de catastro desde SiGeMI')
        ->addArgument(
            'desde',
            InputArgument::OPTIONAL,
            'Registro de inicio'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $desde = (int)($input->getArgument('desde'));
        
        $output->writeln('Importando partidas...');

        $cantidad = 100;
        $progress = null;
        $ResultadoTotal = new ResultadoImportacion();
        
        $importador = new ImportadorPartidas($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $procesados = 0;
        while(true) {
            $ResultadoParcial = $importador->Importar($desde, $cantidad);
            $ResultadoTotal->AgregarResultados($ResultadoParcial);
            if(!$progress) {
                $progress = new ProgressBar($output, $ResultadoTotal->RegistrosTotal);
                $progress->start();
            }
            $procesados += $ResultadoTotal->ObtenerCantidadDeRegistrosProcesados();
            $progress->setProgress($procesados);
            if(!$ResultadoTotal->HayMasRegistros) {
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
