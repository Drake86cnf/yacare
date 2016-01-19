<?php
namespace Yacare\CatastroBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\Importador\ImportadorPartidas;
use Yacare\MunirgBundle\Helper\Importador\ResultadoImportacion;

class GeoCodificarPartidasCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('catastro:partidas:geocod')
        ->setDescription('GeoCodificar partidas obteniendo datos de ubicación desde OpenStreerMap o Google Maps')
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
        ->addOption(
            'calle',
            null,
            InputOption::VALUE_OPTIONAL,
            'Sólo procesar partidas de una calle determinada',
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
        
        $Filtros = array(
            'Ubicacion' => null,
            'UbicacionFecha' => null
        );
        if ($input->getOption('calle')) {
            $Filtros['DomicilioCalle'] = (int)($input->getOption('calle'));
        }
        
        $output->writeln('Geocodificando partidas...');

        $cantidadTotal = $hasta - $desde;
        $progress = null;
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $Helper = new \Yacare\CatastroBundle\Helper\PartidaHelper($this->getContainer(), $em);
        $Partidas = $em->getRepository('Yacare\CatastroBundle\Entity\Partida')->findBy(
            $Filtros,
            array('id' => 'ASC'),
            $desde ?: null,
            $cantidadTotal ?: null);
        $progress = new ProgressBar($output, count($Partidas));
        $progress->start();
        foreach($Partidas as $Partida) {
            $Helper->ObtenerUbicacionPorDomicilio($Partida);
            $progress->advance();
            $em->flush();
            // Dormir unos segundos entre consulta y consulta
            sleep(rand(5, 10));
        }
        $em->clear();
        
        $progress->finish();
        $output->writeln('');

        $output->writeln('Geocodificación terminada, se procesaron ' . count($Partidas) . ' registros.');
    }
}
