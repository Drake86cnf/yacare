<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\ResultadoLote;

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
        
        $importador = new ImportadorPartidas($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->start();
        while(true) {
            $resultado = $importador->Importar($desde, $cantidad);
            $progress->setProgress($resultado->PosicionCursor());
            if(!$resultado->HayMasRegistros()) {
                break;
            }
            $desde += $cantidad;
        }

        $progress->finish();
        echo "\n";

        $output->writeln(' Se importaron   ' . $resultado->RegistrosNuevos . ' registros nuevos.');
        $output->writeln(' Se actualizaron ' . $resultado->RegistrosActualizados . ' registros.');
        $output->writeln(' Se ignoraron    ' . $resultado->RegistrosIgnorados . ' registros.');
        $output->writeln('Importación finalizada, se procesaron ' . $resultado->TotalRegistrosProcesados() . ' registros.');
    }
}