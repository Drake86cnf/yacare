<?php
namespace Yacare\MunirgBundle\Helper;

/**
 * Trait que agrega funciones para los importadores que usan calles.
 *
 * @author Ernesto Nicolás Carrea <equistango@gmail.com>
 */
trait ConCalles
{
    protected function ArreglarNombreCalle($nombreCalle)
    {
        switch ($nombreCalle) {
            case 'D\'Agostini':
                return 'Reverendo Padre Alberto D\'Agostini';
                break;
            case 'Juaretche':
                return 'Arturo Jauretche';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            case '':
                return '';
                break;
            default:
                return $nombreCalle;
                break;
        }
    }

    protected function ArreglarCodigoCalle($codigoCalle)
    {
        // Arreglar errores conocidos
        // O algunas calles que están duplicadas en SIGEMI (Isla Soledad con ids 85 y 354)
        // y que en Yacaré ingresan una sola vez.
        if ($codigoCalle == 380) {
            return null; // No existe
        } elseif ($codigoCalle == 384) { // Santa María Dominga Mazzarello
            return 389; // Este es el código correcto
        } elseif ($codigoCalle == 454) { // Juana Manuela Gorriti
            return 249;
        } elseif ($codigoCalle == 1482) { // General Villegas
            return 211;
        } elseif ($codigoCalle == 724) { // Remolcador Guaraní
            return 69;
        } elseif ($codigoCalle == 567) { // Neuquén
            return 144;
        } elseif ((int) ($codigoCalle) == 0 || $codigoCalle == 1748) { // ???
            return null;
        } elseif ($codigoCalle == 1157) { // 25 de Mayo
            return 224;
        } elseif ($codigoCalle == 474) { // Rosales
            return 174;
        } elseif ($codigoCalle == 3247) { // Luis Garibaldi Honte
            return 285;
        } elseif ($codigoCalle == 1768) { // Obispo Trejo
            return 294;
        } elseif ($codigoCalle == 1153) { // José Hernández
            return 90;
        } elseif ($codigoCalle == 1398 || $codigoCalle == 1381) { // Belisario Roldán
            return 173;
        } elseif ($codigoCalle == 1506) { // Tomas Roldán
            return 53;
        } elseif ($codigoCalle == 718) { // Libertad
            return 116;
        } elseif ($codigoCalle == 1949) { // Juan Bautista Thorne
            return 197;
        } elseif ($codigoCalle == 857) { // Gobernador Paz
            return 67;
        } elseif ($codigoCalle == 655) { // Estrada
            return 55;
        } elseif ($codigoCalle == 354) { // Estrada
            return 85;
        } elseif ($codigoCalle == 2451) { // Mariano Moreno
            return 251;
        } else {
            return (int) ($codigoCalle);
        }
    }
}