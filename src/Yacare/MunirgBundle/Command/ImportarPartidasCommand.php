<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\ImportadorPartidas;

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
