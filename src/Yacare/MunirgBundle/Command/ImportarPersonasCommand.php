<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPersonas;
use Yacare\MunirgBundle\Helper\Importador\ResultadoImportacion;

class ImportarPersonasCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('munirg:importar:personas')
        ->setDescription('Importar personas desde SiGeMI')
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
        
        $output->writeln('Importando personas...');

        $cantidad = 100;
        $progress = null;
        
        $importador = new ImportadorPersonas($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
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
        }

        $progress->finish();
        $output->writeln('');
        
        $output->writeln(' Se importaron   ' . $ResultadoFinal->RegistrosNuevos . ' registros nuevos.');
        $output->writeln(' Se actualizaron ' . $ResultadoFinal->RegistrosActualizados . ' registros.');
        $output->writeln(' Se ignoraron    ' . $ResultadoFinal->RegistrosIgnorados . ' registros.');
        $output->writeln('Importación finalizada, se procesaron ' . $ResultadoFinal->TotalRegistrosProcesados() . ' registros.');
    }
}
