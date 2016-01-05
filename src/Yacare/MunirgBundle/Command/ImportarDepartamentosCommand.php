<?php
namespace Yacare\MunirgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Yacare\MunirgBundle\Helper\Importador\ImportadorSecretarias;
use Yacare\MunirgBundle\Helper\Importador\ImportadorDirecciones;
use Yacare\MunirgBundle\Helper\Importador\ImportadorSectores;
use Yacare\MunirgBundle\Helper\Importador\ResultadoImportacion;

class ImportarDepartamentosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('munirg:importar:departamentos')
            ->setDescription('Importar departamentos desde Gestión');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cantidad = 10;
        $progress = null;
        
        $output->writeln('Importando secretarías...');
        $importador = new ImportadorSecretarias($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->start();
        $desde = 0;
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

        $output->writeln('Importando direcciones...');
        $importador = new ImportadorDirecciones($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->start();
        $desde = 0;
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
        
        $output->writeln('Importando sectores...');
        $importador = new ImportadorSectores($this->getContainer(), $this->getContainer()->get('doctrine')->getManager());
        $importador->Inicializar();
        $progress = new ProgressBar($output, $importador->ObtenerCantidadTotal());
        $progress->start();
        $desde = 0;
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
