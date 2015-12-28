<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\Importador\ImportadorAgentes;

class ImportarAgentesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('munirg:importar:agentes')
        ->setDescription('Importar agentes desde Gestión')
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

        $cantidad = 100;
        $progress = null;
        
        $importador = new ImportadorAgentes($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->setRedrawFrequency(1);
        $progress->setMessage('Importando agentes...');
        $progress->start();
        while(true) {
            $resultado = $importador->Importar($desde, $cantidad);
            if(!$resultado->HayMasRegistros()) {
                break;
            }
            $desde += $cantidad;
            $progress->advance($cantidad);
        }

        $progress->finish();
        $output->writeln('');
        
        $output->writeln(' Se importaron   ' . $resultado->RegistrosNuevos . ' registros nuevos.');
        $output->writeln(' Se actualizaron ' . $resultado->RegistrosActualizados . ' registros.');
        $output->writeln(' Se ignoraron    ' . $resultado->RegistrosIgnorados . ' registros.');
        $output->writeln('Importación finalizada, se procesaron ' . $resultado->TotalRegistrosProcesados() . ' registros.');
    }
}
