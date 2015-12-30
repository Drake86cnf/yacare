<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\Importador\ResultadoImportacion;

class ImportarPartidasCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('munirg:importar:partidas')
        ->setDescription('Importar partidas de catastro desde SiGeMI')
        ->addOption(
            'desde',
            null,
            InputOption::VALUE_OPTIONAL,
            'Número de registro inicial',
            0)
        ->addOption(
            'hasta',
            null,
            InputOption::VALUE_OPTIONAL,
            'Número de registro final',
            0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('desde')) {
            $desde = (int)($input->getOption('desde'));
        } else {
            $desde = 0;
        }
        if ($input->getOption('hasta')) {
            $hasta = (int)($input->getOption('hasta'));
        } else {
            $hasta = 0;
        }
        
        $output->writeln('Importando partidas...');

        $cantidad = 100;
        $progress = null;
        
        $importador = new ImportadorPartidas($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->start();
        $ResultadoFinal = new ResultadoImportacion($importador);
        while(true) {
            $resultado = $importador->Importar($desde, $cantidad);
            $ResultadoFinal->AgregarContadoresLote($resultado);
            $progress->setProgress($resultado->PosicionCursor());
            if(!$resultado->HayMasRegistros()) {
                break;
            }
            $desde += $cantidad;
            
            if($hasta > 0 && $desde >= $hasta) {
                break;
            }
        }

        $progress->finish();
        $output->writeln('');

        $output->writeln(' Se importaron   ' . $ResultadoFinal->RegistrosNuevos . ' registros nuevos.');
        $output->writeln(' Se actualizaron ' . $ResultadoFinal->RegistrosActualizados . ' registros.');
        $output->writeln(' Se ignoraron    ' . $ResultadoFinal->RegistrosIgnorados . ' registros.');
        $output->writeln('Importación finalizada, se procesaron ' . $ResultadoFinal->TotalRegistrosProcesados() . ' registros.');
    }
}
